<?php
/**
 * Página Política de Privacidade, igual ao Figma ("AVISO- 1366").
 *
 * [fachini_politica] monta o caminho, o título, a barra das seções e o texto.
 * O texto é o aprovado pelo jurídico da Fachini (arquivo recebido em
 * 13/10/2026), copiado sem mudanças de palavra. Fica aqui, e não no editor da
 * página, para cada mudança ficar registrada no Git, junto com a versão.
 * Do layout vêm só a apresentação: títulos sem número, a primeira seção
 * ("Quem somos") sem título, tabelas e listas.
 *
 * O único trecho trocado é o marcador [[LINK/BOTÃO DE PREFERÊNCIAS DE
 * COOKIES]], que o próprio documento pede para virar o link que reabre as
 * preferências de cookies (includes/consentimento.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Seções que aparecem na barra, com o nome curto. As outras seções ficam
 * marcadas pela anterior na barra.
 */
function fachini_politica_abas() {
	return array(
		'dados-coletados'   => 'Dados coletados',
		'base-legal'        => 'Base legal',
		'contato-comercial' => 'Contato comercial',
		'cookies'           => 'Cookies',
		'compartilhamento'  => 'Compartilhamento',
		'seus-direitos'     => 'Seus direitos',
	);
}

/**
 * Tabela com a primeira linha de cabeçalho.
 *
 * @param string[]   $cabecalho Títulos das colunas.
 * @param string[][] $linhas    Linhas, já em HTML seguro.
 */
function fachini_politica_tabela( $cabecalho, $linhas ) {
	$html = '<div class="fachini-politica__tabela"><table><thead><tr>';
	foreach ( $cabecalho as $titulo ) {
		$html .= '<th scope="col">' . esc_html( $titulo ) . '</th>';
	}
	$html .= '</tr></thead><tbody>';
	foreach ( $linhas as $linha ) {
		$html .= '<tr>';
		// No celular cada linha vira um bloco, e a célula mostra o nome da coluna.
		foreach ( $linha as $i => $celula ) {
			$html .= '<td data-rotulo="' . esc_attr( $cabecalho[ $i ] ) . '">' . esc_html( $celula ) . '</td>';
		}
		$html .= '</tr>';
	}
	return $html . '</tbody></table></div>';
}

function fachini_politica_lista( $itens ) {
	return '<ul><li>' . implode( '</li><li>', array_map( 'esc_html', $itens ) ) . '</li></ul>';
}

function fachini_politica_email( $endereco ) {
	return '<a href="mailto:' . esc_attr( $endereco ) . '">' . esc_html( $endereco ) . '</a>';
}

/**
 * Uma seção: linha em cima, título e conteúdo.
 */
function fachini_politica_secao( $id, $titulo, $conteudo ) {
	return '<section class="fachini-politica__secao" id="' . esc_attr( $id ) . '">'
		. ( '' !== $titulo ? '<h2 class="fachini-politica__titulo">' . esc_html( $titulo ) . '</h2>' : '' )
		. $conteudo
		. '</section>';
}

function fachini_politica_subtitulo( $texto ) {
	return '<h3 class="fachini-politica__subtitulo">' . esc_html( $texto ) . '</h3>';
}

function fachini_politica_p( $texto ) {
	return '<p>' . esc_html( $texto ) . '</p>';
}

/**
 * O texto aprovado, seção por seção.
 */
function fachini_politica_texto() {
	$dpo       = 'protecaodedados@fachinimaquinas.com.br';
	$marketing = 'marketing@fachinimaquinas.com.br';
	$cookies   = '<a href="#preferencias-cookies" data-fachini-cookies>Preferências de cookies</a>';

	$html = '<p class="fachini-politica__vigencia">Vigente desde: 31 de Agosto de 2026<br>Última atualização: 31/08/2026</p>';

	// 1. Quem somos (no layout, sem título).
	$html .= fachini_politica_secao(
		'quem-somos',
		'',
		fachini_politica_p( 'Esta política explica como a FACHINI MAQUINAS LTDA, CNPJ 04.152.592/0001-18, com sede na R. Beliamino Julio Miotto, 493, CITVEL 1, Cascavel/PR - 85.818-576 - coleta, usa, compartilha e protege dados pessoais no site fachinimaquinas.com.br nos canais e plataformas utilizadas pelo time de atendimento comercial e marketing ligados a ele.' )
		. fachini_politica_p( 'Para os fins da Lei nº 13.709/2018 (LGPD), a Fachini Máquinas atua como controladora dos dados tratados neste site.' )
		. '<p>Encarregado pelo Tratamento de Dados Pessoais (DPO): Paulo Jr Nascimento – Dep. de Marketing Fachini Maquinas – e-mail: ' . fachini_politica_email( $dpo ) . '</p>'
	);

	$html .= fachini_politica_secao(
		'resumo',
		'Resumo em linguagem direta',
		fachini_politica_p( 'Se você preencher um formulário no nosso site, acontece o seguinte:' )
		. fachini_politica_lista(
			array(
				'Guardamos o que você escreveu e a data, a hora e a origem do envio.',
				'Um vendedor da Fachini entra em contato por WhatsApp, telefone ou e-mail, usando os dados que você informou, para responder ao que você pediu.',
				'Só enviamos conteúdo promocional (novidades, campanhas, materiais) se você tiver marcado a caixa específica para isso. São autorizações separadas.',
				'Você pode pedir para parar a qualquer momento, em qualquer canal, e nós paramos — inclusive respondendo SAIR em uma mensagem de WhatsApp.',
				'Não vendemos, alugamos nem cedemos sua lista de contato para terceiros.',
			)
		)
		. fachini_politica_p( 'O restante deste documento detalha cada um desses pontos.' )
	);

	$html .= fachini_politica_secao(
		'dados-coletados',
		'Quais dados coletamos',
		fachini_politica_subtitulo( 'Dados que você nos fornece' )
		. fachini_politica_p( 'Coletados quando você preenche um formulário, solicita orçamento, baixa um material ou nos escreve:' )
		. fachini_politica_tabela(
			array( 'Dado', 'Obrigatório', 'Para quê' ),
			array(
				array( 'Nome completo', 'Sim', 'Identificar e personalizar o atendimento' ),
				array( 'E-mail', 'Sim', 'Responder à solicitação e enviar orçamento, documentos e registrar atendimento no sistema' ),
				array( 'Telefone/WhatsApp', 'Sim', 'Contato comercial pelo canal que você autorizou' ),
				array( 'CNPJ', 'Sim', 'Identificar a empresa e registrar atendimento no sistema' ),
				array( 'Empresa e cargo', 'Não', 'Qualificar o atendimento técnico' ),
				array( 'Cidade/estado', 'Não', 'Direcionar para a unidade Fachini mais próxima' ),
				array( 'Segmento de atuação', 'Não', 'Indicar a máquina adequada à sua aplicação' ),
				array( 'Mensagem livre', 'Não', 'Entender sua necessidade' ),
			)
		)
		. fachini_politica_p( 'Não pedimos e não queremos receber dados pessoais sensíveis (art. 5º, II da LGPD), como origem racial, convicção religiosa, opinião política, dado de saúde ou biometria. Não inclua esse tipo de informação no campo de mensagem livre.' )
		. fachini_politica_subtitulo( 'Dados coletados automaticamente' )
		. fachini_politica_p( 'Quando você navega no site, coletamos:' )
		. fachini_politica_lista(
			array(
				'endereço IP e informações do dispositivo/navegador;',
				'páginas visitadas, tempo de permanência e caminho de navegação;',
				'origem do acesso (buscador, anúncio, link direto) e parâmetros de campanha (UTMs);',
				'identificadores de cookies, conforme sua escolha no banner de consentimento.',
			)
		)
		. fachini_politica_subtitulo( 'Registro do consentimento' )
		. fachini_politica_p( 'Junto de cada formulário enviado, gravamos: data e hora, endereço IP, página de origem, texto exato das autorizações exibidas e quais caixas você marcou. Fazemos isso porque a LGPD atribui à empresa o ônus de provar que o consentimento foi obtido (art. 8º, § 2º) — e porque não queremos contatar ninguém que não tenha pedido.' )
		. fachini_politica_subtitulo( 'Dados das conversas de atendimento' )
		. fachini_politica_p( 'Registramos o histórico de atendimento (mensagens de WhatsApp, e-mails e o registro das ligações) para dar continuidade ao seu atendimento, manter o histórico comercial e comprovar o que foi combinado.' )
	);

	$html .= fachini_politica_secao(
		'base-legal',
		'Por que tratamos seus dados e com qual base legal',
		fachini_politica_tabela(
			array( 'Finalidade', 'Base legal (LGPD)' ),
			array(
				array( 'Responder à sua solicitação, elaborar e enviar orçamento', 'Procedimentos preliminares relacionados a contrato, a pedido do titular (art. 7º, V) e consentimento (art. 7º, I)' ),
				array( 'Contato comercial ativo por WhatsApp, telefone e e-mail sobre o que você solicitou', 'Consentimento (art. 7º, I)' ),
				array( 'Envio de conteúdos, novidades, campanhas e ofertas', 'Consentimento específico e separado (art. 7º, I)' ),
				array( 'Prova de que o consentimento foi obtido', 'Cumprimento de obrigação legal e exercício regular de direitos (art. 7º, II e VI)' ),
				array( 'Segurança do site, prevenção a fraude, spam e abuso de formulário', 'Legítimo interesse (art. 7º, IX)' ),
				array( 'Métricas de audiência e melhoria do site', 'Consentimento no banner de cookies (art. 7º, I)' ),
				array( 'Cumprimento de obrigações fiscais, contábeis e regulatórias', 'Obrigação legal (art. 7º, II)' ),
				array( 'Defesa em processo judicial, administrativo ou arbitral', 'Art. 7º, VI' ),
			)
		)
		. fachini_politica_p( 'Quando a base legal for consentimento, você pode revogá-lo a qualquer momento, sem custo e sem justificativa. A revogação não invalida o tratamento feito antes dela.' )
	);

	$html .= fachini_politica_secao(
		'contato-comercial',
		'Contato comercial: WhatsApp, telefone e e-mail',
		fachini_politica_p( 'Esta seção descreve exatamente o que acontece depois que você envia um formulário.' )
		. fachini_politica_subtitulo( 'O que você autoriza' )
		. fachini_politica_p( 'Ao marcar a caixa de autorização obrigatória do formulário, você concorda em receber, nos dados de contato que você mesmo informou:' )
		. fachini_politica_lista(
			array(
				'mensagens e chamadas de voz pelo WhatsApp, enviadas pela Fachini Máquinas;',
				'ligações telefônicas de um vendedor da Fachini;',
				'e-mails com orçamento, documentação técnica e condições comerciais.',
			)
		)
		. fachini_politica_p( 'Esse contato tem como finalidade responder à sua solicitação e apresentar produtos, serviços e condições comerciais da Fachini Máquinas.' )
		. fachini_politica_subtitulo( 'Quem vai falar com você' )
		. fachini_politica_p( 'O contato é feito pela Fachini Máquinas, a partir de:' )
		. '<ul><li>WhatsApp: +55 45 3328-1313, identificado como Fachini Máquinas;</li><li>telefone: +55 45 3328-1313;</li><li>e-mail: ' . fachini_politica_email( $dpo ) . '</li></ul>'
		. '<p>A primeira mensagem sempre identifica a empresa e cita o que você solicitou. Se você receber uma abordagem em nome da Fachini que não siga esse padrão, avise em ' . fachini_politica_email( $dpo ) . '</p>'
		. fachini_politica_subtitulo( 'Marketing é uma autorização separada' )
		. fachini_politica_p( 'Mensagens promocionais — novidades, campanhas, materiais, convites para eventos — só são enviadas se você marcar a caixa opcional de comunicações de marketing. Não marcar essa caixa não impede que seu orçamento seja respondido.' )
		. fachini_politica_subtitulo( 'Como parar de receber contato' )
		. fachini_politica_p( 'Você pode encerrar o contato a qualquer momento, por qualquer destes caminhos:' )
		. '<ul><li>responder SAIR ou PARAR em qualquer mensagem de WhatsApp;</li><li>clicar em descadastrar no rodapé de qualquer e-mail;</li><li>dizer ao vendedor, durante a ligação ou a conversa, que não quer mais ser contatado;</li><li>escrever para ' . fachini_politica_email( $marketing ) . '.</li></ul>'
		. fachini_politica_p( 'O pedido é registrado em uma lista de bloqueio que vale para todos os canais — WhatsApp, telefone e e-mail — e é cumprido em até 72 horas. Bloquear nosso número no WhatsApp também é entendido por nós como pedido de encerramento de contato.' )
		. fachini_politica_subtitulo( 'Sobre o WhatsApp' )
		. fachini_politica_p( 'O WhatsApp é um serviço da Meta Platforms, Inc. Quando você conversa conosco por lá, o tratamento dos dados dentro do aplicativo também é regido pelas políticas do WhatsApp e da Meta, sobre as quais a Fachini não tem controle. Recomendamos a leitura da política de privacidade do WhatsApp.' )
		. fachini_politica_p( 'A Fachini Máquinas segue a Política de Mensagens Comerciais do WhatsApp: só contatamos quem forneceu o número e autorizou o contato, respeitamos todos os pedidos de bloqueio ou descadastro e não enviamos mensagens em massa para listas compradas ou obtidas de terceiros.' )
	);

	$html .= fachini_politica_secao(
		'cookies',
		'Cookies e tecnologias semelhantes',
		'<p>O site usa cookies para funcionar, medir audiência e, quando autorizado, mensurar campanhas. O banner de consentimento permite aceitar ou recusar as categorias não essenciais, e a escolha pode ser revista a qualquer momento pelo link ' . $cookies . '.</p>'
		. fachini_politica_tabela(
			array( 'Categoria', 'Função', 'Precisa de consentimento?' ),
			array(
				array( 'Essenciais', 'Segurança, sessão, funcionamento do formulário', 'Não' ),
				array( 'Desempenho e análise', 'Medir uso e melhorar o site', 'Sim' ),
				array( 'Marketing e remarketing', 'Mensurar campanhas e exibir anúncios', 'Sim' ),
			)
		)
		. fachini_politica_p( 'Ferramentas em uso: Ferramentas de Automação e CRM do RD Station, RankMath, Google Analytics, Google Tag Manager e Meta Pixel.' )
	);

	$html .= fachini_politica_secao(
		'compartilhamento',
		'Com quem compartilhamos',
		fachini_politica_p( 'Não vendemos, alugamos nem cedemos dados pessoais. Compartilhamos apenas o necessário, com:' )
		. fachini_politica_tabela(
			array( 'Quem', 'Para quê' ),
			array(
				array( 'Plataforma de automação/CRM — RD Station', 'Armazenar o lead e gerenciar o atendimento' ),
				array( 'Provedor de hospedagem e infraestrutura', 'Manter o site no ar' ),
				array( 'Provedor de envio de e-mail', 'Entregar mensagens transacionais e de marketing' ),
				array( 'Meta Platforms (WhatsApp)', 'Viabilizar a conversa no aplicativo' ),
				array( 'Google', 'Métricas de audiência e campanhas, conforme seu consentimento' ),
				array( 'Contabilidade, advogados e auditoria', 'Cumprir obrigações legais e defender direitos' ),
				array( 'Autoridades públicas', 'Quando houver requisição legal ou ordem judicial' ),
			)
		)
		. fachini_politica_p( 'Fornecedores atuam como operadores, sob contrato e instrução da Fachini, e não podem usar os dados para finalidades próprias.' )
	);

	$html .= fachini_politica_secao(
		'transferencia-internacional',
		'Transferência internacional',
		fachini_politica_p( 'Parte dos fornecedores acima processa dados fora do Brasil (por exemplo, servidores nos Estados Unidos). Nesses casos, a transferência ocorre nos termos dos arts. 33 a 36 da LGPD, com cláusulas contratuais e garantias de proteção equivalentes às exigidas pela lei brasileira.' )
	);

	$html .= fachini_politica_secao(
		'prazos',
		'Por quanto tempo guardamos',
		fachini_politica_tabela(
			array( 'Dado', 'Prazo' ),
			array(
				array( 'Lead que não virou cliente', '24 meses a partir do último contato' ),
				array( 'Cliente', 'Durante a relação comercial e pelo prazo legal seguinte' ),
				array( 'Registro de consentimento e de opt-out', '05 anos após a revogação, como prova' ),
				array( 'Documentos fiscais e contábeis', 'Prazo exigido pela legislação' ),
				array( 'Logs de acesso à aplicação', '6 meses (art. 15 do Marco Civil da Internet)' ),
			)
		)
		. fachini_politica_p( 'Encerrado o prazo, os dados são eliminados ou anonimizados. O registro de quem pediu para não ser contatado é mantido justamente para não voltar a ser contatado.' )
	);

	$html .= fachini_politica_secao(
		'como-protegemos',
		'Como protegemos',
		fachini_politica_p( 'Adotamos medidas técnicas e administrativas compatíveis com o art. 46 da LGPD: conexão criptografada (HTTPS), controle de acesso por perfil, autenticação reforçada nas contas administrativas, proteção contra automação abusiva nos formulários, backups e registro de acessos.' )
		. fachini_politica_p( 'Nenhum sistema é infalível. Se identificarmos incidente de segurança com risco relevante aos titulares, comunicaremos a ANPD e os titulares afetados, nos termos do art. 48 da LGPD.' )
	);

	$html .= fachini_politica_secao(
		'seus-direitos',
		'Seus direitos',
		fachini_politica_p( 'Nos termos do art. 18 da LGPD, você pode solicitar:' )
		. fachini_politica_lista(
			array(
				'confirmação da existência de tratamento;',
				'acesso aos seus dados;',
				'correção de dados incompletos, inexatos ou desatualizados;',
				'anonimização, bloqueio ou eliminação de dados desnecessários, excessivos ou tratados em desconformidade com a lei;',
				'portabilidade a outro fornecedor;',
				'eliminação dos dados tratados com base no consentimento;',
				'informação sobre com quem compartilhamos seus dados;',
				'informação sobre a possibilidade de não consentir e as consequências disso;',
				'revogação do consentimento;',
				'oposição a tratamento feito com base em legítimo interesse;',
				'revisão de decisões automatizadas que afetem seus interesses.',
			)
		)
		. '<p>Como exercer: escreva para ' . fachini_politica_email( $dpo ) . ' com o assunto "LGPD — direitos do titular". Respondemos em até 10 dias úteis. Podemos pedir informações adicionais para confirmar sua identidade antes de atender ao pedido — é uma proteção para você.</p>'
		. fachini_politica_p( 'Você também pode peticionar à Autoridade Nacional de Proteção de Dados (ANPD).' )
	);

	$html .= fachini_politica_secao(
		'criancas-e-adolescentes',
		'Crianças e adolescentes',
		fachini_politica_p( 'O site e os produtos da Fachini Máquinas são destinados a profissionais e empresas. Não direcionamos comunicação a menores de 18 anos nem coletamos intencionalmente seus dados. Se identificarmos coleta indevida, os dados serão eliminados.' )
	);

	$html .= fachini_politica_secao(
		'alteracoes',
		'Alterações desta política',
		fachini_politica_p( 'Podemos atualizar esta política. Alterações relevantes serão informadas no site e, quando a mudança afetar a base de consentimento, solicitaremos nova autorização. O histórico fica registrado abaixo.' )
		. fachini_politica_tabela(
			array( 'Versão', 'Data', 'O que mudou' ),
			array(
				array( '1.0', '31/08/2026', 'Publicação inicial' ),
			)
		)
	);

	$html .= fachini_politica_secao(
		'contato',
		'Contato',
		'<p>FACHINI MAQUINAS LTDA - CNPJ 04.152.592/0001-18, Encarregado (DPO): Paulo Jr Nascimento — ' . fachini_politica_email( $dpo ) . '</p>'
		. fachini_politica_p( 'Esta política é regida pela legislação brasileira, em especial a Lei nº 13.709/2018 (LGPD), a Lei nº 12.965/2014 (Marco Civil da Internet) e a Lei nº 8.078/1990 (Código de Defesa do Consumidor).' )
	);

	return $html;
}

/**
 * A página inteira.
 */
function fachini_sc_politica() {
	wp_enqueue_script(
		'fachini-politica',
		plugins_url( 'assets/politica.js', FACHINI_CORE_PATH . 'fachini-core.php' ),
		array(),
		FACHINI_CORE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	$abas     = '';
	$primeira = true;
	foreach ( fachini_politica_abas() as $ancora => $rotulo ) {
		$abas    .= '<li><a class="fachini-cat-nav__item' . ( $primeira ? ' is-ativo' : '' ) . '" href="#' . esc_attr( $ancora ) . '">' . esc_html( $rotulo ) . '</a></li>';
		$primeira = false;
	}

	return '<div class="fachini-politica">'
		. '<div class="fachini-politica__topo">' . fachini_sc_breadcrumb() . '<h1 class="fachini-politica__h1">' . esc_html( get_the_title() ) . '</h1></div>'
		. '<nav class="fachini-cat-nav fachini-politica-abas" aria-label="Seções da política"><ul class="fachini-cat-nav__lista">' . $abas . '</ul></nav>'
		. '<div class="fachini-politica__texto">' . fachini_politica_texto() . '</div>'
		. '</div>';
}
add_shortcode( 'fachini_politica', 'fachini_sc_politica' );
