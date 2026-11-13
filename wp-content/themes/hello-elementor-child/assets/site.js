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
	var semMovimento = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

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
		var suave = ! semMovimento;
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

	// Perguntas frequentes (Contato): a resposta abre e fecha deslizando, em
	// vez de aparecer de uma vez (revisão da Débora, 05/11/2026). Anima a
	// altura do próprio <details>, do tamanho da pergunta até o total.
	document.querySelectorAll( 'details.fachini-faq__item' ).forEach( function ( item ) {
		var pergunta = item.querySelector( 'summary' );
		if ( ! pergunta || ! item.animate ) {
			return;
		}
		var animacao = null;
		// Para onde o item está indo. Um clique no meio da animação inverte o
		// caminho a partir da altura em que ele está.
		var abrir = item.open;
		pergunta.addEventListener( 'click', function ( evento ) {
			if ( semMovimento ) {
				return;
			}
			evento.preventDefault();
			var de = item.getBoundingClientRect().height;
			if ( animacao ) {
				animacao.cancel();
			}
			abrir = ! abrir;
			// Aberto durante a animação, para a resposta aparecer enquanto cresce
			// ou some.
			item.open = true;
			var ate = abrir ? item.scrollHeight : pergunta.getBoundingClientRect().height;
			animacao = item.animate( { height: [ de + 'px', ate + 'px' ] }, { duration: 300, easing: 'ease-in-out' } );
			animacao.onfinish = function () {
				animacao = null;
				item.open = abrir;
			};
		} );
	} );

	// Entrada dos blocos na rolagem (revisão da Débora, 05/11/2026). Só o que
	// começa abaixo da tela entra com o efeito; o que aparece ao abrir a página
	// fica parado, para não atrasar o carregamento nem piscar.
	if ( ! semMovimento && 'IntersectionObserver' in window ) {
		var blocos = document.querySelectorAll( [
			'.elementor[data-elementor-type="wp-page"] > .e-con:not(.fachini-home-hero)',
			'.elementor[data-elementor-type="wp-page"] > .elementor-section:not(.fachini-home-hero)',
			'.fachini-maquina-secao',
			'.fachini-faixa',
			'.fachini-maquina-linha',
			'.fachini-modelo-card',
			'.fachini-contato-linha',
		].join( ',' ) );
		var entrada = new IntersectionObserver( function ( entradas ) {
			var ordem = 0;
			entradas.forEach( function ( item ) {
				if ( ! item.isIntersecting ) {
					return;
				}
				// Vários ao mesmo tempo (cards lado a lado): um depois do outro.
				item.target.style.transitionDelay = Math.min( ordem, 3 ) * 80 + 'ms';
				ordem++;
				item.target.classList.add( 'is-visivel' );
				entrada.unobserve( item.target );
			} );
		}, { rootMargin: '0px 0px -8% 0px' } );
		var altura = window.innerHeight;
		blocos.forEach( function ( bloco ) {
			if ( bloco.getBoundingClientRect().top < altura ) {
				return;
			}
			bloco.classList.add( 'fachini-anima' );
			entrada.observe( bloco );
		} );
	}

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
