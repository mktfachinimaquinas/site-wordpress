<?php
/**
 * Endereços no formato aprovado na planilha de arquitetura de URLs.
 *
 *   /calhas/                                    categoria principal
 *   /calhas/dobradeiras-regua-lisa/             subcategoria
 *   /calhas/dobradeiras-regua-lisa/automatica/  máquina
 *   /corte-e-dobra/dobradeira-cn/               máquina ligada direto à categoria
 *
 * Três problemas precisam ser resolvidos para isso funcionar, e é o que este
 * arquivo faz:
 *
 * 1. O WordPress colocaria um prefixo antes da categoria (/categorias/calhas/).
 *    A planilha não tem esse prefixo.
 * 2. Um endereço de dois níveis pode ser tanto subcategoria quanto máquina.
 *    Só dá para saber consultando o banco, então a decisão é feita na leitura
 *    do endereço e não por regra fixa.
 * 3. Nomes se repetem: "manual", "hidraulica" e "automatica" existem na régua
 *    lisa e na régua dentada, e "Acessórios" existe em Calhas e Perfiladeiras.
 *    O WordPress renomearia a segunda ocorrência. Aqui a unicidade passa a
 *    valer por categoria, como na planilha.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slugs das categorias principais, usados para montar as regras de endereço.
 * Guardado em opção para não consultar o banco a cada requisição.
 *
 * @param bool $forcar Recalcula ignorando o cache.
 * @return array
 */
function fachini_slugs_categorias_raiz( $forcar = false ) {
	$slugs = get_option( 'fachini_slugs_raiz' );

	if ( $forcar || ! is_array( $slugs ) || empty( $slugs ) ) {
		$termos = get_terms(
			array(
				'taxonomy'   => 'categoria_maquina',
				'parent'     => 0,
				'hide_empty' => false,
				'fields'     => 'slugs',
			)
		);

		$slugs = ( is_wp_error( $termos ) || empty( $termos ) ) ? array() : $termos;
		update_option( 'fachini_slugs_raiz', $slugs );
	}

	return $slugs;
}

/**
 * Sempre que a árvore de categorias mudar, o cache acima é refeito.
 */
function fachini_limpar_cache_slugs() {
	fachini_slugs_categorias_raiz( true );
	flush_rewrite_rules();
}
add_action( 'created_categoria_maquina', 'fachini_limpar_cache_slugs' );
add_action( 'edited_categoria_maquina', 'fachini_limpar_cache_slugs' );
add_action( 'delete_categoria_maquina', 'fachini_limpar_cache_slugs' );

/* -------------------------------------------------------------------------
   1. Endereço das categorias, sem o prefixo /categorias/
   ------------------------------------------------------------------------- */

function fachini_term_link( $url, $termo, $taxonomia ) {
	if ( 'categoria_maquina' !== $taxonomia ) {
		return $url;
	}

	return str_replace( '/' . FACHINI_SLUG_CATEGORIAS . '/', '/', $url );
}
add_filter( 'term_link', 'fachini_term_link', 10, 3 );

/* -------------------------------------------------------------------------
   2. Endereço das máquinas: categoria (+ subcategoria) + apelido
   ------------------------------------------------------------------------- */

function fachini_get_termo_principal( $post_id ) {
	$termos = get_the_terms( $post_id, 'categoria_maquina' );

	if ( empty( $termos ) || is_wp_error( $termos ) ) {
		return null;
	}

	// Entre os termos atribuídos, vence o mais profundo na hierarquia.
	$escolhido = null;
	$maior     = -1;

	foreach ( $termos as $termo ) {
		$niveis = count( get_ancestors( $termo->term_id, 'categoria_maquina' ) );
		if ( $niveis > $maior ) {
			$maior     = $niveis;
			$escolhido = $termo;
		}
	}

	return $escolhido;
}

function fachini_caminho_do_termo( $termo ) {
	$partes     = array( $termo->slug );
	$ancestrais = array_reverse( get_ancestors( $termo->term_id, 'categoria_maquina' ) );

	foreach ( $ancestrais as $id ) {
		$pai = get_term( $id, 'categoria_maquina' );
		if ( $pai && ! is_wp_error( $pai ) ) {
			array_unshift( $partes, $pai->slug );
		}
	}

	return implode( '/', $partes );
}

function fachini_permalink_maquina( $url, $post ) {
	if ( 'maquina' !== $post->post_type || false === strpos( $url, '%categoria_maquina%' ) ) {
		return $url;
	}

	$termo   = fachini_get_termo_principal( $post->ID );
	$caminho = $termo ? fachini_caminho_do_termo( $termo ) : FACHINI_SLUG_MAQUINAS;

	return str_replace( '%categoria_maquina%', $caminho, $url );
}
add_filter( 'post_type_link', 'fachini_permalink_maquina', 10, 2 );

/* -------------------------------------------------------------------------
   3. Leitura dos endereços
   ------------------------------------------------------------------------- */

function fachini_query_vars( $vars ) {
	$vars[] = 'fachini_cat';
	$vars[] = 'fachini_seg';
	$vars[] = 'fachini_sub';
	return $vars;
}
add_filter( 'query_vars', 'fachini_query_vars' );

function fachini_rewrite_rules() {
	// /maquinas/maquina/  -> máquina ainda sem categoria
	add_rewrite_rule(
		'^' . FACHINI_SLUG_MAQUINAS . '/([^/]+)/?$',
		'index.php?maquina=$matches[1]',
		'top'
	);

	$raizes = fachini_slugs_categorias_raiz();

	if ( empty( $raizes ) ) {
		return;
	}

	$grupo = implode( '|', array_map( 'preg_quote', $raizes ) );

	// /categoria/subcategoria/maquina/
	add_rewrite_rule(
		'^(' . $grupo . ')/([^/]+)/([^/]+)/?$',
		'index.php?fachini_cat=$matches[1]&fachini_sub=$matches[2]&fachini_seg=$matches[3]',
		'top'
	);

	// /categoria/algo/  -> pode ser subcategoria ou máquina, decidido na leitura
	add_rewrite_rule(
		'^(' . $grupo . ')/([^/]+)/?$',
		'index.php?fachini_cat=$matches[1]&fachini_seg=$matches[2]',
		'top'
	);

	// /categoria/
	add_rewrite_rule(
		'^(' . $grupo . ')/?$',
		'index.php?categoria_maquina=$matches[1]',
		'top'
	);
}
add_action( 'init', 'fachini_rewrite_rules', 30 );

/**
 * Descarta as regras genéricas que o WordPress cria a partir do marcador
 * %categoria_maquina% do tipo "Máquinas".
 *
 * Uma delas, (.+?)/?$, fica no topo da lista e captura QUALQUER endereço de um
 * nível como se fosse categoria: /quem-somos/ e /contato/ davam 404. As
 * máquinas já são lidas pelas regras explícitas acima, então as genéricas
 * não fazem falta.
 *
 * Efeito colateral aceito: o mesmo bloco gerado trazia as regras de feed,
 * embed, paginação (<!--nextpage-->) e anexo de cada máquina, que também
 * deixam de existir. Nada disso é usado: os comentários estão fechados e
 * nenhuma máquina usa quebra de página.
 */
add_filter( 'maquina_rewrite_rules', '__return_empty_array' );

/**
 * Decide se o endereço é de categoria ou de máquina, consultando o banco.
 */
function fachini_resolver_endereco( $query ) {
	if ( ! isset( $query->query_vars['fachini_cat'] ) || '' === $query->query_vars['fachini_cat'] ) {
		return $query;
	}

	$cat = sanitize_title( $query->query_vars['fachini_cat'] );
	$sub = isset( $query->query_vars['fachini_sub'] ) ? sanitize_title( $query->query_vars['fachini_sub'] ) : '';
	$seg = isset( $query->query_vars['fachini_seg'] ) ? sanitize_title( $query->query_vars['fachini_seg'] ) : '';

	// Limpa as variáveis internas, elas não são consulta de verdade.
	unset( $query->query_vars['fachini_cat'], $query->query_vars['fachini_sub'], $query->query_vars['fachini_seg'] );

	$caminho_pai = $sub ? $cat . '/' . $sub : $cat;

	// Existe máquina com este apelido? Então é página de máquina.
	$maquina = get_posts(
		array(
			'name'             => $seg,
			'post_type'        => 'maquina',
			'post_status'      => 'publish',
			'numberposts'      => 1,
			'suppress_filters' => false,
			'fields'           => 'ids',
		)
	);

	if ( ! empty( $maquina ) ) {
		$query->query_vars['post_type'] = 'maquina';
		$query->query_vars['maquina']   = $seg;
		$query->query_vars['name']      = $seg;
		return $query;
	}

	// Caso contrário, tratamos como categoria (ou subcategoria).
	$query->query_vars['categoria_maquina'] = $caminho_pai . '/' . $seg;

	return $query;
}
add_filter( 'parse_request', 'fachini_resolver_endereco' );

/* -------------------------------------------------------------------------
   4. Apelidos repetidos entre categorias diferentes
   ------------------------------------------------------------------------- */

/**
 * Máquinas: "automatica" pode existir na régua lisa e na régua dentada.
 */
function fachini_slug_unico_por_categoria( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug ) {
	if ( 'maquina' !== $post_type ) {
		return $slug;
	}

	global $wpdb;

	$termo   = fachini_get_termo_principal( $post_ID );
	$caminho = $termo ? fachini_caminho_do_termo( $termo ) : '';

	$iguais = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = 'maquina' AND ID != %d AND post_status != 'trash'",
			$original_slug,
			$post_ID
		)
	);

	foreach ( $iguais as $outro_id ) {
		$outro_termo   = fachini_get_termo_principal( (int) $outro_id );
		$outro_caminho = $outro_termo ? fachini_caminho_do_termo( $outro_termo ) : '';

		if ( $outro_caminho === $caminho ) {
			return $slug; // conflito real, mantém o apelido que o WordPress sugeriu
		}
	}

	return $original_slug;
}
add_filter( 'wp_unique_post_slug', 'fachini_slug_unico_por_categoria', 10, 6 );

/**
 * Categorias: "Acessórios" pode existir em Calhas e em Perfiladeiras.
 * Sem isto, a segunda viraria "acessorios-calhas".
 */
function fachini_slug_unico_termo( $slug, $term, $original_slug ) {
	if ( ! isset( $term->taxonomy ) || 'categoria_maquina' !== $term->taxonomy ) {
		return $slug;
	}

	$pai = isset( $term->parent ) ? (int) $term->parent : 0;

	$irmaos = get_terms(
		array(
			'taxonomy'   => 'categoria_maquina',
			'parent'     => $pai,
			'slug'       => $original_slug,
			'hide_empty' => false,
			'exclude'    => isset( $term->term_id ) ? array( (int) $term->term_id ) : array(),
		)
	);

	// Só é conflito se já houver irmão com o mesmo apelido sob o mesmo pai.
	if ( ! is_wp_error( $irmaos ) && ! empty( $irmaos ) ) {
		return $slug;
	}

	return $original_slug;
}
add_filter( 'wp_unique_term_slug', 'fachini_slug_unico_termo', 10, 3 );

/**
 * Conteúdo duplicado: o endereço canônico é sempre o da categoria mais específica.
 */
function fachini_canonical_maquina( $canonical ) {
	if ( is_singular( 'maquina' ) ) {
		return get_permalink( get_queried_object_id() );
	}

	return $canonical;
}
add_filter( 'get_canonical_url', 'fachini_canonical_maquina' );
