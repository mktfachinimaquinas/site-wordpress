/**
 * Integrações de marketing (includes/integracoes.php).
 *
 * 1. Origem da visita: na chegada, guarda as UTMs, o gclid e o fbclid do
 *    endereço, a página de entrada e o site de onde a pessoa veio, só durante
 *    a visita (sessionStorage). O formulário de orçamento envia isso junto com
 *    o pedido, para a origem do lead aparecer certa no RD Station.
 * 2. GTM e RD Station: só carregam depois de a pessoa aceitar cookies de
 *    análise ou de marketing no banner, e sem atrasar a página (depois do
 *    carregamento, quando o navegador estiver livre).
 */
(function () {
	'use strict';

	var config = window.fachiniRastreamento || {};
	var CHAVE = 'fachini-origem';

	/* 1. Origem da visita: vale a primeira da sessão. */
	try {
		if (!window.sessionStorage.getItem(CHAVE)) {
			var params = new URLSearchParams(window.location.search);
			var origem = {};
			['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'].forEach(function (nome) {
				var valor = params.get(nome);
				if (valor) {
					origem[nome] = valor.slice(0, 200);
				}
			});
			origem.entrada = window.location.pathname;
			if (document.referrer && document.referrer.indexOf(window.location.host) === -1) {
				origem.referencia = document.referrer.slice(0, 300);
			}
			window.sessionStorage.setItem(CHAVE, JSON.stringify(origem));
		}
	} catch (e) {
		/* Sem armazenamento: o pedido vai sem a origem. */
	}

	/* 2. Tags, só com consentimento. */
	var carregado = false;

	function consentiu() {
		var m = document.cookie.match(/(?:^|; )fachini_consentimento=([^;]*)/);
		if (!m) {
			return false;
		}
		var p = decodeURIComponent(m[1]).split('|');
		return p[1] === '1' || p[2] === '1';
	}

	function script(src) {
		var s = document.createElement('script');
		s.async = true;
		s.src = src;
		document.head.appendChild(s);
	}

	function carregar() {
		if (carregado || !consentiu()) {
			return;
		}
		carregado = true;
		if (config.gtm) {
			window.dataLayer = window.dataLayer || [];
			window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
			script('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(config.gtm));
		}
		if (config.rd) {
			script(config.rd);
		}
	}

	function quandoLivre() {
		var rodar = function () {
			if ('requestIdleCallback' in window) {
				window.requestIdleCallback(carregar, { timeout: 3000 });
			} else {
				window.setTimeout(carregar, 1500);
			}
		};
		if (document.readyState === 'complete') {
			rodar();
		} else {
			window.addEventListener('load', rodar);
		}
	}

	if (config.gtm || config.rd) {
		quandoLivre();
		/* Quem aceita durante a visita já recebe as tags, sem recarregar. */
		document.addEventListener('fachini-consentimento', carregar);
	}
})();
