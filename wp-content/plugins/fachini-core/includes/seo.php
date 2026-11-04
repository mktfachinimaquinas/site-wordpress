<?php
/**
 * Ajustes do Rank Math que dependem do conteúdo deste site.
 * Os textos daqui só valem enquanto o campo da página no Rank Math estiver
 * vazio: o que for preenchido lá tem a palavra final.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Páginas, máquinas e modelos ficam sem tipo de schema padrão (máquina como
 * "Produto" sem preço gera alerta no Google). Sem tipo, o Rank Math não
 * imprime nada nelas; aqui ele volta a imprimir o básico: página, empresa e site.
 */
function fachini_seo_schema_basico( $adicionar ) {
	return is_singular( array( 'page', 'maquina', 'fachini_modelo' ) ) ? true : $adicionar;
}
add_filter( 'rank_math/schema/add_global_entities', 'fachini_seo_schema_basico' );

function fachini_seo_campo_vazio( $campo ) {
	return '' === trim( (string) get_post_meta( get_queried_object_id(), $campo, true ) );
}

function fachini_seo_pagina_com( $shortcode ) {
	$post = get_queried_object();
	return is_page() && ( $post instanceof WP_Post ) && has_shortcode( $post->post_content, $shortcode );
}

// "Home - Fachini Máquinas" não diz o que a empresa vende.
function fachini_seo_titulo( $titulo ) {
	if ( is_front_page() && fachini_seo_campo_vazio( 'rank_math_title' ) ) {
		return 'Fachini Máquinas - Dobradeiras, perfiladeiras, corte e solda a laser';
	}
	return $titulo;
}
add_filter( 'rank_math/frontend/title', 'fachini_seo_titulo' );

// Contato e política são montados por shortcode, então não têm resumo próprio.
// No Quem somos, o resumo automático cortava a primeira frase no meio.
function fachini_seo_descricao( $descricao ) {
	if ( is_singular( 'fachini_modelo' ) && fachini_seo_campo_vazio( 'rank_math_description' ) ) {
		return fachini_seo_descricao_modelo( get_queried_object_id() );
	}
	if ( ! is_page() || ! fachini_seo_campo_vazio( 'rank_math_description' ) ) {
		return $descricao;
	}
	if ( is_page( 'quem-somos' ) ) {
		return 'Fachini Máquinas: indústria brasileira de máquinas para conformação, corte e processamento de metais desde 2003, com parque industrial em Cascavel (PR).';
	}
	if ( fachini_seo_pagina_com( 'fachini_contato' ) ) {
		return 'Solicite seu orçamento à Fachini Máquinas. Escolha a máquina de interesse e um especialista entra em contato com você.';
	}
	if ( fachini_seo_pagina_com( 'fachini_politica' ) ) {
		return 'Como a Fachini Máquinas coleta, usa, compartilha e protege dados pessoais no site e nos canais de atendimento comercial e marketing.';
	}
	if ( fachini_seo_pagina_com( 'fachini_termos' ) ) {
		return 'Termos de uso do site da Fachini Máquinas: licença de uso dos materiais, isenção de responsabilidade, limitações, links e lei aplicável.';
	}
	return $descricao;
}
add_filter( 'rank_math/frontend/description', 'fachini_seo_descricao' );

/**
 * Modelo: a descrição curta do cadastro. Sem ela, uma frase montada só com o
 * que a página tem de fato (o resumo automático do Rank Math sairia vazio,
 * porque o modelo quase não tem texto).
 */
function fachini_seo_descricao_modelo( $modelo_id ) {
	$curta = trim( (string) get_post_meta( $modelo_id, 'descricao_curta', true ) );
	if ( '' !== $curta ) {
		return $curta;
	}

	$partes = array();
	if ( '' !== trim( (string) get_post_meta( $modelo_id, 'especificacoes', true ) ) ) {
		$partes[] = 'tabela técnica';
	}
	if ( (int) get_post_meta( $modelo_id, 'desenho', true ) ) {
		$partes[] = 'desenho técnico';
	}
	if ( function_exists( 'fachini_modelo_amostras' ) && fachini_modelo_amostras( $modelo_id ) ) {
		$partes[] = 'fotos de amostra';
	}
	$ultima = array_pop( $partes );
	$lista  = $partes ? implode( ', ', $partes ) . ' e ' . $ultima : (string) $ultima;

	$texto    = get_the_title( $modelo_id ) . ( '' !== $lista ? ': ' . $lista . '.' : '.' );
	$maquinas = function_exists( 'fachini_modelo_maquinas' ) ? fachini_modelo_maquinas( $modelo_id ) : array();
	if ( $maquinas ) {
		return $texto . ' Produzido na ' . get_the_title( $maquinas[0] ) . ' da Fachini Máquinas.';
	}
	return $texto . ' Modelo da Fachini Máquinas.';
}

/**
 * Configuração do Rank Math para os modelos. O Rank Math só coloca no sitemap
 * (e só configura título, robots e schema) os tipos de conteúdo que existiam
 * quando ele foi configurado, e os modelos vieram depois. Enquanto ninguém
 * salvar os modelos em Rank Math > Títulos e meta e Sitemap, eles seguem a
 * configuração das máquinas. O que for salvo no painel tem a palavra final.
 */
function fachini_seo_modelos_como_maquinas( $opcoes ) {
	if ( ! is_array( $opcoes ) ) {
		return $opcoes;
	}
	foreach ( $opcoes as $chave => $valor ) {
		if ( 0 !== strpos( $chave, 'pt_maquina_' ) || false !== strpos( $chave, 'archive' ) || false !== strpos( $chave, 'primary_taxonomy' ) ) {
			continue;
		}
		$nova = 'pt_fachini_modelo_' . substr( $chave, strlen( 'pt_maquina_' ) );
		if ( ! array_key_exists( $nova, $opcoes ) ) {
			$opcoes[ $nova ] = $valor;
		}
	}
	return $opcoes;
}
add_filter( 'option_rank-math-options-titles', 'fachini_seo_modelos_como_maquinas' );
add_filter( 'option_rank-math-options-sitemap', 'fachini_seo_modelos_como_maquinas' );
