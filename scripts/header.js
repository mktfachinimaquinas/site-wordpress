/* ==========================================================================
   HEADER — Site Fachini Maquinas
   --------------------------------------------------------------------------
   Abre o submenu de "MAQUINAS" por clique, em vez de hover, e responde ao
   teclado.

   Destino: Elementor > Codigo Personalizado > Fim do <body>
            Condicao: site inteiro. Envolver em <script> ao colar.

   Depende da secao 5 do css/header.css. Este script nao mostra nem esconde
   nada — ele so liga e desliga a classe .is-open no <li>. Quem faz o painel
   aparecer e o CSS reagindo a essa classe.

   ESCOPO — le antes de mexer:
   O widget de menu renderiza DOIS menus no HTML. O de desktop recebe a
   classe .elementor-nav-menu--main; o que vive dentro do hamburguer recebe
   .elementor-nav-menu--dropdown. Os dois carregam .elementor-nav-menu.

   Por isso o seletor daqui exige --main. No mobile nao existe hover para
   substituir, e o acordeao nativo do Elementor ja funciona por toque.

   O ancoramento em .fachini-header impede que qualquer outro menu de
   navegacao do site — o do rodape, quando existir — herde este
   comportamento sem ninguem pedir.
   ========================================================================== */

(function () {
  'use strict';

  /* Os dois seletores ficam em constantes porque sao usados em varios
     pontos. Se o escopo mudar um dia, muda em um lugar so. */
  const MENU = '.fachini-header .elementor-nav-menu--main';
  const PAI = MENU + ' .menu-item-has-children';

  /* ------------------------------------------------------------------
     ESTADO
     ------------------------------------------------------------------
     Duas coisas mudam juntas e nunca se separam:

       .is-open        vive no <li>  — e o que o CSS enxerga
       aria-expanded   vive no <a>   — e o que o leitor de tela enxerga

     Se so a classe mudar, o menu abre visualmente e continua anunciando
     "recolhido" para quem usa leitor de tela. Isso e pior que nao ter o
     atributo: e informacao errada.

     ':scope > a' significa "o <a> que e filho direto DESTE elemento".
     Sem o ':scope', o querySelector procuraria qualquer <a> la dentro e
     acharia primeiro um link do proprio submenu. */

  function linkDo(li) {
    return li.querySelector(':scope > a');
  }

  function fechar(li) {
    li.classList.remove('is-open');
    const link = linkDo(li);
    if (link) link.setAttribute('aria-expanded', 'false');
  }

  function abrir(li) {
    li.classList.add('is-open');
    const link = linkDo(li);
    if (link) link.setAttribute('aria-expanded', 'true');
  }

  function fecharTodos() {
    document.querySelectorAll(PAI).forEach(fechar);
  }

  /* Abre, fecha, ou troca de um submenu para outro — em um lugar so.
     Usado pelo clique e pela tecla Espaco. */
  function alternar(li) {
    const jaAberto = li.classList.contains('is-open');
    fecharTodos();
    if (!jaAberto) abrir(li);
  }

  /* ------------------------------------------------------------------
     CLIQUE
     ------------------------------------------------------------------
     Um unico ouvinte no document, em vez de um por link.

     Vantagem: continua valendo se o Elementor reconstruir o menu no DOM,
     e nao depende da ordem de carregamento dos scripts.

     O 'true' no final ativa a FASE DE CAPTURA. O navegador entrega o
     evento de cima para baixo (document -> elemento clicado) antes de
     devolver de baixo para cima. Ouvindo na captura, este codigo roda
     antes do SmartMenus, que e a biblioteca de menu do Elementor.

     A TECLA ENTER JA FUNCIONA POR AQUI — nao precisa de codigo proprio.
     O navegador sintetiza um evento de clique quando alguem pressiona
     Enter num link em foco. Se alguem acrescentar um tratamento de Enter
     no keydown abaixo, o item vai abrir e fechar no mesmo toque. */

  document.addEventListener('click', function (e) {
    const link = e.target.closest(PAI + ' > a');

    if (link) {
      /* "MAQUINAS" aponta para # e nao tem pagina de categoria (decisao
         registrada — pendencia 21). Sem preventDefault, o clique jogaria
         a pagina para o topo alem de abrir o submenu. */
      e.preventDefault();

      /* Impede o SmartMenus de processar este clique e reabrir o painel
         por conta propria.

         EFEITO COLATERAL CONHECIDO: na fase de captura, stopPropagation
         impede que QUALQUER outro script veja este clique — rastreio do
         GTM incluso. Aceitavel aqui porque o item nao leva a lugar nenhum
         e nao e CTA. Nao replicar este padrao em botao de conversao. */
      e.stopPropagation();

      alternar(link.closest('.menu-item-has-children'));
      return;
    }

    /* Clique fora do menu fecha o que estiver aberto.
       A fronteira e o widget de menu, nao o header inteiro — assim clicar
       no logo ou na busca tambem fecha, que e o esperado. */
    if (!e.target.closest('.fachini-header .elementor-widget-nav-menu')) {
      fecharTodos();
    }
  }, true);

  /* ------------------------------------------------------------------
     TECLADO
     ------------------------------------------------------------------
     Nao usa fase de captura: nada disputa estas teclas com a gente.

     ESC — fecha o submenu aberto e DEVOLVE O FOCO ao item pai.

     A devolucao do foco nao e refinamento: se o foco estivesse dentro do
     submenu que acabou de sumir, ele ficaria preso num elemento invisivel
     e a navegacao por teclado quebraria no proximo Tab.

     ESPACO — abre e fecha, como o Enter.

     Num link, a tecla Espaco rola a pagina por padrao e NAO gera clique
     (isso e comportamento de botao, nao de link). Por isso ela precisa de
     tratamento proprio, e por isso o preventDefault: sem ele, o submenu
     abriria e a pagina rolaria junto. */

  document.addEventListener('keydown', function (e) {

    if (e.key === 'Escape') {
      const aberto = document.querySelector(PAI + '.is-open');
      if (!aberto) return;

      const link = linkDo(aberto);
      fecharTodos();
      if (link) link.focus();
      return;
    }

    if (e.key === ' ') {
      const link = e.target.closest(PAI + ' > a');
      if (!link) return;

      e.preventDefault();
      alternar(link.closest('.menu-item-has-children'));
    }
  });
})();
