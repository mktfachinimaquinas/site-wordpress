<?php
/**
 * Modelos do Theme Builder criados por código.
 *
 * São cinco: página de máquina, listagem de categoria, listagem de todas as
 * máquinas (/maquinas/), cabeçalho e rodapé. Eles nascem aqui para poderem
 * ser recriados em qualquer ambiente, mas depois disso são editáveis
 * normalmente no Elementor. Um modelo que já existe só tem o layout
 * reescrito quando FACHINI_TEMPLATES_LAYOUT muda (ver abaixo).
 *
 * O conteúdo das máquinas (especificações, catálogo, vídeo, relacionadas) é
 * renderizado por shortcode, em includes/shortcodes.php, e não por widget do
 * Elementor. Assim o dado continua nosso e o Elementor cuida só do visual.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Mudar esta versão faz a rotina rodar de novo: cria os modelos que faltam e
// reaplica tipo e condições de todos.
define( 'FACHINI_TEMPLATES_VERSAO', '2026-10-06a' );

// Mudar esta outra reescreve o layout dos modelos que já existem, a partir do
// código. Fica separada para que acrescentar um modelo novo não apague ajuste
// feito à mão nos outros.
define( 'FACHINI_TEMPLATES_LAYOUT', '2026-10-02e' );

/**
 * Gera um id curto no formato que o Elementor usa.
 */
function fachini_el_id() {
	return substr( md5( uniqid( '', true ) ), 0, 7 );
}

/**
 * Monta um widget.
 */
function fachini_el_widget( $tipo, $settings = array() ) {
	return array(
		'id'         => fachini_el_id(),
		'elType'     => 'widget',
		'widgetType' => $tipo,
		'settings'   => $settings,
		'elements'   => array(),
	);
}

/**
 * Monta uma seção de uma coluna com os widgets informados.
 */
function fachini_el_secao( $widgets, $settings = array() ) {
	return array(
		'id'       => fachini_el_id(),
		'elType'   => 'section',
		'settings' => $settings,
		'elements' => array(
			array(
				'id'       => fachini_el_id(),
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100, '_inline_size' => null ),
				'elements' => $widgets,
			),
		),
	);
}

/**
 * Layout da página de máquina.
 */
function fachini_layout_maquina() {
	return array(

		// Caminho de navegação
		fachini_el_secao(
			array(
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_breadcrumb]' ) ),
			),
			array( 'padding' => array( 'unit' => 'px', 'top' => '24', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false ) )
		),

		// Nome da máquina e descrição curta
		fachini_el_secao(
			array(
				fachini_el_widget(
					'theme-post-title',
					array(
						'title_tag'   => 'h1',
						'title'       => '',
						'__dynamic__' => array( 'title' => '[elementor-tag id="fachtit" name="post-title" settings="%7B%7D"]' ),
					)
				),
				fachini_el_widget( 'theme-post-excerpt', array() ),
			),
			array( 'padding' => array( 'unit' => 'px', 'top' => '16', 'right' => '0', 'bottom' => '24', 'left' => '0', 'isLinked' => false ) )
		),

		// Foto principal
		fachini_el_secao(
			array(
				fachini_el_widget( 'theme-post-featured-image', array( 'image' => array( 'id' => '', 'url' => '' ), 'image_size' => 'large' ) ),
			)
		),

		// Especificações
		fachini_el_secao(
			array(
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_especificacoes]' ) ),
			),
			array( 'padding' => array( 'unit' => 'px', 'top' => '48', 'right' => '0', 'bottom' => '24', 'left' => '0', 'isLinked' => false ) )
		),

		// Vídeo e catálogo
		fachini_el_secao(
			array(
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_video]' ) ),
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_catalogo]' ) ),
			),
			array( 'padding' => array( 'unit' => 'px', 'top' => '24', 'right' => '0', 'bottom' => '24', 'left' => '0', 'isLinked' => false ) )
		),

		// Chamada para orçamento
		fachini_el_secao(
			array(
				fachini_el_widget(
					'heading',
					array( 'title' => 'Quer um orçamento desta máquina?', 'header_size' => 'h3' )
				),
				fachini_el_widget(
					'button',
					array(
						'text' => 'Falar com um especialista',
						'link' => array( 'url' => '/contato/', 'is_external' => '', 'nofollow' => '' ),
						'size' => 'lg',
					)
				),
			),
			array(
				'background_background' => 'classic',
				'background_color'      => '#F1F3F6',
				'padding'               => array( 'unit' => 'px', 'top' => '48', 'right' => '24', 'bottom' => '48', 'left' => '24', 'isLinked' => false ),
			)
		),

		// Relacionadas
		fachini_el_secao(
			array(
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_relacionadas]' ) ),
			),
			array( 'padding' => array( 'unit' => 'px', 'top' => '48', 'right' => '0', 'bottom' => '48', 'left' => '0', 'isLinked' => false ) )
		),
	);
}

/**
 * Layout da listagem de categoria.
 */
function fachini_layout_categoria() {
	return array(

		fachini_el_secao(
			array(
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_breadcrumb]' ) ),
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_titulo_arquivo]' ) ),
			),
			array( 'padding' => array( 'unit' => 'px', 'top' => '24', 'right' => '0', 'bottom' => '16', 'left' => '0', 'isLinked' => false ) )
		),

		fachini_el_secao(
			array(
				fachini_el_widget(
					'archive-posts',
					array(
						'_skin'                   => 'archive_classic',
						'archive_classic_columns'         => '3',
						'archive_classic_columns_tablet'  => '2',
						'archive_classic_columns_mobile'  => '1',
						'archive_classic_meta_data'       => array(),
						'archive_classic_show_author'     => '',
						'archive_classic_show_date'       => '',
						'archive_classic_show_comments'   => '',
						'archive_classic_title_tag'       => 'h3',
						// O h3 global tem 36px, grande demais para card. Aqui fica no tamanho de rótulo (20px).
						'archive_classic_title_typography_typography'  => 'custom',
						'archive_classic_title_typography_font_family' => 'Archivo',
						'archive_classic_title_typography_font_weight' => '600',
						'archive_classic_title_typography_font_size'   => array( 'unit' => 'px', 'size' => 20 ),
						'archive_classic_title_typography_line_height' => array( 'unit' => 'em', 'size' => 1.3 ),
						'archive_classic_title_typography_text_transform' => 'none',
						'archive_classic_show_excerpt'    => 'yes',
						'archive_classic_excerpt_length'  => 18,
						'archive_classic_show_read_more'  => 'yes',
						'archive_classic_read_more_text'  => 'Ver máquina',
						'archive_classic_image_size'      => 'medium_large',
					)
				),
			),
			array( 'padding' => array( 'unit' => 'px', 'top' => '16', 'right' => '0', 'bottom' => '64', 'left' => '0', 'isLinked' => false ) )
		),
	);
}


/**
 * Cabeçalho: variante escura da barra de navegação desenhada pela Débora.
 * Fundo navy, logo horizontal à esquerda e menu à direita.
 */
function fachini_layout_cabecalho() {
	$logo_id  = (int) get_option( 'fachini_logo_id' );
	$logo_url = $logo_id ? wp_get_attachment_url( $logo_id ) : '';

	$coluna_logo = array(
		'id'       => fachini_el_id(),
		'elType'   => 'column',
		'settings' => array( '_column_size' => 30, '_inline_size' => 30 ),
		'elements' => array(
			fachini_el_widget(
				'theme-site-logo',
				array(
					'image'      => array( 'id' => $logo_id, 'url' => $logo_url ),
					'image_size' => 'medium',
					'align'      => 'left',
					'width'      => array( 'unit' => 'px', 'size' => 200 ),
					'link_to'    => 'home',
				)
			),
		),
	);

	$coluna_menu = array(
		'id'       => fachini_el_id(),
		'elType'   => 'column',
		'settings' => array( '_column_size' => 70, '_inline_size' => 70 ),
		'elements' => array(
			fachini_el_widget(
				'nav-menu',
				array(
					'menu'            => 'menu-principal',
					'align'           => 'right',
					'layout'          => 'horizontal',
					'color_menu_item' => '#FFFFFF',
					'color_menu_item_hover' => '#E01E26',
					'pointer'         => 'underline',
					'menu_typography_typography'      => 'custom',
					'menu_typography_font_family'     => 'Archivo',
					'menu_typography_font_size'       => array( 'unit' => 'px', 'size' => 16 ),
					'menu_typography_font_weight'     => '400',
					'menu_typography_line_height'     => array( 'unit' => 'em', 'size' => 1.5 ),
					'menu_typography_text_transform'  => 'uppercase',
					'menu_typography_letter_spacing'  => array( 'unit' => 'px', 'size' => 0 ),
					'padding_horizontal_menu_item'    => array( 'unit' => 'px', 'size' => 14 ),
					'toggle_align'    => 'right',
					'color_menu_item_active' => '#E01E26',
				)
			),
		),
	);

	return array(
		array(
			'id'       => fachini_el_id(),
			'elType'   => 'section',
			'settings' => array(
				'background_background' => 'classic',
				'background_color'      => '#15274E',
				'padding'               => array( 'unit' => 'px', 'top' => '16', 'right' => '24', 'bottom' => '16', 'left' => '24', 'isLinked' => false ),
				'content_width'         => 'boxed',
				'structure'             => '20',
			),
			'elements' => array( $coluna_logo, $coluna_menu ),
		),
	);
}

/**
 * Rodapé: navy escuro, com identificação da empresa e links legais.
 * O conteúdo real das unidades entra quando o cliente enviar os dados.
 */
function fachini_layout_rodape() {
	return array(
		array(
			'id'       => fachini_el_id(),
			'elType'   => 'section',
			'settings' => array(
				'background_background' => 'classic',
				'background_color'      => '#00224E',
				'padding'               => array( 'unit' => 'px', 'top' => '48', 'right' => '24', 'bottom' => '32', 'left' => '24', 'isLinked' => false ),
			),
			'elements' => array(
				array(
					'id'       => fachini_el_id(),
					'elType'   => 'column',
					'settings' => array( '_column_size' => 100 ),
					'elements' => array(
						fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_rodape]' ) ),
					),
				),
			),
		),
	);
}

/**
 * Cria os modelos, se ainda não existirem.
 */
function fachini_seed_templates() {

	// Logo oficial enviado pela Débora em 02/10/2026.
	// LIGHT_H é a versão horizontal com o texto claro, para o cabeçalho navy.
	// DARK_H é a versão para fundo claro; LIGHT_V é a vertical, para uso futuro.
	$logo_atual = (int) get_option( 'fachini_logo_id' );
	$oficial    = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'name'           => 'light_h',
		)
	);

	if ( ! empty( $oficial ) && (int) $oficial[0] !== $logo_atual ) {
		update_option( 'fachini_logo_id', (int) $oficial[0] );
		// Força o cabeçalho a ser remontado com o logo novo.
		delete_option( 'fachini_templates_layout' );
	}


	if ( get_option( 'fachini_templates_versao' ) === FACHINI_TEMPLATES_VERSAO ) {
		return;
	}

	if ( ! did_action( 'elementor/loaded' ) || ! post_type_exists( 'elementor_library' ) ) {
		return;
	}

	$modelos = array(
		array(
			'titulo'     => 'Máquina (página individual)',
			'tipo'       => 'single-post',
			'layout'     => fachini_layout_maquina(),
			'condicoes'  => array( 'include/singular/maquina' ),
			'chave'      => 'fachini_tpl_maquina',
		),
		array(
			'titulo'     => 'Cabeçalho do site',
			'tipo'       => 'header',
			'layout'     => fachini_layout_cabecalho(),
			'condicoes'  => array( 'include/general' ),
			'chave'      => 'fachini_tpl_cabecalho',
		),
		array(
			'titulo'     => 'Rodapé do site',
			'tipo'       => 'footer',
			'layout'     => fachini_layout_rodape(),
			'condicoes'  => array( 'include/general' ),
			'chave'      => 'fachini_tpl_rodape',
		),
		array(
			'titulo'     => 'Categoria de máquinas (listagem)',
			'tipo'       => 'archive',
			'layout'     => fachini_layout_categoria(),
			'condicoes'  => array( 'include/archive/taxonomy/categoria_maquina', 'include/archive/categoria_maquina' ),
			'chave'      => 'fachini_tpl_categoria',
		),
		array(
			// /maquinas/, o primeiro item do menu. A condição de arquivo de um tipo
			// de conteúdo no Elementor Pro é "<tipo>_archive", diferente da de taxonomia.
			'titulo'     => 'Listagem de máquinas (todas)',
			'tipo'       => 'archive',
			'layout'     => fachini_layout_categoria(),
			'condicoes'  => array( 'include/archive/maquina_archive' ),
			'chave'      => 'fachini_tpl_listagem',
		),
	);

	foreach ( $modelos as $modelo ) {

		$post_id = (int) get_option( $modelo['chave'] );

		// Cria apenas se ainda não existir. O layout de um modelo já criado só é
		// reescrito quando FACHINI_TEMPLATES_LAYOUT muda.
		$forcar_layout = ( get_option( 'fachini_templates_layout' ) !== FACHINI_TEMPLATES_LAYOUT );

		if ( $post_id && get_post( $post_id ) && $forcar_layout ) {
			// Atualização única do layout. Seguro enquanto os modelos ainda não
			// foram editados à mão; depois disso, esta rotina não roda mais.
			update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $modelo['layout'] ) ) );
		}

		if ( ! $post_id || ! get_post( $post_id ) ) {

			$post_id = wp_insert_post(
				array(
					'post_title'  => $modelo['titulo'],
					'post_type'   => 'elementor_library',
					'post_status' => 'publish',
				)
			);

			if ( is_wp_error( $post_id ) || ! $post_id ) {
				continue;
			}

			update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
			update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $modelo['layout'] ) ) );
			update_option( $modelo['chave'], $post_id );
		}

		// Tipo, classificação e condições são sempre reaplicados: é o que faz o
		// modelo aparecer no Construtor de Temas e valer para as páginas certas.
		update_post_meta( $post_id, '_elementor_template_type', $modelo['tipo'] );
		update_post_meta( $post_id, '_elementor_conditions', $modelo['condicoes'] );
		wp_set_object_terms( $post_id, $modelo['tipo'], 'elementor_library_type', false );
	}

	// O Elementor Pro guarda as condições em cache. Sem limpar, um modelo
	// criado fora do editor existe mas não é aplicado a nenhuma página.
	delete_option( 'elementor_pro_theme_builder_conditions' );

	if ( class_exists( '\ElementorPro\Plugin' ) ) {
		try {
			$modulos = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'theme-builder' );
			if ( $modulos && method_exists( $modulos, 'get_conditions_manager' ) ) {
				$cache = $modulos->get_conditions_manager()->get_cache();
				if ( method_exists( $cache, 'regenerate' ) ) {
					$cache->regenerate();
				}
			}
		} catch ( \Throwable $e ) {
			// Se a API do Elementor mudar, seguimos com o cache apagado acima.
			error_log( 'Fachini Core: não foi possível regenerar o cache de condições do Elementor. ' . $e->getMessage() );
		}
	}

	// Limpa o CSS gerado para os modelos novos aparecerem já estilizados.
	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	update_option( 'fachini_templates_layout', FACHINI_TEMPLATES_LAYOUT );
	update_option( 'fachini_templates_versao', FACHINI_TEMPLATES_VERSAO );
}
add_action( 'init', 'fachini_seed_templates', 30 );
