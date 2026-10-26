<?php
/**
 * Páginas de categoria de máquinas e /maquinas/, igual ao Figma ("MAQUINAS 2"
 * e "MAQUINAS 3"): foto no topo, barra das categorias principais, caminho de
 * navegação com ordenação e, embaixo, as faixas das subcategorias ou, numa
 * categoria sem subcategorias, a lista de máquinas com paginação.
 *
 * Tudo sai das categorias e máquinas cadastradas. Categoria nova, foto nova
 * ou máquina nova aparecem sozinhas, sem mexer no Elementor. O modelo do
 * Construtor de Temas só chama [fachini_listagem].
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ordem das categorias principais na barra, a mesma do menu e da Home.
 * Uma categoria principal nova entra no fim, em ordem alfabética.
 */
define( 'FACHINI_ORDEM_CATEGORIAS', array( 'calhas', 'perfiladeiras', 'corte-e-dobra', 'laser' ) );

/**
 * Categoria da página atual, ou null em /maquinas/.
 */
function fachini_categoria_atual() {
	if ( is_tax( 'categoria_maquina' ) ) {
		$termo = get_queried_object();
		return ( $termo instanceof WP_Term ) ? $termo : null;
	}
	return null;
}

/**
 * Categorias principais, na ordem da barra.
 *
 * @return WP_Term[]
 */
function fachini_categorias_principais() {
	$termos = get_terms(
		array(
			'taxonomy'   => 'categoria_maquina',
			'parent'     => 0,
			'hide_empty' => false,
			'orderby'    => 'name',
		)
	);
	if ( is_wp_error( $termos ) ) {
		return array();
	}

	$ordem = array_flip( FACHINI_ORDEM_CATEGORIAS );
	usort(
		$termos,
		function ( $a, $b ) use ( $ordem ) {
			$pa = isset( $ordem[ $a->slug ] ) ? $ordem[ $a->slug ] : 99;
			$pb = isset( $ordem[ $b->slug ] ) ? $ordem[ $b->slug ] : 99;
			return ( $pa === $pb ) ? strcasecmp( $a->name, $b->name ) : $pa - $pb;
		}
	);
	return $termos;
}

/**
 * Subcategorias na ordem da planilha de URLs aprovada (a mesma da árvore em
 * seed-categorias.php). Uma subcategoria nova entra no fim, em ordem alfabética.
 *
 * @return WP_Term[]
 */
function fachini_subcategorias( WP_Term $pai ) {
	$filhos = get_terms(
		array(
			'taxonomy'   => 'categoria_maquina',
			'parent'     => $pai->term_id,
			'hide_empty' => false,
			'orderby'    => 'name',
		)
	);
	if ( is_wp_error( $filhos ) || ! $filhos ) {
		return array();
	}

	$arvore = function_exists( 'fachini_arvore_categorias' ) ? fachini_arvore_categorias() : array();
	$ordem  = isset( $arvore[ $pai->slug ]['filhos'] ) ? array_flip( array_keys( $arvore[ $pai->slug ]['filhos'] ) ) : array();

	usort(
		$filhos,
		function ( $a, $b ) use ( $ordem ) {
			$pa = isset( $ordem[ $a->slug ] ) ? $ordem[ $a->slug ] : 99;
			$pb = isset( $ordem[ $b->slug ] ) ? $ordem[ $b->slug ] : 99;
			return ( $pa === $pb ) ? strcasecmp( $a->name, $b->name ) : $pa - $pb;
		}
	);
	return $filhos;
}

/**
 * Foto da categoria. Sem foto, usa a da categoria-mãe; sem nenhuma, a imagem
 * destacada da página inicial.
 */
function fachini_foto_categoria( $termo ) {
	while ( $termo instanceof WP_Term ) {
		$id = (int) get_term_meta( $termo->term_id, 'foto_categoria', true );
		if ( $id && wp_attachment_is_image( $id ) ) {
			return $id;
		}
		$termo = $termo->parent ? get_term( $termo->parent, 'categoria_maquina' ) : null;
	}

	$home = (int) get_option( 'page_on_front' );
	return $home ? (int) get_post_thumbnail_id( $home ) : 0;
}

/**
 * Quantas máquinas publicadas a categoria tem, contando as subcategorias.
 */
function fachini_total_maquinas( WP_Term $termo ) {
	static $cache = array();

	if ( ! isset( $cache[ $termo->term_id ] ) ) {
		$consulta = new WP_Query(
			array(
				'post_type'      => 'maquina',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => 1,
				'tax_query'      => array(
					array(
						'taxonomy'         => 'categoria_maquina',
						'terms'            => $termo->term_id,
						'include_children' => true,
					),
				),
			)
		);
		$cache[ $termo->term_id ] = (int) $consulta->found_posts;
	}

	return $cache[ $termo->term_id ];
}

/**
 * Link de texto com a seta do layout (o mesmo desenho dos botões da Home).
 */
function fachini_seta_link( $texto, $url, $variante, $tag = 'a' ) {
	$classe = 'fachini-seta-link fachini-seta-link--' . $variante;
	if ( 'a' === $tag ) {
		// Link para fora do site (ex.: canal do YouTube) abre em outra aba, sem fechar o site.
		$host  = wp_parse_url( $url, PHP_URL_HOST );
		$extra = ( $host && wp_parse_url( home_url(), PHP_URL_HOST ) !== $host ) ? ' target="_blank" rel="noopener"' : '';
		return '<a class="' . esc_attr( $classe ) . '" href="' . esc_url( $url ) . '"' . $extra . '><span>' . esc_html( $texto ) . '</span></a>';
	}
	return '<span class="' . esc_attr( $classe ) . '"><span>' . esc_html( $texto ) . '</span></span>';
}

/**
 * Foto do topo. O título da página (h1) fica aqui para leitores de tela e
 * para o Google; no layout a página é identificada pela barra e pelo caminho.
 */
function fachini_categoria_banner() {
	$termo  = fachini_categoria_atual();
	$foto   = fachini_foto_categoria( $termo );
	$titulo = $termo ? $termo->name : post_type_archive_title( '', false );

	$html = '<div class="fachini-cat-banner">';
	if ( $foto ) {
		$html .= wp_get_attachment_image(
			$foto,
			'full',
			false,
			array(
				'class'         => 'fachini-cat-banner__foto',
				'alt'           => '',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'sizes'         => '100vw',
			)
		);
	}
	$html .= '<h1 class="fachini-sr">' . esc_html( $titulo ) . '</h1>';
	$html .= '</div>';

	return $html;
}

/**
 * Barra das categorias principais. A ativa é a categoria atual ou a
 * categoria principal acima dela.
 */
function fachini_categoria_nav() {
	$atual = fachini_categoria_atual();
	$raiz  = 0;
	if ( $atual ) {
		$ancestrais = get_ancestors( $atual->term_id, 'categoria_maquina' );
		$raiz       = $ancestrais ? (int) end( $ancestrais ) : $atual->term_id;
	}

	$itens = '';
	foreach ( fachini_categorias_principais() as $principal ) {
		$ativo  = ( $principal->term_id === $raiz );
		$itens .= '<li><a class="fachini-cat-nav__item' . ( $ativo ? ' is-ativo' : '' ) . '" href="' . esc_url( get_term_link( $principal ) ) . '"' . ( $ativo ? ' aria-current="true"' : '' ) . '>' . esc_html( $principal->name ) . '</a></li>';
	}

	return '<nav class="fachini-cat-nav" aria-label="Categorias de máquinas"><ul class="fachini-cat-nav__lista">' . $itens . '</ul></nav>';
}

/**
 * Barra das subcategorias, logo abaixo da barra principal (pedido do Rodrigo,
 * 22/10/2026): atalho para as subcategorias da categoria aberta. Numa
 * subcategoria, mostra as irmãs dela, com a atual marcada.
 */
function fachini_subcategoria_nav() {
	$atual = fachini_categoria_atual();
	if ( ! $atual ) {
		return '';
	}

	$pai    = $atual;
	$filhos = fachini_subcategorias( $atual );
	if ( ! $filhos && $atual->parent ) {
		$pai    = get_term( $atual->parent, 'categoria_maquina' );
		$filhos = ( $pai instanceof WP_Term ) ? fachini_subcategorias( $pai ) : array();
	}
	if ( ! $filhos ) {
		return '';
	}

	$itens = '';
	foreach ( $filhos as $filho ) {
		$ativo  = ( $filho->term_id === $atual->term_id );
		$itens .= '<li><a class="fachini-cat-nav__item' . ( $ativo ? ' is-ativo' : '' ) . '" href="' . esc_url( get_term_link( $filho ) ) . '"' . ( $ativo ? ' aria-current="page"' : '' ) . '>' . esc_html( $filho->name ) . '</a></li>';
	}

	return '<nav class="fachini-cat-nav fachini-subcat-nav" aria-label="' . esc_attr( 'Subcategorias de ' . $pai->name ) . '"><ul class="fachini-cat-nav__lista">' . $itens . '</ul></nav>';
}

/**
 * Ordenação da lista de máquinas. Muda a ordem pela própria URL (?ordem=),
 * então funciona com o cache da página e volta para a página 1.
 */
function fachini_ordenacao() {
	$atual  = isset( $_GET['ordem'] ) ? sanitize_key( wp_unslash( $_GET['ordem'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$opcoes = array(
		''         => 'Relevância',
		'nome'     => 'Nome (A a Z)',
		'recentes' => 'Mais recentes',
	);

	$termo = fachini_categoria_atual();
	$acao  = $termo ? get_term_link( $termo ) : get_post_type_archive_link( 'maquina' );

	$html  = '<form class="fachini-ordenar" method="get" action="' . esc_url( $acao ) . '">';
	$html .= '<label class="fachini-sr" for="fachini-ordem">Ordenar por</label>';
	$html .= '<select id="fachini-ordem" name="ordem" onchange="this.form.submit()">';
	foreach ( $opcoes as $valor => $rotulo ) {
		$html .= '<option value="' . esc_attr( $valor ) . '"' . selected( $atual, $valor, false ) . '>' . esc_html( $rotulo ) . '</option>';
	}
	$html .= '</select>';
	$html .= '<noscript><button type="submit">Ordenar</button></noscript>';
	$html .= '</form>';

	return $html;
}

/**
 * Uma faixa por categoria: rótulo com a contagem, foto escurecida, nome,
 * descrição curta e "Explorar categoria". A faixa inteira é o link.
 *
 * @param WP_Term[] $termos
 */
function fachini_faixas( $termos, $rotulo ) {
	$html = '<div class="fachini-faixas">';

	// No celular a primeira faixa é o maior elemento da tela: ela vem primeiro.
	// As de baixo só carregam quando a pessoa chega perto delas.
	$primeira = true;

	foreach ( $termos as $termo ) {
		$total     = fachini_total_maquinas( $termo );
		$foto      = fachini_foto_categoria( $termo );
		$descricao = wp_strip_all_tags( term_description( $termo ) );

		$html .= '<section class="fachini-faixa">';
		$html .= '<div class="fachini-faixa__rotulo"><span>' . esc_html( $rotulo ) . '</span>';
		if ( $total > 0 ) {
			$html .= '<span class="fachini-faixa__total">' . esc_html( sprintf( _n( '%d modelo', '%d modelos', $total, 'fachini-core' ), $total ) ) . '</span>';
		}
		$html .= '</div>';

		$html .= '<a class="fachini-faixa__corpo" href="' . esc_url( get_term_link( $termo ) ) . '">';
		if ( $foto ) {
			$carga = $primeira ? array( 'loading' => 'eager', 'fetchpriority' => 'high' ) : array( 'loading' => 'lazy', 'fetchpriority' => 'auto' );
			$html .= wp_get_attachment_image( $foto, 'full', false, array( 'class' => 'fachini-faixa__foto', 'alt' => '', 'sizes' => '100vw' ) + $carga );
			$primeira = false;
		}
		$html .= '<div class="fachini-faixa__texto">';
		$html .= '<h2 class="fachini-faixa__titulo">' . esc_html( $termo->name ) . '</h2>';
		if ( $descricao ) {
			$html .= '<p class="fachini-faixa__descricao">' . esc_html( $descricao ) . '</p>';
		}
		$html .= fachini_seta_link( 'Explorar categoria', '', 'claro', 'span' );
		$html .= '</div></a>';
		$html .= '</section>';
	}

	return $html . '</div>';
}

/**
 * Lista de máquinas da categoria (consulta principal da página), em linhas:
 * foto, nome, modelo, resumo e "Ver máquina". O cartão definitivo ainda vai
 * ser desenhado pela Débora; esta versão segue o estilo do resto do site.
 */
function fachini_lista_maquinas( $vazio = 'Em breve, as máquinas desta categoria.' ) {
	if ( ! have_posts() ) {
		return '<p class="fachini-lista-vazia">' . esc_html( $vazio ) . '</p>';
	}

	$html = '<div class="fachini-maquinas-lista">';

	while ( have_posts() ) {
		the_post();
		$link   = get_permalink();
		$modelo = (string) get_post_meta( get_the_ID(), 'modelo_serie', true );
		$resumo = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 24 );

		$html .= '<article class="fachini-maquina-linha">';
		$html .= '<a class="fachini-maquina-linha__foto" href="' . esc_url( $link ) . '" tabindex="-1" aria-hidden="true">';
		if ( has_post_thumbnail() ) {
			$html .= get_the_post_thumbnail( null, 'medium_large', array( 'alt' => '', 'sizes' => '(max-width: 767px) 100vw, 360px' ) );
		}
		$html .= '</a>';
		$html .= '<div class="fachini-maquina-linha__corpo">';
		$html .= '<h2 class="fachini-maquina-linha__nome"><a href="' . esc_url( $link ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
		if ( $modelo ) {
			$html .= '<p class="fachini-maquina-linha__modelo">' . esc_html( $modelo ) . '</p>';
		}
		if ( $resumo ) {
			$html .= '<p class="fachini-maquina-linha__resumo">' . esc_html( $resumo ) . '</p>';
		}
		$html .= fachini_seta_link( 'Ver máquina', $link, 'escuro' );
		$html .= '</div></article>';
	}
	wp_reset_postdata();

	$html .= '</div>';

	$paginas = paginate_links(
		array(
			'type'      => 'array',
			'mid_size'  => 1,
			'prev_text' => '<span aria-hidden="true">‹</span><span class="fachini-sr">Página anterior</span>',
			'next_text' => '<span aria-hidden="true">›</span><span class="fachini-sr">Próxima página</span>',
		)
	);
	if ( $paginas ) {
		$html .= '<nav class="fachini-paginacao" aria-label="Páginas"><ul><li>' . implode( '</li><li>', $paginas ) . '</li></ul></nav>';
	}

	return $html;
}

/**
 * A página inteira da listagem. Em /maquinas/, as faixas das categorias
 * principais; numa categoria com subcategorias, as faixas delas; numa
 * categoria sem subcategorias, as máquinas.
 */
function fachini_sc_listagem() {
	// Resultado da busca: mesmo modelo, sem foto no topo.
	if ( is_search() ) {
		$vazio = 'Nenhuma máquina encontrada. Tente outra palavra ou navegue pelas categorias acima.';
		return '<div class="fachini-listagem fachini-listagem--busca">' . fachini_categoria_nav() . fachini_busca_topo() . fachini_lista_maquinas( $vazio ) . '</div>';
	}

	$atual = fachini_categoria_atual();

	if ( $atual ) {
		$filhos = fachini_subcategorias( $atual );
		$rotulo = $atual->name;
	} else {
		$filhos = fachini_categorias_principais();
		$rotulo = post_type_archive_title( '', false );
	}

	$html  = '<div class="fachini-listagem">';
	$html .= fachini_categoria_banner();
	$html .= fachini_categoria_nav();
	$html .= fachini_subcategoria_nav();
	$html .= '<div class="fachini-cat-topo">' . fachini_sc_breadcrumb() . ( $filhos ? '' : fachini_ordenacao() ) . '</div>';
	$html .= $filhos ? fachini_faixas( $filhos, $rotulo ) : fachini_lista_maquinas();
	$html .= '</div>';

	return $html;
}
add_shortcode( 'fachini_listagem', 'fachini_sc_listagem' );

/**
 * Ordem da lista de máquinas: relevância (ordem definida no painel, depois o
 * nome), nome de A a Z ou mais recentes.
 */
function fachini_ordenar_listagem( $consulta ) {
	if ( is_admin() || ! $consulta->is_main_query() ) {
		return;
	}
	if ( ! $consulta->is_tax( 'categoria_maquina' ) && ! $consulta->is_post_type_archive( 'maquina' ) ) {
		return;
	}

	$ordem = isset( $_GET['ordem'] ) ? sanitize_key( wp_unslash( $_GET['ordem'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( 'nome' === $ordem ) {
		$consulta->set( 'orderby', 'title' );
		$consulta->set( 'order', 'ASC' );
	} elseif ( 'recentes' === $ordem ) {
		$consulta->set( 'orderby', 'date' );
		$consulta->set( 'order', 'DESC' );
	} else {
		$consulta->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
	}
}
add_action( 'pre_get_posts', 'fachini_ordenar_listagem' );
