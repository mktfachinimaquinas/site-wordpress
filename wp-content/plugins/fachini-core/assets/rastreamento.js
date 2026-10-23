/**
 * Integrações de marketing (includes/integracoes.php).
 *
 * 1. Origem da visita: na chegada, guarda as UTMs, o gclid e o fbclid do
 *    endereço, a página de entrada e o site de onde a pessoa veio, só durante
 *    a visita (sessionStorage). O formulário de orçamento envia isso junto com
 *    o pedido, para a origem do lead aparecer certa no RD Station.
 * 2. Tags, só com consentimento e sem atrasar a página (depois do
 *    carregamento, quando o navegador estiver livre): GA4 com análise;
 *    Google Ads e Pixel da Meta com marketing; GTM e RD com qualquer um.
 * 3. Eventos: clique no WhatsApp e pedido de orçamento (na confirmação, uma
 *    vez por protocolo em cada ferramenta).
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

	/*
	 * O endereço da confirmação leva a chave que abre a página com o nome da
	 * pessoa. As tags enviam o endereço da página, então ele é limpo antes de
	 * qualquer uma carregar.
	 */
	if (config.lead && window.history && window.history.replaceState) {
		window.history.replaceState(window.history.state, '', window.location.pathname);
	}

	/* 2. Tags, só com consentimento. */
	window.dataLayer = window.dataLayer || [];
	var gtag = window.gtag || function () { window.dataLayer.push(arguments); };
	var ativo = { gtm: false, rd: false, ga4: false, ads: false, pixel: false };
	var gtagJs = false;

	function consentimento() {
		var m = document.cookie.match(/(?:^|; )fachini_consentimento=([^;]*)/);
		var p = m ? decodeURIComponent(m[1]).split('|') : [];
		return { analise: p[1] === '1', marketing: p[2] === '1' };
	}

	function script(src) {
		var s = document.createElement('script');
		s.async = true;
		s.src = src;
		document.head.appendChild(s);
	}

	// Um único gtag.js atende GA4 e Google Ads.
	function configurarGoogle(id) {
		if (!gtagJs) {
			gtagJs = true;
			script('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id));
			gtag('js', new Date());
		}
		gtag('config', id);
	}

	function carregarPixel(id) {
		if (window.fbq && window.fbq.fachiniIniciado) {
			window.fbq('consent', 'grant');
			return;
		}
		if (!window.fbq) {
			var n = window.fbq = function () {
				if (n.callMethod) {
					n.callMethod.apply(n, arguments);
				} else {
					n.queue.push(arguments);
				}
			};
			if (!window._fbq) {
				window._fbq = n;
			}
			n.push = n;
			n.loaded = true;
			n.version = '2.0';
			n.queue = [];
			script('https://connect.facebook.net/en_US/fbevents.js');
		}
		window.fbq('consent', 'grant');
		window.fbq('init', id);
		window.fbq('track', 'PageView');
		window.fbq.fachiniIniciado = true;
	}

	function carregar() {
		var c = consentimento();

		if ((c.analise || c.marketing) && !ativo.gtm && config.gtm) {
			ativo.gtm = true;
			window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
			script('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(config.gtm));
		}
		if ((c.analise || c.marketing) && !ativo.rd && config.rd) {
			ativo.rd = true;
			script(config.rd);
		}
		if (c.analise && !ativo.ga4 && config.ga4) {
			ativo.ga4 = true;
			configurarGoogle(config.ga4);
		}
		if (c.marketing && !ativo.ads && config.ads) {
			ativo.ads = true;
			configurarGoogle(config.ads);
		}
		if (c.marketing && !ativo.pixel && config.pixel) {
			ativo.pixel = true;
			carregarPixel(config.pixel);
		}
		// Marketing retirado depois de aceito: o pixel para de enviar.
		if (!c.marketing && ativo.pixel) {
			ativo.pixel = false;
			window.fbq('consent', 'revoke');
		}

		enviarLead();
	}

	/* 3. Eventos. */
	function umaVez(canal, enviar) {
		var chave = 'fachini-lead-' + canal + '-' + config.lead.id;
		try {
			if (window.sessionStorage.getItem(chave)) {
				return;
			}
			window.sessionStorage.setItem(chave, '1');
		} catch (e) {
			/* Sem armazenamento: envia assim mesmo. */
		}
		enviar();
	}

	function enviarLead() {
		var lead = config.lead;
		if (!lead || !lead.id) {
			return;
		}
		if (ativo.gtm) {
			umaVez('gtm', function () {
				window.dataLayer.push({ event: 'fachini_pedido', pedido_protocolo: lead.id, pedido_categoria: lead.categoria });
			});
		}
		if (ativo.ga4) {
			umaVez('ga4', function () {
				gtag('event', 'generate_lead', { send_to: config.ga4, lead_id: lead.id, categoria: lead.categoria });
			});
		}
		if (ativo.ads && config.adsRotulo) {
			umaVez('ads', function () {
				gtag('event', 'conversion', { send_to: config.ads + '/' + config.adsRotulo, transaction_id: lead.id });
			});
		}
		if (ativo.pixel) {
			umaVez('pixel', function () {
				window.fbq('track', 'Lead', { content_category: lead.categoria }, { eventID: 'pedido-' + lead.id });
			});
		}
	}

	// Vai só o endereço sem a mensagem: a mensagem pode ter o nome da pessoa.
	document.addEventListener('click', function (e) {
		var link = e.target && e.target.closest ? e.target.closest('a[href*="wa.me/"], a[href*="whatsapp.com/send"]') : null;
		if (!link) {
			return;
		}
		var destino = link.href.split('?')[0];
		if (ativo.gtm) {
			window.dataLayer.push({ event: 'fachini_whatsapp', whatsapp_link: destino });
		}
		if (ativo.ga4) {
			gtag('event', 'whatsapp_click', { send_to: config.ga4, link_url: destino });
		}
		if (ativo.pixel) {
			window.fbq('track', 'Contact');
		}
	});

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

	if (config.gtm || config.rd || config.ga4 || config.ads || config.pixel) {
		// A confirmação abre o WhatsApp em 5 segundos: ali as tags não esperam.
		if (config.lead) {
			carregar();
		} else {
			quandoLivre();
		}
		/* Quem aceita (ou muda a escolha) durante a visita já é atendido, sem recarregar. */
		document.addEventListener('fachini-consentimento', carregar);
	}
})();
