<?php
/**
 * Redirecionamentos 301 do site antigo para o novo, conforme a planilha de
 * URLs aprovada pela Fachini (versão 4, aprovada por escrito em 13/10/2026).
 *
 * O site antigo responde no domínio principal com endereços /site/... No
 * lançamento, o domínio passa a abrir este WordPress, e cada endereço antigo
 * leva ao novo com 301: o Google transfere a relevância e ninguém cai em
 * página de erro (links salvos, anúncios, WhatsApp). Os parâmetros do endereço
 * (UTMs das campanhas) são mantidos.
 *
 * Se o destino ainda não existir (ex.: uma máquina que ainda não foi
 * cadastrada), o redirecionamento vai para a página-mãe mais próxima que
 * exista. Quando a máquina for cadastrada com o endereço da planilha, o
 * redirecionamento passa a levar direto para ela, sem mexer aqui.
 *
 * Os domínios e subdomínios antigos (www, wordpress., maquinas.,
 * dobradeirasfachini.com.br) só são redirecionados quando apontarem para este
 * WordPress e não forem o endereço principal dele. No ambiente de construção
 * (wordpress.fachinimaquinas.com.br) nada muda.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Endereço antigo (sem barra no fim, minúsculo) => endereço novo.
 */
function fachini_mapa_redirecionamentos() {
	return array(
		'/site'                                                 => '/',
		'/site/home'                                            => '/',
		'/site/empresa'                                         => '/quem-somos/',
		'/site/contato'                                         => '/contato/',
		'/site/maquinas'                                        => '/maquinas/',
		'/site/categorias'                                      => '/maquinas/',
		'/site/catalogo'                                        => '/maquinas/',
		'/site/categorias/perfiladeiras'                        => '/perfiladeiras/',
		'/site/categorias/corte-e-dobra'                        => '/corte-e-dobra/',
		'/site/categorias/laser'                                => '/laser/',
		'/site/categorias/serralheria'                          => '/calhas/',
		'/site/categorias/corte-a-laser'                        => '/laser/corte-a-laser/',
		'/site/maquinas/dobradeira-lisa'                        => '/calhas/dobradeiras-regua-lisa/',
		'/site/maquinas/dobradeira-dentada'                     => '/calhas/dobradeiras-regua-dentada/',
		'/site/maquinas/acessorios'                             => '/calhas/acessorios/',
		'/site/maquinas/dobradeira-cn'                          => '/corte-e-dobra/dobradeiras-hidraulicas/cn/',
		'/site/maquinas/dobradeira-cnc'                         => '/corte-e-dobra/dobradeiras-hidraulicas/cnc/',
		'/site/maquinas/guilhotina'                             => '/corte-e-dobra/guilhotinas/',
		'/site/maquinas/corte-a-laser'                          => '/laser/corte-a-laser/',
		'/site/maquinas/mesa-aberta-serie-n'                    => '/laser/corte-a-laser/mesa-aberta/',
		'/site/maquinas/mesa-fechada-serie-hc'                  => '/laser/corte-a-laser/cabine-fechada/',
		'/site/maquinas/mista-chapa-e-tubo-serie-c'             => '/laser/corte-a-laser/chapa-e-tubo/',
		'/site/maquinas/exclusiva-para-tubos-serie-t'           => '/laser/corte-a-laser/tubos/',
		'/site/maquinas/solda-a-laser-portatil-serie-hwm'       => '/laser/solda-a-laser/hwm/',
		'/site/maquinas/solda-a-laser-de-fibra-portatil-serie-hw' => '/laser/solda-a-laser/hw/',
		'/site/maquinas/perfiladeira-de-telhas'                 => '/perfiladeiras/coberturas-e-fechamentos/simples/',
		'/site/maquinas/perfiladeira-de-telhas-duplas'          => '/perfiladeiras/coberturas-e-fechamentos/dupla/',
		'/site/maquinas/perfiladeira-de-telhas-tripla'          => '/perfiladeiras/coberturas-e-fechamentos/tripla/',
		'/site/maquinas/meia-cana'                              => '/perfiladeiras/coberturas-e-fechamentos/porta-metalica/',
		'/site/maquinas/perfiladeira-para-chapa-frisada-em-v'   => '/perfiladeiras/coberturas-e-fechamentos/chapa-frisada-v/',
		'/site/maquinas/cumeeira'                               => '/perfiladeiras/acessorios/prensa-cumeeira/',
		'/site/tdu'                                             => '/termos-de-uso/',
		'/site/tdu/uso'                                         => '/termos-de-uso/',
		'/site/tdu/privacidade'                                 => '/politica-de-privacidade/',
		// A planilha manda para o catálogo em PDF, que a Fachini ainda vai
		// enviar. Até lá, a listagem de máquinas.
		'/api/download/file/catalogo'                           => '/maquinas/',
	);
}

/**
 * Domínios antigos que, se apontarem para este WordPress, redirecionam para o
 * principal. null = mesmo caminho; texto = sempre esse caminho.
 */
function fachini_dominios_antigos() {
	return array(
		'www.fachinimaquinas.com.br'       => null,
		'wordpress.fachinimaquinas.com.br' => null,
		'maquinas.fachinimaquinas.com.br'  => '/maquinas/',
		'dobradeirasfachini.com.br'        => '/calhas/',
		'www.dobradeirasfachini.com.br'    => '/calhas/',
	);
}

/**
 * Categoria pelo caminho (calhas/dobradeiras-regua-lisa), ou null.
 */
function fachini_termo_pelo_caminho( $partes ) {
	$pai   = 0;
	$termo = null;
	foreach ( $partes as $slug ) {
		$achados = get_terms(
			array(
				'taxonomy'   => 'categoria_maquina',
				'slug'       => $slug,
				'parent'     => $pai,
				'hide_empty' => false,
			)
		);
		if ( is_wp_error( $achados ) || ! $achados ) {
			return null;
		}
		$termo = $achados[0];
		$pai   = $termo->term_id;
	}
	return $termo;
}

/**
 * O endereço novo existe? Página, listagem, categoria ou máquina publicada.
 */
function fachini_caminho_existe( $caminho ) {
	$partes = array_values( array_filter( explode( '/', trim( $caminho, '/' ) ), 'strlen' ) );
	if ( ! $partes ) {
		return true;
	}

	if ( 1 === count( $partes ) ) {
		if ( FACHINI_SLUG_MAQUINAS === $partes[0] ) {
			return true;
		}
		$pagina = get_page_by_path( $partes[0] );
		if ( $pagina && 'publish' === $pagina->post_status ) {
			return true;
		}
	}

	if ( fachini_termo_pelo_caminho( $partes ) ) {
		return true;
	}

	// Máquina: o último pedaço é o apelido, o resto é o caminho da categoria.
	// Confere pelo endereço real da máquina, que é o que o visitante vai ver.
	$slug     = array_pop( $partes );
	$esperado = '/' . implode( '/', $partes ) . '/' . $slug . '/';
	$ids      = get_posts(
		array(
			'post_type'   => 'maquina',
			'post_status' => 'publish',
			'name'        => $slug,
			'numberposts' => 10,
			'fields'      => 'ids',
		)
	);
	foreach ( $ids as $id ) {
		if ( trailingslashit( (string) wp_parse_url( get_permalink( $id ), PHP_URL_PATH ) ) === $esperado ) {
			return true;
		}
	}
	return false;
}

/**
 * O destino, ou a página-mãe mais próxima que exista.
 */
function fachini_destino_existente( $destino ) {
	$caminho = '/' . trim( $destino, '/' ) . '/';
	if ( '//' === $caminho ) {
		return '/';
	}
	while ( '/' !== $caminho && ! fachini_caminho_existe( $caminho ) ) {
		$sem_barra = rtrim( $caminho, '/' );
		$caminho   = substr( $sem_barra, 0, strrpos( $sem_barra, '/' ) + 1 );
	}
	return $caminho;
}

/**
 * Leva os endereços antigos aos novos.
 */
function fachini_redirecionar_site_antigo() {
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( preg_replace( '/:\d+$/', '', sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) ) ) : '';
	$base = rtrim( (string) wp_parse_url( home_url(), PHP_URL_PATH ), '/' );

	$caminho = strtolower( rtrim( rawurldecode( (string) wp_parse_url( $uri, PHP_URL_PATH ) ), '/' ) );
	if ( '' !== $base && 0 === strpos( $caminho, $base ) ) {
		$caminho = substr( $caminho, strlen( $base ) );
	}
	$params = (string) wp_parse_url( $uri, PHP_URL_QUERY );

	$destino = null;

	// Domínio antigo apontando para cá (nunca o próprio endereço do site).
	$principal = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	$dominios  = fachini_dominios_antigos();
	if ( $host && $host !== $principal && array_key_exists( $host, $dominios ) ) {
		$destino = null === $dominios[ $host ] ? ( '' === $caminho ? '/' : $caminho ) : $dominios[ $host ];
	}

	$mapa = fachini_mapa_redirecionamentos();
	if ( isset( $mapa[ $caminho ] ) ) {
		$destino = $mapa[ $caminho ];
	}

	if ( null === $destino ) {
		return;
	}

	$url = home_url( fachini_destino_existente( $destino ) );
	if ( '' !== $params ) {
		$url .= '?' . $params;
	}
	// wp_redirect, e não wp_safe_redirect: o destino é sempre o próprio site,
	// mas montado a partir do endereço principal mesmo quando o pedido chegou
	// por outro domínio.
	wp_redirect( $url, 301, 'Fachini Core' ); // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
	exit;
}
add_action( 'template_redirect', 'fachini_redirecionar_site_antigo', 0 );
