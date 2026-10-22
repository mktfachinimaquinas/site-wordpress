/**
 * Política de Privacidade: a barra das seções marca a seção que está sendo
 * lida. Seções sem aba na barra (as do meio e as do fim) ficam marcadas pela
 * aba anterior.
 */
(function () {
	'use strict';

	var links = Array.prototype.slice.call(document.querySelectorAll('.fachini-politica-abas a'));
	var pares = links.map(function (link) {
		return [document.getElementById(link.hash.slice(1)), link];
	}).filter(function (par) {
		return par[0];
	});
	if (!pares.length) {
		return;
	}

	var agendado = false;

	function marcar() {
		agendado = false;
		var limite = window.innerHeight * 0.4;
		var ativo = pares[0][1];
		pares.forEach(function (par) {
			if (par[0].getBoundingClientRect().top <= limite) {
				ativo = par[1];
			}
		});
		links.forEach(function (link) {
			link.classList.toggle('is-ativo', link === ativo);
			if (link === ativo) {
				link.setAttribute('aria-current', 'true');
			} else {
				link.removeAttribute('aria-current');
			}
		});
	}

	window.addEventListener('scroll', function () {
		if (!agendado) {
			agendado = true;
			window.requestAnimationFrame(marcar);
		}
	}, { passive: true });
	window.addEventListener('resize', marcar);
	marcar();
})();
