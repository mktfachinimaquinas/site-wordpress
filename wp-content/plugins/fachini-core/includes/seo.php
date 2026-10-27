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
 * Páginas e máquinas ficam sem tipo de schema padrão (máquina como "Produto"
 * sem preço gera alerta no Google). Sem tipo, o Rank Math não imprime nada
 * nelas; aqui ele volta a imprimir o básico: página, empresa e site.
 */
function fachini_seo_schema_basico( $adicionar ) {
	return is_singular( array( 'page', 'maquina' ) ) ? true : $adicionar;
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
function fachini_seo_descricao( $descricao ) {
	if ( ! is_page() || ! fachini_seo_campo_vazio( 'rank_math_description' ) ) {
		return $descricao;
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
