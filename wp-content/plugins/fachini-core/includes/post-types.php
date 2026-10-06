<?php
/**
 * Tipo de conteúdo: Máquinas.
 *
 * Cada máquina é um cadastro, não uma página montada no Elementor. O visual
 * fica no modelo do Theme Builder; o conteúdo fica aqui. Se um dia o site sair
 * do Elementor, os cadastros continuam inteiros.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fachini_core_register_post_types() {

	$labels = array(
		'name'                  => 'Máquinas',
		'singular_name'         => 'Máquina',
		'menu_name'             => 'Máquinas',
		'add_new'               => 'Adicionar nova',
		'add_new_item'          => 'Adicionar nova máquina',
		'edit_item'             => 'Editar máquina',
		'new_item'              => 'Nova máquina',
		'view_item'             => 'Ver máquina',
		'view_items'            => 'Ver máquinas',
		'search_items'          => 'Buscar máquinas',
		'not_found'             => 'Nenhuma máquina cadastrada',
		'not_found_in_trash'    => 'Nenhuma máquina na lixeira',
		'all_items'             => 'Todas as máquinas',
		'archives'              => 'Listagem de máquinas',
		'featured_image'        => 'Foto principal',
		'set_featured_image'    => 'Definir foto principal',
		'remove_featured_image' => 'Remover foto principal',
		'use_featured_image'    => 'Usar como foto principal',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => FACHINI_SLUG_MAQUINAS,
		// O marcador abaixo é trocado pelo caminho real da categoria em includes/permalinks.php,
		// produzindo /calhas/dobradeiras-regua-lisa/automatica/ conforme a planilha aprovada.
		'rewrite'            => array(
			'slug'       => '%categoria_maquina%',
			'with_front' => false,
		),
		'menu_icon'          => 'dashicons-hammer',
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		'show_in_rest'       => true,  // necessário para o editor de blocos e para integrações futuras
		'publicly_queryable' => true,
		// Permissões próprias (edit_maquinas, publish_maquinas...) em vez das de
		// "post", para que alguém possa cadastrar máquinas sem poder mexer em
		// páginas, modelos ou posts. A distribuição fica em includes/papeis.php.
		'capability_type'    => 'maquina',
		'map_meta_cap'       => true,
		'hierarchical'       => false,
	);

	register_post_type( 'maquina', $args );
}
add_action( 'init', 'fachini_core_register_post_types' );
