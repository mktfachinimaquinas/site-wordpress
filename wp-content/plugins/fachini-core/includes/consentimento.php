<?php
/**
 * Banner de cookies (LGPD), em código e sem plugin, ligado ao Consent Mode do
 * Google, como combinado na proposta.
 *
 * As categorias são as da Política de Privacidade (item 6): Essenciais
 * (sempre ativos), Desempenho e análise, Marketing e remarketing. Até a pessoa
 * escolher, tudo que não é essencial fica negado. A escolha fica num cookie
 * essencial (fachini_consentimento) por 12 meses e pode ser revista pelo link
 * "Preferências de cookies" da política, ou por qualquer link para
 * #preferencias-cookies.
 *
 * As tags (Google Tag Manager, Analytics, Meta Pixel) entram na etapa 3 e
 * leem esta escolha: o padrão do Consent Mode é declarado aqui, antes delas,
 * e cada escolha gera o evento "fachini_consentimento" no dataLayer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Mudar a versão faz o banner aparecer de novo para todos (ex.: categoria nova).
define( 'FACHINI_COOKIES_VERSAO', '1' );

/**
 * Página aberta dentro do editor do Elementor: sem banner.
 */
function fachini_cookies_no_editor() {
	return isset( $_GET['elementor-preview'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

/**
 * Consent Mode: o padrão (negado) e, se a pessoa já escolheu, a escolha dela.
 * Vai no começo do <head>, antes de qualquer tag. data-no-optimize impede o
 * LiteSpeed de adiar este script.
 */
function fachini_cookies_padrao() {
	if ( fachini_cookies_no_editor() ) {
		return;
	}
	$versao = wp_json_encode( FACHINI_COOKIES_VERSAO );
	$script = "window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}"
		. "gtag('consent','default',{ad_storage:'denied',ad_user_data:'denied',ad_personalization:'denied',analytics_storage:'denied',functionality_storage:'granted',security_storage:'granted',wait_for_update:500});"
		. "(function(){var m=document.cookie.match(/(?:^|; )fachini_consentimento=([^;]*)/);if(!m){return;}"
		. "var p=decodeURIComponent(m[1]).split('|');if(p[0]!==" . $versao . "){return;}"
		. "var a=p[1]==='1'?'granted':'denied',k=p[2]==='1'?'granted':'denied';"
		. "gtag('consent','update',{analytics_storage:a,ad_storage:k,ad_user_data:k,ad_personalization:k});})();";

	wp_print_inline_script_tag(
		$script,
		array(
			'id'                => 'fachini-consent-mode',
			'data-no-optimize'  => '1',
			'data-cfasync'      => 'false',
		)
	);
}
add_action( 'wp_head', 'fachini_cookies_padrao', 1 );

/**
 * O banner. Sai em todas as páginas, escondido; o script mostra só para quem
 * ainda não escolheu. Assim a página pode ficar no cache.
 */
function fachini_cookies_banner() {
	if ( fachini_cookies_no_editor() ) {
		return;
	}
	$politica = home_url( '/politica-de-privacidade/' );
	?>
	<div class="fachini-cookies" id="preferencias-cookies" role="region" aria-labelledby="fachini-cookies-titulo" data-versao="<?php echo esc_attr( FACHINI_COOKIES_VERSAO ); ?>" hidden>
		<div class="fachini-cookies__caixa">
			<p class="fachini-cookies__titulo" id="fachini-cookies-titulo">Cookies</p>
			<p class="fachini-cookies__texto">Usamos cookies para o site funcionar e, se você autorizar, para medir a audiência e mensurar campanhas. Você pode aceitar, recusar os não essenciais ou escolher por categoria. Saiba mais na <a href="<?php echo esc_url( $politica . '#cookies' ); ?>">Política de Privacidade</a>.</p>
			<div class="fachini-cookies__opcoes" hidden>
				<label class="fachini-cookies__opcao">
					<input type="checkbox" checked disabled>
					<span><strong>Essenciais</strong> Segurança, sessão e funcionamento do formulário. Sempre ativos.</span>
				</label>
				<label class="fachini-cookies__opcao">
					<input type="checkbox" name="analise">
					<span><strong>Desempenho e análise</strong> Medir o uso e melhorar o site.</span>
				</label>
				<label class="fachini-cookies__opcao">
					<input type="checkbox" name="marketing">
					<span><strong>Marketing e remarketing</strong> Mensurar campanhas e exibir anúncios.</span>
				</label>
			</div>
			<div class="fachini-cookies__acoes">
				<button type="button" class="fachini-cookies__botao" data-acao="recusar">Recusar não essenciais</button>
				<button type="button" class="fachini-cookies__botao" data-acao="escolher">Escolher</button>
				<button type="button" class="fachini-cookies__botao" data-acao="salvar" hidden>Salvar escolhas</button>
				<button type="button" class="fachini-cookies__botao fachini-cookies__botao--aceitar" data-acao="aceitar">Aceitar todos</button>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'fachini_cookies_banner', 20 );

function fachini_cookies_script() {
	if ( fachini_cookies_no_editor() ) {
		return;
	}
	wp_enqueue_script(
		'fachini-consentimento',
		plugins_url( 'assets/consentimento.js', FACHINI_CORE_PATH . 'fachini-core.php' ),
		array(),
		FACHINI_CORE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'fachini_cookies_script' );
