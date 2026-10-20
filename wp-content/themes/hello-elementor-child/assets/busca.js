/**
 * Abre e fecha a camada da busca (montada pelo plugin, em includes/busca.php).
 * Quem abre é o item "Pesquisa" do menu, com a classe fachini-busca-item.
 */
( function () {
	var camada = document.getElementById( 'fachini-busca' );
	if ( ! camada ) {
		return;
	}
	var campo = camada.querySelector( '.fachini-busca-form__campo' );
	var origem = null;

	function abrir( link ) {
		origem = link;
		// No celular o pedido vem de dentro do menu aberto: fecha o menu antes.
		var menuAberto = document.querySelector( '.elementor-location-header .elementor-menu-toggle.elementor-active' );
		if ( menuAberto ) {
			menuAberto.click();
		}
		camada.hidden = false;
		document.body.classList.add( 'fachini-busca-aberta' );
		window.requestAnimationFrame( function () {
			camada.classList.add( 'is-aberta' );
		} );
		window.setTimeout( function () {
			campo.focus();
		}, 60 );
	}

	function fechar() {
		camada.classList.remove( 'is-aberta' );
		document.body.classList.remove( 'fachini-busca-aberta' );
		window.setTimeout( function () {
			camada.hidden = true;
		}, 250 );
		if ( origem && origem.offsetParent !== null ) {
			origem.focus();
		}
	}

	// Na fase de captura, antes do Elementor tratar o link "#buscar".
	document.addEventListener( 'click', function ( evento ) {
		var link = evento.target.closest( '.fachini-busca-item > a' );
		if ( link ) {
			evento.preventDefault();
			evento.stopPropagation();
			if ( camada.hidden ) {
				abrir( link );
			} else {
				fechar();
			}
			return;
		}
		if ( evento.target.closest( '[data-fachini-fechar]' ) ) {
			fechar();
		}
	}, true );

	document.addEventListener( 'keydown', function ( evento ) {
		if ( 'Escape' === evento.key && ! camada.hidden ) {
			fechar();
		}
	} );
}() );
