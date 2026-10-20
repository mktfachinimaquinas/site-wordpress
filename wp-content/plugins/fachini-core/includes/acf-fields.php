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

	// Seções da página da máquina que seguem o Figma ("MAQUINAS 1"): foto do
	// topo, modelos de telha (imagem e desenho de cada um) e as duas fotos de
	// aplicação com legenda. Campos soltos, numerados, porque o ACF gratuito não
	// tem repetidor. Um modelo ou aplicação sem imagem simplesmente não aparece.
	$campos = array(
		array(
			'key'   => 'field_fachini_aba_topo',
			'label' => 'Topo da página',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_fachini_foto_topo',
			'label'         => 'Foto do topo',
			'name'          => 'foto_topo',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'instructions'  => 'Opcional. Foto larga atrás do nome da máquina. Sem ela, entra a foto da categoria.',
		),
		array(
			'key'   => 'field_fachini_aba_modelos',
			'label' => 'Modelos de telha',
			'type'  => 'tab',
		),
		array(
			'key'          => 'field_fachini_titulo_modelos',
			'label'        => 'Título da seção',
			'name'         => 'titulo_modelos',
			'type'         => 'text',
			'placeholder'  => 'Dimensional e modelos de telhas',
			'instructions' => 'Opcional. Em branco, fica "Dimensional e modelos de telhas".',
		),
	);
	for ( $n = 1; $n <= 6; $n++ ) {
		$campos[] = array(
			'key'          => 'field_fachini_modelo_' . $n . '_nome',
			'label'        => 'Modelo ' . $n . ': nome',
			'name'         => 'modelo_' . $n . '_nome',
			'type'         => 'text',
			'instructions' => 1 === $n ? 'Ex.: TP 40/980. Preencha só os modelos que a máquina produz.' : '',
		);
		$campos[] = array(
			'key'           => 'field_fachini_modelo_' . $n . '_imagem_1',
			'label'         => 'Modelo ' . $n . ': imagem da telha ou da peça',
			'name'          => 'modelo_' . $n . '_imagem_1',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'thumbnail',
			'wrapper'       => array( 'width' => '50' ),
		);
		$campos[] = array(
			'key'           => 'field_fachini_modelo_' . $n . '_imagem_2',
			'label'         => 'Modelo ' . $n . ': desenho técnico',
			'name'          => 'modelo_' . $n . '_imagem_2',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'thumbnail',
			'wrapper'       => array( 'width' => '50' ),
		);
	}
	$campos[] = array(
		'key'   => 'field_fachini_aba_aplicacoes',
		'label' => 'Aplicações',
		'type'  => 'tab',
	);
	for ( $n = 1; $n <= 2; $n++ ) {
		$campos[] = array(
			'key'           => 'field_fachini_aplicacao_' . $n . '_foto',
			'label'         => 'Aplicação ' . $n . ': foto',
			'name'          => 'aplicacao_' . $n . '_foto',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'wrapper'       => array( 'width' => '50' ),
		);
		$campos[] = array(
			'key'          => 'field_fachini_aplicacao_' . $n . '_legenda',
			'label'        => 'Aplicação ' . $n . ': legenda curta',
			'name'         => 'aplicacao_' . $n . '_legenda',
			'type'         => 'text',
			'wrapper'      => array( 'width' => '50' ),
		);
	}

	acf_add_local_field_group(
		array(
			'key'          => 'group_fachini_maquina_pagina',
			'title'        => 'Página da máquina: topo, modelos e aplicações',
			'location'     => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'maquina',
					),
				),
			),
			'menu_order'   => 1,
			'position'     => 'normal',
			'style'        => 'default',
			'active'       => true,
			'show_in_rest' => true,
			'fields'       => $campos,
		)
	);

	// Foto de cada categoria: usada na faixa da categoria (na página da
	// categoria-mãe e em /maquinas/) e no topo da própria página da categoria.
	acf_add_local_field_group(
		array(
			'key'             => 'group_fachini_categoria',
			'title'           => 'Foto da categoria',
			'location'        => array(
				array(
					array(
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => 'categoria_maquina',
					),
				),
			),
			'label_placement' => 'top',
			'active'          => true,
			'fields'          => array(
				array(
					'key'           => 'field_fachini_categoria_foto',
					'label'         => 'Foto',
					'name'          => 'foto_categoria',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'instructions'  => 'Foto horizontal, de preferência com 1920 px de largura. Sem foto, a categoria usa a da categoria-mãe.',
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
