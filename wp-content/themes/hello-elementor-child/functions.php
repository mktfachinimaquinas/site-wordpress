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
 * Carrega as fontes do site, do próprio servidor (assets/fontes/).
 *
 * Decisão da Débora em 02/10/2026: a Geist é usada exclusivamente no hero.
 * No Figma o estilo do hero (DISPLAY/HERO) é a Geist Mono, então é ela que
 * carregamos. Todo o resto do site usa Archivo.
 *
 * Desde 22/10/2026 os arquivos ficam no tema, e não no Google Fonts: a
 * página não espera mais a conexão com outro servidor para mostrar o texto,
 * e o IP do visitante não vai para o Google sem consentimento. São os mesmos
 * arquivos que o Google entregava (só o alfabeto latino, que cobre o
 * português), com licença OFL (assets/fontes/OFL-*.txt).
 *
 * Archivo: um arquivo variável com todos os pesos (400 texto, 500 rótulos,
 * 600 destaques e botões, 700 títulos). Geist Mono 700: título do hero.
 * Inter 700: números da Home.
 */
function fachini_child_fontes() {
	$base  = get_stylesheet_directory_uri() . '/assets/fontes/';
	$faixa = 'U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD';
	$fonte = function ( $familia, $peso, $arquivo ) use ( $base, $faixa ) {
		return "@font-face{font-family:'" . $familia . "';font-style:normal;font-weight:" . $peso . ';font-display:swap;src:url(' . esc_url( $base . $arquivo ) . ") format('woff2');unicode-range:" . $faixa . ";}\n";
	};

	// A Archivo está em quase todo texto: o navegador já começa a baixar.
	echo '<link rel="preload" href="' . esc_url( $base . 'archivo-latin.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	echo "<style id=\"fachini-fontes\">\n"
		. $fonte( 'Archivo', '400 700', 'archivo-latin.woff2' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- montado acima com esc_url.
		. $fonte( 'Geist Mono', '700', 'geist-mono-700-latin.woff2' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. $fonte( 'Inter', '700', 'inter-700-latin.woff2' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		. "</style>\n";
}
add_action( 'wp_head', 'fachini_child_fontes', 3 );

/**
 * Home: a foto do hero é fundo de um container do Elementor, e o navegador só
 * a encontra depois de ler todo o CSS. Ela é o maior elemento da tela, então
 * avisamos logo no começo do <head> para baixá-la primeiro. O endereço sai do
 * próprio Elementor (container com a classe fachini-home-hero): trocar a foto
 * no editor não exige mexer aqui.
 */
function fachini_child_foto_hero( $elementos ) {
	foreach ( (array) $elementos as $elemento ) {
		$ajustes = isset( $elemento['settings'] ) ? $elemento['settings'] : array();
		$classes = ( isset( $ajustes['css_classes'] ) ? $ajustes['css_classes'] : '' ) . ' ' . ( isset( $ajustes['_css_classes'] ) ? $ajustes['_css_classes'] : '' );
		if ( false !== strpos( $classes, 'fachini-home-hero' ) && ! empty( $ajustes['background_image']['url'] ) ) {
			return $ajustes['background_image']['url'];
		}
		if ( ! empty( $elemento['elements'] ) ) {
			$achou = fachini_child_foto_hero( $elemento['elements'] );
			if ( $achou ) {
				return $achou;
			}
		}
	}
	return '';
}

function fachini_child_preload_hero() {
	if ( ! is_front_page() ) {
		return;
	}
	$dados = json_decode( (string) get_post_meta( get_queried_object_id(), '_elementor_data', true ), true );
	$foto  = fachini_child_foto_hero( $dados );
	if ( $foto ) {
		echo '<link rel="preload" as="image" href="' . esc_url( $foto ) . '" fetchpriority="high">' . "\n";
	}
}
add_action( 'wp_head', 'fachini_child_preload_hero', 2 );

/**
 * Home: como a foto do hero é a primeira a carregar, nenhuma foto do conteúdo
 * (as das abas, mais abaixo) recebe prioridade alta, que o WordPress daria à
 * primeira imagem da página.
 */
function fachini_child_sem_prioridade_na_home( $atributos ) {
	if ( is_front_page() && isset( $atributos['fetchpriority'] ) && 'high' === $atributos['fetchpriority'] ) {
		unset( $atributos['fetchpriority'] );
	}
	return $atributos;
}
add_filter( 'wp_get_loading_optimization_attributes', 'fachini_child_sem_prioridade_na_home' );

/**
 * Impede o Elementor de carregar as fontes por conta própria.
 *
 * Por padrão ele pede a Archivo em todos os pesos e itálicos, 18 arquivos,
 * sendo que o projeto usa quatro. Como já carregamos acima exatamente o que é
 * usado, aqui apenas desligamos a carga automática dele.
 */
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

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
