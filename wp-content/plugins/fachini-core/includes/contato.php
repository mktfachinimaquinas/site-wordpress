<?php
/**
 * Página Contato e página de confirmação do pedido, iguais ao Figma
 * ("CONTATO - 1370" e "CONFIRMAÇÃO - 1367").
 *
 * [fachini_contato]: caminho, título, o formulário de orçamento em duas
 * linhas (dados de cadastro e interesse) e as perguntas frequentes.
 * [fachini_confirmacao]: número do protocolo, próximos passos e o caminho
 * para o WhatsApp.
 *
 * Os campos seguem a Política de Privacidade aprovada (item 3.1): nome,
 * e-mail, WhatsApp e, para empresa, CNPJ são obrigatórios; empresa, cargo,
 * cidade, estado e mensagem são opcionais. As duas autorizações são separadas
 * (item 5): a de contato é obrigatória, a de marketing não.
 *
 * O registro e o envio do pedido ficam em includes/pedidos.php, o
 * comportamento do formulário em assets/contato.js e o visual no tema filho.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Quantas perguntas frequentes a página aceita.
define( 'FACHINI_FAQ_MAX', 8 );

/**
 * A página atual é montada por inteiro pelo plugin (contato, confirmação ou
 * política de privacidade)?
 */
function fachini_contato_pagina_propria() {
	if ( ! is_page() ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return false;
	}
	foreach ( array( 'fachini_contato', 'fachini_confirmacao', 'fachini_politica', 'fachini_termos' ) as $shortcode ) {
		if ( has_shortcode( $post->post_content, $shortcode ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Nessas páginas o título e a largura vêm do layout, não do tema pai.
 */
function fachini_contato_classe_body( $classes ) {
	if ( fachini_contato_pagina_propria() ) {
		$classes[] = 'fachini-pagina-larga';
	}
	return $classes;
}
add_filter( 'body_class', 'fachini_contato_classe_body' );

function fachini_contato_sem_titulo_tema( $mostrar ) {
	return fachini_contato_pagina_propria() ? false : $mostrar;
}
add_filter( 'hello_elementor_page_title', 'fachini_contato_sem_titulo_tema' );

/**
 * A confirmação de um pedido mostra o protocolo e o nome da pessoa: não pode
 * ficar guardada no cache nem aparecer no Google.
 */
function fachini_confirmacao_sem_cache() {
	if ( isset( $_GET['pedido'] ) && fachini_contato_pagina_propria() ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		nocache_headers();
		do_action( 'litespeed_control_set_nocache', 'pedido de orçamento' );
	}
}
add_action( 'template_redirect', 'fachini_confirmacao_sem_cache' );

function fachini_confirmacao_e_esta() {
	if ( ! is_page() ) {
		return false;
	}
	$post = get_queried_object();
	return ( $post instanceof WP_Post ) && has_shortcode( $post->post_content, 'fachini_confirmacao' );
}

function fachini_confirmacao_robots( $robots ) {
	if ( fachini_confirmacao_e_esta() ) {
		$robots['noindex'] = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'fachini_confirmacao_robots' );

function fachini_confirmacao_robots_rank_math( $robots ) {
	if ( fachini_confirmacao_e_esta() ) {
		$robots['index'] = 'noindex';
	}
	return $robots;
}
add_filter( 'rank_math/frontend/robots', 'fachini_confirmacao_robots_rank_math' );

// O sitemap do Rank Math não passa pelo filtro acima: a confirmação sai dele aqui.
function fachini_confirmacao_fora_do_sitemap( $url, $tipo, $objeto ) {
	if ( 'post' === $tipo && isset( $objeto->post_content ) && has_shortcode( $objeto->post_content, 'fachini_confirmacao' ) ) {
		return false;
	}
	return $url;
}
add_filter( 'rank_math/sitemap/entry', 'fachini_confirmacao_fora_do_sitemap', 10, 3 );

/**
 * Perguntas frequentes: campos na própria página Contato (ACF), preenchidos
 * por nós com o texto que a Fachini enviar. Pergunta sem resposta não aparece;
 * sem nenhuma, a seção some.
 */
function fachini_contato_campos_faq() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$pagina = get_page_by_path( 'contato' );
	if ( ! $pagina ) {
		return;
	}

	$campos = array();
	for ( $n = 1; $n <= FACHINI_FAQ_MAX; $n++ ) {
		$campos[] = array(
			'key'   => 'field_fachini_faq_' . $n . '_pergunta',
			'label' => 'Pergunta ' . $n,
			'name'  => 'faq_' . $n . '_pergunta',
			'type'  => 'text',
		);
		$campos[] = array(
			'key'       => 'field_fachini_faq_' . $n . '_resposta',
			'label'     => 'Resposta ' . $n,
			'name'      => 'faq_' . $n . '_resposta',
			'type'      => 'textarea',
			'rows'      => 3,
			'new_lines' => '',
		);
	}

	acf_add_local_field_group(
		array(
			'key'         => 'group_fachini_contato_faq',
			'title'       => 'Perguntas frequentes (página Contato)',
			'location'    => array(
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => (string) $pagina->ID,
					),
				),
			),
			'position'    => 'normal',
			'show_in_rest' => true,
			'description' => 'Aparecem no fim da página, em "Ainda tem dúvidas?".',
			'fields'      => $campos,
		)
	);
}
add_action( 'acf/init', 'fachini_contato_campos_faq' );

/**
 * Perguntas preenchidas, na ordem.
 *
 * @return array<int, array{0: string, 1: string}>
 */
function fachini_contato_faq( $post_id ) {
	$itens = array();
	for ( $n = 1; $n <= FACHINI_FAQ_MAX; $n++ ) {
		$pergunta = trim( (string) fachini_campo( 'faq_' . $n . '_pergunta', $post_id ) );
		$resposta = trim( (string) fachini_campo( 'faq_' . $n . '_resposta', $post_id ) );
		if ( '' !== $pergunta && '' !== $resposta ) {
			$itens[] = array( $pergunta, $resposta );
		}
	}
	return $itens;
}

/**
 * Categorias principais e as máquinas de cada uma, para os campos Categoria e
 * Modelo. O Modelo é preenchido pelo assets/contato.js conforme a categoria.
 */
function fachini_contato_maquinas() {
	$lista = array();
	foreach ( fachini_categorias_principais() as $termo ) {
		$ids = get_posts(
			array(
				'post_type'      => 'maquina',
				'post_status'    => 'publish',
				'posts_per_page' => 200,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy'         => 'categoria_maquina',
						'terms'            => $termo->term_id,
						'include_children' => true,
					),
				),
			)
		);
		$lista[] = array(
			'id'       => $termo->term_id,
			'nome'     => $termo->name,
			'maquinas' => array_map(
				function ( $id ) {
					return array(
						'id'   => $id,
						'nome' => html_entity_decode( get_the_title( $id ), ENT_QUOTES, 'UTF-8' ),
					);
				},
				$ids
			),
		);
	}
	return $lista;
}

/**
 * Uma linha do layout: linha em cima, rótulo e título à esquerda, conteúdo à
 * direita.
 */
function fachini_contato_linha( $rotulo, $titulo, $conteudo, $classe = '' ) {
	return '<section class="fachini-contato-linha' . ( $classe ? ' ' . esc_attr( $classe ) : '' ) . '">'
		. '<div class="fachini-contato-linha__cabeca">'
		. '<p class="fachini-contato-linha__rotulo">' . esc_html( $rotulo ) . '</p>'
		. '<h2 class="fachini-contato-linha__titulo">' . esc_html( $titulo ) . '</h2>'
		. '</div>'
		. '<div class="fachini-contato-linha__corpo">' . $conteudo . '</div>'
		. '</section>';
}

/**
 * Um campo: rótulo em cima, campo sublinhado, mensagem de erro embaixo.
 *
 * @param array $c nome, rotulo, tipo (text, email, tel, select, textarea),
 *                 obrigatorio, opcoes (select), atributos extras, classe.
 */
function fachini_contato_campo( $c ) {
	$id     = 'fachini-' . $c['nome'];
	$obrig  = ! empty( $c['obrigatorio'] );
	$tipo   = isset( $c['tipo'] ) ? $c['tipo'] : 'text';
	$extras = '';
	foreach ( isset( $c['atributos'] ) ? $c['atributos'] : array() as $atributo => $valor ) {
		$extras .= ' ' . $atributo . '="' . esc_attr( $valor ) . '"';
	}
	$comum = ' id="' . esc_attr( $id ) . '" name="' . esc_attr( $c['nome'] ) . '" class="fachini-campo__controle"'
		. ( $obrig ? ' required aria-required="true"' : '' )
		. ' aria-describedby="' . esc_attr( $id ) . '-erro"' . $extras;

	if ( 'select' === $tipo ) {
		// Campo opcional pode voltar a ficar em branco.
		$controle = '<select' . $comum . '><option value="" selected' . ( $obrig ? ' disabled hidden' : '' ) . '></option>';
		foreach ( isset( $c['opcoes'] ) ? $c['opcoes'] : array() as $valor => $texto ) {
			$controle .= '<option value="' . esc_attr( $valor ) . '">' . esc_html( $texto ) . '</option>';
		}
		$controle .= '</select>';
	} elseif ( 'textarea' === $tipo ) {
		$controle = '<textarea' . $comum . ' rows="4"></textarea>';
	} else {
		$controle = '<input type="' . esc_attr( $tipo ) . '"' . $comum . '>';
	}

	return '<div class="fachini-campo fachini-campo--' . esc_attr( $tipo ) . ( ! empty( $c['classe'] ) ? ' ' . esc_attr( $c['classe'] ) : '' ) . '" data-campo="' . esc_attr( $c['nome'] ) . '">'
		. '<label class="fachini-campo__rotulo" for="' . esc_attr( $id ) . '">' . esc_html( $c['rotulo'] )
		. ( $obrig ? '<span class="fachini-campo__obrig" aria-hidden="true">*</span>' : '' ) . '</label>'
		. $controle
		. '<p class="fachini-campo__erro" id="' . esc_attr( $id ) . '-erro" hidden></p>'
		. '</div>';
}

/**
 * Caixa de autorização, com o texto exato que fica registrado no pedido.
 */
function fachini_contato_aceite( $nome, $texto, $obrigatorio ) {
	$id   = 'fachini-' . $nome;
	$html = esc_html( $texto );
	// O texto é o mesmo gravado no pedido; só o nome da política vira link.
	$html = str_replace(
		'Política de Privacidade',
		'<a href="' . esc_url( home_url( '/politica-de-privacidade/' ) ) . '" target="_blank" rel="noopener">Política de Privacidade</a>',
		$html
	);

	return '<div class="fachini-aceite" data-campo="' . esc_attr( $nome ) . '">'
		. '<input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $nome ) . '" value="1"'
		. ( $obrigatorio ? ' required aria-required="true"' : '' ) . ' aria-describedby="' . esc_attr( $id ) . '-erro">'
		. '<label for="' . esc_attr( $id ) . '">' . $html . ( $obrigatorio ? '<span class="fachini-campo__obrig" aria-hidden="true">*</span>' : '' ) . '</label>'
		. '<p class="fachini-campo__erro" id="' . esc_attr( $id ) . '-erro" hidden></p>'
		. '</div>';
}

/**
 * Carrega o script do formulário e da confirmação.
 */
function fachini_contato_script() {
	wp_enqueue_script(
		'fachini-contato',
		plugins_url( 'assets/contato.js', FACHINI_CORE_PATH . 'fachini-core.php' ),
		array(),
		FACHINI_CORE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}

/**
 * A página Contato inteira.
 */
function fachini_sc_contato() {
	fachini_contato_script();

	$ufs = array();
	foreach ( fachini_ufs() as $uf ) {
		$ufs[ $uf ] = $uf;
	}
	$categorias = array();
	$maquinas   = fachini_contato_maquinas();
	foreach ( $maquinas as $categoria ) {
		$categorias[ $categoria['id'] ] = $categoria['nome'];
	}
	$textos = fachini_textos_consentimento();

	// Dados de cadastro.
	$tipo = '<fieldset class="fachini-campo fachini-campo--opcoes" data-campo="tipo" aria-describedby="fachini-tipo-erro">'
		. '<legend class="fachini-campo__rotulo">Como deseja prosseguir?<span class="fachini-campo__obrig" aria-hidden="true">*</span></legend>'
		. '<div class="fachini-opcoes">'
		. '<label class="fachini-opcao"><input type="radio" name="tipo" value="pf" required> Pessoa física</label>'
		. '<label class="fachini-opcao"><input type="radio" name="tipo" value="pj"> Empresa</label>'
		. '</div>'
		. '<p class="fachini-campo__erro" id="fachini-tipo-erro" hidden></p>'
		. '</fieldset>';

	$cadastro = $tipo
		. fachini_contato_campo( array( 'nome' => 'nome', 'rotulo' => 'Nome completo', 'obrigatorio' => true, 'atributos' => array( 'autocomplete' => 'name', 'maxlength' => '120' ) ) )
		. fachini_contato_campo( array( 'nome' => 'email', 'rotulo' => 'E-mail', 'tipo' => 'email', 'obrigatorio' => true, 'atributos' => array( 'autocomplete' => 'email', 'maxlength' => '120' ) ) )
		. fachini_contato_campo( array( 'nome' => 'whatsapp', 'rotulo' => 'WhatsApp', 'tipo' => 'tel', 'obrigatorio' => true, 'atributos' => array( 'autocomplete' => 'tel', 'inputmode' => 'tel', 'maxlength' => '30', 'placeholder' => '(00) 00000-0000' ) ) )
		. fachini_contato_campo( array( 'nome' => 'cnpj', 'rotulo' => 'CNPJ', 'obrigatorio' => true, 'classe' => 'fachini-campo--empresa', 'atributos' => array( 'maxlength' => '18', 'autocapitalize' => 'characters', 'placeholder' => '00.000.000/0000-00' ) ) )
		. '<div class="fachini-form__dupla fachini-campo--empresa">'
		. fachini_contato_campo( array( 'nome' => 'empresa', 'rotulo' => 'Empresa', 'atributos' => array( 'autocomplete' => 'organization', 'maxlength' => '120' ) ) )
		. fachini_contato_campo( array( 'nome' => 'cargo', 'rotulo' => 'Cargo', 'atributos' => array( 'autocomplete' => 'organization-title', 'maxlength' => '80' ) ) )
		. '</div>'
		. '<div class="fachini-form__dupla fachini-form__dupla--cidade">'
		. fachini_contato_campo( array( 'nome' => 'cidade', 'rotulo' => 'Cidade', 'atributos' => array( 'autocomplete' => 'address-level2', 'maxlength' => '80' ) ) )
		. fachini_contato_campo( array( 'nome' => 'uf', 'rotulo' => 'Estado', 'tipo' => 'select', 'opcoes' => $ufs, 'atributos' => array( 'autocomplete' => 'address-level1' ) ) )
		. '</div>';

	// Interesse, autorizações e botões.
	$interesse = fachini_contato_campo( array( 'nome' => 'categoria', 'rotulo' => 'Categoria', 'tipo' => 'select', 'obrigatorio' => true, 'opcoes' => $categorias ) )
		. fachini_contato_campo( array( 'nome' => 'modelo', 'rotulo' => 'Modelo', 'tipo' => 'select', 'obrigatorio' => true, 'opcoes' => array() ) )
		. fachini_contato_campo( array( 'nome' => 'mensagem', 'rotulo' => 'Mensagem', 'tipo' => 'textarea', 'atributos' => array( 'maxlength' => '2000', 'placeholder' => 'Conte o que você pretende fabricar, se quiser.' ) ) )
		. '<div class="fachini-form__aceites">'
		. fachini_contato_aceite( 'aceite_contato', $textos['contato'], true )
		. fachini_contato_aceite( 'aceite_marketing', $textos['marketing'], false )
		. '</div>'
		. '<p class="fachini-form__aviso" role="alert" hidden></p>'
		. '<div class="fachini-form__acoes">'
		. '<button type="reset" class="fachini-form__botao fachini-form__botao--limpar">Limpar</button>'
		. '<button type="submit" class="fachini-form__botao fachini-form__botao--enviar">Enviar</button>'
		. '</div>';

	$html  = '<div class="fachini-contato">';
	$html .= '<div class="fachini-contato__topo">' . fachini_sc_breadcrumb() . '<h1 class="fachini-contato__titulo">Solicite seu orçamento</h1></div>';

	$html .= '<form class="fachini-form" novalidate data-endpoint="' . esc_url( rest_url( 'fachini/v1/pedido' ) ) . '">';
	$html .= fachini_contato_linha( 'Dados', 'Informações de cadastro', $cadastro );
	$html .= fachini_contato_linha( 'Interesse', 'O que você procura?', $interesse );
	// Campo isca: invisível para pessoas, robôs preenchem.
	$html .= '<div class="fachini-form__isca" aria-hidden="true"><label>Deixe este campo em branco <input type="text" name="site" tabindex="-1" autocomplete="off"></label></div>';
	$html .= '<input type="hidden" name="t" value=""><input type="hidden" name="pagina" value=""><input type="hidden" name="referencia" value="">';
	$html .= '<noscript><p class="fachini-form__aviso">Para enviar o pedido, ative o JavaScript do navegador ou fale conosco pelo WhatsApp.</p></noscript>';
	$html .= '</form>';
	$html .= '<script type="application/json" id="fachini-form-maquinas">' . wp_json_encode( $maquinas, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE ) . '</script>';

	$faq = fachini_contato_faq( get_the_ID() );
	if ( $faq ) {
		$itens = '';
		foreach ( $faq as $item ) {
			$itens .= '<details class="fachini-faq__item">'
				. '<summary class="fachini-faq__pergunta">' . esc_html( $item[0] ) . '</summary>'
				. '<div class="fachini-faq__resposta">' . wpautop( wp_kses_post( $item[1] ) ) . '</div>'
				. '</details>';
		}
		$html .= fachini_contato_linha( 'FAQ', 'Ainda tem dúvidas?', '<div class="fachini-faq">' . $itens . '</div>', 'fachini-contato-linha--faq' );
	}

	return $html . '</div>';
}
add_shortcode( 'fachini_contato', 'fachini_sc_contato' );

/**
 * Página de confirmação. Com um pedido válido no endereço, mostra o protocolo
 * e leva ao WhatsApp com uma mensagem pronta; sem ele (alguém abriu
 * /obrigado/ direto), mostra a confirmação sem protocolo e sem redirecionar.
 */
function fachini_sc_confirmacao() {
	fachini_contato_script();

	$pedido    = fachini_pedido_da_url();
	$protocolo = '';
	$mensagem  = 'Olá! Gostaria de falar com um especialista da Fachini Máquinas.';

	if ( $pedido ) {
		$protocolo = (string) get_post_meta( $pedido->ID, 'fachini_pedido_protocolo', true );
		$d         = get_post_meta( $pedido->ID, 'fachini_pedido_dados', true );
		$primeiro  = is_array( $d ) ? strtok( $d['nome'], ' ' ) : '';
		$interesse = '';
		if ( is_array( $d ) ) {
			$interesse = 'ajuda' === $d['modelo'] ? $d['categoria_nome'] . ' (ainda sem modelo definido)' : $d['modelo_nome'];
		}
		$mensagem = 'Olá! ' . ( $primeiro ? 'Meu nome é ' . $primeiro . ' e acabei' : 'Acabei' )
			. ' de enviar um pedido de orçamento pelo site (protocolo #' . $protocolo . ').'
			. ( $interesse ? ' Tenho interesse em: ' . $interesse . '.' : '' );
	}
	$whatsapp = fachini_whatsapp_link( $mensagem );

	$caminho = fachini_breadcrumb_montar(
		array(
			'<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>',
			'<a href="' . esc_url( home_url( '/contato/' ) ) . '">Contato</a>',
			'<span>Atendimento</span>',
		)
	);

	if ( $pedido && $whatsapp ) {
		$texto = 'Obrigado pelo contato! Para dar início ao seu atendimento, você será redirecionado ao WhatsApp.';
	} elseif ( $whatsapp ) {
		$texto = 'Obrigado pelo contato! Para falar agora com um especialista, use o botão abaixo.';
	} else {
		$texto = 'Obrigado pelo contato! Um especialista da Fachini vai falar com você em breve.';
	}

	$html  = '<div class="fachini-confirmacao">';
	$html .= '<div class="fachini-confirmacao__caminho">' . $caminho . '</div>';
	$html .= '<div class="fachini-confirmacao__grade">';

	$html .= '<div class="fachini-confirmacao__principal">';
	$html .= '<span class="fachini-confirmacao__icone" aria-hidden="true"></span>';
	$html .= '<h1 class="fachini-confirmacao__titulo">Solicitação enviada com sucesso!</h1>';
	$html .= '<p class="fachini-confirmacao__texto">' . esc_html( $texto ) . '</p>';
	if ( $whatsapp ) {
		$html .= '<div class="fachini-confirmacao__whatsapp"' . ( $pedido ? ' data-auto="' . esc_attr( $pedido->ID ) . '"' : '' ) . ' data-url="' . esc_url( $whatsapp ) . '">';
		if ( $pedido ) {
			$html .= '<p class="fachini-confirmacao__status" aria-live="polite">Redirecionando...</p>'
				. '<div class="fachini-confirmacao__barra" aria-hidden="true"><span></span></div>'
				. '<p class="fachini-confirmacao__ajuda">Não abriu? Clique abaixo para acessar o WhatsApp</p>';
		}
		$html .= '<a class="fachini-confirmacao__botao" href="' . esc_url( $whatsapp ) . '">Falar com um especialista</a>';
		$html .= '</div>';
	}
	$html .= '</div>';

	$html .= '<div class="fachini-confirmacao__lateral">';
	if ( $protocolo ) {
		$html .= '<p class="fachini-confirmacao__rotulo">Número de protocolo</p>'
			. '<p class="fachini-confirmacao__protocolo">#' . esc_html( $protocolo ) . '</p>';
	}
	$html .= '<p class="fachini-confirmacao__passos-titulo">Próximos passos</p>';
	$html .= '<ol class="fachini-confirmacao__passos">'
		. '<li class="is-feito"><span>01</span>Formulário enviado</li>'
		. '<li class="is-atual"><span>02</span>Iniciar conversa</li>'
		. '<li><span>03</span>Atendimento com especialista</li>'
		. '<li class="is-depois"><span>04</span>Orçamento</li>'
		. '</ol>';
	$html .= '<p class="fachini-confirmacao__nota">Nosso atendimento via WhatsApp está disponível em horário comercial. Um especialista técnico entrará em contato para atender a sua necessidade.</p>';
	$html .= '</div>';

	return $html . '</div></div>';
}
add_shortcode( 'fachini_confirmacao', 'fachini_sc_confirmacao' );
