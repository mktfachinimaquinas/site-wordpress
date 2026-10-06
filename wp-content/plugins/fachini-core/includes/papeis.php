<?php
/**
 * Permissões das máquinas e o papel "Cadastro de Máquinas".
 *
 * O tipo "Máquinas" usa permissões próprias (capability_type 'maquina'). Elas
 * ficam gravadas no banco, por papel, então precisam ser distribuídas: na
 * ativação e uma vez a cada versão nova do plugin (ver fachini-core.php).
 *
 * Administrador: todas as permissões de máquina. Sem isso o menu Máquinas
 * some para o administrador.
 *
 * Cadastro de Máquinas: cria, edita, publica e apaga só as próprias máquinas,
 * escolhe a categoria e envia fotos e PDFs. Não mexe em páginas, modelos,
 * plugins, tema nem usuários. Qualquer permissão a mais precisa ser combinada
 * antes, porque o e-mail desse usuário é uma conta compartilhada.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FACHINI_PAPEL_CADASTRO', 'cadastro_maquinas' );

/**
 * Todas as permissões do tipo "Máquinas", para o administrador.
 */
function fachini_permissoes_maquina_admin() {
	return array(
		'edit_maquinas',
		'edit_others_maquinas',
		'edit_published_maquinas',
		'edit_private_maquinas',
		'publish_maquinas',
		'read_private_maquinas',
		'delete_maquinas',
		'delete_others_maquinas',
		'delete_published_maquinas',
		'delete_private_maquinas',
	);
}

/**
 * A lista completa do papel "Cadastro de Máquinas". Nada além disto.
 */
function fachini_permissoes_papel_cadastro() {
	return array(
		'read',
		'upload_files',
		'edit_maquinas',
		'edit_published_maquinas',
		'publish_maquinas',
		'delete_maquinas',
		'delete_published_maquinas',
	);
}

/**
 * Dá ao administrador as permissões de máquina e deixa o papel "Cadastro de
 * Máquinas" exatamente com a lista acima.
 */
function fachini_core_migrar_papeis() {
	$admin = get_role( 'administrator' );

	if ( $admin ) {
		foreach ( fachini_permissoes_maquina_admin() as $permissao ) {
			$admin->add_cap( $permissao );
		}
	}

	$desejadas = fachini_permissoes_papel_cadastro();
	$papel     = get_role( FACHINI_PAPEL_CADASTRO );

	if ( ! $papel ) {
		add_role( FACHINI_PAPEL_CADASTRO, 'Cadastro de Máquinas', array_fill_keys( $desejadas, true ) );
	} else {
		foreach ( $desejadas as $permissao ) {
			$papel->add_cap( $permissao );
		}

		// Remove o que tiver sido acrescentado por fora, para o papel não crescer sem aviso.
		foreach ( array_keys( $papel->capabilities ) as $permissao ) {
			if ( ! in_array( $permissao, $desejadas, true ) ) {
				$papel->remove_cap( $permissao );
			}
		}
	}

	// O usuário desta requisição já teve as permissões calculadas antes da
	// migração. Recalcula, senão o menu Máquinas some até a próxima página.
	if ( is_user_logged_in() ) {
		wp_get_current_user()->get_role_caps();
	}
}
