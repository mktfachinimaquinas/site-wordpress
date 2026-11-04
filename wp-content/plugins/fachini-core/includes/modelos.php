<?php
/**
 * Modelos de telha e de perfil, cada um com página própria (ideia do Rodrigo,
 * 03/11/2026): tabela técnica, desenho técnico e fotos de amostra, em
 * /modelos/<apelido>/, um link que os vendedores podem mandar direto.
 *
 * Cada modelo diz quais máquinas o produzem. Na página da máquina, a seção
 * Modelos mostra um card para cada modelo ligado a ela, sem limite de
 * quantidade. Máquina sem nenhum modelo ligado continua mostrando os modelos
 * cadastrados nela mesma (até 6, ver acf-fields.php): nada muda nela até o
 * primeiro modelo ser ligado.
 *
 * O tipo de conteúdo se chama "fachini_modelo", e não "modelo": "modelo" é o
 * nome de um campo do formulário de contato, e o WordPress trataria o envio
 * como busca de um modelo (página não encontrada).
 *
 * Quem pode cadastrar máquinas pode cadastrar modelos: o tipo usa as mesmas
 * permissões das máquinas (capability_type 'maquina'), então o papel
 * "Cadastro de Máquinas" não precisou de nenhuma permissão nova.
 *
 * A página usa o mesmo visual da máquina (fachini_pagina_maquina, em
 * includes/maquina.php). O modelo do Construtor de Temas só chama
 * [fachini_modelo]; o CSS dos cards fica no tema filho.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Mudar esta versão reescreve o modelo do Construtor de Temas da página do modelo.
define( 'FACHINI_MODELO_LAYOUT', '2026-11-04a' );

/**
 * Quantas fotos de amostra cada modelo aceita.
 */
define( 'FACHINI_MODELO_AMOSTRAS', 4 );

function fachini_core_register_modelos() {
	$labels = array(
		'name'                  => 'Modelos',
		'singular_name'         => 'Modelo',
		'menu_name'             => 'Modelos',
		'all_items'             => 'Modelos',
		'add_new'               => 'Adicionar novo',
		'add_new_item'          => 'Adicionar novo modelo',
		'edit_item'             => 'Editar modelo',
		'new_item'              => 'Novo modelo',
		'view_item'             => 'Ver modelo',
		'view_items'            => 'Ver modelos',
		'search_items'          => 'Buscar modelos',
		'not_found'             => 'Nenhum modelo cadastrado',
		'not_found_in_trash'    => 'Nenhum modelo na lixeira',
		'item_published'        => 'Modelo publicado.',
		'item_updated'          => 'Modelo atualizado.',
		'featured_image'        => 'Imagem do modelo',
		'set_featured_image'    => 'Definir imagem do modelo',
		'remove_featured_image' => 'Remover imagem do modelo',
		'use_featured_image'    => 'Usar como imagem do modelo',
	);

	register_post_type(
		'fachini_modelo',
		array(
			'labels'          => $labels,
			'public'          => true,
			'has_archive'     => false,
			'rewrite'         => array(
				'slug'       => FACHINI_SLUG_MODELOS,
				'with_front' => false,
				'feeds'      => false,
				'pages'      => false,
			),
			// Fica dentro do menu Máquinas, logo abaixo de "Todas as máquinas".
			'show_in_menu'    => 'edit.php?post_type=maquina',
			// 'page-attributes': o campo Ordem define a ordem dos cards na máquina.
			'supports'        => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'author' ),
			'show_in_rest'    => true,
			'capability_type' => 'maquina',
			'map_meta_cap'    => true,
			'hierarchical'    => false,
		)
	);
}
add_action( 'init', 'fachini_core_register_modelos' );

/**
 * Campos do modelo (ACF). A imagem do modelo (telha ou peça) é a imagem
 * destacada, na coluna da direita, e o texto livre é o editor.
 */
function fachini_core_campos_modelo() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$campos = array(
		array(
			'key'          => 'field_fachini_modelo_resumo',
			'label'        => 'Descrição curta',
			'name'         => 'descricao_curta',
			'type'         => 'textarea',
			'rows'         => 3,
			'instructions' => 'Uma ou duas frases. Aparece no alto da página do modelo e na busca do Google.',
		),
		array(
			'key'           => 'field_fachini_modelo_maquinas',
			'label'         => 'Máquinas que produzem este modelo',
			'name'          => 'maquinas',
			'type'          => 'relationship',
			'post_type'     => array( 'maquina' ),
			'filters'       => array( 'search', 'taxonomy' ),
			'return_format' => 'id',
			'instructions'  => 'O modelo aparece como card na seção Modelos de cada máquina escolhida. A primeira da lista define o caminho no alto da página, a foto do topo e a máquina já escolhida no pedido de orçamento.',
		),
		array(
			'key'          => 'field_fachini_modelo_specs',
			'label'        => 'Tabela técnica',
			'name'         => 'especificacoes',
			'type'         => 'textarea',
			'rows'         => 10,
			'instructions' => 'Uma linha por item, no formato "Rótulo: valor". Exemplo:<br>Largura útil: 980 mm<br>Altura: 40 mm',
		),
		array(
			'key'           => 'field_fachini_modelo_desenho',
			'label'         => 'Desenho técnico',
			'name'          => 'desenho',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'instructions'  => 'Aparece ao lado da imagem do modelo. A imagem do modelo (a telha ou a peça) é a "Imagem do modelo", na coluna da direita: ela também vai no card da máquina.',
		),
	);
	for ( $n = 1; $n <= FACHINI_MODELO_AMOSTRAS; $n++ ) {
		$campos[] = array(
			'key'           => 'field_fachini_modelo_amostra_' . $n,
			'label'         => 'Foto de amostra ' . $n,
			'name'          => 'amostra_' . $n,
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'wrapper'       => array( 'width' => '50' ),
			'instructions'  => 1 === $n ? 'Opcional. Fotos da telha ou da peça pronta. Aparecem ao lado do texto do modelo.' : '',
		);
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_fachini_modelo',
			'title'           => 'Dados do modelo',
			'location'        => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'fachini_modelo',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'show_in_rest'    => true,
			'description'     => 'Preencha os dados do modelo. A página é montada automaticamente, no mesmo visual da página da máquina.',
			'fields'          => $campos,
		)
	);
}
add_action( 'acf/init', 'fachini_core_campos_modelo' );

/* -------------------------------------------------------------------------
   Ligação entre modelos e máquinas
   ------------------------------------------------------------------------- */

/**
 * Máquinas publicadas que produzem o modelo, na ordem escolhida no cadastro.
 *
 * @return int[]
 */
function fachini_modelo_maquinas( $modelo_id ) {
	$ids = array_map( 'intval', (array) get_post_meta( $modelo_id, 'maquinas', true ) );
	return array_values(
		array_filter(
			array_unique( $ids ),
			function ( $id ) {
				return $id > 0 && 'maquina' === get_post_type( $id ) && 'publish' === get_post_status( $id );
			}
		)
	);
}

/**
 * Modelos publicados ligados à máquina, pelo campo Ordem e depois pelo nome.
 *
 * O ACF guarda a lista de máquinas como texto serializado, com cada id entre
 * aspas (a:2:{i:0;s:2:"17";...}): procurar por "17", com as aspas, não pega
 * o 117 nem o 170.
 *
 * @return int[]
 */
function fachini_maquina_modelos_ligados( $maquina_id ) {
	return get_posts(
		array(
			'post_type'     => 'fachini_modelo',
			'post_status'   => 'publish',
			'numberposts'   => 200,
			'orderby'       => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'meta_query'    => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'     => 'maquinas',
					'value'   => '"' . (int) $maquina_id . '"',
					'compare' => 'LIKE',
				),
			),
			'fields'        => 'ids',
			'no_found_rows' => true,
		)
	);
}

/**
 * Imagem do card e do topo: a do modelo, senão o desenho técnico.
 */
function fachini_modelo_imagem( $modelo_id ) {
	$imagem = (int) get_post_thumbnail_id( $modelo_id );
	return $imagem ? $imagem : fachini_campo_imagem( 'desenho', $modelo_id );
}

/**
 * Cards dos modelos na página da máquina: imagem, nome e "Ver modelo". O card
 * inteiro é o link.
 *
 * @param int[] $ids Modelos, na ordem de exibição.
 */
function fachini_modelos_cards( $ids ) {
	$html = '<ul class="fachini-modelos-cards">';
	foreach ( $ids as $id ) {
		$imagem = fachini_modelo_imagem( $id );
		$html  .= '<li class="fachini-modelo-card"><a class="fachini-modelo-card__link" href="' . esc_url( get_permalink( $id ) ) . '">'
			. '<span class="fachini-modelo-card__imagem">'
			. ( $imagem ? wp_get_attachment_image(
				$imagem,
				'medium_large',
				false,
				array(
					'alt'     => '',
					'sizes'   => '(max-width: 767px) 50vw, 380px',
					'loading' => 'lazy',
				)
			) : '' )
			. '</span>'
			. '<span class="fachini-modelo-card__nome">' . esc_html( get_the_title( $id ) ) . '</span>'
			. fachini_seta_link( 'Ver modelo', '', 'escuro', 'span' )
			. '</a></li>';
	}
	return $html . '</ul>';
}

/**
 * Máquinas que produzem o modelo, nas mesmas linhas da listagem das
 * categorias: foto, nome, série, resumo e "Ver máquina".
 *
 * @param int[] $ids Máquinas.
 */
function fachini_modelo_linhas_maquinas( $ids ) {
	$html = '<div class="fachini-maquinas-lista">';
	foreach ( $ids as $id ) {
		$link   = get_permalink( $id );
		$serie  = (string) get_post_meta( $id, 'modelo_serie', true );
		$resumo = has_excerpt( $id ) ? get_the_excerpt( $id ) : wp_trim_words( wp_strip_all_tags( (string) get_post_field( 'post_content', $id ) ), 24 );

		$html .= '<article class="fachini-maquina-linha">';
		$html .= '<a class="fachini-maquina-linha__foto" href="' . esc_url( $link ) . '" tabindex="-1" aria-hidden="true">';
		if ( has_post_thumbnail( $id ) ) {
			$html .= get_the_post_thumbnail( $id, 'medium_large', array( 'alt' => '', 'sizes' => '(max-width: 767px) 100vw, 360px', 'loading' => 'lazy' ) );
		}
		$html .= '</a>';
		$html .= '<div class="fachini-maquina-linha__corpo">';
		$html .= '<h3 class="fachini-maquina-linha__nome"><a href="' . esc_url( $link ) . '">' . esc_html( get_the_title( $id ) ) . '</a></h3>';
		if ( '' !== $serie ) {
			$html .= '<p class="fachini-maquina-linha__modelo">' . esc_html( $serie ) . '</p>';
		}
		if ( $resumo ) {
			$html .= '<p class="fachini-maquina-linha__resumo">' . esc_html( $resumo ) . '</p>';
		}
		$html .= fachini_seta_link( 'Ver máquina', $link, 'escuro' );
		$html .= '</div></article>';
	}
	return $html . '</div>';
}

/* -------------------------------------------------------------------------
   Página do modelo
   ------------------------------------------------------------------------- */

/**
 * Fotos de amostra do modelo, sem repetir.
 *
 * @return int[]
 */
function fachini_modelo_amostras( $modelo_id ) {
	$fotos = array();
	for ( $n = 1; $n <= FACHINI_MODELO_AMOSTRAS; $n++ ) {
		$fotos[] = fachini_campo_imagem( 'amostra_' . $n, $modelo_id );
	}
	return array_values( array_unique( array_filter( $fotos ) ) );
}

/**
 * A página inteira: caminho, topo, barra e as seções que tiverem conteúdo,
 * na ordem do pedido do Rodrigo (tabela técnica, desenho técnico, amostras),
 * mais as máquinas que produzem o modelo.
 */
function fachini_sc_modelo() {
	$post_id = get_the_ID();
	if ( ! $post_id || 'fachini_modelo' !== get_post_type( $post_id ) ) {
		return '';
	}

	$titulo   = get_the_title( $post_id );
	$maquinas = fachini_modelo_maquinas( $post_id );
	$maquina  = $maquinas ? $maquinas[0] : 0;
	$secoes   = array();

	$tabela = fachini_maquina_tabela( $post_id );
	if ( $tabela ) {
		$secoes['tabela'] = array( 'Tabela técnica', 'Tabela técnica', $tabela );
	}

	// A imagem do modelo e o desenho, lado a lado no quadro branco, sem cortar.
	$imagens = array();
	$foto    = (int) get_post_thumbnail_id( $post_id );
	$desenho = fachini_campo_imagem( 'desenho', $post_id );
	if ( $foto ) {
		$imagens[] = array( $foto, $titulo );
	}
	if ( $desenho && $desenho !== $foto ) {
		$imagens[] = array( $desenho, 'Desenho técnico: ' . $titulo );
	}
	if ( $imagens ) {
		$nome_desenho      = $desenho ? 'Desenho técnico' : 'Modelo';
		$secoes['desenho'] = array( $nome_desenho, $nome_desenho, '<div class="fachini-maquina-modelos">' . fachini_maquina_modelo_linha( '', $imagens ) . '</div>' );
	}

	// Texto livre do modelo e as fotos de amostra, no desenho da Descrição da máquina.
	$texto     = trim( (string) get_post_field( 'post_content', $post_id ) );
	$tem_texto = '' !== wp_strip_all_tags( $texto );
	$amostras  = fachini_modelo_amostras( $post_id );
	if ( $tem_texto || $amostras ) {
		$classe = 'fachini-maquina-descricao';
		if ( ! $tem_texto ) {
			$classe .= ' fachini-maquina-descricao--so-fotos';
		} elseif ( ! $amostras ) {
			$classe .= ' fachini-maquina-descricao--so-texto';
		}
		$nome_amostras      = $amostras ? 'Amostras' : 'Descrição';
		$secoes['amostras'] = array(
			$nome_amostras,
			$nome_amostras,
			'<div class="' . $classe . '">'
				. ( $tem_texto ? '<div class="fachini-maquina-descricao__texto">' . apply_filters( 'the_content', $texto ) . '</div>' : '' )
				. fachini_maquina_galeria( $amostras, $titulo )
				. '</div>',
			'fachini-maquina-secao--descricao',
		);
	}

	if ( $maquinas ) {
		$secoes['maquinas'] = array(
			1 === count( $maquinas ) ? 'Máquina' : 'Máquinas',
			1 === count( $maquinas ) ? 'Máquina que produz este modelo' : 'Máquinas que produzem este modelo',
			fachini_modelo_linhas_maquinas( $maquinas ),
		);
	}

	return fachini_pagina_maquina(
		array(
			'titulo'    => $titulo,
			'resumo'    => trim( (string) fachini_campo( 'descricao_curta', $post_id ) ),
			// A foto larga da máquina que produz o modelo. A imagem do modelo é
			// recortada para um quadro claro e não serve de fundo escuro.
			'foto_topo' => $maquina ? fachini_maquina_foto_topo( $maquina ) : 0,
			// O formulário abre com a máquina que produz o modelo já escolhida.
			'orcamento' => $maquina ? add_query_arg( 'orcamento', $maquina, home_url( '/contato/' ) ) : home_url( '/contato/' ),
			'classe'    => 'fachini-modelo',
			'secoes'    => $secoes,
		)
	);
}
add_shortcode( 'fachini_modelo', 'fachini_sc_modelo' );

/* -------------------------------------------------------------------------
   Cache do LiteSpeed
   ------------------------------------------------------------------------- */

/**
 * O card do modelo fica na página da máquina, e o LiteSpeed só limpa
 * sozinho a página do próprio modelo. Ao salvar, publicar, tirar do ar ou
 * apagar um modelo, limpa também as máquinas ligadas a ele agora e as que
 * estavam ligadas antes (o card some delas).
 */
function fachini_modelo_limpar_maquinas( $post_id ) {
	if ( 'fachini_modelo' !== get_post_type( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	$antes = array_map( 'intval', (array) get_post_meta( $post_id, '_fachini_maquinas_no_cache', true ) );
	$agora = array_map( 'intval', (array) get_post_meta( $post_id, 'maquinas', true ) );
	foreach ( array_filter( array_unique( array_merge( $antes, $agora ) ) ) as $maquina ) {
		do_action( 'litespeed_purge_post', $maquina );
	}
	update_post_meta( $post_id, '_fachini_maquinas_no_cache', array_values( array_filter( $agora ) ) );
}
// Depois que o ACF gravou os campos (o editor salva os campos numa segunda requisição).
add_action( 'acf/save_post', 'fachini_modelo_limpar_maquinas', 20 );
add_action( 'save_post_fachini_modelo', 'fachini_modelo_limpar_maquinas', 20 );
add_action( 'trashed_post', 'fachini_modelo_limpar_maquinas' );
add_action( 'untrashed_post', 'fachini_modelo_limpar_maquinas' );
add_action( 'before_delete_post', 'fachini_modelo_limpar_maquinas' );

/**
 * O contrário: a página do modelo mostra a máquina (nome, foto, resumo).
 * Ao salvar uma máquina, limpa os modelos ligados a ela.
 */
function fachini_maquina_limpar_modelos( $post_id ) {
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	foreach ( fachini_maquina_modelos_ligados( $post_id ) as $modelo ) {
		do_action( 'litespeed_purge_post', $modelo );
	}
}
add_action( 'save_post_maquina', 'fachini_maquina_limpar_modelos', 20 );

/* -------------------------------------------------------------------------
   Modelo do Construtor de Temas
   ------------------------------------------------------------------------- */

/**
 * Cria (uma vez) o modelo "Modelo de telha ou perfil (página individual)" no
 * Construtor de Temas, com [fachini_modelo] na largura toda, igual ao da
 * máquina. Separado de seed-templates.php para não reaplicar nada nos
 * modelos que já existem.
 */
function fachini_seed_template_modelo() {
	if ( get_option( 'fachini_tpl_modelo_layout' ) === FACHINI_MODELO_LAYOUT ) {
		return;
	}
	if ( ! did_action( 'elementor/loaded' ) || ! post_type_exists( 'elementor_library' ) || ! function_exists( 'fachini_el_secao' ) ) {
		return;
	}

	$layout = array(
		fachini_el_secao(
			array(
				fachini_el_widget( 'shortcode', array( 'shortcode' => '[fachini_modelo]' ) ),
			),
			array(
				'layout'  => 'full_width',
				'gap'     => 'no',
				'padding' => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
			)
		),
	);

	$post_id = (int) get_option( 'fachini_tpl_modelo' );
	if ( ! $post_id || ! get_post( $post_id ) ) {
		$post_id = wp_insert_post(
			array(
				'post_title'  => 'Modelo de telha ou perfil (página individual)',
				'post_type'   => 'elementor_library',
				'post_status' => 'publish',
			)
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			return;
		}
		update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
		update_option( 'fachini_tpl_modelo', $post_id );
	}

	update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $layout ) ) );
	update_post_meta( $post_id, '_elementor_template_type', 'single-post' );
	update_post_meta( $post_id, '_elementor_conditions', array( 'include/singular/fachini_modelo' ) );
	wp_set_object_terms( $post_id, 'single-post', 'elementor_library_type', false );

	fachini_elementor_regenerar_condicoes();
	update_option( 'fachini_tpl_modelo_layout', FACHINI_MODELO_LAYOUT );
}
add_action( 'init', 'fachini_seed_template_modelo', 31 );
