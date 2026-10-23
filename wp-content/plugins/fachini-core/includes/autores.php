<?php
/**
 * O site não tem blog nem autores: a página de autor e a lista pública de
 * usuários só serviriam para mostrar o login do administrador.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * /author/... e ?author=1 vão para a Home. Roda antes do redirecionamento
 * do próprio WordPress, que levaria ?author=1 para /author/<login>/.
 * (A opção "Arquivos do autor: Desativado" do Rank Math não funciona nesta
 * versão: ela grava 1 e o código dele compara com true.)
 */
function fachini_autores_para_home() {
	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'fachini_autores_para_home', 0 );

// Usuários pela API só para quem está logado (o editor usa /users/me).
function fachini_autores_api_fechada( $rotas ) {
	if ( is_user_logged_in() ) {
		return $rotas;
	}
	foreach ( array_keys( $rotas ) as $rota ) {
		if ( 0 === strpos( $rota, '/wp/v2/users' ) ) {
			unset( $rotas[ $rota ] );
		}
	}
	return $rotas;
}
add_filter( 'rest_endpoints', 'fachini_autores_api_fechada' );
