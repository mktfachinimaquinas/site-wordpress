/**
 * Comportamentos de todas as páginas (pedidos do cliente em 22/10/2026):
 * cabeçalho fixo no alto, botão de voltar ao topo e, nas barras de abas que
 * rolam de lado no celular, a aba ativa à vista.
 *
 * O cabeçalho fica fixo pelo CSS. Aqui só medimos a altura dele (as barras de
 * seção grudam logo abaixo) e marcamos a página como "rolada", para o
 * cabeçalho transparente das páginas com foto ganhar fundo.
 */
( function () {
	var raiz = document.documentElement;
	var cabecalho = document.querySelector( '.elementor-location-header' );
	var barraAdmin = document.getElementById( 'wpadminbar' );

	var medir = function () {
		var admin = barraAdmin && window.getComputedStyle( barraAdmin ).position === 'fixed' ? barraAdmin.offsetHeight : 0;
		raiz.style.setProperty( '--fachini-barra-admin', admin + 'px' );
		raiz.style.setProperty( '--fachini-topo', ( admin + ( cabecalho ? cabecalho.offsetHeight : 0 ) ) + 'px' );
	};
	medir();
	window.addEventListener( 'resize', medir );
	if ( cabecalho && 'ResizeObserver' in window ) {
		new ResizeObserver( medir ).observe( cabecalho );
	}

	// Voltar ao topo: aparece depois de um pouco de rolagem.
	var botao = document.createElement( 'button' );
	botao.type = 'button';
	botao.className = 'fachini-topo-botao';
	botao.setAttribute( 'aria-label', 'Voltar ao topo da página' );
	document.body.appendChild( botao );
	botao.addEventListener( 'click', function () {
		var suave = ! window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		window.scrollTo( { top: 0, behavior: suave ? 'smooth' : 'auto' } );
		// Para quem navega pelo teclado, o foco volta para o início da página.
		var primeiro = cabecalho && cabecalho.querySelector( 'a' );
		if ( primeiro ) {
			primeiro.focus( { preventScroll: true } );
		}
	} );

	var agendado = false;
	var aoRolar = function () {
		agendado = false;
		var y = window.scrollY || window.pageYOffset;
		document.body.classList.toggle( 'fachini-rolou', y > 10 );
		botao.classList.toggle( 'is-visivel', y > 600 );
	};
	window.addEventListener( 'scroll', function () {
		if ( ! agendado ) {
			agendado = true;
			window.requestAnimationFrame( aoRolar );
		}
	}, { passive: true } );
	aoRolar();

	// Barras de abas que rolam de lado (celular): centraliza a aba ativa.
	document.querySelectorAll( '.fachini-cat-nav__lista' ).forEach( function ( lista ) {
		var ativa = lista.querySelector( '.is-ativo' );
		if ( ! ativa || lista.scrollWidth <= lista.clientWidth ) {
			return;
		}
		var esquerda = ativa.getBoundingClientRect().left - lista.getBoundingClientRect().left + lista.scrollLeft;
		lista.scrollLeft = esquerda - ( lista.clientWidth - ativa.offsetWidth ) / 2;
	} );
}() );
