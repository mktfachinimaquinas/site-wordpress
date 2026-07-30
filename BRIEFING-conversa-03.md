# BRIEFING DE CONTINUIDADE — Conversa Central 03

**Gerado em:** 30/07/2026
**Origem:** conversa central 02, encerrada por limite de contexto
**Módulo em execução:** 2 — Header · **Passo 9 de 11**

---

# PARTE A — MENSAGEM DE ABERTURA

> Cola isto como primeira mensagem da conversa nova, com os anexos listados
> na Parte G.

```
Retomando o projeto do site da Fachini Máquinas. Esta é a conversa CENTRAL:
dona do estado, audita consistência, decide prioridade, gera briefing de
módulo. Não faz execução detalhada.

Antes de responder qualquer coisa, leia neste briefing:
- a PARTE 0B (protocolo de blindagem) — sete gatilhos com verificação
  obrigatória, cada um existe porque o erro correspondente já aconteceu
- a PARTE 1B (o projeto é quase todo painel do Elementor)
- a PARTE F deste documento (erros da sessão anterior)

REGRA QUE VALE PARA TUDO: status carrega método de verificação, e os três
estados são distintos — escrito · aplicado · verificado. Documento correto
não prova sistema correto. Antes de afirmar estado, confira no
controle-projeto.md; antes de mapear algo que eu disse, pergunte o que
exatamente foi feito.

Contexto é caro. Os arquivos ficam no disco entre os turnos — a partir de
agora eu anexo só o que mudou.

Confirme que absorveu com um resumo curto do estado real e me diga qual é
a próxima ação. Não comece a executar antes disso.
```

---

# PARTE B — ESTADO REAL, POR NÍVEL DE VERIFICAÇÃO

## B1. Verificado

| Item | Como foi verificado |
|---|---|
| **Passo 7 — dropdown por clique** | Janela anônima, sem interação prévia: o primeiro clique abre. `aria-expanded` alterna `true`/`false` no inspetor |
| **Enter abre e fecha o submenu** | Testado pelo Wilson. Funciona **sem código próprio** — o navegador sintetiza um clique ao pressionar Enter num link em foco |
| **Home é página estática** | Código-fonte: `body class="home ... page-id-497 ... elementor-template-full-width"` |
| **Content Width 1200** | Aplicado no Elementor e propagado em 7 arquivos |
| **`scroll-behavior` no consolidado** | Presente no `elementor-css-completo.txt` |
| **Classe `fachini-busca` duplicada** | Corrigida — só no container, confirmado no HTML |
| **Largura do logo (208px)** | Resolvida travando o encolhimento do container |
| **Atraso de JS do WP Rocket não engole o primeiro clique** | Teste em anônima sem mover o mouse |

## B2. Verificado como QUEBRADO

| Item | Evidência |
|---|---|
| **Esc não fecha o dropdown** | Testado pelo Wilson. Não havia nenhum `keydown` no script |
| **Espaço provavelmente não abre** | Não testado. Em link, Espaço rola a página e não gera clique — comportamento de botão, não de link |
| **Skip link aponta para o vazio** | `<a href="#content">` existe, mas nenhum elemento tem `id="content"` no template Largura Total |
| **Logo com lazyload** | `data-lazy-src` no header **e** no rodapé. Elemento acima da dobra dependendo de script |
| **Title e description da home** | A caixa de SEO da página 497 está vazia. Title virou `HOME - Fachini Máquinas \| ...`. `<meta name="description">` **não existe mais** no código-fonte |

## B3. Escrito, NÃO aplicado

Tudo isto foi entregue na sessão anterior e está nos anexos. Nada foi
colado no site nem commitado.

| Arquivo | O que mudou |
|---|---|
| `scripts/header.js` | Esc (com devolução de foco) e Espaço. Fecha a §4.0b |
| `css/global.css` | Seção 3 nova — `prefers-reduced-motion` geral. Item 8.3 da revisão de blindagem |
| `css/elementor-css-completo.txt` | Regenerado com a seção 3 |
| `css/header.css` | Sem alteração desde 29/07 — incluído para o commit ficar completo |

**Nada foi commitado em 29 nem em 30/07.**

## B4. Nunca testado

| Item | Por quê importa |
|---|---|
| **Mobile / hambúrguer** | Nunca foi aberto num celular desde o início do módulo. O passo 10 inteiro depende disso, e a correção de escopo do `--main` pode ter consertado um rasgo de branco que ninguém viu |
| **Onde está o padding horizontal de 24px** | Se estiver no container interno, o conteúdo começa 21px além do Figma. Tem que estar no **externo** — ver C3 |
| **Resíduo `e-transform` no `fachini-logo`** | Escala vazia, efeito nenhum, mas adiciona classe e `data-settings` que o JS do Elementor processa |

---

# PARTE C — FILA IMEDIATA

## C1. Aplicar o que já está escrito (30 minutos, sem dependência)

1. `header.js` — Elementor — Código Personalizado, envolvido em `<script>`, fim do `<body>`, condição site inteiro
2. `elementor-css-completo.txt` — Configurações do Site — CSS Personalizado, substituindo tudo
3. Limpar as três camadas de cache
4. **Verificar:** Tab até "MÁQUINAS" · Enter abre · Esc fecha e o foco volta ao item · Espaço abre sem rolar a página
5. Commitar os quatro arquivos

Convenção do README:
```
feat: acrescenta Esc e Espaco ao dropdown do header
style: respeita prefers-reduced-motion em todo o site
chore: regenera css consolidado do elementor
```

## C2. Dois minutos cada, independentes de tudo

- **Title e description** na caixa de SEO da página 497. Os textos que se perderam na virada para página estática e que devem voltar:
  - Title: `Fachini Máquinas | Perfiladeiras Industriais e Corte a Laser`
  - Description: `Fabricante nacional de perfiladeiras de telhas e fornecedora de máquinas de corte e solda a laser Senfeng, guilhotinas e dobradeiras hidráulicas industriais.`
- **Excluir o logo do lazyload** no WP Rocket — Mídia — Excluir do LazyLoad. Vale para o header e o rodapé
- **Zerar o `e-transform`** do container `fachini-logo`

## C3. Conferir antes de montar o hero

**Onde está o padding horizontal de 24px do header.**

| Onde está | Borda do conteúdo a 1366 | Desvio do Figma |
|---|---|---|
| Container **interno** (o de 1200) | 107 | 21px |
| Container **externo** (largura total) | 83 | 3px |

Tem que estar no **externo**, nos dois — header e hero. É o que faz o logo
alinhar com o H1 abaixo dele, e a proteção contra tela estreita continua
igual: abaixo de 1248px de viewport o padding empurra o conteúdo para dentro
do mesmo jeito.

## C4. Montar o hero

Receita completa na Parte D. **Não precisa de uma linha de CSS.**

## C5. Depois do hero

- Passo 10 — mobile. Começa abrindo o site num celular
- Passo 11 — logo, já resolvido; falta só a largura por breakpoint
- Passo 8 — busca expansível. **Bloqueado** pela pendência 19 (transição suave ou seca), que agora é decisão do Wilson, e pela decisão de a busca subir ou não no lançamento

---

# PARTE D — RECEITA DO HERO

## D1. Os números do Figma e o que eles provaram

Prancheta 1366. Imagem do hero: container de **1440 × 782**, com uma foto de
1556,98 × 1040,35 encaixada e recortada dentro dele.

| Medida | Valor |
|---|---|
| Altura do hero | **782px** |
| Bloco de conteúdo | 734 × 314, em x=86 · y=266 |
| Busca (estática) | 178 × 35, em x=1102 · y=25,5 |
| Logo | 208 × 39,51, topo em 36 |

**O conteúdo está centrado, mas em 1194 e não em 1200.** A busca termina em
1102 + 178 = 1280; o bloco começa em 86. Centro em 683, que é 1366 ÷ 2.
Largura real: 1194. Com Content Width 1200 as bordas caem em 83 e 1283 —
3px por lado. Mantido 1200.

**Os espaçamentos do `tokens.md` §7 foram confirmados por dedução:**

| | |
|---|---|
| H1 — 56px × 1.1, duas linhas | 123,2 |
| Espaço título — texto | **24** |
| Subtítulo — 23px × 1.4, três linhas | 96,6 |
| Espaço texto — botão | **32** |
| Botão | ~38 |
| **Total** | **313,8** contra os 314 medidos |

Os 24 e 32 que já estavam registrados são exatamente os que a designer usou.

## D2. Container externo

| Controle | Valor |
|---|---|
| Largura do conteúdo | Largura total |
| Altura mínima | **782px** |
| Alinhar itens | Início |
| Padding | topo **266** · direita **24** · baixo **0** · esquerda **24** |
| Avançado — CSS ID | `content` |

Altura **mínima**, não altura: se um texto crescer, o hero cede em vez de
estourar. O `CSS ID: content` conserta o skip link do tema — item do passo 9
resolvido de graça agora, caro depois de montado.

Com min-height 782 e padding-top 266 sobram 516 para o conteúdo. O bloco tem
314. Restam 202 abaixo — a proporção exata do Figma.

**Estilo:**

| Controle | Valor |
|---|---|
| Fundo — Clássico — Imagem | o frame exportado |
| Posição | Centro Centro |
| Repetição | Sem repetição |
| Tamanho | **Cobrir** |
| Sobreposição — Gradiente | preto 35% no topo — transparente em 33% |

## D3. Container interno

| Controle | Valor |
|---|---|
| Largura do conteúdo | Caixa — **deixar o campo vazio** para herdar os 1200 |
| Padding | tudo 0 |

## D4. Bloco de texto (container filho do interno)

| Controle | Valor |
|---|---|
| Largura | Personalizada, **734px** |
| Direção | Coluna |
| Espaço entre | **24px** |

## D5. Widgets

| Widget | Configuração |
|---|---|
| Título | Tag **H1** · `AQUI VOCÊ ENCONTRA A PERFILADEIRA IDEAL` · cor Off-white |
| Título | Tag **p** · Archivo 700 · 23px · 1.4 · MAIÚSCULAS · cor Off-white |
| Botão | `SOLICITE UM ORÇAMENTO` · Avançado — Margem **8px** no topo |

O subtítulo vai como widget Título com tag `p`, não como Editor de Texto — o
Editor herda o corpo (Archivo 400/16px) e exigiria sobrescrever tudo.

Os 8px de margem do botão somam com os 24 do container e dão os **32** da
tabela. Os dois valores estão na escala de 8px.

**O H1 é provisório.** A pendência 3 da §2.2 registra que o texto final ainda
não existe. Sem essa nota ele vira definitivo por inércia.

## D6. A imagem

**Exportar o frame de 1440 × 782, não a foto.** A foto é proporcionalmente
mais alta que o container (1,497 contra 1,841) e está recortada no Figma por
decisão de composição. Exportando o frame, o recorte vem embutido e o
navegador não precisa adivinhar onde cortar.

| | |
|---|---|
| Resolução | 2x, se a foto original tiver pixels para isso |
| Formato | WebP |
| Nome | `hero-perfiladeira-fachini.webp` |
| WP Rocket | **excluir do lazyload** — é o LCP da página |

**Recorte no navegador, por viewport:**

| Viewport | O que acontece |
|---|---|
| 1366 | Corta 74px de largura — irrelevante |
| 1440 | Encaixe exato |
| 1920 | Corta **260px de altura**, 130 em cima e 130 embaixo |

Consequência que define a escolha das fotos: **o assunto precisa estar na
faixa central vertical.** E se a designer protegeu o menu deixando o topo da
foto escuro, em 1920 essa proteção some junto com os 130px de cima — o
gradiente de sobreposição deixa de ser reforço e passa a ser o que segura o
menu off-white. Não remover.

---

# PARTE E — DIVERGÊNCIAS ABERTAS COM A DESIGNER

| # | Item | Situação |
|---|---|---|
| — | **Alinhamento vertical do header** | No Figma a busca está centralizada nos 86px (centro em 43) e o logo está 12,75px abaixo do centro (topo em 36, centro em 55,76). Implementado com os dois centralizados. Confirmar se o 36 foi medido no logo ou num grupo em volta |
| — | **Largura do conteúdo** | Figma entrega 1194px; implementado 1200. Diferença de 3px por lado |
| 19 | **Transição da busca** | Suave ou seca. Bloqueia o passo 8. Agora é decisão do Wilson |
| 20 | **Camada "Larga" a 1200px** | `min(94vw, 1560px)` entrega 1284 numa tela de 1366 — 84px acima do padrão. Ou ganha número novo, ou o mosaico vira full-bleed |
| 18 | **Hierarquia de headings** | Alinhar a marcação semântica antes da montagem das seções |

Registrado em 29/07: **a designer não monta a home.** Wilson assume a
montagem; ela entra depois do lançamento, com a home como template mestre.

---

# PARTE F — ERROS DA SESSÃO ANTERIOR

> Escritos aqui porque são a base empírica da Parte 0B. A conversa nova não
> deve repeti-los.

**1. Presumi execução a partir de uma frase ambígua.** Ele disse "o menu
consegui resolver" e eu mapeei isso no passo 7 sem perguntar o que
exatamente. A suposição virou linha no `CLAUDE.md`, depois no BRIEFING,
depois no guia. Quatro documentos afirmando um passo que nunca tinha sido
executado. — *Antes de mapear algo que ele disse, pergunte o quê e como.*

**2. Auditei documento contra documento.** Escrevi "confirmei tudo" sobre um
conjunto de arquivos internamente consistentes a respeito de um estado que
não existia. — *Auditoria se ancora fora dos documentos.*

**3. Mandei colar JavaScript num campo que só lê CSS.** Entreguei um `.js` e
um `.txt` no mesmo lote e apontei "CSS Personalizado" e "Código
Personalizado" sem dizer que são menus completamente diferentes — Código
Personalizado nem fica no editor do Elementor, fica na barra lateral do
WordPress. Ele colou o JS no CSS e todo o estilo do header caiu. —
*Instrução de destino precisa dizer onde a tela fica.*

**4. Registrei "verificado por código-fonte" a partir de um fragmento do
inspetor.** O inspetor mostra o DOM depois do lazyload resolver; o `src`
aparece preenchido de qualquer jeito. Código-fonte é `Ctrl+U`. — *O método
de verificação faz parte do registro, e tem que ser o método certo.*

**5. Afirmei que a fonte Inter estava sendo carregada.** Era declaração
`@font-face` do WordPress, e declaração não baixa arquivo — só baixa se
alguma regra usar a família.

**6. Recomendei criar variáveis `--cor-*` no `global.css`.** O Elementor já
expõe as cores globais como variáveis; criar as nossas teria produzido uma
segunda fonte de verdade para a paleta. A escolha dele foi melhor.

**7. Sugeri testar com dois scripts ativos ao mesmo tempo.** Os dois ouvem no
`document` e alternam a mesma classe — o clique dispara os dois e eles se
anulam. `stopPropagation` não impede outro ouvinte no mesmo elemento.

**8. Gerei um arquivo `.css` que era material de leitura, não de colagem.**
Num projeto onde todo `.css` vai colado no painel, a extensão sozinha já era
instrução errada.

## Duas armadilhas técnicas que valem para o futuro

**Nunca acrescentar tratamento de Enter ao `header.js`.** O navegador
sintetiza um clique ao pressionar Enter num link em foco, e o ouvinte de
clique já cobre. Um tratamento de Enter faria o item abrir pelo keydown e
fechar pelo clique sintetizado no mesmo toque.

**O widget de menu renderiza dois menus no HTML** — `--main` no desktop e
`--dropdown` dentro do hambúrguer, ambos com `.elementor-nav-menu`. Qualquer
seletor sem `--main` sequestra o mobile.

---

# PARTE G — ANEXOS DA PRIMEIRA MENSAGEM

**Sempre:**
- Este briefing
- `docs/controle-projeto.md`
- `CLAUDE.md`
- `BRIEFING.md` (Partes 0, 0B, 1B, 11, 11B, 11C)

**Enquanto o módulo em execução for o header:**
- `css/global.css`
- `css/header.css`
- `scripts/header.js`

**Só quando o assunto for estratégia:**
- `docs/DOSSIE_FACHINI_projeto_site.md`
- `docs/analise-360-ux-seo.md`
- `docs/tarefas-designer.md`

---

# PARTE H — REGISTROS A APLICAR NO CONTROLE

Colar em `docs/controle-projeto.md` depois de aplicar e verificar o C1.

**Em §1 — decisões travadas:**

| Data | Decisão | Consequência |
|---|---|---|
| 30/07 | **Padding horizontal vai no container externo** | Header e hero. No interno, o conteúdo começaria 21px além do Figma; no externo, 3px. A proteção contra tela estreita é a mesma |
| 30/07 | **Hero: altura mínima 782px, imagem exportada do frame** | O frame já traz o recorte de composição embutido. A foto crua exigiria traduzir o deslocamento em `background-position` |
| 30/07 | **Espaçamentos internos do hero confirmados em 24 e 32** | Deduzidos dos 314px de altura do bloco. São os mesmos do `tokens.md` §7 |

**Em §2.3 — verificações técnicas, a fazer:**

| Item | Método |
|---|---|
| Esc, Espaço e Enter no dropdown | Tab até "MÁQUINAS", testar as três teclas, conferir que o foco volta ao item após Esc |
| Menu no celular | Abrir em dispositivo real, conferir que o hambúrguer não tem rasgo de branco |
| Padding horizontal do header | Inspetor: largura computada do `e-con-inner` a 1366 deve ser 1200, não 1152 |
| Logo fora do lazyload | `Ctrl+U`, buscar `LOGO.svg` — não pode haver `data-lazy-src` |

**Em §4.1 — checklist de go-live:**

```
- [ ] Testar o menu com JavaScript desabilitado — "Máquinas" precisa
      levar a algum lugar ou o submenu precisa ser alcançável
- [ ] Navegação por teclado completa no header (Tab, Enter, Espaço, Esc)
- [ ] Foco visível em todos os elementos interativos
- [ ] prefers-reduced-motion respeitado nas transições
- [ ] Imagem do hero excluída do lazyload e servida em WebP
```
