<?php
/**
 * Integrações de marketing (etapa 3), em código e sem plugin, como combinado:
 *
 * - Google Tag Manager: GA4, Google Ads e Pixel da Meta são configurados
 *   dentro do GTM. O site só carrega o GTM, e só depois de a pessoa aceitar
 *   cookies de análise ou de marketing no banner (consentimento.php). Antes
 *   disso, nenhuma tag dispara.
 * - RD Station Marketing: o script de rastreamento do RD (que também traz o
 *   RD Conversas) entra direto pelo site, não pelo GTM, também só com
 *   consentimento. E cada pedido de orçamento vai para o RD pela API de
 *   conversões, com a origem da visita (UTMs, gclid, fbclid e o cookie de
 *   origem do próprio RD), para a origem do lead aparecer certa lá dentro.
 *
 * Tudo fica desligado enquanto os códigos não forem preenchidos em
 * Configurações > Integrações. O SMTP (includes/smtp.php) também mostra o
 * estado nessa tela.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Identificador da conversão no RD Station.
define( 'FACHINI_RD_CONVERSAO', 'pedido-de-orcamento-site' );

function fachini_gtm_id() {
	$id = strtoupper( trim( (string) get_option( 'fachini_gtm_id', '' ) ) );
	return preg_match( '/^GTM-[A-Z0-9]{4,12}$/', $id ) ? $id : '';
}

function fachini_rd_script() {
	$url = trim( (string) get_option( 'fachini_rd_script', '' ) );
	return ( 0 === strpos( $url, 'https://' ) ) ? esc_url_raw( $url ) : '';
}

function fachini_rd_token() {
	return preg_replace( '/[^A-Za-z0-9]/', '', (string) get_option( 'fachini_rd_token', '' ) );
}

/* ---------------------------------------------------------------------------
   Site: carregamento das tags, depois do consentimento.
   ------------------------------------------------------------------------ */

function fachini_rastreamento_script() {
	if ( isset( $_GET['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	wp_enqueue_script(
		'fachini-rastreamento',
		plugins_url( 'assets/rastreamento.js', FACHINI_CORE_PATH . 'fachini-core.php' ),
		array(),
		FACHINI_CORE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	wp_add_inline_script(
		'fachini-rastreamento',
		'window.fachiniRastreamento = ' . wp_json_encode(
			array(
				'gtm' => fachini_gtm_id(),
				'rd'  => fachini_rd_script(),
			)
		) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'fachini_rastreamento_script' );

/* ---------------------------------------------------------------------------
   RD Station: cada pedido vira uma conversão.
   ------------------------------------------------------------------------ */

/**
 * Monta os dados da conversão. Separado do envio para poder ser conferido.
 */
function fachini_rd_dados( $d, $protocolo, $origem ) {
	$origem = is_array( $origem ) ? $origem : array();
	$tags   = array_filter(
		array(
			'site',
			$d['categoria_nome'] ? sanitize_title( $d['categoria_nome'] ) : '',
			'pj' === $d['tipo'] ? 'empresa' : 'pessoa-fisica',
		)
	);

	$payload = array(
		'conversion_identifier' => FACHINI_RD_CONVERSAO,
		'email'                 => $d['email'],
		'name'                  => $d['nome'],
		'mobile_phone'          => $d['whatsapp'],
		'city'                  => $d['cidade'],
		'state'                 => $d['uf'],
		'tags'                  => array_values( $tags ),
		'available_for_mailing' => (bool) $d['aceite_marketing'],
		'legal_bases'           => array(
			array(
				'category' => 'communications',
				'type'     => 'consent',
				'status'   => $d['aceite_contato'] ? 'granted' : 'declined',
			),
		),
	);
	if ( 'pj' === $d['tipo'] ) {
		$payload['company_name'] = $d['empresa'];
		$payload['job_title']    = $d['cargo'];
	}

	// Origem: o cookie do próprio RD vale mais; sem ele, as UTMs.
	if ( ! empty( $origem['rd_src'] ) ) {
		$payload['traffic_source'] = $origem['rd_src'];
	} elseif ( ! empty( $origem['utm_source'] ) ) {
		$payload['traffic_source']   = $origem['utm_source'];
		$payload['traffic_medium']   = isset( $origem['utm_medium'] ) ? $origem['utm_medium'] : '';
		$payload['traffic_campaign'] = isset( $origem['utm_campaign'] ) ? $origem['utm_campaign'] : '';
		$payload['traffic_value']    = isset( $origem['utm_term'] ) ? $origem['utm_term'] : '';
	} elseif ( ! empty( $origem['gclid'] ) ) {
		$payload['traffic_source'] = 'google';
		$payload['traffic_medium'] = 'cpc';
	}

	return array(
		'event_type'   => 'CONVERSION',
		'event_family' => 'CDP',
		'payload'      => array_filter(
			$payload,
			function ( $valor ) {
				return '' !== $valor && null !== $valor && array() !== $valor;
			}
		),
	);
}

/**
 * Envia o pedido ao RD. Roda depois de o pedido estar gravado: se o RD
 * falhar, o pedido continua salvo e o motivo fica anotado nele.
 */
function fachini_rd_enviar_pedido( $id, $d, $protocolo, $origem ) {
	$token = fachini_rd_token();
	if ( '' === $token ) {
		update_post_meta( $id, 'fachini_pedido_rd', 'sem token configurado' );
		return;
	}

	$endereco = apply_filters( 'fachini_rd_endpoint', 'https://api.rd.services/platform/conversions?api_key=' . rawurlencode( $token ) );
	$resposta = wp_remote_post(
		$endereco,
		array(
			'timeout' => 8,
			'headers' => array(
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			),
			'body'    => wp_json_encode( fachini_rd_dados( $d, $protocolo, $origem ) ),
		)
	);

	if ( is_wp_error( $resposta ) ) {
		update_post_meta( $id, 'fachini_pedido_rd', 'falhou: ' . $resposta->get_error_message() );
		return;
	}
	$codigo = (int) wp_remote_retrieve_response_code( $resposta );
	update_post_meta( $id, 'fachini_pedido_rd', ( $codigo >= 200 && $codigo < 300 ) ? 'enviado' : 'falhou: HTTP ' . $codigo . ' ' . mb_substr( wp_remote_retrieve_body( $resposta ), 0, 200 ) );
}
add_action( 'fachini_pedido_recebido', 'fachini_rd_enviar_pedido', 10, 4 );

/* ---------------------------------------------------------------------------
   Painel: Configurações > Integrações.
   ------------------------------------------------------------------------ */

function fachini_integracoes_menu() {
	add_options_page( 'Integrações do site', 'Integrações', 'manage_options', 'fachini-integracoes', 'fachini_integracoes_tela' );
}
add_action( 'admin_menu', 'fachini_integracoes_menu' );

function fachini_integracoes_ajustes() {
	register_setting(
		'fachini_integracoes',
		'fachini_gtm_id',
		array(
			'type'              => 'string',
			'default'           => '',
			'sanitize_callback' => function ( $valor ) {
				$valor = strtoupper( trim( (string) $valor ) );
				return ( '' === $valor || preg_match( '/^GTM-[A-Z0-9]{4,12}$/', $valor ) ) ? $valor : '';
			},
		)
	);
	register_setting(
		'fachini_integracoes',
		'fachini_rd_script',
		array(
			'type'              => 'string',
			'default'           => '',
			'sanitize_callback' => function ( $valor ) {
				// Aceita o endereço do script ou o código inteiro que o RD fornece.
				if ( preg_match( '#https://[^\s"\'<>]+\.js#', (string) $valor, $m ) ) {
					return esc_url_raw( $m[0] );
				}
				return '';
			},
		)
	);
	register_setting(
		'fachini_integracoes',
		'fachini_rd_token',
		array(
			'type'              => 'string',
			'default'           => '',
			'sanitize_callback' => function ( $valor ) {
				return preg_replace( '/[^A-Za-z0-9]/', '', (string) $valor );
			},
		)
	);
}
add_action( 'admin_init', 'fachini_integracoes_ajustes' );

function fachini_integracoes_tela() {
	$smtp = function_exists( 'fachini_smtp_configurado' ) && fachini_smtp_configurado();
	?>
	<div class="wrap">
		<h1>Integrações do site</h1>
		<p>Os códigos abaixo só são usados depois que o visitante aceita cookies de análise ou de marketing no banner. Em branco, a integração fica desligada.</p>
		<?php if ( isset( $_GET['fachini_teste'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-<?php echo 'ok' === $_GET['fachini_teste'] ? 'success' : 'error'; // phpcs:ignore ?>"><p><?php echo 'ok' === $_GET['fachini_teste'] ? 'E-mail de teste enviado. Confira a caixa de entrada (e o spam).' : 'O e-mail de teste não foi enviado. Confira os dados do SMTP no wp-config.php.'; // phpcs:ignore ?></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'fachini_integracoes' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="fachini_gtm_id">Google Tag Manager</label></th>
					<td>
						<input name="fachini_gtm_id" id="fachini_gtm_id" type="text" class="regular-text" placeholder="GTM-XXXXXXX" value="<?php echo esc_attr( (string) get_option( 'fachini_gtm_id', '' ) ); ?>">
						<p class="description">GA4, Google Ads e Pixel da Meta são configurados dentro do GTM.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fachini_rd_script">Script do RD Station</label></th>
					<td>
						<input name="fachini_rd_script" id="fachini_rd_script" type="text" class="large-text" placeholder="https://d335luupugsy2.cloudfront.net/js/loader-scripts/...-loader.js" value="<?php echo esc_attr( (string) get_option( 'fachini_rd_script', '' ) ); ?>">
						<p class="description">O endereço do código de rastreamento do RD (pode colar o código inteiro; só o endereço é guardado). Também carrega o RD Conversas.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fachini_rd_token">Token público do RD Station</label></th>
					<td>
						<input name="fachini_rd_token" id="fachini_rd_token" type="text" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'fachini_rd_token', '' ) ); ?>">
						<p class="description">Envia cada pedido de orçamento ao RD como conversão "<?php echo esc_html( FACHINI_RD_CONVERSAO ); ?>", com a origem da visita.</p>
					</td>
				</tr>
				<tr>
					<th scope="row">E-mail (SMTP)</th>
					<td>
						<p><?php echo $smtp ? 'Configurado no wp-config.php.' : 'Não configurado: os e-mails saem pelo envio padrão do servidor.'; ?></p>
						<p class="description">As credenciais ficam no wp-config.php, nunca no banco de dados (ver includes/smtp.php).</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="fachini_teste_email">
			<?php wp_nonce_field( 'fachini_teste_email' ); ?>
			<?php submit_button( 'Enviar e-mail de teste para ' . wp_get_current_user()->user_email, 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}

function fachini_teste_email() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Sem permissão.' );
	}
	check_admin_referer( 'fachini_teste_email' );
	$ok = wp_mail( wp_get_current_user()->user_email, 'Teste de e-mail do site', "Este é um e-mail de teste do site da Fachini Máquinas.\n\nSe chegou, o envio de e-mails do site está funcionando." );
	wp_safe_redirect( admin_url( 'options-general.php?page=fachini-integracoes&fachini_teste=' . ( $ok ? 'ok' : 'falhou' ) ) );
	exit;
}
add_action( 'admin_post_fachini_teste_email', 'fachini_teste_email' );
