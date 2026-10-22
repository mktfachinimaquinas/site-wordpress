<?php
/**
 * Tema filho Hello Elementor - Fachini Máquinas.
 *
 * Aqui entra todo o código personalizado do site. O tema pai (Hello Elementor)
 * nunca é editado, para que ele possa ser atualizado sem perder nada.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Carrega o CSS do tema pai e depois o do filho.
 */
function fachini_child_enqueue_styles() {
	wp_enqueue_style(
		'hello-elementor-child',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'hello-elementor', 'hello-elementor-theme-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'fachini_child_enqueue_styles', 20 );

/**
 * Abre e fecha a camada da busca (a camada em si vem do plugin Fachini Core).
 * Carregado no rodapé e com defer, para não atrasar a página.
 */
function fachini_child_busca_script() {
	wp_enqueue_script(
		'fachini-busca',
		get_stylesheet_directory_uri() . '/assets/busca.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true, 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', 'fachini_child_busca_script', 20 );

/**
 * Cabeçalho fixo, botão de voltar ao topo e abas no celular. Todas as páginas.
 */
function fachini_child_site_script() {
	wp_enqueue_script(
		'fachini-site',
		get_stylesheet_directory_uri() . '/assets/site.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true, 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', 'fachini_child_site_script', 20 );

/**
 * Galeria, barra das seções e vídeo da página da máquina. Só nessa página.
 */
function fachini_child_maquina_script() {
	if ( ! is_singular( 'maquina' ) ) {
		return;
	}
	wp_enqueue_script(
		'fachini-maquina',
		get_stylesheet_directory_uri() . '/assets/maquina.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true, 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', 'fachini_child_maquina_script', 20 );

/**
 * Carrega as fontes do site.
 *
 * Decisão da Débora em 02/10/2026: a Geist é usada exclusivamente no hero.
 * No Figma o estilo do hero (DISPLAY/HERO) é a Geist Mono, então é ela que
 * carregamos. Todo o resto do site usa Archivo.
 *
 * Carregamos só os pesos realmente usados. Cada peso a mais é um arquivo a
 * mais para o visitante baixar, e isso pesa na nota de performance.
 */
function fachini_child_fontes() {
	// Uma única requisição, só com os pesos realmente usados no projeto.
	// Archivo: 400 texto, 500 rótulos, 600 destaques e botões, 700 títulos.
	// Geist Mono: 700, exclusiva do título do hero.
	// Inter: 700, só nos números da Home (é a fonte do componente no Figma).
	wp_enqueue_style(
		'fachini-fontes',
		'https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=Geist+Mono:wght@700&family=Inter:wght@700&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'fachini_child_fontes', 5 );

/**
 * Impede o Elementor de carregar as fontes por conta própria.
 *
 * Por padrão ele pede a Archivo em todos os pesos e itálicos, 18 arquivos,
 * sendo que o projeto usa quatro. Como já carregamos acima exatamente o que é
 * usado, aqui apenas desligamos a carga automática dele.
 */
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

/**
 * Abre a conexão com o servidor de fontes mais cedo, para o texto aparecer antes.
 */
function fachini_child_preconnect_fontes( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'fachini_child_preconnect_fontes', 10, 2 );

/**
 * Limpeza de cabeçalho: remove o que não é usado e só adiciona peso.
 */
remove_action( 'wp_head', 'wp_generator' );                 // esconde a versão do WordPress
remove_action( 'wp_head', 'wlwmanifest_link' );             // Windows Live Writer, descontinuado
remove_action( 'wp_head', 'rsd_link' );                     // Really Simple Discovery, não usado

/**
 * Desativa a API de comentários do site inteiro.
 * O site é institucional e não tem blog aberto a comentários. Comentário
 * habilitado sem uso é porta de spam.
 *
 * OBS.: se o blog previsto no projeto for aprovado e quiser comentários,
 * basta remover este bloco.
 */
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

/**
 * Remove a barra de emojis do WordPress.
 * Economiza uma requisição e alguns KB em toda página, e o site não usa emoji.
 */
add_action(
	'init',
	function () {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}
);

/**
 * ------------------------------------------------------------------
 * ESPAÇOS RESERVADOS PARA AS PRÓXIMAS ETAPAS
 * ------------------------------------------------------------------
 * Etapa 2: envio de e-mail por SMTP em código (sem plugin). As credenciais
 *          ficam em wp-config.php, nunca no banco de dados.
 *
 * Etapa 3: GTM, Pixel da Meta e RD Station carregados de forma adiada,
 *          respeitando o banner de consentimento (LGPD), e captura de
 *          UTM / gclid / fbclid para enviar junto com o lead.
 *
 * Cada um entra como um arquivo próprio em /includes, não solto aqui.
 */
