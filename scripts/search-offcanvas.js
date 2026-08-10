/* ==========================================================================
   BUSCA OFF CANVAS — gerenciamento de foco
   --------------------------------------------------------------------------
   Complementa a acessibilidade do widget Fora da Tela do Elementor:

   - coloca o foco no campo de pesquisa ao abrir;
   - impede que o Tab escape para o conteúdo ao fundo;
   - aplica inert somente ao conteúdo externo;
   - recalcula os elementos focáveis quando surgem resultados;
   - devolve o foco ao botão que abriu a pesquisa;
   - não disputa o foco com uma interface ativa do CookieAdmin.

   O Elementor continua responsável por abrir, fechar e animar o painel.
   Este script não altera aparência nem substitui o comportamento nativo.

   Destino: Elementor > Código Personalizado > Fim do <body>
            Condição: site inteiro. Envolver em <script> ao colar.

   O arquivo do repositório contém somente JavaScript puro.

   Depende destas classes aplicadas no Elementor:

   .fachini-busca
   .fachini-header-offcanvas
   .fachini-busca-offcanvas
   .fachini-exit-offcanvas
   ========================================================================== */

(function () {
  'use strict';

  const HEADER_OFFCANVAS = '.fachini-header-offcanvas';
  const ABRIR =
    '.fachini-busca a[aria-label="Abrir pesquisa"]';
  const CAMPO =
    '.fachini-busca-offcanvas input[type="search"], ' +
    '.fachini-busca-offcanvas .e-search-input';
  const COOKIEADMIN =
    '.cookieadmin_law_container, .cookieadmin_cookie_modal';

  const FOCAVEIS = [
    'a[href]:not([tabindex="-1"])',
    'button:not([disabled]):not([tabindex="-1"])',
    'input:not([disabled]):not([type="hidden"]):not([tabindex="-1"])',
    'select:not([disabled]):not([tabindex="-1"])',
    'textarea:not([disabled]):not([tabindex="-1"])',
    '[tabindex]:not([tabindex="-1"])'
  ].join(',');

  let offCanvas = null;
  let acionador = null;

  /* Guarda somente os elementos que ESTE script tornou inertes.
     Assim, nenhum inert preexistente é removido no fechamento. */
  const inertesDoScript = new Set();

  function estaVisivel(elemento) {
    const estilo = getComputedStyle(elemento);

    return elemento.getClientRects().length > 0 &&
      estilo.display !== 'none' &&
      estilo.visibility !== 'hidden' &&
      !elemento.closest('[aria-hidden="true"]') &&
      !elemento.closest('[inert]');
  }

  function cookieAdminAtivo() {
    return Array.from(
      document.querySelectorAll(COOKIEADMIN)
    ).some(estaVisivel);
  }

  function estaAberto() {
    return offCanvas &&
      offCanvas.getAttribute('aria-hidden') === 'false';
  }

  /* A lista é refeita a cada Tab porque os resultados da pesquisa
     aparecem dinamicamente e acrescentam novos links ao diálogo. */
  function obterFocaveis() {
    return Array.from(
      offCanvas.querySelectorAll(FOCAVEIS)
    ).filter(estaVisivel);
  }

  function aplicarInert() {
    let atual = offCanvas;

    while (atual && atual !== document.body) {
      const pai = atual.parentElement;
      if (!pai) break;

      Array.from(pai.children).forEach(function (irmao) {
        if (
          irmao === atual ||
          irmao.matches(COOKIEADMIN) ||
          irmao.inert
        ) {
          return;
        }

        irmao.inert = true;
        inertesDoScript.add(irmao);
      });

      atual = pai;
    }
  }

  function removerInert() {
    inertesDoScript.forEach(function (elemento) {
      elemento.inert = false;
    });

    inertesDoScript.clear();
  }

  function focarPesquisa() {
    const campo = offCanvas.querySelector(CAMPO);
    if (!campo) return;

    /* Dois frames permitem que o Elementor termine a abertura antes
       de transferirmos o foco para o campo. */
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        if (estaAberto() && !cookieAdminAtivo()) {
          campo.focus({ preventScroll: true });
        }
      });
    });
  }

  function devolverFoco() {
    const destino = acionador;
    if (!destino || !destino.isConnected) return;

    requestAnimationFrame(function () {
      if (!estaAberto() && !cookieAdminAtivo()) {
        destino.focus({ preventScroll: true });
      }
    });
  }

  function aoAbrir() {
    if (cookieAdminAtivo()) return;

    aplicarInert();
    focarPesquisa();
  }

  function aoFechar() {
    removerInert();
    devolverFoco();
  }

  /* Registra o elemento que realmente acionou o Off Canvas.
     Enter num link também gera clique e passa por este ponto. */
  document.addEventListener('click', function (evento) {
    const botao = evento.target.closest(ABRIR);
    if (botao) acionador = botao;
  }, true);

  document.addEventListener('keydown', function (evento) {
    if (
      evento.key !== 'Tab' ||
      !estaAberto() ||
      cookieAdminAtivo()
    ) {
      return;
    }

    const focaveis = obterFocaveis();
    if (!focaveis.length) return;

    const primeiro = focaveis[0];
    const ultimo = focaveis[focaveis.length - 1];
    const ativo = document.activeElement;

    /* Se outro script deslocar o foco para fora, o próximo Tab o
       devolve imediatamente ao diálogo. */
    if (!offCanvas.contains(ativo)) {
      evento.preventDefault();
      (evento.shiftKey ? ultimo : primeiro)
        .focus({ preventScroll: true });
      return;
    }

    if (evento.shiftKey && ativo === primeiro) {
      evento.preventDefault();
      ultimo.focus({ preventScroll: true });
      return;
    }

    if (!evento.shiftKey && ativo === ultimo) {
      evento.preventDefault();
      primeiro.focus({ preventScroll: true });
    }
  }, true);

  function iniciar() {
    const header = document.querySelector(HEADER_OFFCANVAS);

    offCanvas = header
      ? header.closest('.e-off-canvas')
      : null;

    if (!offCanvas) return;

    /* Escape, X e clique na sobreposição terminam todos alterando
       aria-hidden. Assim não precisamos duplicar os três fechamentos. */
    new MutationObserver(function () {
      if (estaAberto()) {
        aoAbrir();
      } else {
        aoFechar();
      }
    }).observe(offCanvas, {
      attributes: true,
      attributeFilter: ['aria-hidden']
    });

    if (estaAberto()) aoAbrir();
  }

  if (document.readyState === 'loading') {
    document.addEventListener(
      'DOMContentLoaded',
      iniciar,
      { once: true }
    );
  } else {
    iniciar();
  }
})();
