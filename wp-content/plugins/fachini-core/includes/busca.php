<?php
/**
 * Busca do site, igual ao Figma ("OVERLAY SEARCH"): a lupa no fim do menu abre
 * uma camada escura com o campo de pesquisa, os links das categorias
 * ("Explore") e três máquinas em destaque.
 *
 * A lupa é um item do menu principal com a classe "fachini-busca-item" (link
 * "#buscar"). Assim ela aparece no computador e no menu do celular sem mexer
 * no modelo do cabeçalho. O visual e o abrir/fechar ficam no tema filho.
 *
 * O resultado da busca usa o mesmo modelo da listagem /maquinas/ e procura só
 * entre as máquinas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe do item de menu que abre a busca.
 */
define( 'FACHINI_BUSCA_CLASSE', 'fachini-busca-item' );

/**
 * A busca do site procura só entre as máquinas.
 */
function fachini_busca_so_maquinas( $consulta ) {
	if ( is_admin() || ! $consulta->is_main_query() || ! $consulta->is_search() ) {
		return;
	}
	$consulta->set( 'post_type', 'maquina' );
}
add_action( 'pre_get_posts', 'fachini_busca_so_maquinas' );

/**
 * Máquinas em destaque na busca: as marcadas como "Destacar na home" e, se
 * faltar, as mais recentes que têm foto.
 *
 * @return WP_Post[]
 */
function fachini_busca_destaques( $quantas = 3 ) {
	$base = array(
		'post_type'      => 'maquina',
		'post_status'    => 'publish',
		'posts_per_page' => $quantas,
		'no_found_rows'  => true,
		'meta_query'     => array( array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ) ),
	);

	$destaques = get_posts(
		array_merge(
			$base,
			array(
				'meta_query' => array(
					'relation' => 'AND',
					array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ),
					array( 'key' => 'destaque_home', 'value' => '1' ),
				),
				'orderby'    => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
			)
		)
	);

	if ( count( $destaques ) < $quantas ) {
		$extras    = get_posts(
			array_merge(
				$base,
				array(
					'posts_per_page' => $quantas - count( $destaques ),
					'post__not_in'   => wp_list_pluck( $destaques, 'ID' ),
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			)
		);
		$destaques = array_merge( $destaques, $extras );
	}

	return $destaques;
}

/**
 * Itens de primeiro nível do menu principal, sem a lupa.
 */
function fachini_busca_menu() {
	$itens = wp_get_nav_menu_items( 'menu-principal' );
	if ( ! $itens ) {
		return '';
	}

	$html = '';
	foreach ( $itens as $item ) {
		if ( (int) $item->menu_item_parent || in_array( FACHINI_BUSCA_CLASSE, (array) $item->classes, true ) ) {
			continue;
		}
		$html .= '<li><a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></li>';
	}

	return $html ? '<nav class="fachini-busca__menu" aria-label="Menu"><ul>' . $html . '</ul></nav>' : '';
}

/**
 * Campo de pesquisa. O mesmo na camada da busca e na página de resultados.
 */
function fachini_busca_form( $id ) {
	return '<form class="fachini-busca-form" role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '">'
		. '<label class="fachini-sr" for="' . esc_attr( $id ) . '">Buscar máquinas</label>'
		. '<input id="' . esc_attr( $id ) . '" class="fachini-busca-form__campo" type="search" name="s" value="' . esc_attr( get_search_query() ) . '" placeholder="Pesquisa..." autocomplete="off">'
		. '<button class="fachini-busca-form__enviar" type="submit"><span class="fachini-sr">Buscar</span></button>'
		. '</form>';
}

/**
 * A camada da busca, no fim da página. Fica escondida até a lupa ser clicada.
 */
function fachini_busca_camada() {
	if ( is_admin() || ( isset( $_GET['elementor-preview'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	$logo_id = (int) get_option( 'fachini_logo_id' );
	$logo    = $logo_id ? wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'fachini-busca__logo-img', 'alt' => 'Fachini Máquinas' ) ) : esc_html( get_bloginfo( 'name' ) );

	$explore = '';
	foreach ( fachini_categorias_principais() as $termo ) {
		$explore .= '<li><a href="' . esc_url( get_term_link( $termo ) ) . '">' . esc_html( $termo->name ) . '</a></li>';
	}

	$cards = '';
	foreach ( fachini_busca_destaques() as $maquina ) {
		$cards .= '<a class="fachini-busca__card" href="' . esc_url( get_permalink( $maquina ) ) . '">'
			. '<span class="fachini-busca__card-foto">' . get_the_post_thumbnail( $maquina, 'medium_large', array( 'alt' => '', 'loading' => 'lazy', 'sizes' => '280px' ) ) . '</span>'
			. '<span class="fachini-busca__card-texto">'
			. '<span class="fachini-busca__card-nome">' . esc_html( get_the_title( $maquina ) ) . '</span>'
			. '<span class="fachini-busca__card-ver">Ver detalhes</span>'
			. '</span></a>';
	}

	echo '<div class="fachini-busca" id="fachini-busca" role="dialog" aria-modal="true" aria-label="Busca" hidden>'
		. '<div class="fachini-busca__painel">'
		. '<div class="fachini-busca__topo">'
		. '<a class="fachini-busca__logo" href="' . esc_url( home_url( '/' ) ) . '">' . $logo . '</a>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. fachini_busca_menu() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. '<button class="fachini-busca__fechar" type="button" data-fachini-fechar><span class="fachini-sr">Fechar a busca</span></button>'
		. '</div>'
		. fachini_busca_form( 'fachini-busca-campo' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. '<div class="fachini-busca__corpo">'
		. ( $explore ? '<div class="fachini-busca__explore"><p class="fachini-busca__rotulo">Explore</p><ul>' . $explore . '</ul></div>' : '' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. ( $cards ? '<div class="fachini-busca__destaques">' . $cards . '</div>' : '' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. '</div></div>'
		. '<div class="fachini-busca__fundo" data-fachini-fechar></div>'
		. '</div>';
}
add_action( 'wp_footer', 'fachini_busca_camada', 5 );

/**
 * Topo da página de resultados: caminho, título com o termo e total.
 */
function fachini_busca_topo() {
	global $wp_query;

	$termo = get_search_query();
	$total = (int) $wp_query->found_posts;

	if ( '' === trim( $termo ) ) {
		$titulo = 'Buscar máquinas';
		$resumo = '';
	} else {
		$titulo = 'Resultados para “' . $termo . '”';
		$resumo = ( 1 === $total ) ? '1 máquina encontrada' : $total . ' máquinas encontradas';
	}

	return '<div class="fachini-busca-topo">'
		. fachini_sc_breadcrumb()
		. '<h1 class="fachini-busca-topo__titulo">' . esc_html( $titulo ) . '</h1>'
		. ( $resumo ? '<p class="fachini-busca-topo__total">' . esc_html( $resumo ) . '</p>' : '' )
		. fachini_busca_form( 'fachini-busca-resultados' )
		. '</div>';
}
