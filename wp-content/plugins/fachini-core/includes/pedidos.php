<?php
/**
 * Pedidos de orçamento: o que acontece quando alguém envia o formulário da
 * página Contato (o formulário fica em includes/contato.php).
 *
 * Cada pedido é gravado no painel, no menu "Pedidos de orçamento" (só o
 * administrador vê), junto com o registro do consentimento que a Política de
 * Privacidade promete no item 3.3: data e hora, IP, página de origem, o texto
 * exato das autorizações exibidas e quais caixas foram marcadas. Se houver
 * e-mail configurado em Pedidos de orçamento > Configurações, o pedido também
 * vai por e-mail. Assim nenhum pedido se perde, mesmo que o e-mail falhe.
 *
 * O envio ao RD Station entra na etapa 3, a partir de fachini_pedido_receber().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FACHINI_PEDIDO_TIPO', 'fachini_pedido' );

// WhatsApp do atendimento, o da Política de Privacidade (item 5.2). Pode ser
// trocado em Pedidos de orçamento > Configurações.
define( 'FACHINI_WHATSAPP_PADRAO', '554533281313' );

// Versão dos textos de autorização. Mudou o texto, muda a versão: cada pedido
// guarda a versão e o texto que a pessoa viu.
define( 'FACHINI_CONSENTIMENTO_VERSAO', '2026-10-21' );

// Quantos pedidos o mesmo endereço IP pode enviar por hora.
define( 'FACHINI_PEDIDOS_POR_HORA', 5 );

/**
 * Textos das duas autorizações, separadas como pede a Política (item 5).
 * A de contato é obrigatória; a de marketing não impede o orçamento.
 */
function fachini_textos_consentimento() {
	return array(
		'contato'   => 'Autorizo a Fachini Máquinas a entrar em contato comigo por WhatsApp, telefone e e-mail para responder a esta solicitação, conforme a Política de Privacidade.',
		'marketing' => 'Quero receber comunicações de marketing da Fachini Máquinas, como novidades, campanhas, materiais e convites para eventos. Posso cancelar quando quiser.',
	);
}

/**
 * Tipo de conteúdo dos pedidos. Não aparece no site, só no painel, e só para
 * quem pode gerenciar o site: são dados pessoais.
 */
function fachini_pedidos_registrar() {
	$cap = 'manage_options';

	register_post_type(
		FACHINI_PEDIDO_TIPO,
		array(
			'labels'              => array(
				'name'               => 'Pedidos de orçamento',
				'singular_name'      => 'Pedido de orçamento',
				'menu_name'          => 'Pedidos de orçamento',
				'all_items'          => 'Todos os pedidos',
				'edit_item'          => 'Pedido de orçamento',
				'search_items'       => 'Buscar pedidos',
				'not_found'          => 'Nenhum pedido recebido ainda',
				'not_found_in_trash' => 'Nenhum pedido na lixeira',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'query_var'           => false,
			'rewrite'             => false,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 21,
			'supports'            => array( 'title' ),
			// Pedido só nasce pelo formulário: sem "Adicionar novo".
			'capabilities'        => array(
				'edit_post'              => $cap,
				'read_post'              => $cap,
				'delete_post'            => $cap,
				'edit_posts'             => $cap,
				'edit_others_posts'      => $cap,
				'edit_private_posts'     => $cap,
				'edit_published_posts'   => $cap,
				'publish_posts'          => $cap,
				'read_private_posts'     => $cap,
				'delete_posts'           => $cap,
				'delete_private_posts'   => $cap,
				'delete_published_posts' => $cap,
				'delete_others_posts'    => $cap,
				'create_posts'           => 'do_not_allow',
			),
			'map_meta_cap'        => false,
		)
	);
}
add_action( 'init', 'fachini_pedidos_registrar' );

/**
 * Número do protocolo: ano-mês do pedido e o número dele, ex. 2026-10-0257.
 */
function fachini_pedido_protocolo( $id ) {
	return get_post_time( 'Y-m', false, $id ) . '-' . sprintf( '%04d', $id );
}

/**
 * Chave que libera a página de confirmação de um pedido. Sem ela, quem
 * trocasse o número no endereço veria o pedido de outra pessoa.
 */
function fachini_pedido_chave( $id ) {
	return substr( wp_hash( 'fachini_pedido_' . (int) $id, 'nonce' ), 0, 16 );
}

/**
 * WhatsApp do atendimento, só números com país e DDD. Vazio desliga o
 * redirecionamento da página de confirmação.
 */
function fachini_whatsapp_numero() {
	return preg_replace( '/\D/', '', (string) get_option( 'fachini_whatsapp', FACHINI_WHATSAPP_PADRAO ) );
}

function fachini_whatsapp_link( $texto = '' ) {
	$numero = fachini_whatsapp_numero();
	if ( '' === $numero ) {
		return '';
	}
	return 'https://wa.me/' . $numero . ( '' !== $texto ? '?text=' . rawurlencode( $texto ) : '' );
}

/**
 * E-mails que recebem os pedidos.
 *
 * @return string[]
 */
function fachini_pedidos_emails() {
	$lista = array_map( 'trim', explode( ',', (string) get_option( 'fachini_pedidos_emails', '' ) ) );
	return array_values( array_filter( $lista, 'is_email' ) );
}

/**
 * Estados, para o campo Estado.
 */
function fachini_ufs() {
	return array( 'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO' );
}

/**
 * CNPJ válido, no formato numérico e no alfanumérico que a Receita Federal
 * passou a emitir em julho de 2026 (letras nas 12 primeiras posições). O
 * dígito verificador usa o código do caractere menos 48, que para números é o
 * próprio número.
 */
function fachini_cnpj_valido( $cnpj ) {
	$c = strtoupper( preg_replace( '/[^0-9A-Za-z]/', '', (string) $cnpj ) );

	if ( ! preg_match( '/^[0-9A-Z]{12}[0-9]{2}$/', $c ) || preg_match( '/^(.)\1{13}$/', $c ) ) {
		return false;
	}

	foreach ( array( 12, 13 ) as $tamanho ) {
		$soma = 0;
		$peso = $tamanho - 7;
		for ( $i = 0; $i < $tamanho; $i++ ) {
			$soma += ( ord( $c[ $i ] ) - 48 ) * $peso;
			$peso  = ( 2 === $peso ) ? 9 : $peso - 1;
		}
		$resto = $soma % 11;
		if ( (int) $c[ $tamanho ] !== ( $resto < 2 ? 0 : 11 - $resto ) ) {
			return false;
		}
	}
	return true;
}

/**
 * A máquina está publicada e pertence à categoria (ou a uma subcategoria dela)?
 */
function fachini_maquina_na_categoria( $maquina_id, $categoria_id ) {
	if ( 'maquina' !== get_post_type( $maquina_id ) || 'publish' !== get_post_status( $maquina_id ) ) {
		return false;
	}
	foreach ( wp_get_object_terms( $maquina_id, 'categoria_maquina', array( 'fields' => 'ids' ) ) as $termo ) {
		if ( (int) $termo === (int) $categoria_id || in_array( (int) $categoria_id, array_map( 'intval', get_ancestors( $termo, 'categoria_maquina' ) ), true ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Confere o que veio do formulário.
 *
 * @return array{0: array, 1: array} Os dados limpos e os erros por campo.
 */
function fachini_pedido_validar( $p ) {
	$texto = function ( $chave, $maximo ) use ( $p ) {
		$valor = isset( $p[ $chave ] ) && is_scalar( $p[ $chave ] ) ? sanitize_text_field( (string) $p[ $chave ] ) : '';
		return mb_substr( $valor, 0, $maximo );
	};

	$d     = array();
	$erros = array();

	$d['tipo'] = $texto( 'tipo', 2 );
	if ( ! in_array( $d['tipo'], array( 'pf', 'pj' ), true ) ) {
		$erros['tipo'] = 'Escolha como deseja prosseguir.';
	}

	$d['nome'] = $texto( 'nome', 120 );
	if ( mb_strlen( $d['nome'] ) < 3 ) {
		$erros['nome'] = 'Informe seu nome completo.';
	}

	$d['email'] = sanitize_email( $texto( 'email', 120 ) );
	if ( ! is_email( $d['email'] ) ) {
		$erros['email'] = 'Informe um e-mail válido.';
	}

	$d['whatsapp'] = $texto( 'whatsapp', 30 );
	$digitos       = strlen( preg_replace( '/\D/', '', $d['whatsapp'] ) );
	if ( $digitos < 10 || $digitos > 15 ) {
		$erros['whatsapp'] = 'Informe o WhatsApp com DDD.';
	}

	$d['cnpj'] = $d['empresa'] = $d['cargo'] = '';
	if ( 'pj' === $d['tipo'] ) {
		$d['cnpj'] = strtoupper( $texto( 'cnpj', 20 ) );
		if ( ! fachini_cnpj_valido( $d['cnpj'] ) ) {
			$erros['cnpj'] = 'Informe um CNPJ válido.';
		}
		$d['empresa'] = $texto( 'empresa', 120 );
		$d['cargo']   = $texto( 'cargo', 80 );
	}

	$d['cidade'] = $texto( 'cidade', 80 );
	$d['uf']     = strtoupper( $texto( 'uf', 2 ) );
	if ( '' !== $d['uf'] && ! in_array( $d['uf'], fachini_ufs(), true ) ) {
		$d['uf'] = '';
	}

	$d['categoria']      = absint( $texto( 'categoria', 12 ) );
	$categoria           = $d['categoria'] ? get_term( $d['categoria'], 'categoria_maquina' ) : null;
	$d['categoria_nome'] = ( $categoria instanceof WP_Term && 0 === (int) $categoria->parent ) ? $categoria->name : '';
	if ( '' === $d['categoria_nome'] ) {
		$erros['categoria'] = 'Escolha uma categoria.';
	}

	$modelo           = $texto( 'modelo', 12 );
	$d['modelo']      = 'ajuda' === $modelo ? 'ajuda' : absint( $modelo );
	$d['modelo_nome'] = '';
	if ( 'ajuda' === $d['modelo'] ) {
		$d['modelo_nome'] = 'Ainda não sei, quero ajuda para escolher';
	} elseif ( $d['modelo'] && $d['categoria_nome'] && fachini_maquina_na_categoria( $d['modelo'], $d['categoria'] ) ) {
		$d['modelo_nome'] = html_entity_decode( get_the_title( $d['modelo'] ), ENT_QUOTES, 'UTF-8' );
	}
	if ( '' === $d['modelo_nome'] && ! isset( $erros['categoria'] ) ) {
		$erros['modelo'] = 'Escolha um modelo.';
	}

	$d['mensagem'] = isset( $p['mensagem'] ) && is_scalar( $p['mensagem'] ) ? mb_substr( sanitize_textarea_field( (string) $p['mensagem'] ), 0, 2000 ) : '';

	$d['aceite_contato']   = ! empty( $p['aceite_contato'] );
	$d['aceite_marketing'] = ! empty( $p['aceite_marketing'] );
	if ( ! $d['aceite_contato'] ) {
		$erros['aceite_contato'] = 'Para responder ao seu pedido, precisamos da sua autorização de contato.';
	}

	return array( $d, $erros );
}

/**
 * Os dados do pedido em linhas "rótulo: valor", para o e-mail e o painel.
 */
function fachini_pedido_linhas( $d ) {
	$linhas = array(
		'Como deseja prosseguir' => 'pj' === $d['tipo'] ? 'Empresa' : 'Pessoa física',
		'Nome'                   => $d['nome'],
		'E-mail'                 => $d['email'],
		'WhatsApp'               => $d['whatsapp'],
	);
	if ( 'pj' === $d['tipo'] ) {
		$linhas['CNPJ']    = $d['cnpj'];
		$linhas['Empresa'] = $d['empresa'];
		$linhas['Cargo']   = $d['cargo'];
	}
	$linhas['Cidade']    = $d['cidade'];
	$linhas['Estado']    = $d['uf'];
	$linhas['Categoria'] = $d['categoria_nome'];
	$linhas['Modelo']    = $d['modelo_nome'];
	$linhas['Mensagem']  = $d['mensagem'];
	$linhas['Autoriza contato comercial'] = $d['aceite_contato'] ? 'Sim' : 'Não';
	$linhas['Aceita comunicações de marketing'] = $d['aceite_marketing'] ? 'Sim' : 'Não';

	return array_filter(
		$linhas,
		function ( $valor ) {
			return '' !== (string) $valor;
		}
	);
}

/**
 * Manda o pedido por e-mail, se houver e-mail configurado.
 *
 * @return bool|null Null quando não há para quem mandar.
 */
function fachini_pedido_enviar_email( $id, $d, $protocolo ) {
	$para = fachini_pedidos_emails();
	if ( ! $para ) {
		return null;
	}

	$corpo = "Novo pedido de orçamento recebido pelo site.\n\nProtocolo: #" . $protocolo . "\n";
	foreach ( fachini_pedido_linhas( $d ) as $rotulo => $valor ) {
		$corpo .= $rotulo . ': ' . $valor . "\n";
	}
	$corpo .= "\nVer no painel: " . admin_url( 'post.php?post=' . (int) $id . '&action=edit' ) . "\n";

	$nome = trim( str_replace( array( '"', ',', '<', '>' ), '', $d['nome'] ) );

	return wp_mail(
		$para,
		'Pedido de orçamento #' . $protocolo . ' - ' . $d['nome'],
		$corpo,
		array( 'Reply-To: "' . $nome . '" <' . $d['email'] . '>' )
	);
}

/**
 * Endereço da página de confirmação (/obrigado/).
 */
function fachini_confirmacao_url() {
	$pagina = get_page_by_path( 'obrigado' );
	return $pagina ? get_permalink( $pagina ) : home_url( '/obrigado/' );
}

/**
 * Recebe o formulário: POST /wp-json/fachini/v1/pedido.
 */
function fachini_pedido_receber( WP_REST_Request $pedido ) {
	$p    = $pedido->get_body_params();
	$erro = function ( $mensagem, $erros = array(), $status = 400 ) {
		return new WP_REST_Response( array( 'ok' => false, 'mensagem' => $mensagem, 'erros' => (object) $erros ), $status );
	};

	// Campo isca, invisível para pessoas: preenchido, é robô. Responde como se
	// tivesse dado certo, para o robô não insistir.
	if ( ! empty( $p['site'] ) ) {
		return new WP_REST_Response( array( 'ok' => true, 'destino' => fachini_confirmacao_url() ), 200 );
	}

	// Ninguém preenche o formulário em menos de 3 segundos.
	if ( empty( $p['t'] ) || (int) $p['t'] < 3000 ) {
		return $erro( 'Não foi possível enviar. Aguarde alguns segundos e tente de novo.' );
	}

	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$chave = 'fachini_pedidos_' . md5( $ip );
	$vezes = (int) get_transient( $chave );
	if ( $vezes >= FACHINI_PEDIDOS_POR_HORA ) {
		return $erro( 'Recebemos vários pedidos seguidos deste endereço. Tente de novo mais tarde ou fale conosco pelo WhatsApp.', array(), 429 );
	}

	list( $d, $erros ) = fachini_pedido_validar( $p );
	if ( $erros ) {
		return $erro( 'Confira os campos destacados.', $erros );
	}

	$id = wp_insert_post(
		array(
			'post_type'   => FACHINI_PEDIDO_TIPO,
			'post_status' => 'private',
			'post_title'  => $d['nome'],
		),
		true
	);
	if ( is_wp_error( $id ) || ! $id ) {
		return $erro( 'Não foi possível registrar o pedido agora. Tente de novo em instantes ou fale conosco pelo WhatsApp.', array(), 500 );
	}
	set_transient( $chave, $vezes + 1, HOUR_IN_SECONDS );

	$protocolo = fachini_pedido_protocolo( $id );
	wp_update_post(
		array(
			'ID'         => $id,
			'post_title' => '#' . $protocolo . ' · ' . $d['nome'],
		)
	);

	// Registro do consentimento, item 3.3 da Política de Privacidade.
	$textos = fachini_textos_consentimento();
	$pagina = isset( $p['pagina'] ) && is_scalar( $p['pagina'] ) ? esc_url_raw( mb_substr( (string) $p['pagina'], 0, 500 ) ) : '';
	$origem = isset( $p['referencia'] ) && is_scalar( $p['referencia'] ) ? esc_url_raw( mb_substr( (string) $p['referencia'], 0, 500 ) ) : '';

	update_post_meta( $id, 'fachini_pedido_protocolo', $protocolo );
	update_post_meta( $id, 'fachini_pedido_dados', $d );
	update_post_meta(
		$id,
		'fachini_pedido_consentimento',
		array(
			'data_hora'         => current_time( 'c' ),
			'ip'                => $ip,
			'pagina'            => $pagina,
			'pagina_anterior'   => $origem,
			'versao'            => FACHINI_CONSENTIMENTO_VERSAO,
			'texto_contato'     => $textos['contato'],
			'texto_marketing'   => $textos['marketing'],
			'marcou_contato'    => $d['aceite_contato'],
			'marcou_marketing'  => $d['aceite_marketing'],
		)
	);

	$email = fachini_pedido_enviar_email( $id, $d, $protocolo );
	update_post_meta( $id, 'fachini_pedido_email', null === $email ? 'sem e-mail configurado' : ( $email ? 'enviado' : 'falhou' ) );

	return new WP_REST_Response(
		array(
			'ok'      => true,
			'destino' => add_query_arg(
				array(
					'pedido' => $id,
					'chave'  => fachini_pedido_chave( $id ),
				),
				fachini_confirmacao_url()
			),
		),
		200
	);
}

function fachini_pedidos_rota() {
	register_rest_route(
		'fachini/v1',
		'/pedido',
		array(
			'methods'             => 'POST',
			'callback'            => 'fachini_pedido_receber',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'fachini_pedidos_rota' );

/**
 * Pedido aberto pela página de confirmação, se o endereço trouxer a chave
 * certa e o pedido for recente (até dois dias).
 */
function fachini_pedido_da_url() {
	$id    = isset( $_GET['pedido'] ) ? absint( $_GET['pedido'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$chave = isset( $_GET['chave'] ) ? sanitize_text_field( wp_unslash( $_GET['chave'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( ! $id || '' === $chave || ! hash_equals( fachini_pedido_chave( $id ), $chave ) ) {
		return null;
	}
	$post = get_post( $id );
	if ( ! $post || FACHINI_PEDIDO_TIPO !== $post->post_type ) {
		return null;
	}
	if ( time() - (int) get_post_time( 'U', true, $post ) > 2 * DAY_IN_SECONDS ) {
		return null;
	}
	return $post;
}

/* ---------------------------------------------------------------------------
   Painel: lista, tela do pedido e configurações.
   ------------------------------------------------------------------------ */

/**
 * Todo pedido é privado; sem isto o painel escreveria "Privado:" antes de
 * cada um e "— Privado" depois.
 */
function fachini_pedido_titulo_sem_prefixo( $formato, $post ) {
	return ( $post && FACHINI_PEDIDO_TIPO === get_post_type( $post ) ) ? '%s' : $formato;
}
add_filter( 'private_title_format', 'fachini_pedido_titulo_sem_prefixo', 10, 2 );

function fachini_pedido_sem_estado( $estados, $post ) {
	if ( FACHINI_PEDIDO_TIPO === get_post_type( $post ) ) {
		unset( $estados['private'] );
	}
	return $estados;
}
add_filter( 'display_post_states', 'fachini_pedido_sem_estado', 10, 2 );

function fachini_pedidos_colunas( $colunas ) {
	return array(
		'cb'                => $colunas['cb'],
		'title'             => 'Pedido',
		'fachini_contato'   => 'Contato',
		'fachini_interesse' => 'Interesse',
		'fachini_marketing' => 'Marketing',
		'fachini_email'     => 'E-mail',
		'date'              => 'Recebido em',
	);
}
add_filter( 'manage_' . FACHINI_PEDIDO_TIPO . '_posts_columns', 'fachini_pedidos_colunas' );

function fachini_pedidos_coluna( $coluna, $id ) {
	$d = get_post_meta( $id, 'fachini_pedido_dados', true );
	if ( ! is_array( $d ) ) {
		return;
	}
	switch ( $coluna ) {
		case 'fachini_contato':
			echo esc_html( $d['email'] ) . '<br>' . esc_html( $d['whatsapp'] );
			if ( 'pj' === $d['tipo'] && '' !== $d['empresa'] ) {
				echo '<br>' . esc_html( $d['empresa'] );
			}
			break;
		case 'fachini_interesse':
			echo esc_html( $d['categoria_nome'] ) . '<br>' . esc_html( $d['modelo_nome'] );
			break;
		case 'fachini_marketing':
			echo $d['aceite_marketing'] ? 'Sim' : 'Não';
			break;
		case 'fachini_email':
			echo esc_html( (string) get_post_meta( $id, 'fachini_pedido_email', true ) );
			break;
	}
}
add_action( 'manage_' . FACHINI_PEDIDO_TIPO . '_posts_custom_column', 'fachini_pedidos_coluna', 10, 2 );

function fachini_pedido_caixas() {
	add_meta_box( 'fachini_pedido_dados', 'Dados do pedido', 'fachini_pedido_caixa_dados', null, 'normal', 'high' );
	add_meta_box( 'fachini_pedido_consentimento', 'Registro do consentimento (LGPD)', 'fachini_pedido_caixa_consentimento', null, 'normal', 'default' );
	remove_meta_box( 'slugdiv', FACHINI_PEDIDO_TIPO, 'normal' );
}
add_action( 'add_meta_boxes_' . FACHINI_PEDIDO_TIPO, 'fachini_pedido_caixas' );

/**
 * Pedido recebido não se edita: sem "Edição rápida" na lista.
 */
function fachini_pedido_acoes( $acoes, $post ) {
	if ( FACHINI_PEDIDO_TIPO === $post->post_type ) {
		unset( $acoes['inline hide-if-no-js'] );
	}
	return $acoes;
}
add_filter( 'post_row_actions', 'fachini_pedido_acoes', 10, 2 );

function fachini_pedido_tabela( $linhas ) {
	echo '<table class="widefat striped"><tbody>';
	foreach ( $linhas as $rotulo => $valor ) {
		echo '<tr><th scope="row" style="width:30%">' . esc_html( $rotulo ) . '</th><td>' . nl2br( esc_html( (string) $valor ) ) . '</td></tr>';
	}
	echo '</tbody></table>';
}

function fachini_pedido_caixa_dados( $post ) {
	$d = get_post_meta( $post->ID, 'fachini_pedido_dados', true );
	if ( ! is_array( $d ) ) {
		return;
	}
	fachini_pedido_tabela(
		array( 'Protocolo' => '#' . get_post_meta( $post->ID, 'fachini_pedido_protocolo', true ) )
		+ fachini_pedido_linhas( $d )
		+ array( 'E-mail do pedido' => get_post_meta( $post->ID, 'fachini_pedido_email', true ) )
	);
}

function fachini_pedido_caixa_consentimento( $post ) {
	$c = get_post_meta( $post->ID, 'fachini_pedido_consentimento', true );
	if ( ! is_array( $c ) ) {
		return;
	}
	fachini_pedido_tabela(
		array(
			'Data e hora'                    => $c['data_hora'],
			'Endereço IP'                    => $c['ip'],
			'Página do envio'                => $c['pagina'],
			'Página anterior'                => $c['pagina_anterior'],
			'Versão dos textos'              => $c['versao'],
			'Autorização de contato (texto)' => $c['texto_contato'],
			'Marcou a autorização de contato' => $c['marcou_contato'] ? 'Sim' : 'Não',
			'Marketing (texto)'              => $c['texto_marketing'],
			'Marcou marketing'               => $c['marcou_marketing'] ? 'Sim' : 'Não',
		)
	);
}

function fachini_pedidos_menu() {
	add_submenu_page(
		'edit.php?post_type=' . FACHINI_PEDIDO_TIPO,
		'Configurações dos pedidos',
		'Configurações',
		'manage_options',
		'fachini-pedidos-config',
		'fachini_pedidos_config_tela'
	);
}
add_action( 'admin_menu', 'fachini_pedidos_menu' );

function fachini_pedidos_limpar_emails( $valor ) {
	$lista = array_filter( array_map( 'sanitize_email', array_map( 'trim', explode( ',', (string) $valor ) ) ), 'is_email' );
	return implode( ', ', $lista );
}

function fachini_pedidos_limpar_whatsapp( $valor ) {
	return preg_replace( '/\D/', '', (string) $valor );
}

function fachini_pedidos_ajustes() {
	register_setting( 'fachini_pedidos', 'fachini_pedidos_emails', array( 'type' => 'string', 'sanitize_callback' => 'fachini_pedidos_limpar_emails', 'default' => '' ) );
	register_setting( 'fachini_pedidos', 'fachini_whatsapp', array( 'type' => 'string', 'sanitize_callback' => 'fachini_pedidos_limpar_whatsapp', 'default' => FACHINI_WHATSAPP_PADRAO ) );
}
add_action( 'admin_init', 'fachini_pedidos_ajustes' );

function fachini_pedidos_config_tela() {
	?>
	<div class="wrap">
		<h1>Configurações dos pedidos de orçamento</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'fachini_pedidos' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="fachini_pedidos_emails">E-mails que recebem os pedidos</label></th>
					<td>
						<input name="fachini_pedidos_emails" id="fachini_pedidos_emails" type="text" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'fachini_pedidos_emails', '' ) ); ?>">
						<p class="description">Separe por vírgula. Em branco, os pedidos ficam só aqui no painel.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fachini_whatsapp">WhatsApp do atendimento</label></th>
					<td>
						<input name="fachini_whatsapp" id="fachini_whatsapp" type="text" class="regular-text" value="<?php echo esc_attr( fachini_whatsapp_numero() ); ?>">
						<p class="description">Só números, com país e DDD (ex.: 554533281313). Depois do envio, a página de confirmação leva a pessoa para este WhatsApp. Em branco, ela vê só a confirmação.</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
