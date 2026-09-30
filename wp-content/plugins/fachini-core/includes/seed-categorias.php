<?php
/**
 * Carga inicial das categorias e subcategorias de máquina.
 *
 * A árvore abaixo é exatamente a da planilha de arquitetura de URLs aprovada
 * pelo cliente (versão 4, com a coluna de tipo de página). Fica em código de
 * propósito: assim a estrutura pode ser recriada em qualquer ambiente, entra
 * no Git e não depende de alguém lembrar de digitar tudo de novo.
 *
 * Roda uma vez só. Para rodar de novo depois de mexer na árvore, basta apagar
 * a opção 'fachini_categorias_versao' no banco.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FACHINI_CATEGORIAS_VERSAO', '2026-09-30c' );

/**
 * Árvore aprovada: slug => [nome, [filhos...]]
 */
function fachini_arvore_categorias() {
	return array(
		'perfiladeiras' => array(
			'nome'   => 'Perfiladeiras',
			'filhos' => array(
				'paineis-termoacusticos'      => 'Painéis termoacústicos',
				'coberturas-e-fechamentos'    => 'Coberturas e fechamentos',
				'tercas-e-perfis-estruturais' => 'Terças e perfis estruturais',
				'construcao-a-seco'           => 'Construção a seco',
				'porta-pallet-e-armazenagem'  => 'Porta-pallet e armazenagem',
				'defensas-metalicas'          => 'Defensas metálicas',
				'agricola'                    => 'Agrícola',
				'acessorios'                  => 'Acessórios',
			),
		),
		'calhas'        => array(
			'nome'   => 'Calhas',
			'filhos' => array(
				'dobradeiras-regua-lisa'    => 'Dobradeiras de régua lisa',
				'dobradeiras-regua-dentada' => 'Dobradeiras de régua dentada',
				'acessorios'                => 'Acessórios',
			),
		),
		'corte-e-dobra' => array(
			'nome'   => 'Corte e dobra',
			'filhos' => array(
				'dobradeiras-hidraulicas' => 'Dobradeiras hidráulicas',
			),
		),
		'laser'         => array(
			'nome'   => 'Laser',
			'filhos' => array(
				'corte-a-laser'  => 'Corte a laser',
				'solda-a-laser'  => 'Solda a laser',
			),
		),
	);
}

/**
 * Cria a árvore se ainda não existir. Nunca apaga nem renomeia nada que já esteja lá.
 */
function fachini_seed_categorias() {

	if ( get_option( 'fachini_categorias_versao' ) === FACHINI_CATEGORIAS_VERSAO ) {
		return;
	}

	if ( ! taxonomy_exists( 'categoria_maquina' ) ) {
		return;
	}

	foreach ( fachini_arvore_categorias() as $slug_pai => $dados ) {

		$pai = get_term_by( 'slug', $slug_pai, 'categoria_maquina' );

		if ( ! $pai ) {
			$novo = wp_insert_term( $dados['nome'], 'categoria_maquina', array( 'slug' => $slug_pai ) );
			if ( is_wp_error( $novo ) ) {
				continue;
			}
			$pai_id = (int) $novo['term_id'];
		} else {
			$pai_id = (int) $pai->term_id;
		}

		foreach ( $dados['filhos'] as $slug_filho => $nome_filho ) {

			// "Acessórios" existe em Calhas e em Perfiladeiras. Como a taxonomia é
			// hierárquica, o mesmo apelido pode repetir desde que o pai seja outro.
			$existente = get_terms(
				array(
					'taxonomy'   => 'categoria_maquina',
					'slug'       => $slug_filho,
					'parent'     => $pai_id,
					'hide_empty' => false,
				)
			);

			if ( ! empty( $existente ) && ! is_wp_error( $existente ) ) {
				continue;
			}

			wp_insert_term(
				$nome_filho,
				'categoria_maquina',
				array(
					'slug'   => $slug_filho,
					'parent' => $pai_id,
				)
			);
		}
	}

	fachini_corrigir_slugs_renomeados();

	update_option( 'fachini_categorias_versao', FACHINI_CATEGORIAS_VERSAO );
	flush_rewrite_rules();
}

/**
 * Limpa apelidos que o WordPress renomeou antes de o filtro de unicidade existir.
 *
 * Caso concreto: "Acessórios" de Calhas virou "acessorios-calhas", porque o
 * WordPress acrescenta o apelido do pai quando encontra repetição. A planilha
 * aprovada pede /calhas/acessorios/.
 *
 * Se já existir o termo correto ao lado, o renomeado é removido. Se não
 * existir, ele é renomeado e aproveitado, preservando qualquer máquina que
 * já estivesse ligada a ele.
 */
function fachini_corrigir_slugs_renomeados() {

	$renomeados = array(
		// apelido errado => apelido correto
		'acessorios-calhas' => 'acessorios',
	);

	foreach ( $renomeados as $errado => $correto ) {

		$termo = get_term_by( 'slug', $errado, 'categoria_maquina' );

		if ( ! $termo || is_wp_error( $termo ) ) {
			continue;
		}

		$irmao_correto = get_terms(
			array(
				'taxonomy'   => 'categoria_maquina',
				'parent'     => (int) $termo->parent,
				'slug'       => $correto,
				'hide_empty' => false,
			)
		);

		$tem_irmao = ( ! is_wp_error( $irmao_correto ) && ! empty( $irmao_correto ) );

		if ( $tem_irmao ) {
			// Só remove se nenhuma máquina estiver usando o termo antigo.
			if ( 0 === (int) $termo->count ) {
				wp_delete_term( $termo->term_id, 'categoria_maquina' );
			}
			continue;
		}

		wp_update_term( $termo->term_id, 'categoria_maquina', array( 'slug' => $correto ) );
	}
}
add_action( 'init', 'fachini_seed_categorias', 20 );
