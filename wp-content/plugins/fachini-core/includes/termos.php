<?php
/**
 * Página Termos de uso, no mesmo desenho da Política de Privacidade.
 *
 * [fachini_termos] monta o caminho, o título, a barra das seções e o texto.
 * O texto é o do site anterior (fachinimaquinas.com.br/site/tdu/uso), que a
 * Fachini pediu para manter (27/10/2026). Mudanças só de formatação: espaços
 * invisíveis e o espaço antes de vírgula. Fica no código pelo mesmo motivo da
 * política: cada mudança fica registrada no Git.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fachini_termos_abas() {
	return array(
		'termos'         => 'Termos',
		'uso-de-licenca' => 'Uso de licença',
		'isencao'        => 'Isenção',
		'limitacoes'     => 'Limitações',
		'precisao'       => 'Precisão',
		'links'          => 'Links',
		'modificacoes'   => 'Modificações',
		'lei-aplicavel'  => 'Lei aplicável',
	);
}

function fachini_termos_texto() {
	$html = fachini_politica_secao(
		'termos',
		'1. Termos',
		fachini_politica_p( 'Ao acessar ao site Fachini Máquinas, concorda em cumprir estes termos de serviço, todas as leis e regulamentos aplicáveis e concorda que é responsável pelo cumprimento de todas as leis locais aplicáveis. Se você não concordar com algum desses termos, está proibido de usar ou acessar este site. Os materiais contidos neste site são protegidos pelas leis de direitos autorais e marcas comerciais aplicáveis.' )
	);

	$html .= fachini_politica_secao(
		'uso-de-licenca',
		'2. Uso de Licença',
		fachini_politica_p( 'É concedida permissão para baixar temporariamente uma cópia dos materiais (informações ou software) no site Fachini Máquinas, apenas para visualização transitória pessoal e não comercial. Esta é a concessão de uma licença, não uma transferência de título e, sob esta licença, você não pode:' )
		. fachini_politica_lista(
			array(
				'modificar ou copiar os materiais;',
				'usar os materiais para qualquer finalidade comercial ou para exibição pública (comercial ou não comercial);',
				'tentar descompilar ou fazer engenharia reversa de qualquer software contido no site Fachini Máquinas;',
				'remover quaisquer direitos autorais ou outras notações de propriedade dos materiais; ou',
				"transferir os materiais para outra pessoa ou 'espelhe' os materiais em qualquer outro servidor.",
			)
		)
		. fachini_politica_p( 'Esta licença será automaticamente rescindida se você violar alguma dessas restrições e poderá ser rescindida por Fachini Máquinas a qualquer momento. Ao encerrar a visualização desses materiais ou após o término desta licença, você deve apagar todos os materiais baixados em sua posse, seja em formato eletrónico ou impresso.' )
	);

	$html .= fachini_politica_secao(
		'isencao',
		'3. Isenção de responsabilidade',
		fachini_politica_p( "Os materiais no site da Fachini Máquinas são fornecidos 'como estão'. Fachini Máquinas não oferece garantias, expressas ou implícitas, e, por este meio, isenta e nega todas as outras garantias, incluindo, sem limitação, garantias implícitas ou condições de comercialização, adequação a um fim específico ou não violação de propriedade intelectual ou outra violação de direitos." )
		. fachini_politica_p( 'Além disso, o Fachini Máquinas não garante ou faz qualquer representação relativa à precisão, aos resultados prováveis ou à confiabilidade do uso dos materiais em seu site ou de outra forma relacionado a esses materiais ou em sites vinculados a este site.' )
	);

	$html .= fachini_politica_secao(
		'limitacoes',
		'4. Limitações',
		fachini_politica_p( 'Em nenhum caso o Fachini Máquinas ou seus fornecedores serão responsáveis por quaisquer danos (incluindo, sem limitação, danos por perda de dados ou lucro ou devido a interrupção dos negócios) decorrentes do uso ou da incapacidade de usar os materiais em Fachini Máquinas, mesmo que Fachini Máquinas ou um representante autorizado da Fachini Máquinas tenha sido notificado oralmente ou por escrito da possibilidade de tais danos. Como algumas jurisdições não permitem limitações em garantias implícitas, ou limitações de responsabilidade por danos conseqüentes ou incidentais, essas limitações podem não se aplicar a você.' )
	);

	$html .= fachini_politica_secao(
		'precisao',
		'5. Precisão dos materiais',
		fachini_politica_p( 'Os materiais exibidos no site da Fachini Máquinas podem incluir erros técnicos, tipográficos ou fotográficos. Fachini Máquinas não garante que qualquer material em seu site seja preciso, completo ou atual. Fachini Máquinas pode fazer alterações nos materiais contidos em seu site a qualquer momento, sem aviso prévio. No entanto, Fachini Máquinas não se compromete a atualizar os materiais.' )
	);

	$html .= fachini_politica_secao(
		'links',
		'6. Links',
		fachini_politica_p( 'O Fachini Máquinas não analisou todos os sites vinculados ao seu site e não é responsável pelo conteúdo de nenhum site vinculado. A inclusão de qualquer link não implica endosso por Fachini Máquinas do site. O uso de qualquer site vinculado é por conta e risco do usuário.' )
	);

	$html .= fachini_politica_secao(
		'modificacoes',
		'Modificações',
		fachini_politica_p( 'O Fachini Máquinas pode revisar estes termos de serviço do site a qualquer momento, sem aviso prévio. Ao usar este site, você concorda em ficar vinculado à versão atual desses termos de serviço.' )
	);

	$html .= fachini_politica_secao(
		'lei-aplicavel',
		'Lei aplicável',
		fachini_politica_p( 'Estes termos e condições são regidos e interpretados de acordo com as leis do Fachini Máquinas e você se submete irrevogavelmente à jurisdição exclusiva dos tribunais naquele estado ou localidade.' )
	);

	return $html;
}

function fachini_sc_termos() {
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
	foreach ( fachini_termos_abas() as $ancora => $rotulo ) {
		$abas    .= '<li><a class="fachini-cat-nav__item' . ( $primeira ? ' is-ativo' : '' ) . '" href="#' . esc_attr( $ancora ) . '">' . esc_html( $rotulo ) . '</a></li>';
		$primeira = false;
	}

	return '<div class="fachini-politica fachini-termos">'
		. '<div class="fachini-politica__topo">' . fachini_sc_breadcrumb() . '<h1 class="fachini-politica__h1">' . esc_html( get_the_title() ) . '</h1></div>'
		. '<nav class="fachini-cat-nav fachini-politica-abas" aria-label="Seções dos termos de uso"><ul class="fachini-cat-nav__lista">' . $abas . '</ul></nav>'
		. '<div class="fachini-politica__texto">' . fachini_termos_texto() . '</div>'
		. '</div>';
}
add_shortcode( 'fachini_termos', 'fachini_sc_termos' );
