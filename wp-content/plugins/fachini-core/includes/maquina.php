<?php
/**
 * Página da máquina, igual ao Figma ("MAQUINAS 1 - MAX 1369", nó 66:1587):
 * caminho, foto larga com o nome, barra das seções, descrição com as fotos ao
 * lado, especificações técnicas, modelos de telha (imagem e desenho), duas
 * fotos de aplicação com legenda e o vídeo com o link do canal.
 *
 * Tudo sai do cadastro da máquina. Seção sem conteúdo não aparece, e a barra
 * só mostra as seções que existem. O modelo do Construtor de Temas só chama
 * [fachini_maquina]. O visual fica no tema filho (style.css e maquina.js).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canal da Fachini no YouTube, o mesmo do rodapé.
 */
define( 'FACHINI_YOUTUBE_CANAL', 'https://www.youtube.com/@fachinimaquinasoficial' );

/**
 * Valor de um campo da máquina, sem depender do ACF estar ativo.
 */
function fachini_campo( $nome, $post_id ) {
	return function_exists( 'get_field' ) ? get_field( $nome, $post_id ) : get_post_meta( $post_id, $nome, true );
}

/**
 * Id de uma imagem guardada num campo (o ACF devolve id ou array).
 */
function fachini_campo_imagem( $nome, $post_id ) {
	$valor = fachini_campo( $nome, $post_id );
	if ( is_array( $valor ) ) {
		$valor = isset( $valor['ID'] ) ? $valor['ID'] : ( isset( $valor['id'] ) ? $valor['id'] : 0 );
	}
	return (int) $valor;
}

/**
 * Foto do topo: a da máquina, senão a da categoria, senão a foto principal.
 */
function fachini_maquina_foto_topo( $post_id ) {
	$foto = fachini_campo_imagem( 'foto_topo', $post_id );
	if ( ! $foto ) {
		$termo = function_exists( 'fachini_get_termo_principal' ) ? fachini_get_termo_principal( $post_id ) : null;
		$foto  = $termo ? (int) fachini_foto_categoria( $termo ) : 0;
	}
	if ( ! $foto ) {
		$foto = (int) get_post_thumbnail_id( $post_id );
	}
	return $foto;
}

/**
 * Fotos da máquina: a principal e as adicionais, sem repetir.
 *
 * @return int[]
 */
function fachini_maquina_fotos( $post_id ) {
	$fotos = array( (int) get_post_thumbnail_id( $post_id ) );
	foreach ( array( 'foto_2', 'foto_3', 'foto_4' ) as $campo ) {
		$fotos[] = fachini_campo_imagem( $campo, $post_id );
	}
	return array_values( array_unique( array_filter( $fotos ) ) );
}

/**
 * Galeria ao lado da descrição: foto grande e miniaturas que trocam a grande.
 */
function fachini_maquina_galeria( $fotos, $titulo ) {
	if ( ! $fotos ) {
		return '';
	}

	$html  = '<div class="fachini-maquina-galeria">';
	$html .= '<div class="fachini-maquina-galeria__principal">';
	$html .= wp_get_attachment_image(
		$fotos[0],
		'large',
		false,
		array(
			'class'   => 'fachini-maquina-galeria__foto',
			'alt'     => get_post_meta( $fotos[0], '_wp_attachment_image_alt', true ) ?: $titulo,
			'sizes'   => '(max-width: 767px) 100vw, 50vw',
			'loading' => 'lazy',
		)
	);
	$html .= '</div>';

	if ( count( $fotos ) > 1 ) {
		$html .= '<div class="fachini-maquina-galeria__miniaturas">';
		foreach ( $fotos as $i => $foto ) {
			$grande = wp_get_attachment_image_src( $foto, 'large' );
			$alt    = get_post_meta( $foto, '_wp_attachment_image_alt', true ) ?: $titulo;
			$html  .= '<button type="button" class="fachini-maquina-galeria__miniatura' . ( 0 === $i ? ' is-ativa' : '' ) . '"'
				. ' data-src="' . esc_url( $grande ? $grande[0] : '' ) . '"'
				. ' data-srcset="' . esc_attr( (string) wp_get_attachment_image_srcset( $foto, 'large' ) ) . '"'
				. ' data-alt="' . esc_attr( $alt ) . '"'
				. ( 0 === $i ? ' aria-current="true"' : '' ) . '>'
				. '<span class="fachini-sr">Ver foto ' . ( $i + 1 ) . '</span>'
				. wp_get_attachment_image( $foto, 'thumbnail', false, array( 'alt' => '', 'loading' => 'lazy' ) )
				. '</button>';
		}
		$html .= '</div>';
	}

	return $html . '</div>';
}

/**
 * Tabela das especificações, sem título (o título é o da seção).
 */
function fachini_maquina_tabela( $post_id ) {
	$itens = function_exists( 'fachini_get_especificacoes' ) ? fachini_get_especificacoes( $post_id ) : array();
	if ( ! $itens ) {
		return '';
	}

	$html = '<table class="fachini-maquina-specs"><tbody>';
	foreach ( $itens as $item ) {
		if ( '' !== $item['rotulo'] ) {
			$html .= '<tr><th scope="row">' . esc_html( $item['rotulo'] ) . '</th><td>' . esc_html( $item['valor'] ) . '</td></tr>';
		} else {
			$html .= '<tr><td colspan="2">' . esc_html( $item['valor'] ) . '</td></tr>';
		}
	}
	return $html . '</tbody></table>';
}

/**
 * Modelos de telha: nome, imagem da telha (ou da peça) e desenho técnico.
 */
function fachini_maquina_modelos( $post_id ) {
	$linhas = '';
	for ( $n = 1; $n <= 6; $n++ ) {
		$nome    = trim( (string) fachini_campo( 'modelo_' . $n . '_nome', $post_id ) );
		$imagens = array_filter( array( fachini_campo_imagem( 'modelo_' . $n . '_imagem_1', $post_id ), fachini_campo_imagem( 'modelo_' . $n . '_imagem_2', $post_id ) ) );
		if ( ! $imagens ) {
			continue;
		}
		$linhas .= '<div class="fachini-maquina-modelo' . ( 1 === count( $imagens ) ? ' fachini-maquina-modelo--uma' : '' ) . '">';
		if ( '' !== $nome ) {
			$linhas .= '<p class="fachini-maquina-modelo__nome">' . esc_html( $nome ) . '</p>';
		}
		foreach ( $imagens as $imagem ) {
			$linhas .= '<div class="fachini-maquina-modelo__imagem">' . wp_get_attachment_image(
				$imagem,
				'large',
				false,
				array(
					'alt'     => get_post_meta( $imagem, '_wp_attachment_image_alt', true ) ?: ( '' !== $nome ? 'Telha ' . $nome : '' ),
					'sizes'   => '(max-width: 767px) 100vw, 560px',
					'loading' => 'lazy',
				)
			) . '</div>';
		}
		$linhas .= '</div>';
	}
	return $linhas ? '<div class="fachini-maquina-modelos">' . $linhas . '</div>' : '';
}

/**
 * As duas fotos de aplicação, lado a lado, com a legenda embaixo.
 */
function fachini_maquina_aplicacoes( $post_id ) {
	$fotos = '';
	for ( $n = 1; $n <= 2; $n++ ) {
		$foto = fachini_campo_imagem( 'aplicacao_' . $n . '_foto', $post_id );
		if ( ! $foto ) {
			continue;
		}
		$legenda = trim( (string) fachini_campo( 'aplicacao_' . $n . '_legenda', $post_id ) );
		$fotos  .= '<figure class="fachini-maquina-aplicacao">'
			. '<div class="fachini-maquina-aplicacao__foto">' . wp_get_attachment_image(
				$foto,
				'large',
				false,
				array(
					'alt'     => get_post_meta( $foto, '_wp_attachment_image_alt', true ) ?: $legenda,
					'sizes'   => '(max-width: 767px) 100vw, 50vw',
					'loading' => 'lazy',
				)
			) . '</div>'
			. ( '' !== $legenda ? '<figcaption class="fachini-maquina-aplicacao__legenda">' . esc_html( $legenda ) . '</figcaption>' : '' )
			. '</figure>';
	}
	return $fotos ? '<div class="fachini-maquina-aplicacoes">' . $fotos . '</div>' : '';
}

/**
 * Vídeo (carregado só no clique) e o link do canal, que aparece sempre.
 */
function fachini_maquina_midia( $post_id ) {
	$url = trim( (string) fachini_campo( 'video_url', $post_id ) );
	$id  = '';
	if ( '' !== $url && preg_match( '~(?:youtu\.be/|v=|/embed/|/shorts/)([A-Za-z0-9_-]{6,})~', $url, $m ) ) {
		$id = $m[1];
	}
	$canal = '<p class="fachini-maquina-canal">' . fachini_seta_link( 'Mais vídeos no nosso canal do YouTube', FACHINI_YOUTUBE_CANAL, 'escuro' ) . '</p>';

	// Sem vídeo próprio, a seção fica só com o link do canal.
	if ( '' === $id ) {
		return $canal;
	}

	return '<div class="fachini-video fachini-maquina-video" data-video="' . esc_attr( $id ) . '">'
		. '<button type="button" class="fachini-video__play">'
		. '<span class="fachini-sr">Reproduzir o vídeo da máquina</span>'
		. '<img src="https://i.ytimg.com/vi/' . esc_attr( $id ) . '/hqdefault.jpg" alt="" loading="lazy" width="480" height="360">'
		. '<span class="fachini-video__icone" aria-hidden="true"></span>'
		. '</button></div>'
		. $canal;
}

/**
 * A página inteira.
 */
function fachini_sc_maquina() {
	$post_id = get_the_ID();
	if ( ! $post_id || 'maquina' !== get_post_type( $post_id ) ) {
		return '';
	}

	$titulo = get_the_title( $post_id );
	$resumo = trim( (string) fachini_campo( 'descricao_curta', $post_id ) );
	if ( '' === $resumo ) {
		$resumo = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '';
	}

	// Seções, na ordem do Figma. A barra só lista as que têm conteúdo.
	$texto = trim( (string) get_post_field( 'post_content', $post_id ) );
	$fotos = fachini_maquina_fotos( $post_id );
	$secoes = array();

	if ( '' !== wp_strip_all_tags( $texto ) || $fotos ) {
		$secoes['descricao'] = array(
			'Descrição',
			'Descrição',
			'<div class="fachini-maquina-descricao">'
				. '<div class="fachini-maquina-descricao__texto">' . apply_filters( 'the_content', $texto ) . '</div>'
				. fachini_maquina_galeria( $fotos, $titulo )
				. '</div>',
		);
	}
	$tabela = fachini_maquina_tabela( $post_id );
	if ( $tabela ) {
		$secoes['especificacoes'] = array( 'Especificações', 'Especificações técnicas', $tabela );
	}
	$modelos = fachini_maquina_modelos( $post_id );
	if ( $modelos ) {
		$titulo_modelos = trim( (string) fachini_campo( 'titulo_modelos', $post_id ) );
		$secoes['modelos'] = array( 'Modelos', '' !== $titulo_modelos ? $titulo_modelos : 'Dimensional e modelos de telhas', $modelos );
	}
	$aplicacoes = fachini_maquina_aplicacoes( $post_id );
	if ( $aplicacoes ) {
		$secoes['aplicacoes'] = array( 'Aplicações', 'Aplicações', $aplicacoes );
	}
	$midia = fachini_maquina_midia( $post_id );
	if ( $midia ) {
		$secoes['midia'] = array( 'Mídia', 'Mídia', $midia );
	}

	$html  = '<div class="fachini-maquina">';
	$html .= '<div class="fachini-maquina__caminho">' . fachini_sc_breadcrumb() . '</div>';

	// Topo: foto larga com o nome, o resumo e o pedido de orçamento.
	$foto_topo = fachini_maquina_foto_topo( $post_id );
	$html     .= '<section class="fachini-maquina-topo">';
	if ( $foto_topo ) {
		$html .= wp_get_attachment_image(
			$foto_topo,
			'full',
			false,
			array(
				'class'         => 'fachini-maquina-topo__foto',
				'alt'           => '',
				'sizes'         => '100vw',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
	}
	$html .= '<div class="fachini-maquina-topo__texto">';
	$html .= '<h1 class="fachini-maquina-topo__titulo">' . esc_html( $titulo ) . '</h1>';
	if ( '' !== $resumo ) {
		$html .= '<p class="fachini-maquina-topo__resumo">' . esc_html( $resumo ) . '</p>';
	}
	$html .= fachini_seta_link( 'Solicite seu orçamento', home_url( '/contato/' ), 'claro' );
	$html .= '</div></section>';

	if ( count( $secoes ) > 1 ) {
		$abas = '';
		$primeira = true;
		foreach ( $secoes as $ancora => $secao ) {
			$abas    .= '<li><a class="fachini-cat-nav__item' . ( $primeira ? ' is-ativo' : '' ) . '" href="#' . esc_attr( $ancora ) . '">' . esc_html( $secao[0] ) . '</a></li>';
			$primeira = false;
		}
		$html .= '<nav class="fachini-cat-nav fachini-maquina-abas" aria-label="Seções da página"><ul class="fachini-cat-nav__lista">' . $abas . '</ul></nav>';
	}

	foreach ( $secoes as $ancora => $secao ) {
		$html .= '<section class="fachini-maquina-secao fachini-maquina-secao--' . esc_attr( $ancora ) . '" id="' . esc_attr( $ancora ) . '">'
			. '<h2 class="fachini-maquina-secao__titulo">' . esc_html( $secao[1] ) . '</h2>'
			. $secao[2]
			. '</section>';
	}

	return $html . '</div>';
}
add_shortcode( 'fachini_maquina', 'fachini_sc_maquina' );
