<?php
/**
 * Fotos em WebP.
 *
 * As fotos enviadas em JPEG passam a ter todos os tamanhos gerados em WebP,
 * que dá arquivos menores com a mesma qualidade e deixa o site mais rápido.
 * O arquivo original enviado continua guardado como veio. PNG fica como está,
 * para não mexer em logos e imagens com transparência.
 *
 * O próprio WordPress só aplica a troca se o editor de imagens do servidor
 * souber gravar WebP; se não souber, mantém o JPEG.
 *
 * Vale só para as imagens enviadas depois que este código está ativo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fachini_formato_webp( $formatos ) {
	$formatos['image/jpeg'] = 'image/webp';

	return $formatos;
}
add_filter( 'image_editor_output_format', 'fachini_formato_webp' );
