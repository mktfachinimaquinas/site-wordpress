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
