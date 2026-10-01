<?php
/**
 * Kit de estilos global do Elementor, aplicado por código.
 *
 * Os valores vêm do design system do projeto (design-system/tokens.md no
 * repositório, medido no Figma pela equipe da Fachini). Ficam aqui por três
 * motivos: entram no Git, podem ser reaplicados em qualquer ambiente e ninguém
 * precisa redigitar quarenta campos na mão se o kit se perder.
 *
 * Depois de aplicado, tudo continua editável normalmente em
 * Elementor > Configurações do site. Esta rotina só roda uma vez por versão.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FACHINI_STYLEKIT_VERSAO', '2026-10-01' );

/**
 * Paleta aprovada. Os apelidos "primary", "secondary", "text" e "accent" são os
 * quatro globais que o Elementor já traz; os demais entram como cores extras.
 */
function fachini_paleta() {
	return array(
		'sistema' => array(
			array( '_id' => 'primary',   'title' => 'Navy primário',   'color' => '#15274E' ),
			array( '_id' => 'secondary', 'title' => 'Navy secundário', 'color' => '#00224E' ),
			array( '_id' => 'text',      'title' => 'Ônix (texto)',    'color' => '#0F0F0F' ),
			array( '_id' => 'accent',    'title' => 'Vermelho (CTA)',  'color' => '#E01E26' ),
		),
		'extras'  => array(
			array( '_id' => 'fachini_vermelho_hover', 'title' => 'Vermelho hover', 'color' => '#B01319' ),
			array( '_id' => 'fachini_offwhite',       'title' => 'Off-white',      'color' => '#FBFBFB' ),
			array( '_id' => 'fachini_cinza_nevoa',    'title' => 'Cinza névoa',    'color' => '#F1F3F6' ),
			array( '_id' => 'fachini_cinza_medio',    'title' => 'Cinza médio',    'color' => '#5C6675' ),
		),
	);
}

/**
 * Monta um bloco de tipografia no formato que o Elementor espera.
 */
function fachini_tipografia( $fonte, $peso, $tamanho, $altura, $espaco = 0, $caixa = 'none' ) {
	return array(
		'typography_typography'      => 'custom',
		'typography_font_family'     => $fonte,
		'typography_font_weight'     => (string) $peso,
		'typography_font_size'       => array( 'unit' => 'px', 'size' => $tamanho ),
		'typography_font_size_mobile'=> array( 'unit' => 'px', 'size' => null ),
		'typography_line_height'     => array( 'unit' => 'em', 'size' => $altura ),
		'typography_letter_spacing'  => array( 'unit' => 'em', 'size' => $espaco ),
		'typography_text_transform'  => $caixa,
	);
}

/**
 * Aplica o kit no documento de estilos do Elementor.
 */
function fachini_aplicar_style_kit() {

	if ( get_option( 'fachini_stylekit_versao' ) === FACHINI_STYLEKIT_VERSAO ) {
		return;
	}

	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	$kit_id = (int) get_option( 'elementor_active_kit' );

	if ( ! $kit_id || ! get_post( $kit_id ) ) {
		return;
	}

	$paleta = fachini_paleta();

	$ajustes = get_post_meta( $kit_id, '_elementor_page_settings', true );
	$ajustes = is_array( $ajustes ) ? $ajustes : array();

	// Cores
	$ajustes['system_colors'] = $paleta['sistema'];
	$ajustes['custom_colors'] = $paleta['extras'];

	// Tipografia global do Elementor
	$ajustes['system_typography'] = array(
		array_merge( array( '_id' => 'primary',   'title' => 'Títulos (Mitr)' ),   fachini_tipografia( 'Mitr', 600, 56, 1.1, 0.06, 'uppercase' ) ),
		array_merge( array( '_id' => 'secondary', 'title' => 'Subtítulos' ),       fachini_tipografia( 'Archivo', 600, 23, 1.35 ) ),
		array_merge( array( '_id' => 'text',      'title' => 'Corpo de texto' ),   fachini_tipografia( 'Archivo', 400, 16, 1.6 ) ),
		array_merge( array( '_id' => 'accent',    'title' => 'Destaques e botões' ), fachini_tipografia( 'Archivo', 700, 15, 1, 0.05, 'uppercase' ) ),
	);

	// Escala de títulos (Elementor > Estilo do tema)
	$escala = array(
		'h1' => array( 'Mitr', 600, 56, 1.1, 0.06, 'uppercase' ),
		'h2' => array( 'Mitr', 600, 45, 1.15, 0.06, 'uppercase' ),
		'h3' => array( 'Archivo', 600, 36, 1.25, 0.02, 'none' ),
		'h4' => array( 'Archivo', 600, 29, 1.3, 0, 'none' ),
		'h5' => array( 'Archivo', 600, 23, 1.35, 0, 'none' ),
		'h6' => array( 'Archivo', 600, 19, 1.4, 0, 'none' ),
	);

	foreach ( $escala as $tag => $v ) {
		foreach ( fachini_tipografia( $v[0], $v[1], $v[2], $v[3], $v[4], $v[5] ) as $chave => $valor ) {
			$ajustes[ $tag . '_' . $chave ] = $valor;
		}
		$ajustes[ $tag . '_color' ] = '#15274E';
	}

	// Corpo de texto
	foreach ( fachini_tipografia( 'Archivo', 400, 16, 1.6 ) as $chave => $valor ) {
		$ajustes[ 'body_' . $chave ] = $valor;
	}
	$ajustes['body_color'] = '#0F0F0F';

	// Links
	$ajustes['link_normal_color'] = '#E01E26';
	$ajustes['link_hover_color']  = '#B01319';

	// Botões
	foreach ( fachini_tipografia( 'Archivo', 700, 15, 1, 0.05, 'uppercase' ) as $chave => $valor ) {
		$ajustes[ 'button_' . $chave ] = $valor;
	}
	$ajustes['button_text_color']             = '#FFFFFF';
	$ajustes['button_background_color']       = '#E01E26';
	$ajustes['button_hover_text_color']       = '#FFFFFF';
	$ajustes['button_background_hover_color'] = '#B01319';
	$ajustes['button_border_radius']          = array( 'unit' => 'px', 'top' => '4', 'right' => '4', 'bottom' => '4', 'left' => '4', 'isLinked' => true );

	// Largura de conteúdo e espaçamento (base 8, seção 96 no desktop)
	$ajustes['container_width']        = array( 'unit' => 'px', 'size' => 1200 );
	$ajustes['space_between_widgets']  = array( 'unit' => 'px', 'size' => 24 );
	$ajustes['page_title_selector']    = 'h1.entry-title';

	update_post_meta( $kit_id, '_elementor_page_settings', $ajustes );

	// Limpa o CSS gerado, senão o site continua servindo o estilo antigo.
	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	update_option( 'fachini_stylekit_versao', FACHINI_STYLEKIT_VERSAO );
}
add_action( 'init', 'fachini_aplicar_style_kit', 25 );
