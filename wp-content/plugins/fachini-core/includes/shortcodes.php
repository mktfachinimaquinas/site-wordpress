<?php
/**
 * Blocos de conteúdo da máquina, em código.
 *
 * O Elementor monta o visual da página, mas quem desenha a tabela de
 * especificações, o botão do catálogo e a lista de relacionadas é este arquivo.
 * Assim esses blocos continuam existindo mesmo que o layout mude, e podem ser
 * ajustados sem abrir o editor.
 *
 * Uso dentro do Elementor: widget "Shortcode", com [fachini_especificacoes],
 * [fachini_catalogo], [fachini_video] ou [fachini_relacionadas].
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tabela de especificações, montada a partir do campo de texto.
 */
function fachini_sc_especificacoes() {
	$itens = function_exists( 'fachini_get_especificacoes' ) ? fachini_get_especificacoes( get_the_ID() ) : array();

	if ( empty( $itens ) ) {
		return '';
	}

	$html = '<table class="fachini-specs"><tbody>';

	foreach ( $itens as $item ) {
		$html .= '<tr>';
		if ( '' !== $item['rotulo'] ) {
			$html .= '<th scope="row">' . esc_html( $item['rotulo'] ) . '</th>';
			$html .= '<td>' . esc_html( $item['valor'] ) . '</td>';
		} else {
			$html .= '<td colspan="2">' . esc_html( $item['valor'] ) . '</td>';
		}
		$html .= '</tr>';
	}

	$html .= '</tbody></table>';

	return $html;
}
add_shortcode( 'fachini_especificacoes', 'fachini_sc_especificacoes' );

/**
 * Botão de download do catálogo. Só aparece se houver arquivo.
 */
function fachini_sc_catalogo() {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$arquivo = get_field( 'catalogo_pdf', get_the_ID() );

	if ( empty( $arquivo['url'] ) ) {
		return '';
	}

	return sprintf(
		'<a class="fachini-botao fachini-botao--catalogo" href="%s" target="_blank" rel="noopener">Baixar catálogo em PDF</a>',
		esc_url( $arquivo['url'] )
	);
}
add_shortcode( 'fachini_catalogo', 'fachini_sc_catalogo' );

/**
 * Vídeo do YouTube, carregado só quando o visitante clica.
 * Evita o peso do player em toda visita, que é o que derruba nota de performance.
 */
function fachini_sc_video() {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$url = (string) get_field( 'video_url', get_the_ID() );

	if ( '' === trim( $url ) ) {
		return '';
	}

	// Extrai o id do vídeo das formas mais comuns de endereço do YouTube.
	$id = '';
	if ( preg_match( '~(?:youtu\.be/|v=|/embed/|/shorts/)([A-Za-z0-9_-]{6,})~', $url, $m ) ) {
		$id = $m[1];
	}

	if ( '' === $id ) {
		return '';
	}

	return sprintf(
		'<div class="fachini-video" data-video="%1$s">
			<button type="button" class="fachini-video__play" aria-label="Reproduzir vídeo">
				<img src="https://i.ytimg.com/vi/%1$s/hqdefault.jpg" alt="" loading="lazy" width="480" height="360">
				<span class="fachini-video__icone" aria-hidden="true"></span>
			</button>
		</div>',
		esc_attr( $id )
	);
}
add_shortcode( 'fachini_video', 'fachini_sc_video' );

/**
 * Máquinas relacionadas. Se o campo estiver vazio, usa as da mesma categoria.
 */
function fachini_sc_relacionadas() {
	$id  = get_the_ID();
	$ids = function_exists( 'get_field' ) ? (array) get_field( 'maquinas_relacionadas', $id ) : array();
	$ids = array_filter( array_map( 'intval', $ids ) );

	if ( empty( $ids ) ) {
		$termo = function_exists( 'fachini_get_termo_principal' ) ? fachini_get_termo_principal( $id ) : null;

		if ( $termo ) {
			$ids = get_posts(
				array(
					'post_type'      => 'maquina',
					'posts_per_page' => 4,
					'post__not_in'   => array( $id ),
					'fields'         => 'ids',
					'tax_query'      => array(
						array(
							'taxonomy' => 'categoria_maquina',
							'field'    => 'term_id',
							'terms'    => $termo->term_id,
						),
					),
				)
			);
		}
	}

	if ( empty( $ids ) ) {
		return '';
	}

	$html = '<div class="fachini-relacionadas">';

	foreach ( $ids as $rid ) {
		$html .= sprintf(
			'<a class="fachini-relacionadas__item" href="%s">%s<span class="fachini-relacionadas__nome">%s</span></a>',
			esc_url( get_permalink( $rid ) ),
			get_the_post_thumbnail( $rid, 'medium', array( 'loading' => 'lazy' ) ),
			esc_html( get_the_title( $rid ) )
		);
	}

	$html .= '</div>';

	return $html;
}
add_shortcode( 'fachini_relacionadas', 'fachini_sc_relacionadas' );
