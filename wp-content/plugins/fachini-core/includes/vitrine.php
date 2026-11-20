<?php
/**
 * Vitrine da Home (abas por categoria com a grade de fotos): no hover, cada
 * foto que tem link mostra o card do Figma ("MACHINE CARD", estado hover),
 * com o nome e o resumo da máquina ou da categoria para onde o link leva.
 *
 * O texto vem do cadastro, então acompanha qualquer mudança na máquina ou na
 * categoria. No Elementor basta escolher o link da foto (Link: URL
 * personalizada, de preferência o caminho sem o domínio, ex.:
 * /perfiladeiras/coberturas-e-fechamentos/simples/). Foto sem link, ou com
 * link para fora das máquinas, fica como está. O visual fica no tema filho.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nome e resumo da máquina ou da categoria de um endereço do site, ou null.
 *
 * @return array{0: string, 1: string}|null
 */
function fachini_vitrine_alvo( $url ) {
	$caminho = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
	$base    = trim( (string) wp_parse_url( home_url(), PHP_URL_PATH ), '/' );
	if ( '' !== $base && 0 === strpos( $caminho, $base ) ) {
		$caminho = trim( substr( $caminho, strlen( $base ) ), '/' );
	}
	$partes = array_values( array_filter( explode( '/', $caminho ), 'strlen' ) );
	if ( ! $partes ) {
		return null;
	}

	// Máquina: o último pedaço é o apelido; confere pelo endereço real dela.
	$esperado = '/' . implode( '/', $partes ) . '/';
	$ids      = get_posts(
		array(
			'post_type'   => 'maquina',
			'post_status' => 'publish',
			'name'        => sanitize_title( end( $partes ) ),
			'numberposts' => 10,
			'fields'      => 'ids',
		)
	);
	foreach ( $ids as $id ) {
		$real = '/' . trim( substr( (string) wp_parse_url( get_permalink( $id ), PHP_URL_PATH ), strlen( '' !== $base ? '/' . $base : '' ) ), '/' ) . '/';
		if ( $real !== $esperado ) {
			continue;
		}
		return array( get_the_title( $id ), fachini_vitrine_resumo( $id ) );
	}

	// Categoria ou subcategoria.
	$termo = function_exists( 'fachini_termo_pelo_caminho' ) ? fachini_termo_pelo_caminho( $partes ) : null;
	if ( $termo ) {
		return array( $termo->name, wp_strip_all_tags( term_description( $termo ) ) );
	}

	// Máquina que mudou de apelido depois que o link foi escolhido: o card
	// aparece e o link passa a ser o endereço atual (terceiro item).
	$antiga = function_exists( 'fachini_maquina_pelo_apelido_antigo' ) ? fachini_maquina_pelo_apelido_antigo( $esperado ) : 0;
	if ( $antiga ) {
		return array( get_the_title( $antiga ), fachini_vitrine_resumo( $antiga ), get_permalink( $antiga ) );
	}

	return null;
}

/**
 * Resumo da máquina para o card: a descrição curta, ou o resumo do texto.
 */
function fachini_vitrine_resumo( $id ) {
	$resumo = trim( (string) get_post_meta( $id, 'descricao_curta', true ) );
	if ( '' === $resumo ) {
		$resumo = has_excerpt( $id ) ? get_the_excerpt( $id ) : wp_strip_all_tags( (string) get_post_field( 'post_content', $id ) );
	}
	return $resumo;
}

/**
 * Acrescenta o card dentro do link da foto, na saída do widget de imagem.
 */
function fachini_vitrine_cartao( $html, $widget ) {
	if ( ! is_object( $widget ) || ! method_exists( $widget, 'get_name' ) || 'image' !== $widget->get_name() ) {
		return $html;
	}
	$ajustes = $widget->get_settings();
	$classes = isset( $ajustes['_css_classes'] ) ? (string) $ajustes['_css_classes'] : '';
	if ( false === strpos( $classes, 'fachini-vitrine__foto' ) || false === strpos( $html, '</a>' ) ) {
		return $html;
	}
	$url  = ( isset( $ajustes['link_to'] ) && 'custom' === $ajustes['link_to'] && ! empty( $ajustes['link']['url'] ) ) ? (string) $ajustes['link']['url'] : '';
	$alvo = '' !== $url ? fachini_vitrine_alvo( $url ) : null;
	if ( ! $alvo ) {
		return $html;
	}

	$cartao = '<span class="fachini-vitrine__cartao" aria-hidden="true">'
		. '<span class="fachini-vitrine__info">'
		. '<span class="fachini-vitrine__nome">' . esc_html( $alvo[0] ) . '</span>'
		. ( '' !== trim( $alvo[1] ) ? '<span class="fachini-vitrine__texto">' . esc_html( wp_trim_words( $alvo[1], 40 ) ) . '</span>' : '' )
		. '</span>'
		. '<span class="fachini-vitrine__seta"></span>'
		. '</span>';

	// Link escolhido com o apelido antigo da máquina: vai direto ao endereço atual.
	if ( ! empty( $alvo[2] ) ) {
		$html = preg_replace( '/(<a\b[^>]*?\bhref=")[^"]*(")/', '${1}' . esc_url( $alvo[2] ) . '${2}', $html, 1 );
	}

	$fim = strrpos( $html, '</a>' );
	return substr( $html, 0, $fim ) . $cartao . substr( $html, $fim );
}
add_filter( 'elementor/widget/render_content', 'fachini_vitrine_cartao', 10, 2 );
