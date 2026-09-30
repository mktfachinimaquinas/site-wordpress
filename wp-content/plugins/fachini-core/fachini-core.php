<?php
/**
 * Plugin Name:       Fachini Core
 * Plugin URI:        https://github.com/mktfachinimaquinas/site-wordpress
 * Description:       Estrutura de conteúdo do site da Fachini Máquinas: tipo de conteúdo "Máquinas", taxonomias e campos. Independente do tema e do Elementor, de forma que trocar o visual do site não apaga nenhum cadastro.
 * Version:           1.2.1
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:            Fachini Máquinas
 * License:           GPL-2.0-or-later
 * Text Domain:       fachini-core
 */

// Bloqueia acesso direto ao arquivo.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FACHINI_CORE_VERSION', '1.2.1' );
define( 'FACHINI_CORE_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Slugs base das URLs.
 *
 * FACHINI_SLUG_MAQUINAS é o endereço da listagem geral (/maquinas/).
 * FACHINI_SLUG_CATEGORIAS é o prefixo interno da taxonomia; ele é removido do
 * endereço final em includes/permalinks.php, porque a planilha aprovada usa
 * /calhas/ e não /categorias/calhas/.
 *
 * ATENÇÃO: ao alterar qualquer um destes valores, é obrigatório salvar os
 * links permanentes novamente (Configurações > Links permanentes) para o
 * WordPress regravar as regras de reescrita.
 */
define( 'FACHINI_SLUG_MAQUINAS', 'maquinas' );
define( 'FACHINI_SLUG_CATEGORIAS', 'categorias' );

require_once FACHINI_CORE_PATH . 'includes/post-types.php';
require_once FACHINI_CORE_PATH . 'includes/taxonomies.php';
require_once FACHINI_CORE_PATH . 'includes/permalinks.php';
require_once FACHINI_CORE_PATH . 'includes/seed-categorias.php';
require_once FACHINI_CORE_PATH . 'includes/acf-fields.php';

/**
 * Na ativação, registra as estruturas e regrava as regras de URL.
 * Sem isso, as páginas de máquina dariam 404 até alguém salvar os links permanentes na mão.
 */
function fachini_core_activate() {
	fachini_core_register_post_types();
	fachini_core_register_taxonomies();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'fachini_core_activate' );

/**
 * Na desativação, limpa as regras de URL.
 * Os cadastros de máquina NÃO são apagados: eles continuam no banco de dados.
 */
function fachini_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'fachini_core_deactivate' );
