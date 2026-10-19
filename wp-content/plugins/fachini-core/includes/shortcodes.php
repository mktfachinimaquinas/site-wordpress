<?php
/**
 * Blocos de conteúdo da máquina, em código.
 *
 * O Elementor monta o visual da página, mas quem desenha a tabela de
 * especificações, o botão do catálogo e a lista de relacionadas é este arquivo.
 * Assim esses blocos continuam existindo mesmo que o layout mude, e podem ser
 * ajustados sem abrir o editor.
 *
 * Uso dentro do Elementor: widget "Shortcode", com [fachini_especificacoes],
 * [fachini_catalogo], [fachini_video] ou [fachini_relacionadas].
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Conteúdo do rodapé, igual ao layout do Figma (desktop e celular).
 *
 * As quatro unidades de venda de máquinas vêm da ficha cadastral enviada pela
 * Fachini em 13/10/2026. A filial de Cascavel da Rua Francisco Ignacio
 * Fernandes fica de fora de propósito: é a loja de peças de caminhão, outro
 * negócio. O link do blog do layout entra quando o blog existir.
 * Os desenhos (logo, linhas, ícones) são os exportados do Figma, em
 * assets/rodape/.
 */
function fachini_sc_rodape() {
	$img = plugins_url( 'assets/rodape/', FACHINI_CORE_PATH . 'fachini-core.php' );

	$menu = array(
		'/'           => 'Home',
		'/quem-somos/' => 'Quem somos',
		'/contato/'   => 'Contato',
	);

	$redes = array(
		array( 'https://www.instagram.com/fachinimaquinasoficial/', '@fachinimaquinasoficial', 'Instagram' ),
		array( 'https://www.facebook.com/fachinimaquinasoficial/', 'Fachini Máquinas Oficial', 'Facebook' ),
		array( 'https://www.linkedin.com/company/grupofachini/', 'Grupo Fachini', 'LinkedIn' ),
		array( 'https://www.youtube.com/@fachinimaquinasoficial', 'Fachini Máquinas', 'YouTube' ),
	);

	$unidades = array(
		array( 'Curitiba - PR', 'Rua Albino Niquele, 160 - Umbará, Curitiba - PR, 81940-220', 'pino.svg' ),
		array( 'Cascavel - PR', 'R. Beliamino Julio Miotto, 493 - Citvel I, Cascavel - PR, 85818-576', 'pino-2.svg' ),
		array( 'Joinville - SC', 'R. Princesa Mafalda, 447 - Floresta, Joinville - SC, 89212-170', 'pino-2.svg' ),
		array( 'Chapecó - SC', 'Av. Leopoldo Sander, 1081 - Cristo Rei, Chapecó - SC, 89810-000', 'pino-2.svg' ),
	);

	$divisor = '<span class="fachini-rodape__divisor" aria-hidden="true"><img src="' . esc_url( $img . 'linha-vertical.svg' ) . '" width="162" height="1" alt=""></span>';

	ob_start();
	?>
	<div class="fachini-rodape">
		<div class="fachini-rodape__topo">
			<a class="fachini-rodape__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( $img . 'logo.svg' ); ?>" width="129" height="92" alt="Fachini Máquinas">
			</a>
			<div class="fachini-rodape__colunas">
				<div class="fachini-rodape__menu-bloco">
					<?php echo $divisor; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- montado acima com esc_url. No desktop esta linha fica escondida. ?>
					<nav class="fachini-rodape__menu" aria-label="Rodapé">
						<?php foreach ( $menu as $caminho => $rotulo ) : ?>
							<a href="<?php echo esc_url( home_url( $caminho ) ); ?>"><?php echo esc_html( $rotulo ); ?></a>
						<?php endforeach; ?>
					</nav>
				</div>
				<div class="fachini-rodape__redes">
					<?php echo $divisor; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- montado acima com esc_url. ?>
					<div class="fachini-rodape__redes-lista">
						<img class="fachini-rodape__redes-icones" src="<?php echo esc_url( $img . 'redes.svg' ); ?>" width="29.9726" height="134" alt="" aria-hidden="true">
						<ul>
							<?php foreach ( $redes as $rede ) : ?>
								<li><a href="<?php echo esc_url( $rede[0] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $rede[2] . ': ' . $rede[1] ); ?>"><?php echo esc_html( $rede[1] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div class="fachini-rodape__unidades">
					<?php echo $divisor; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- montado acima com esc_url. ?>
					<div class="fachini-rodape__grade">
						<?php foreach ( $unidades as $unidade ) : ?>
							<div class="fachini-rodape__unidade">
								<p class="fachini-rodape__cidade"><img src="<?php echo esc_url( $img . $unidade[2] ); ?>" width="8.85938" height="10.3837" alt=""><?php echo esc_html( $unidade[0] ); ?></p>
								<p class="fachini-rodape__endereco"><?php echo esc_html( $unidade[1] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="fachini-rodape__base">
			<img class="fachini-rodape__linha" src="<?php echo esc_url( $img . 'linha-horizontal.svg' ); ?>" width="1208" height="1" alt="" aria-hidden="true">
			<div class="fachini-rodape__base-linha">
				<a href="<?php echo esc_url( home_url( '/politica-de-privacidade/' ) ); ?>">Política de Privacidade</a>
				<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> All Rights Reserved by Fachini</p>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'fachini_rodape', 'fachini_sc_rodape' );

/**
 * Caminho de navegação (breadcrumb).
 *
 * Feito aqui em vez de depender do Rank Math: o shortcode dele só existe se a
 * opção estiver ligada no painel, e se não estiver o visitante vê o shortcode
 * escrito na tela. Este sempre funciona.
 */
function fachini_sc_breadcrumb() {
	$itens = array( '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>' );

	// No Figma o caminho passa por "Máquinas" (/maquinas/) antes das categorias.
	if ( is_singular( 'maquina' ) || is_tax( 'categoria_maquina' ) ) {
		$itens[] = '<a href="' . esc_url( get_post_type_archive_link( 'maquina' ) ) . '">Máquinas</a>';
	}

	if ( is_singular( 'maquina' ) ) {
		$termo = fachini_get_termo_principal( get_the_ID() );

		if ( $termo ) {
			$ancestrais = array_reverse( get_ancestors( $termo->term_id, 'categoria_maquina' ) );
			foreach ( $ancestrais as $id ) {
				$pai = get_term( $id, 'categoria_maquina' );
				if ( $pai && ! is_wp_error( $pai ) ) {
					$itens[] = '<a href="' . esc_url( get_term_link( $pai ) ) . '">' . esc_html( $pai->name ) . '</a>';
				}
			}
			$itens[] = '<a href="' . esc_url( get_term_link( $termo ) ) . '">' . esc_html( $termo->name ) . '</a>';
		}

		$itens[] = '<span>' . esc_html( get_the_title() ) . '</span>';

	} elseif ( is_tax( 'categoria_maquina' ) ) {
		$atual      = get_queried_object();
		$ancestrais = array_reverse( get_ancestors( $atual->term_id, 'categoria_maquina' ) );

		foreach ( $ancestrais as $id ) {
			$pai = get_term( $id, 'categoria_maquina' );
			if ( $pai && ! is_wp_error( $pai ) ) {
				$itens[] = '<a href="' . esc_url( get_term_link( $pai ) ) . '">' . esc_html( $pai->name ) . '</a>';
			}
		}
		$itens[] = '<span>' . esc_html( $atual->name ) . '</span>';

	} elseif ( is_post_type_archive( 'maquina' ) ) {
		$itens[] = '<span>' . esc_html( post_type_archive_title( '', false ) ) . '</span>';
	}

	// O último item é a página atual. O separador é o quadradinho do layout,
	// desenhado no CSS.
	$ultimo = count( $itens ) - 1;
	$itens[ $ultimo ] = preg_replace( '/^<span>/', '<span aria-current="page">', $itens[ $ultimo ] );

	return '<nav class="fachini-breadcrumb" aria-label="Você está aqui">' . implode( '<span class="fachini-breadcrumb__sep" aria-hidden="true"></span>', $itens ) . '</nav>';
}
add_shortcode( 'fachini_breadcrumb', 'fachini_sc_breadcrumb' );

/**
 * Título da listagem, sem o prefixo que o Elementor acrescenta
 * ("Categoria de máquina: Calhas" vira apenas "Calhas"; "Arquivos: Máquinas"
 * vira "Máquinas").
 * Abaixo dele entra a descrição da categoria, quando houver.
 */
function fachini_sc_titulo_arquivo() {
	if ( is_post_type_archive( 'maquina' ) ) {
		return '<h1 class="fachini-titulo-arquivo">' . esc_html( post_type_archive_title( '', false ) ) . '</h1>';
	}

	if ( ! is_tax( 'categoria_maquina' ) ) {
		return '';
	}

	$termo = get_queried_object();

	if ( ! $termo || is_wp_error( $termo ) ) {
		return '';
	}

	$html = '<h1 class="fachini-titulo-arquivo">' . esc_html( $termo->name ) . '</h1>';

	$descricao = term_description( $termo );
	if ( $descricao ) {
		$html .= '<div class="fachini-arquivo-descricao">' . wp_kses_post( $descricao ) . '</div>';
	}

	return $html;
}
add_shortcode( 'fachini_titulo_arquivo', 'fachini_sc_titulo_arquivo' );

/**
 * Tabela de especificações, montada a partir do campo de texto.
 * O título vem junto: assim a seção inteira some quando não há especificação.
 */
function fachini_sc_especificacoes() {
	$itens = function_exists( 'fachini_get_especificacoes' ) ? fachini_get_especificacoes( get_the_ID() ) : array();

	if ( empty( $itens ) ) {
		return '';
	}

	$html  = '<h2 class="fachini-titulo-secao">Especificações técnicas</h2>';
	$html .= '<table class="fachini-specs"><tbody>';

	foreach ( $itens as $item ) {
		$html .= '<tr>';
		if ( '' !== $item['rotulo'] ) {
			$html .= '<th scope="row">' . esc_html( $item['rotulo'] ) . '</th>';
			$html .= '<td>' . esc_html( $item['valor'] ) . '</td>';
		} else {
			$html .= '<td colspan="2">' . esc_html( $item['valor'] ) . '</td>';
		}
		$html .= '</tr>';
	}

	$html .= '</tbody></table>';

	return $html;
}
add_shortcode( 'fachini_especificacoes', 'fachini_sc_especificacoes' );

/**
 * Botão de download do catálogo. Só aparece se houver arquivo.
 */
function fachini_sc_catalogo() {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$arquivo = get_field( 'catalogo_pdf', get_the_ID() );

	if ( empty( $arquivo['url'] ) ) {
		return '';
	}

	return sprintf(
		'<a class="fachini-botao fachini-botao--catalogo" href="%s" target="_blank" rel="noopener">Baixar catálogo em PDF</a>',
		esc_url( $arquivo['url'] )
	);
}
add_shortcode( 'fachini_catalogo', 'fachini_sc_catalogo' );

/**
 * Vídeo do YouTube, carregado só quando o visitante clica.
 * Evita o peso do player em toda visita, que é o que derruba nota de performance.
 */
function fachini_sc_video() {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$url = (string) get_field( 'video_url', get_the_ID() );

	if ( '' === trim( $url ) ) {
		return '';
	}

	// Extrai o id do vídeo das formas mais comuns de endereço do YouTube.
	$id = '';
	if ( preg_match( '~(?:youtu\.be/|v=|/embed/|/shorts/)([A-Za-z0-9_-]{6,})~', $url, $m ) ) {
		$id = $m[1];
	}

	if ( '' === $id ) {
		return '';
	}

	return sprintf(
		'<div class="fachini-video" data-video="%1$s">
			<button type="button" class="fachini-video__play" aria-label="Reproduzir vídeo">
				<img src="https://i.ytimg.com/vi/%1$s/hqdefault.jpg" alt="" loading="lazy" width="480" height="360">
				<span class="fachini-video__icone" aria-hidden="true"></span>
			</button>
		</div>',
		esc_attr( $id )
	);
}
add_shortcode( 'fachini_video', 'fachini_sc_video' );

/**
 * Máquinas relacionadas. Se o campo estiver vazio, usa as da mesma categoria.
 */
function fachini_sc_relacionadas() {
	$id  = get_the_ID();
	$ids = function_exists( 'get_field' ) ? (array) get_field( 'maquinas_relacionadas', $id ) : array();
	$ids = array_filter( array_map( 'intval', $ids ) );

	if ( empty( $ids ) ) {
		$termo = function_exists( 'fachini_get_termo_principal' ) ? fachini_get_termo_principal( $id ) : null;

		if ( $termo ) {
			$ids = get_posts(
				array(
					'post_type'      => 'maquina',
					'posts_per_page' => 4,
					'post__not_in'   => array( $id ),
					'fields'         => 'ids',
					'tax_query'      => array(
						array(
							'taxonomy' => 'categoria_maquina',
							'field'    => 'term_id',
							'terms'    => $termo->term_id,
						),
					),
				)
			);
		}
	}

	if ( empty( $ids ) ) {
		return '';
	}

	$html  = '<h2 class="fachini-titulo-secao">Máquinas relacionadas</h2>';
	$html .= '<div class="fachini-relacionadas">';

	foreach ( $ids as $rid ) {
		$html .= sprintf(
			'<a class="fachini-relacionadas__item" href="%s">%s<span class="fachini-relacionadas__nome">%s</span></a>',
			esc_url( get_permalink( $rid ) ),
			get_the_post_thumbnail( $rid, 'medium', array( 'loading' => 'lazy' ) ),
			esc_html( get_the_title( $rid ) )
		);
	}

	$html .= '</div>';

	return $html;
}
add_shortcode( 'fachini_relacionadas', 'fachini_sc_relacionadas' );
