<?php
/**
 * Campos das máquinas (ACF), registrados em código.
 *
 * Por que em código e não pelo painel: assim os campos nascem junto com o
 * plugin, entram no Git e podem ser recriados em qualquer ambiente. Se o ACF
 * for desativado um dia, os dados continuam salvos no banco; some apenas a
 * tela de edição.
 *
 * LIMITAÇÃO CONHECIDA (versão gratuita do ACF):
 * os campos "repetidor" e "galeria" só existem no ACF Pro. Enquanto a licença
 * não for decidida:
 *   - especificações: um campo de texto longo, uma linha por item, no formato
 *     "Rótulo: valor". O modelo da página monta a tabela a partir disso.
 *   - galeria: campos de imagem separados (foto_2 a foto_4).
 * Se o ACF Pro for aprovado, os dois viram repetidor e galeria de verdade, e a
 * migração é simples porque os nomes dos campos não mudam.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'fachini_core_register_acf_fields' );

function fachini_core_register_acf_fields() {

	// Se o ACF não estiver ativo, não faz nada e não quebra o site.
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_fachini_maquina',
			'title'                 => 'Dados da máquina',
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'maquina',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'active'                => true,
			'show_in_rest'          => true,
			'description'           => 'Preencha os dados da máquina. O visual da página é montado automaticamente pelo modelo.',
			'fields'                => array(

				array(
					'key'         => 'field_fachini_modelo',
					'label'       => 'Modelo / série',
					'name'        => 'modelo_serie',
					'type'        => 'text',
					'instructions' => 'Ex.: Série "HWM". Aparece logo abaixo do nome da máquina.',
				),

				array(
					'key'         => 'field_fachini_resumo',
					'label'       => 'Descrição curta',
					'name'        => 'descricao_curta',
					'type'        => 'textarea',
					'rows'        => 3,
					'instructions' => 'Uma ou duas frases. Usada nos cards da listagem e na busca do Google.',
				),

				array(
					'key'          => 'field_fachini_specs',
					'label'        => 'Especificações técnicas',
					'name'         => 'especificacoes',
					'type'         => 'textarea',
					'rows'         => 10,
					'instructions' => 'Uma por linha, no formato "Rótulo: valor". Exemplo:<br>Espessura: 0,43 mm<br>Velocidade: 18 m/min<br>Potência: 7,5 cv',
				),

				array(
					'key'           => 'field_fachini_catalogo',
					'label'         => 'Catálogo em PDF',
					'name'          => 'catalogo_pdf',
					'type'          => 'file',
					'return_format' => 'array',
					'mime_types'    => 'pdf',
					'instructions'  => 'Opcional. O botão de download só aparece se houver arquivo aqui.',
				),

				array(
					'key'          => 'field_fachini_video',
					'label'        => 'Vídeo (YouTube)',
					'name'         => 'video_url',
					'type'         => 'url',
					'instructions' => 'Opcional. Cole o endereço do vídeo no YouTube.',
				),

				array(
					'key'           => 'field_fachini_foto_2',
					'label'         => 'Foto adicional 2',
					'name'          => 'foto_2',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'instructions'  => 'A foto principal é a "Foto principal" do cadastro, na coluna da direita.',
				),
				array(
					'key'           => 'field_fachini_foto_3',
					'label'         => 'Foto adicional 3',
					'name'          => 'foto_3',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'           => 'field_fachini_foto_4',
					'label'         => 'Foto adicional 4',
					'name'          => 'foto_4',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),

				array(
					'key'           => 'field_fachini_relacionadas',
					'label'         => 'Máquinas relacionadas',
					'name'          => 'maquinas_relacionadas',
					'type'          => 'relationship',
					'post_type'     => array( 'maquina' ),
					'max'           => 4,
					'return_format' => 'id',
					'instructions'  => 'Até 4 máquinas que aparecem no fim da página.',
				),

				array(
					'key'          => 'field_fachini_destaque',
					'label'        => 'Destacar na home',
					'name'         => 'destaque_home',
					'type'         => 'true_false',
					'ui'           => 1,
					'instructions' => 'Marque para a máquina aparecer na seleção da página inicial.',
				),
			),
		)
	);
}

/**
 * Transforma o texto de especificações em uma lista pronta para o modelo.
 * Usada no template da máquina: fachini_get_especificacoes( get_the_ID() ).
 *
 * @param int $post_id ID da máquina.
 * @return array<int, array{rotulo: string, valor: string}>
 */
function fachini_get_especificacoes( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$bruto   = function_exists( 'get_field' ) ? (string) get_field( 'especificacoes', $post_id ) : '';

	if ( '' === trim( $bruto ) ) {
		return array();
	}

	$linhas = preg_split( '/\r\n|\r|\n/', $bruto );
	$itens  = array();

	foreach ( $linhas as $linha ) {
		$linha = trim( $linha );
		if ( '' === $linha ) {
			continue;
		}

		// Aceita "Rótulo: valor". Linha sem dois-pontos vira item sem rótulo.
		$partes = explode( ':', $linha, 2 );

		if ( 2 === count( $partes ) ) {
			$itens[] = array(
				'rotulo' => trim( $partes[0] ),
				'valor'  => trim( $partes[1] ),
			);
		} else {
			$itens[] = array(
				'rotulo' => '',
				'valor'  => $linha,
			);
		}
	}

	return $itens;
}
