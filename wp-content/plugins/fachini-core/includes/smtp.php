<?php
/**
 * Envio de e-mail por SMTP, em código e sem plugin, como combinado na
 * proposta. Usa a caixa de e-mail da Fachini (Hostinger), o que faz os
 * pedidos de orçamento chegarem na caixa de entrada, e não no spam.
 *
 * As credenciais ficam no wp-config.php, nunca no banco de dados:
 *
 *   define( 'FACHINI_SMTP_HOST', 'smtp.hostinger.com' );
 *   define( 'FACHINI_SMTP_PORT', 465 );
 *   define( 'FACHINI_SMTP_SECURE', 'ssl' );              // ou 'tls' com a porta 587
 *   define( 'FACHINI_SMTP_USER', 'site@fachinimaquinas.com.br' );
 *   define( 'FACHINI_SMTP_PASS', 'senha da caixa' );
 *   define( 'FACHINI_SMTP_FROM_NAME', 'Site Fachini Máquinas' );   // opcional
 *
 * Sem essas constantes, o WordPress envia do jeito padrão do servidor. O
 * teste fica em Configurações > Integrações.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fachini_smtp_configurado() {
	return defined( 'FACHINI_SMTP_HOST' ) && defined( 'FACHINI_SMTP_USER' ) && defined( 'FACHINI_SMTP_PASS' ) && '' !== FACHINI_SMTP_HOST;
}

function fachini_smtp( $mail ) {
	if ( ! fachini_smtp_configurado() ) {
		return;
	}
	$mail->isSMTP();
	$mail->Host       = FACHINI_SMTP_HOST;
	$mail->Port       = defined( 'FACHINI_SMTP_PORT' ) ? (int) FACHINI_SMTP_PORT : 465;
	$mail->SMTPSecure = defined( 'FACHINI_SMTP_SECURE' ) ? FACHINI_SMTP_SECURE : 'ssl';
	$mail->SMTPAuth   = true;
	$mail->Username   = FACHINI_SMTP_USER;
	$mail->Password   = FACHINI_SMTP_PASS;
	// O remetente precisa ser a própria caixa, senão o servidor recusa ou o
	// e-mail cai no spam. Quem responde vai para o Reply-To (o visitante).
	$mail->setFrom( FACHINI_SMTP_USER, defined( 'FACHINI_SMTP_FROM_NAME' ) ? FACHINI_SMTP_FROM_NAME : 'Site Fachini Máquinas', false );
}
add_action( 'phpmailer_init', 'fachini_smtp' );
