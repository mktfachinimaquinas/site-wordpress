# CLAUDE.md — Site Fachini Máquinas

## O que é este projeto

Repositório de trabalho do novo site da **Fachini Máquinas**, construído em
**WordPress + Elementor Pro**. Este repositório **não é o site**: o site roda
num servidor. Aqui ficam a documentação, o design system, o CSS customizado
que será colado no Elementor, os mapas de SEO e os scripts de apoio.

- Desenvolvimento: `wordpress.fachinimaquinas.com.br`
- Produção: `fachinimaquinas.com.br`
- **Prazo imediato:** homepage no ar em 2 semanas. Layout finalizado no Figma.

---

## Fonte de verdade

`docs/DOSSIE_FACHINI_projeto_site.md` é a **fonte de verdade** deste projeto.
As seções 1 a 12 são o dossiê; 13 e 14 são adendos de execução e de
posicionamento.

O dossiê é a referência primária do projeto. Ele prevalece sobre sugestões
avulsas e não se rediscute por conveniência. Mas não é imutável: decisões de
quem tem autoridade (dono, diretoria) o atualizam via adendo, e divergências
técnicas devem ser registradas como pendência para decisão — não aplicadas
por conta própria nem ignoradas. Quando algo conflitar com o dossiê, o
procedimento é documentar o conflito, não escolher um lado sozinho.

| Arquivo | O que é |
|---|---|
| `docs/relatorio-analise-homepage.md` | Bloqueadores, riscos de conversão, fila de código customizado |
| `docs/modulo-01-design-system.md` | Guia de execução do design system |
| `design-system/tokens.md` | Valores extraídos do Figma |
| `docs/modulo-02-header.md` | Guia do header em execução |
| `docs/analise-360-ux-seo.md` | Estratégia de UX/UI e SEO |
| `BRIEFING.md` | Documento de continuidade entre conversas |

---

## Stack (travada)

- **Tema:** Hello Elementor (casca vazia)
- **Builder:** Elementor Pro — **toda** página é montada nele, nunca no editor
  de blocos do WordPress. Misturar cria dois sistemas de design paralelos.
- **Performance:** WP Rocket PRO · **SEO:** RankMath PRO
- **Segurança:** Loginizer PRO · **Backup:** Backuply PRO

**ÁRVORE DE NAVEGAÇÃO — em disputa.** O dono da empresa definiu uma árvore
(ver `docs/conflito-arvore-navegacao.md`) que diverge da seção 7.1 do dossiê
em pontos de SEO. Os conflitos estão documentados para defesa junto à diretoria.

**O que está implementado (28/07):** o menu usa "MÁQUINAS" como guarda-chuva,
com as categorias do mapa do dono dentro do dropdown — Perfiladeiras, Laser,
Corte e Dobra, Serralheria. É a conciliação decidida no `modulo-02-header.md`
§1.2: preserva as categorias do dono sem espalhar oito itens na barra.

Não construir páginas de produto sobre estrutura em disputa até a decisão
fechar.

**POSICIONAMENTO — perfiladeira é FABRICAÇÃO Fachini.** Decisão da diretoria
(26/07/2026, seção 14 do dossiê). Sustentado por capacidade instalada: a empresa
tem insumos e estrutura para fabricar cada componente, e há histórico de
refabricação completa. A composição atual de importados é decisão econômica, não
limitação técnica. Finame para perfiladeiras em andamento.

Termos por linha:

| Linha | Como comunicar |
|---|---|
| Perfiladeiras e Calhas | fabricação Fachini |
| CN/CNC e Guilhotinas | marca Fachini, padrão europeu |
| Laser e Solda | **parceria Senfeng** — nunca fabricação |

Evitar "100% nacional" até a conclusão do Finame. Keywords liberadas:
`fabricante de perfiladeiras`, `fábrica de perfiladeiras`, `perfiladeira nacional`.

---

## Design System

### Paleta — 8 cores, fechada

| Nome | Hex | Uso |
|---|---|---|
| Navy Primário | `#15274E` | Títulos, fundos de seção escura |
| Navy Secundário | `#00224E` | Footer, sobreposição em imagem |
| Vermelho | `#E01E26` | CTA — **exclusivo** |
| Vermelho Hover | `#B01319` | Hover de botões |
| Onix | `#0F0F0F` | Corpo de texto |
| Off-white | `#FBFBFB` | Fundo padrão |
| Cinza Névoa | `#F1F3F6` | Seção alternada, cards, contorno de input |
| Cinza Médio | `#5C6675` | Texto de apoio, barras de slide inativas |

**Slots do Elementor:** Primary = Navy Primário · Secondary = Cinza Médio ·
Text = Onix · Accent = Vermelho. As outras quatro como personalizadas, com nome.

**Estados translúcidos não geram cor nova.** Hover do menu = branco a 15%; texto
sobre navy = off-white ~80%; sobreposição de imagem = navy com opacidade.

**Botões sem sombra** (26/07/2026). Superfícies planas — coerente com o
território industrial. Sombra em cards ainda pendente da designer.

### Tipografia — duas famílias, 4 arquivos

| Fonte | Peso | Onde |
|---|---|---|
| **Mitr** | 600 | H1 e H2 — **sempre em CAIXA ALTA** |
| **Archivo** | 400 | Corpo |
| **Archivo** | 600 | H3, H4, H5, menu |
| **Archivo** | 700 | Botões, subtítulo do hero |

- Ambas do Google Fonts, licença SIL OFL. **Hospedadas localmente**, nunca via
  CDN do Google (performance + LGPD).
- **Mitr não tem peso acima de 700.** Mais impacto só via tamanho.
- **Mitr tem o Bold visivelmente mais pesado que o comum.** É uma tipografia de
  origem tailandesa — o alfabeto tailandês exige contraste maior entre pesos, e
  isso se reflete no desenho latino. Na prática, o Bold (700) dela aparenta um
  peso acima do Bold de uma grotesca ocidental típica. Somado à caixa alta, fica
  excessivo. **Por isso o projeto usa 600 (SemiBold)** — não é engano nem
  divergência a corrigir.
- **Mitr só em caixa alta.** Em caixa mista os terminais arredondados aparecem
  e o tom fica macio demais para o território industrial. Headline em caixa
  mista usa Archivo 700.
- **Toska** é exclusiva do logo, em SVG vetorizado. Não é webfont.
- **Roboto está descontinuada.** A página `3 - MARCA` do Figma está desatualizada.
- Não adicionar peso novo sem avaliar custo em Core Web Vitals.

### Escala tipográfica — razão 1.25

**Desktop**

| Nível | Fonte | Peso | Tamanho | Line-height | Tracking | Caixa |
|---|---|---|---|---|---|---|
| H1 | Mitr | 600 | 56px | 1.1 | 0.06em | ALTA |
| H2 | Mitr | 600 | 45px | 1.15 | 0.06em | ALTA |
| H3 | Archivo | 600 | 36px | 1.25 | 0.02em | normal |
| H4 | Archivo | 600 | 29px | 1.3 | 0 | normal |
| H5 | Archivo | 600 | 23px | 1.35 | 0 | normal |
| Corpo | Archivo | 400 | 16px | 1.6 | 0 | normal |
| Corpo pequeno | Archivo | 400 | 14px | 1.6 | 0 | normal |
| Botão | Archivo | 700 | 15px | 1 | 0.05em | ALTA |
| Menu | Archivo | 600 | 15px | 1 | 0 | ALTA |

> **Escala revista em 27/07/2026.** O H1 a 64px ficou grande demais em notebook
> (a 150% de escala do Windows, 64px CSS renderiza como ~1 polegada física). O
> Figma define 56px — a escala foi reconstruída a partir desse valor com razão
> 1.25. **O H3 permanece em 36px**, valor original da designer.
>
> Tamanho de fonte **não influencia SEO.** O que importa no H1 é existir, ser
> único, conter a palavra-chave e estar marcado semanticamente. A escolha é de
> legibilidade, não de ranking.

> **H3 sem transformação de caixa no Theme Style.** Ele aparece em dois
> contextos: "SUPORTE TÉCNICO / INSTALAÇÃO PROFISSIONAL / PÓS VENDA" em caixa
> alta, e títulos de card de notícia em caixa baixa. Forçar maiúsculas
> globalmente quebraria os segundos. A caixa alta é aplicada por seção.

**Mobile** — razão 1.18, proposta (não existe prancheta mobile no Figma)

| Nível | Tamanho | Line-height |
|---|---|---|
| H1 | 32px | 1.15 |
| H2 | 27px | 1.2 |
| H3 | 23px | 1.3 |
| H4 | 19px | 1.35 |
| H5 | 17px | 1.4 |
| Corpo | 16px | 1.65 |

**Corpo nunca abaixo de 16px no mobile** — o Safari do iOS dá zoom automático
em campo de formulário com fonte menor, e a página saltaria no formulário de
orçamento.

**Line-height do H1 e H2 nunca abaixo de 1.1.** Em português, acentos em caixa
alta ficam acima da altura das maiúsculas — a 1.02 o acento encosta na linha
de cima.

### Larguras — sistema de 4 camadas

O Figma foi desenhado em prancheta de 1920px com conteúdo de 1558px. Isso não
vai direto para o Elementor: notebook de 1366 e escala do Windows a 125% (que
entrega 1536px de viewport) são comuns.

| Camada | Largura | Onde |
|---|---|---|
| Full-bleed | 100% | Hero, seções navy, banner de CTA, footer |
| Larga | `min(94vw, 1560px)` | Mosaico, grid de notícias, estatísticas |
| Padrão | 1200px | Maioria das seções — **Content Width do Elementor** |
| Texto | 720px | Parágrafo corrido |

Motivo das camadas: imagem e grid querem largura; texto corrido quer estreiteza
(acima de ~75 caracteres por linha a leitura despenca). Uma medida única não
serve aos dois.

### Espaçamento — escala base 8px

```
8 · 16 · 24 · 32 · 48 · 64 · 96 · 128
```

Padding vertical de seção: 96px desktop / 56px mobile.

---

## Hierarquia de headings

**Nível de heading é significado, não tamanho.** O H1 é o assunto da página,
não o texto maior. A hierarquia serve ao Google e ao leitor de tela.

**Homepage:**

| Nível | Elementos |
|---|---|
| H1 | Hero — **um só por página** |
| H2 | "Aumente a produtividade", "Tecnologia que transforma", "Notícias", "Solicite seu orçamento", título de cada aba do mosaico |
| H3 | "Suporte técnico", "Instalação profissional", "Pós venda", títulos dos cards de notícia |

**Armadilhas:**
- "Aumente a produtividade" é **H2**, apesar de estar em Mitr grande. Dois H1
  deixam o Google sem saber qual é o assunto.
- **"+50", "+30", "+300" NÃO são heading.** São dados — texto comum estilizado
  grande. Marcados como H2, entram na estrutura do documento.
- Links do footer não são heading.

**Páginas internas:** H1 é o nome da máquina ou categoria, sempre com a
palavra-chave. Nunca "Bem-vindo" ou "Conheça nossa linha".

**Tamanho visual pode variar dentro do mesmo nível.** Título de card de notícia
é H3 semanticamente mas pode ter 24px em vez de 36px. O que não se faz é
rebaixar para H4 só porque é menor.

---

## Status dos módulos

**Módulo 1 — Design System: CONCLUÍDO em 26/07/2026.** Executado no Elementor:
Global Colors (8 cores), Global Fonts (4 slots), Theme Style completo
(tipografia H1–H6, corpo, links, botões), Content Width 1200px, Layout padrão
Elementor Largura Total, variáveis de espaçamento no Custom CSS. Teste de
herança validado em página de rascunho.

**Módulo 2 — Header: EM EXECUÇÃO; próximo foco: responsividade.**

Concluído: menu criado no WordPress, template de cabeçalho, containers
aninhados (externo 100% + interno herdando o global), widgets de menu e busca,
posicionamento absoluto funcionando — o header flutua sobre o hero.

Classes CSS do header: `fachini-header`, `fachini-logo`, `fachini-menu` e
`fachini-busca`. O Off Canvas usa `fachini-header-offcanvas`,
`fachini-logo-offcanvas`, `fachini-menu-offcanvas`,
`fachini-exit-offcanvas` e `fachini-busca-offcanvas`.

Concluído até o passo 6: fundo condicional por `body.home`, hover do menu em
pílula, chevron por opacidade, dropdown com deslize e barra vermelha em
pseudo-elemento. CSS versionado em `css/global.css` e `css/header.css`.

**Dropdown por clique aplicado e verificado.** Clique, Enter, Espaço, Escape,
devolução de foco e alternância de `aria-expanded` foram testados no site. O
JavaScript puro está versionado em `scripts/header.js`; no Elementor ele é
publicado dentro de `<script>...</script>`.

**A busca expansível inline foi substituída pelo Off Canvas nativo.** A versão
desktop está aplicada e verificada: abertura/fechamento, foco inicial, contenção
do Tab, devolução de foco, busca ao vivo, Loop Item, navegação do card, estado
sem resultado, paletas e logos condicionais. O comportamento de foco está em
`scripts/search-offcanvas.js`; a aparência permanece no painel e em
`css/header.css`.

Próximo foco: tablet e mobile. Continuam pendentes as páginas reais das
máquinas, os links do bloco EXPLORAR, as exclusões da consulta e o fallback
final. Sticky e o rótulo Lisa/Dentada permanecem nas decisões já registradas.

---

## Escopo da entrega de 2 semanas

- Hero em slider **sem vídeo** — remove o maior risco de CWV mobile
- Scrollytelling **adiado** para depois do go-live. No lançamento: sticky via
  Elementor + fade simples
- **Rótulo da linha Lisa/Dentada em aberto.** "Serralheria" é segmento e não
  produto, mas "Calhas" subdimensiona a máquina (dentes ajustáveis, dobra 2mm
  carbono / 1mm inox — faz painel elétrico, duto de refrigeração, caixa). Fica
  para teste A/B pós-lançamento. **Não sugerir troca de rótulo até lá.**
- Divisão: Wilson prepara a fundação (Estilos Globais, header, footer, template
  mestre); designer monta as seções herdando o sistema

---

## Meu nível técnico (calibre por isto)

Wilson, comercial da Fachini e líder do projeto. Perfil estratégico, direto,
orientado a resultado.

Em programação sou **iniciante**: 4 meses de curso fullstack Node.js sem
concluir, noção de HTML básico. Boa noção de WordPress, já usei Elementor sem
me aprofundar. Entendo servidores, segurança e performance no nível de **gestor
técnico**.

**Aprendizados alvo:** VS Code, CSS no contexto do Elementor, Node.js (sem
pressa — fora do caminho crítico).

---

## Arquitetura de conversas

O projeto usa uma conversa **central** (dona do estado, atualiza os documentos)
e conversas de **módulo** (executam escopo fechado, reportam de volta).

Conversas de módulo **não editam** `controle-projeto.md`, `BRIEFING.md` nem
este arquivo. Se identificarem algo que precisa entrar, reportam — a central
registra.

Detalhamento na Parte 0 do `BRIEFING.md`.

**A central segue o protocolo de blindagem da Parte 0B** — sete gatilhos com
verificações obrigatórias, cada um existindo porque o erro correspondente já
aconteceu neste projeto.

---

## Como trabalhar comigo

1. **Não escreva código por mim.** Explique o conceito, aponte a direção e
   revise o que eu escrevi. Só escreva código completo se eu pedir com a
   palavra **"escreve"**.
2. **Explique tudo que entregar.** Quero saber o que cada parte faz.
3. **Nunca me deixe aceitar código que eu não sei explicar.**
4. **Exceção:** configuração não ensina nada. `.gitignore`, `package.json` e
   afins pode entregar prontos.
5. **Comunicação direta.** Se algo que eu propus está errado, diga.
6. **Passos pequenos.** Propõe, eu valido, avançamos.

---

## O que NÃO fazer

- **Não sugira frameworks de frontend.** Nada de React, Vue, Next, Tailwind ou
  build tools. O destino do CSS é o campo de CSS customizado do Elementor.
- **Não tente gerar página a partir do Figma.** Não existe caminho automático
  Figma → Elementor.
- **Não instale dependência sem necessidade real.**
- **Não invente informação sobre empresa, produtos ou preços.** Se não estiver
  no dossiê, pergunte.
- **Cuidado com posicionamento de produto.** Perfiladeiras e calhas =
  fabricação Fachini. Laser = parceria Senfeng, nunca fabricação. Erro aqui é
  comercial, não técnico.
- **Não instalar plugin sem avaliação.** Cada plugin carrega CSS/JS em todas as
  páginas e concorre com a meta de CWV verde no mobile. Verificar antes se o
  Elementor Pro já resolve nativamente. Descartado em 26/07/2026: Ultimate
  Addons for Elementor (redundante).
- **Antes de sugerir CSS ou JS, verifique se o Elementor resolve no painel.**
  Este projeto é quase todo painel. O CSS customizado cobre design system e
  header. Há dois scripts pontuais: `scripts/header.js`, para o dropdown por
  clique e teclado, e `scripts/search-offcanvas.js`, para foco e contenção de
  teclado no Off Canvas. Ambos estão aplicados e foram verificados no desktop.
  Estrutura, consulta e a maior parte da aparência continuam nos controles do
  Elementor.

  CSS que duplica função nativa é manutenção sem motivo — e sai do alcance da
  designer, que ajusta o painel sozinha.

  Quando eu disser que resolvi algo, **não presuma que houve código.**
  Pergunte como foi feito.

---

## Estrutura do repositório

```
site-wordpress/
├── CLAUDE.md
├── .gitignore · .gitattributes · .editorconfig
├── docs/                  # dossiê, relatórios, guias de módulo
├── design-system/         # tokens extraídos do Figma
├── css/                   # CSS customizado para o Elementor
├── seo/                   # mapa de páginas, keywords, titles
└── scripts/               # JS colado no Elementor (Código Personalizado)
```
