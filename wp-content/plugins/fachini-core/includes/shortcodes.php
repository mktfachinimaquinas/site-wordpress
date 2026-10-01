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
 * Caminho de navegação (breadcrumb).
 *
 * Feito aqui em vez de depender do Rank Math: o shortcode dele só existe se a
 * opção estiver ligada no painel, e se não estiver o visitante vê o shortcode
 * escrito na tela. Este sempre funciona.
 */
function fachini_sc_breadcrumb() {
	$itens = array( '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>' );

	if ( is_singular( 'maquina' ) ) {
		$termo = fachini_get_termo_principal( get_the_ID() );

		if ( $termo ) {
			$ancestrais = array_reverse( get_ancestors( $termo->term_id, 'categoria_maquina' ) );
			foreach ( $ancestrais as $id ) {
				$pai = get_term( $id, 'categoria_maquina' );
				if ( $pai && ! is_wp_error( $pai ) ) {
					$itens[] = '<a href="' . esc_url( get_term_link( $pai ) ) . '">' . esc_html( $pai->name ) . '</a>';
				}
			}
			$itens[] = '<a href="' . esc_url( get_term_link( $termo ) ) . '">' . esc_html( $termo->name ) . '</a>';
		}

		$itens[] = '<span>' . esc_html( get_the_title() ) . '</span>';

	} elseif ( is_tax( 'categoria_maquina' ) ) {
		$atual      = get_queried_object();
		$ancestrais = array_reverse( get_ancestors( $atual->term_id, 'categoria_maquina' ) );

		foreach ( $ancestrais as $id ) {
			$pai = get_term( $id, 'categoria_maquina' );
			if ( $pai && ! is_wp_error( $pai ) ) {
				$itens[] = '<a href="' . esc_url( get_term_link( $pai ) ) . '">' . esc_html( $pai->name ) . '</a>';
			}
		}
		$itens[] = '<span>' . esc_html( $atual->name ) . '</span>';
	}

	return '<nav class="fachini-breadcrumb" aria-label="Você está aqui">' . implode( ' <span class="fachini-breadcrumb__sep">/</span> ', $itens ) . '</nav>';
}
add_shortcode( 'fachini_breadcrumb', 'fachini_sc_breadcrumb' );

/**
 * Título da listagem, sem o prefixo que o Elementor acrescenta
 * ("Categoria de máquina: Calhas" vira apenas "Calhas").
 * Abaixo dele entra a descrição da categoria, quando houver.
 */
function fachini_sc_titulo_arquivo() {
	if ( ! is_tax( 'categoria_maquina' ) ) {
		return '';
	}

	$termo = get_queried_object();

	if ( ! $termo || is_wp_error( $termo ) ) {
		return '';
	}

	$html = '<h1 class="fachini-titulo-arquivo">' . esc_html( $termo->name ) . '</h1>';

	$descricao = term_description( $termo );
	if ( $descricao ) {
		$html .= '<div class="fachini-arquivo-descricao">' . wp_kses_post( $descricao ) . '</div>';
	}

	return $html;
}
add_shortcode( 'fachini_titulo_arquivo', 'fachini_sc_titulo_arquivo' );

/**
 * Tabela de especificações, montada a partir do campo de texto.
 * O título vem junto: assim a seção inteira some quando não há especificação.
 */
function fachini_sc_especificacoes() {
	$itens = function_exists( 'fachini_get_especificacoes' ) ? fachini_get_especificacoes( get_the_ID() ) : array();

	if ( empty( $itens ) ) {
		return '';
	}

	$html  = '<h2 class="fachini-titulo-secao">Especificações técnicas</h2>';
	$html .= '<table class="fachini-specs"><tbody>';

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

	$html  = '<h2 class="fachini-titulo-secao">Máquinas relacionadas</h2>';
	$html .= '<div class="fachini-relacionadas">';

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
