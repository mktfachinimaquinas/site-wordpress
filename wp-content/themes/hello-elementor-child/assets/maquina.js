/**
 * Página da máquina (montada pelo plugin, em includes/maquina.php):
 * miniaturas que trocam a foto grande, barra das seções que acompanha a
 * rolagem e o vídeo do YouTube, que só carrega quando o visitante clica.
 */
( function () {
	// Galeria: a miniatura clicada vira a foto grande.
	document.querySelectorAll( '.fachini-maquina-galeria' ).forEach( function ( galeria ) {
		var foto = galeria.querySelector( '.fachini-maquina-galeria__foto' );
		galeria.addEventListener( 'click', function ( evento ) {
			var botao = evento.target.closest( '.fachini-maquina-galeria__miniatura' );
			if ( ! botao || ! foto ) {
				return;
			}
			foto.src = botao.dataset.src;
			if ( botao.dataset.srcset ) {
				foto.srcset = botao.dataset.srcset;
			} else {
				foto.removeAttribute( 'srcset' );
			}
			foto.alt = botao.dataset.alt || '';
			galeria.querySelectorAll( '.fachini-maquina-galeria__miniatura' ).forEach( function ( outro ) {
				outro.classList.toggle( 'is-ativa', outro === botao );
				if ( outro === botao ) {
					outro.setAttribute( 'aria-current', 'true' );
				} else {
					outro.removeAttribute( 'aria-current' );
				}
			} );
		} );
	} );

	// Vídeo: troca a capa pelo player do YouTube só no clique.
	document.addEventListener( 'click', function ( evento ) {
		var botao = evento.target.closest( '.fachini-video__play' );
		var caixa = botao && botao.closest( '.fachini-video' );
		if ( ! caixa || ! caixa.dataset.video ) {
			return;
		}
		var player = document.createElement( 'iframe' );
		player.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent( caixa.dataset.video ) + '?autoplay=1&rel=0';
		player.title = 'Vídeo da máquina';
		player.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
		player.allowFullscreen = true;
		caixa.innerHTML = '';
		caixa.appendChild( player );
	} );

	// Barra das seções: marca a seção que está no meio da tela.
	var links = Array.prototype.slice.call( document.querySelectorAll( '.fachini-maquina-abas a' ) );
	if ( ! links.length || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}
	var porSecao = {};
	links.forEach( function ( link ) {
		var secao = document.getElementById( link.hash.slice( 1 ) );
		if ( secao ) {
			porSecao[ secao.id ] = link;
		}
	} );
	var observador = new IntersectionObserver( function ( entradas ) {
		entradas.forEach( function ( entrada ) {
			if ( entrada.isIntersecting ) {
				links.forEach( function ( link ) {
					link.classList.toggle( 'is-ativo', link === porSecao[ entrada.target.id ] );
				} );
			}
		} );
	}, { rootMargin: '-45% 0px -50% 0px' } );
	Object.keys( porSecao ).forEach( function ( id ) {
		observador.observe( document.getElementById( id ) );
	} );
}() );
