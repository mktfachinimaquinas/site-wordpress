<?php
/**
 * Taxonomias das máquinas.
 *
 * "Categoria de máquina" é hierárquica de propósito: a árvore definida pelo
 * dono tem categorias e subcategorias (ex.: Perfiladeiras > Cobertura e
 * fachada). Assim a mesma estrutura atende os dois níveis sem precisar de uma
 * segunda taxonomia.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fachini_core_register_taxonomies() {

	$labels = array(
		'name'              => 'Categorias de máquina',
		'singular_name'     => 'Categoria de máquina',
		'menu_name'         => 'Categorias',
		'all_items'         => 'Todas as categorias',
		'edit_item'         => 'Editar categoria',
		'view_item'         => 'Ver categoria',
		'update_item'       => 'Atualizar categoria',
		'add_new_item'      => 'Adicionar nova categoria',
		'new_item_name'     => 'Nome da nova categoria',
		'parent_item'       => 'Categoria principal',
		'parent_item_colon' => 'Categoria principal:',
		'search_items'      => 'Buscar categorias',
		'not_found'         => 'Nenhuma categoria encontrada',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array(
			'slug'         => FACHINI_SLUG_CATEGORIAS,
			'with_front'   => false,
			'hierarchical' => true, // permite /categorias/perfiladeiras/cobertura-e-fachada/
		),
	);

	register_taxonomy( 'categoria_maquina', array( 'maquina' ), $args );
}
add_action( 'init', 'fachini_core_register_taxonomies' );
