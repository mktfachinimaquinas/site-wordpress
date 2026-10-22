/**
 * Banner de cookies (includes/consentimento.php).
 *
 * Mostra o banner para quem ainda não escolheu, grava a escolha num cookie
 * essencial por 12 meses, avisa o Consent Mode do Google e deixa o evento
 * "fachini_consentimento" no dataLayer para as tags da etapa 3. Qualquer link
 * para #preferencias-cookies reabre as opções.
 */
(function () {
	'use strict';

	var banner = document.getElementById('preferencias-cookies');
	if (!banner) {
		return;
	}

	var versao = banner.getAttribute('data-versao');
	var opcoes = banner.querySelector('.fachini-cookies__opcoes');
	var analise = banner.querySelector('input[name="analise"]');
	var marketing = banner.querySelector('input[name="marketing"]');
	var botao = function (acao) {
		return banner.querySelector('[data-acao="' + acao + '"]');
	};
	var origem = null;

	function lerEscolha() {
		var m = document.cookie.match(/(?:^|; )fachini_consentimento=([^;]*)/);
		if (!m) {
			return null;
		}
		var p = decodeURIComponent(m[1]).split('|');
		if (p[0] !== versao) {
			return null;
		}
		return { analise: p[1] === '1', marketing: p[2] === '1' };
	}

	function gravar(escolha) {
		var valor = [versao, escolha.analise ? 1 : 0, escolha.marketing ? 1 : 0, Math.floor(Date.now() / 1000)].join('|');
		document.cookie = 'fachini_consentimento=' + encodeURIComponent(valor)
			+ '; max-age=31536000; path=/; SameSite=Lax' + (window.location.protocol === 'https:' ? '; Secure' : '');
	}

	function avisarTags(escolha) {
		window.dataLayer = window.dataLayer || [];
		var gtag = window.gtag || function () { window.dataLayer.push(arguments); };
		var a = escolha.analise ? 'granted' : 'denied';
		var k = escolha.marketing ? 'granted' : 'denied';
		gtag('consent', 'update', { analytics_storage: a, ad_storage: k, ad_user_data: k, ad_personalization: k });
		window.dataLayer.push({ event: 'fachini_consentimento', consentimento_analise: a, consentimento_marketing: k });
	}

	function mostrarOpcoes(sim) {
		opcoes.hidden = !sim;
		botao('escolher').hidden = sim;
		botao('salvar').hidden = !sim;
		banner.classList.toggle('is-opcoes', sim);
	}

	function abrir(comOpcoes, quem) {
		var atual = lerEscolha();
		analise.checked = !!(atual && atual.analise);
		marketing.checked = !!(atual && atual.marketing);
		mostrarOpcoes(comOpcoes);
		banner.hidden = false;
		origem = quem || null;
		if (quem) {
			(comOpcoes ? analise : botao('recusar')).focus();
		}
	}

	function fechar() {
		banner.hidden = true;
		if (origem && document.contains(origem)) {
			origem.focus();
		}
		origem = null;
	}

	function escolher(escolha) {
		gravar(escolha);
		avisarTags(escolha);
		fechar();
	}

	banner.addEventListener('click', function (ev) {
		var alvo = ev.target.closest('[data-acao]');
		if (!alvo) {
			return;
		}
		switch (alvo.getAttribute('data-acao')) {
			case 'aceitar':
				escolher({ analise: true, marketing: true });
				break;
			case 'recusar':
				escolher({ analise: false, marketing: false });
				break;
			case 'escolher':
				mostrarOpcoes(true);
				analise.focus();
				break;
			case 'salvar':
				escolher({ analise: analise.checked, marketing: marketing.checked });
				break;
		}
	});

	/* Reabrir pelas "Preferências de cookies". Fechar com Esc só quando já
	   existe uma escolha: no primeiro acesso, a pessoa precisa decidir. */
	document.addEventListener('click', function (ev) {
		var link = ev.target.closest('a[href$="#preferencias-cookies"], [data-fachini-cookies]');
		if (!link) {
			return;
		}
		ev.preventDefault();
		abrir(true, link);
	});

	document.addEventListener('keydown', function (ev) {
		if (ev.key === 'Escape' && !banner.hidden && lerEscolha()) {
			fechar();
		}
	});

	if (!lerEscolha()) {
		abrir(false, null);
	}
})();
