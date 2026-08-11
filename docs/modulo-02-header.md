# Módulo 2 — Header

**Projeto:** Site Fachini Máquinas
**Pré-requisito:** Módulo 1 concluído (design system cadastrado)
**Objetivo:** construir o cabeçalho do site — a peça que aparece em todas as
páginas e concentra a maior parte do código customizado do projeto.

**Status: desktop aplicado e verificado; responsividade em execução**
(atualizado em 11/08/2026)

| # | Passo | Status |
|---|---|---|
| 1 | Menu no WordPress | ✅ |
| 2 | Template + containers aninhados | ✅ |
| 3 | Widgets de menu e busca | ✅ |
| 4 | Posicionamento absoluto — flutua sobre o hero | ✅ |
| 5 | Fundo e paleta condicionais | ✅ desktop verificado |
| 6 | CSS dos hovers | ✅ |
| 7 | **Dropdown por clique (JS)** | ✅ clique, Enter, Espaço, Escape, foco e `aria-expanded` verificados |
| 8 | **Busca em Off Canvas** | ✅ desktop aplicado e verificado |
| 9 | Acessibilidade de teclado | ✅ desktop verificado no menu e no Off Canvas |
| 10 | Tablet e mobile | ⬅ atual — falta validar e ajustar |
| 11 | Logos SVG condicionais | ✅ negativo na Home; positivo nas internas |

**Classes do header:** `fachini-header` · `fachini-logo` · `fachini-menu` ·
`fachini-busca`

**Classes do Off Canvas:** `fachini-header-offcanvas` ·
`fachini-logo-offcanvas` · `fachini-menu-offcanvas` ·
`fachini-exit-offcanvas` · `fachini-busca-offcanvas`

**Rótulo "Serralheria":** mantido por ora. A decisão de 27/07 adiou a troca
para teste A/B pós-lançamento — "Serralheria" é segmento e não produto, mas
"Calhas" subdimensiona a máquina (dentes ajustáveis, dobra 2mm carbono / 1mm
inox, faz painel elétrico e duto de refrigeração). Ver seção 6.4 do
`controle-projeto.md`. **Não sugerir a troca até o teste.**

---

## Por que o header é o módulo mais difícil

Ele reúne o dropdown por clique e a busca em Off Canvas. O Off Canvas, a busca,
a consulta, os acionadores e a maior parte da aparência foram resolvidos pelo
painel do Elementor. O código customizado ficou restrito ao comportamento do
dropdown e à gestão de foco do diálogo.

É também onde você aprende **flexbox** — o sistema que organiza praticamente
todo layout na web moderna, e que o próprio Elementor usa por baixo dos
containers.

Depois deste módulo, montar seção é repetição. Aqui é onde se aprende.

---

## Parte 1 — Anatomia do header

### 1.1 O que ele contém

```
┌────────────────────────────────────────────────────────────┐
│  [LOGO]        HOME  MÁQUINAS▾  QUEM SOMOS  BLOG  CONTATO   [🔍]  │
└────────────────────────────────────────────────────────────┘
```

| Elemento | Comportamento |
|---|---|
| Logo | Link para a home. **SVG**, não PNG |
| Menu | 5 itens. "MÁQUINAS" abre dropdown |
| Busca | Ícone que expande em campo de largura total |

### 1.2 Estrutura do menu

Decisão: manter o guarda-chuva "MÁQUINAS" do mockup, com as categorias do mapa
do dono dentro do dropdown.

```
HOME
MÁQUINAS ▾
   ├── Perfiladeiras
   ├── Laser
   ├── Corte e Dobra
   └── Serralheria
QUEM SOMOS
BLOG
CONTATO
```

**Por quê:** oito itens soltos na barra ficam apertados em 1200px, diluem a
navegação e pioram no mobile. O guarda-chuva preserva todas as categorias do
mapa e mantém o header respirável.

### 1.4 "Máquinas" precisa ser botão, não link

**Decisão de 28/07:** não haverá página de categoria. O item existe apenas para
abrir o submenu.

Isso muda o que ele precisa ser. Hoje é um link customizado apontando para `#`.
Com **hover** isso não incomoda — ninguém clica no pai. Com **clique**, o mesmo
gesto dispara duas coisas: abre o submenu **e** navega para `#`, o que salta a
página para o topo.

E no teclado, link com `#` recebe Enter e navega. Para ser um abridor de
submenu, ele precisa se comportar como **botão**.

**Spec completa do passo 7:**

| # | Comportamento |
|---|---|
| 1 | Abre ao clicar no item |
| 2 | Não abre mais no hover |
| 3 | **Impede a navegação padrão do link** (não salta para `#`) |
| 4 | **Alterna `aria-expanded`** entre `true` e `false` |
| 5 | Enter e Espaço abrem, em vez de navegar |
| 6 | Esc fecha |
| 7 | Clicar fora fecha |

Os itens 3 a 6 vêm da decisão de não ter página. Sem eles, o passo 9
(acessibilidade de teclado) não tem o que fechar — o item principal do menu
ficaria inalcançável por teclado.

Ver §4.0b do `controle-projeto.md`.

**Aplicado e verificado no site.** `scripts/header.js` está versionado como
JavaScript puro e publicado no Elementor dentro de `<script>...</script>`.
Clique, Enter, Espaço, Escape, clique fora, devolução de foco e alternância de
`aria-expanded` foram testados. O primeiro clique também foi verificado em
janela anônima após o ajuste do WP Rocket.

---

> **Registrado como pendência:** o relatório de análise aponta que faltam
> "Soluções" no menu e telefone/WhatsApp no header (bloqueadores 1.3 e 1.4).
> Ambos ficam para quando as decisões correspondentes fecharem. A estrutura
> construída aqui comporta os dois sem redesenho.

### 1.3 Comportamentos a implementar

| # | Comportamento | Onde |
|---|---|---|
| 1 | Hover nos itens: retângulo arredondado cinza translúcido | CSS |
| 2 | "MÁQUINAS": chevron ▾ aparece no hover | CSS |
| 3 | Dropdown abre por **clique**, não por hover — **ver 1.4** | JS |
| 4 | Itens do dropdown: deslocamento lateral no hover, marcador vermelho | CSS |
| 5 | Botão de busca abre o Off Canvas nativo | Painel |
| 6 | X, Escape e clique fora fecham a busca | Painel + gestão de foco em JS |
| 7 | Navegação por teclado e devolução de foco | JS |

---

## Parte 2 — Flexbox: o conceito

Esta parte é teoria, e vale a leitura antes de tocar no Elementor. Sem ela, os
controles do painel são botões misteriosos.

### 2.1 O problema que o flexbox resolve

Antes do flexbox, alinhar três elementos numa linha — um à esquerda, um ao
centro, um à direita — exigia gambiarra. Flexbox resolve com duas linhas de CSS.

A ideia central: **você declara um container como flex, e ele passa a organizar
seus filhos ao longo de um eixo.**

```css
.header {
  display: flex;
}
```

Só isso já coloca logo, menu e busca lado a lado, em vez de empilhados.

### 2.2 Os dois eixos

Flexbox trabalha com dois eixos, e confundir os dois é o erro mais comum:

- **Eixo principal** — a direção em que os itens se organizam. Horizontal por
  padrão
- **Eixo cruzado** — o perpendicular. Vertical, por padrão

Isso importa porque as propriedades de alinhamento são diferentes para cada eixo.

### 2.3 As quatro propriedades que resolvem 90% dos casos

**`justify-content`** — distribui no eixo **principal** (horizontal):

| Valor | Efeito |
|---|---|
| `flex-start` | Tudo grudado à esquerda |
| `center` | Tudo agrupado no centro |
| `flex-end` | Tudo grudado à direita |
| `space-between` | Primeiro na ponta esquerda, último na direita, sobra distribuída no meio |
| `space-around` | Espaço igual em volta de cada item |

Para o header, `space-between` é o que joga o logo para a esquerda e a busca
para a direita automaticamente.

**`align-items`** — alinha no eixo **cruzado** (vertical):

| Valor | Efeito |
|---|---|
| `center` | Todos centralizados verticalmente ← quase sempre este |
| `flex-start` | Alinhados pelo topo |
| `stretch` | Esticados na altura toda |

`center` é o que faz o logo, o texto do menu e o ícone de busca ficarem na mesma
linha visual mesmo tendo alturas diferentes.

**`gap`** — espaço entre os itens. Substitui a antiga gambiarra de aplicar
margem em cada filho e depois remover a do último.

**`flex`** (aplicada ao filho, não ao container) — controla como o item cresce
ou encolhe:

- `flex: 1` — "ocupe todo o espaço que sobrar"
- `flex: 0` — "fique do meu tamanho natural"

É isso que faz o campo de busca expandir e o logo permanecer do tamanho dele.

### 2.4 Onde isso aparece no Elementor

Containers do Elementor **são** flexbox. Os controles do painel são as mesmas
propriedades com nome traduzido:

| Painel do Elementor | Propriedade CSS |
|---|---|
| Direção | `flex-direction` |
| Justificar conteúdo | `justify-content` |
| Alinhar itens | `align-items` |
| Espaçamento | `gap` |
| Largura/Crescer | `flex` |

Entender isso muda o jeito de trabalhar: você para de caçar o controle certo e
passa a saber qual propriedade quer, e só localiza onde ela mora no painel.

---

## Parte 3 — Montagem no Elementor

### 3.1 Criar o template

**Caminho:** Elementor → Modelos → Construtor de Temas → Cabeçalho → Adicionar novo

Nomeia como `Header Principal`. Ao salvar, define a condição de exibição:
**Todo o site**.

### 3.2 A estrutura de containers

```
Container Externo  (full width, é a barra do header)
└── Container Interno  (largura 1200px, centralizado)
    ├── Container Logo
    ├── Container Menu
    └── Container Busca
```

**Por que dois containers aninhados:** o externo pinta a barra de ponta a ponta
da tela; o interno mantém o conteúdo dentro dos 1200px do design system. É o
padrão para qualquer seção full-bleed do site — vale aprender aqui.

**Configuração do Container Externo:**

| Controle | Valor |
|---|---|
| Largura do conteúdo | Largura total |
| Direção | Horizontal |
| Justificar conteúdo | Centro |
| Fundo | (ver 3.4) |

**Configuração do Container Interno:**

| Controle | Valor |
|---|---|
| Largura | deixar **vazio** para herdar o Content Width global (1200px). Ver nota abaixo |
| Direção | Horizontal |
| Justificar conteúdo | Espaço entre (`space-between`) |
| Alinhar itens | Centro |
| Padding | 0 lateral, 16px vertical |

> **Não digite a largura no container interno.** Deixe o campo vazio para ele
> herdar o Content Width global. Valor digitado à mão não acompanha mudanças —
> quando o global foi ajustado de 1280 para 1200 em 28/07, o header ficaria em
> 1280 e o logo desalinhado do conteúdo das seções abaixo, em todas as páginas.
>
> Mesmo princípio de escolher cor pelo nome global em vez de digitar o hex:
> o vínculo é o que mantém o sistema coerente.

### 3.3 Os widgets

| Container | Widget |
|---|---|
| Logo | **Logotipo do site** (puxa de Configurações → Identidade) ou Imagem |
| Menu | **Menu de navegação** (widget do Elementor Pro) |
| Busca | **Formulário de pesquisa** |

O widget de Menu de Navegação lê um menu do WordPress. Antes de usá-lo, cria o
menu em **Aparência → Menus** com a estrutura da seção 1.2 — os itens de
Máquinas entram como subitens (arrastados para a direita na lista).

### 3.4 Header transparente — decisão e implicações

**Decisão (26/07/2026): header transparente sobre o hero.**

Fica mais bonito na home e é o que o mockup sugere. Mas traz três consequências
técnicas que precisam ser resolvidas juntas — não é só remover o fundo.

#### Implicação 1 — o header precisa flutuar, não empilhar

Por padrão o Elementor coloca o header **acima** do conteúdo: ele ocupa altura
e empurra o hero para baixo. Para ficar sobre a imagem, ele precisa flutuar.

No Container Externo → **Avançado → Posicionamento:**

| Controle | Valor |
|---|---|
| Posição | Absoluta |
| Largura | 100% |
| Deslocamento vertical | 0 |
| Índice Z | 100 |

**O que `position: absolute` faz:** remove o elemento do fluxo normal da página.
Os outros elementos passam a se comportar como se ele não existisse — daí o hero
sobe e ocupa o topo, com o header por cima.

**O que `z-index` faz:** define a ordem de empilhamento. Quem tem número maior
fica na frente. Sem ele, o header pode ficar atrás da imagem do hero e
desaparecer. O 100 é folgado de propósito, para o header sempre vencer.

#### Implicação 2 — páginas internas precisam de fundo sólido

Numa página sem hero — `/quem-somos`, um post do blog — o fundo é claro. Menu
branco sobre fundo claro fica invisível.

A solução limpa usa **classes que o WordPress já adiciona ao `<body>`**. Ele
marca a home com a classe `home`, e as outras páginas não têm essa classe. Isso
permite um comportamento por padrão e uma exceção:

```
Regra base:        header com fundo Navy Primário
Exceção na home:   body.home → header com fundo transparente
```

Você escreve essas duas regras no CSS. O seletor da exceção combina a classe do
body com a do header.

**Por que isso é melhor que criar dois templates de header:** um template só,
uma manutenção só. Dois templates significa lembrar de aplicar toda alteração
nos dois — e alguém sempre esquece.

#### Implicação 3 — legibilidade sobre imagem variável

O hero é um slider. Se algum slide tiver área clara no topo, o menu branco
desaparece nela.

Duas proteções, e vale aplicar as duas:

- **Gradiente de proteção:** uma faixa escura sutil no topo do hero,
  transparente na base. Garante contraste independente da imagem
- **Disciplina de curadoria:** os slides precisam ter o terço superior escuro.
  Entra como regra para a designer ao escolher as fotos

#### Pendente — o header acompanha a rolagem (sticky)?

Ainda sem definição, e interage com a decisão acima:

- **Transparente + não sticky** — mais simples. O header fica no topo da home e
  sai de vista ao rolar
- **Transparente + sticky** — o header precisa **virar sólido** ao descolar do
  hero, senão fica flutuando ilegível sobre o conteúdo. Isso exige JavaScript
  detectando a posição da rolagem

O segundo é o padrão de sites mais sofisticados e melhora conversão (CTA sempre
acessível). Mas é mais um item de JavaScript no prazo de duas semanas.

**Recomendação:** entregar sem sticky agora, adicionar depois do go-live. O
header transparente já é o ganho visual; o sticky é refinamento.

---

## Parte 4 — O CSS que você vai escrever

> Aqui começa a parte prática do seu aprendizado. Vou dar a estrutura, os
> seletores e as propriedades — **você escreve as regras.** Depois eu reviso.

### 4.1 Onde o CSS vive

Elementor → Configurações do Site → **CSS Personalizado**. É onde já estão as
variáveis de espaçamento do Módulo 1.

Trabalha primeiro no arquivo `css/header.css` do repositório, e cola no
Elementor quando estiver certo. Assim o código fica versionado no Git.

### 4.2 Comportamento 1 — hover dos itens do menu

**O que deve acontecer:** ao passar o mouse num item, aparece um retângulo de
cantos arredondados, cinza translúcido, atrás do texto.

**Seletor:** os itens do menu do Elementor têm a classe
`.elementor-nav-menu a` (o link em si). O estado hover é `.elementor-nav-menu a:hover`.

**Propriedades que resolvem:**

| Propriedade | Para quê |
|---|---|
| `background-color` | O retângulo. Use `rgba(255, 255, 255, 0.15)` — branco a 15%, valor do Figma |
| `border-radius` | Os cantos arredondados |
| `padding` | Faz o retângulo ser maior que o texto |
| `transition` | Suaviza a aparição (200ms) |

**Sobre `rgba()`:** é uma forma de declarar cor com transparência. Os três
primeiros números são vermelho, verde e azul (0 a 255); o quarto é a opacidade
(0 a 1). `rgba(255,255,255,0.15)` é branco a 15% — é assim que se faz um
translúcido sem inventar uma cor nova na paleta.

**Sobre `transition`:** sem ela, o fundo aparece instantaneamente e parece
defeito. Com `transition: background-color 200ms ease`, ele surge suave. A
regra vai no estado **normal**, não no hover — senão só a entrada é animada e a
saída é seca.

**Escreva a regra e me mostre.**

### 4.3 Comportamento 2 — o chevron do "MÁQUINAS"

**O que deve acontecer:** o ▾ aparece ao lado de "MÁQUINAS" no hover.

O Elementor já adiciona um ícone de seta em itens com submenu. O trabalho é
controlar a **visibilidade** dele: escondido por padrão, visível no hover.

**Propriedades:** `opacity` (0 a 1) e `transition`.

**Dica:** use `opacity: 0` em vez de `display: none`. Com `display: none` o
elemento some e o texto "pula" quando o ícone aparece. Com `opacity`, o espaço
continua reservado e nada se move.

### 4.4 Comportamento 3 — itens do dropdown

**O que deve acontecer:** ao passar o mouse num item do submenu, ele desliza
levemente para a direita e ganha um marcador vermelho à esquerda.

**Seletor:** `.elementor-nav-menu .sub-menu a`

**Propriedades:**

| Efeito | Propriedade |
|---|---|
| Deslizar para a direita | `transform: translateX(8px)` |
| Marcador vermelho | `border-left: 3px solid` com o vermelho da marca |
| Suavidade | `transition` |

**Sobre `transform: translateX()`:** move o elemento sem afetar o layout à
volta. É diferente de mudar `margin-left`, que empurraria os vizinhos.
`translateX` é também mais performático — o navegador processa na placa de
vídeo, sem recalcular a página.

---

## Parte 5 — A busca em Off Canvas

> A arquitetura anterior de busca expansível dentro da linha do header foi
> superada. A implementação atual usa o widget nativo **Fora da Tela** do
> Elementor.

### 5.1 Estrutura atual

```text
fachini-header
├── linha do header
│   ├── fachini-logo
│   ├── fachini-menu
│   └── fachini-busca
└── Fora da Tela
    └── fachini-header-offcanvas
        ├── linha interna
        │   ├── fachini-logo-offcanvas
        │   ├── fachini-menu-offcanvas
        │   └── fachini-exit-offcanvas
        └── fachini-busca-offcanvas
```

O header e o Off Canvas repetem a navegação visualmente porque são contextos
distintos do Elementor, mas usam o mesmo Menu Principal do WordPress. As classes
são diferentes para impedir que o CSS e o JavaScript do dropdown do header
afetem a cópia dentro do diálogo.

### 5.2 O que foi resolvido pelo painel

- abertura e fechamento do Off Canvas;
- botão de abertura, botão X e clique fora;
- animação de 0,4s;
- bloqueio de rolagem;
- busca ao vivo com fonte Páginas, mínimo de 3 caracteres, 3 colunas e 3 itens;
- Loop Item `Busca — Card de resultado`;
- estado sem resultado;
- paletas e logos condicionais.

### 5.3 Código pontual

`scripts/search-offcanvas.js` cuida somente do que o painel não entregou:

- foco automático no campo;
- contenção de Tab e Shift+Tab dentro do diálogo;
- fechamento por Escape com devolução de foco;
- uso de `inert` para retirar o fundo da ordem de foco;
- convivência com a interface do CookieAdmin.

O arquivo é JavaScript puro no repositório. No Elementor, foi publicado no fim
do `<body>`, para todo o site, envolvido por `<script>...</script>`.

### 5.4 Estado verificado e pendências

No desktop, foram verificados: primeiro clique em janela anônima, X, Escape,
clique fora, foco, Tab/Shift+Tab, devolução de foco, ausência de deslocamento da
barra de rolagem, pesquisa por `home`, navegação do card e estado sem resultado.

Pendente: tablet/mobile, páginas reais das máquinas, links do EXPLORAR,
exclusões da consulta, fallback final e testes com termos/códigos reais.

---

## Parte 6 — Acessibilidade de teclado

Não é item opcional: navegação que só funciona com mouse é falha de qualidade
que o Google mede, além de excluir quem depende de teclado.

| Tecla | Comportamento esperado |
|---|---|
| `Tab` | No header, percorre os controles; no Off Canvas, permanece no diálogo |
| `Enter` ou `Espaço` | Abre o dropdown de Máquinas |
| `Esc` | Fecha o dropdown ou o Off Canvas e devolve o foco |
| `Tab` dentro do dropdown | Percorre os subitens |

**Foco visível:** quem navega por teclado precisa ver onde está. O contorno
padrão do navegador é feio mas funcional — se for substituir, o substituto
precisa ser igualmente visível. Nunca use `outline: none` sem colocar outro
indicador no lugar.

---

## Parte 7 — Mobile

O mockup só tem desktop. O header mobile precisa ser definido:

| Elemento | Comportamento no mobile |
|---|---|
| Logo | Menor, à esquerda |
| Menu | Vira hambúrguer (☰) |
| Busca | Ícone, ou dentro do menu aberto |

O widget de Menu de Navegação do Elementor já entrega o hambúrguer nativo — o
trabalho é estilizar o painel que abre para respeitar o design system.

> **Pendência registrada:** o desenho do menu mobile está no controle de
> projeto, item 13 da designer. Enquanto não vier, use o padrão do Elementor
> estilizado com as cores e fontes globais — funciona e pode ser refinado depois.

---

## Parte 8 — Checklist

**Estrutura:**
- [x] Template de cabeçalho criado no Construtor de Temas, condição "Todo o site"
- [x] Menu criado em Aparência → Menus com a hierarquia da seção 1.2
- [x] Container externo full width + interno herdando o Content Width global
- [x] Logos SVG condicionais, com link para a Home
- [x] Alinhamento vertical central no desktop

**Comportamentos:**
- [x] Hover dos itens com retângulo translúcido e transição
- [x] Chevron aparecendo no hover do "MÁQUINAS"
- [x] Dropdown abrindo por clique e teclado; Escape e foco verificados
- [x] Subitens com deslocamento e marcador vermelho
- [x] Busca abrindo no Off Canvas nativo
- [x] X, Escape e clique fora fechando; foco devolvido ao acionador

**Qualidade:**
- [x] Navegação por teclado verificada no desktop
- [x] Foco contido no Off Canvas e devolvido ao acionador
- [ ] Hambúrguer funcional no mobile
- [ ] Tablet e mobile testados e ajustados
- [x] CSS versionado em `css/header.css` no repositório
- [x] JS versionado em `scripts/header.js` no repositório
- [x] JS do foco versionado em `scripts/search-offcanvas.js`

---

## Aprendizados da execução

> Registrados durante os passos 5 e 6. Evitam repetir a mesma investigação nos
> módulos seguintes.

### Hierarquia de precedência no Elementor

Do mais forte para o mais fraco:

| # | Origem | Onde aparece |
|---|---|---|
| 1 | Inline com `!important` | — |
| 2 | **Estilo inline** | SmartMenus escreve `style="width: auto"` no `<ul>` do submenu |
| 3 | Folha de estilo com `!important` | CSS customizado |
| 4 | **CSS gerado pelo painel** | `.elementor-367 .elementor-element.elementor-element-XXX ...` — 4 classes |
| 5 | Folha de estilo normal | CSS customizado sem `!important` |

**Consequências:**

- CSS customizado com 3 classes **perde** para qualquer coisa configurada no
  painel. Os seletores deste arquivo usam 5 classes por isso
- Contra estilo inline, **nada em folha de estilo funciona** — nem
  `!important`. A saída é mexer nos elementos filhos, que não recebem inline.
  Foi o caso da largura do dropdown

### Largura do dropdown: não controlar por CSS

O SmartMenus dimensiona o `<ul>` do submenu em tempo de execução. Para alargar,
usar **Widget de Menu → Estilo → Lista suspensa → Espaçamento horizontal** — o
painel acompanha o conteúdo, então itens mais largos alargam o painel.

### Barra vertical: pseudo-elemento, não `border-left`

A borda do item herda o `border-radius` do painel e fica curvada nas pontas.
Um pseudo-elemento (`::before`) é independente e permanece reto.

O par `position: relative` no item + `position: absolute` no pseudo-elemento é
obrigatório — sem o `relative`, a barra se posiciona em relação à página.

E `content: ''` é obrigatório: sem ele o pseudo-elemento não é criado, mesmo
com todas as outras propriedades declaradas.

### `min-width` é piso, não teto

| Propriedade | Comportamento |
|---|---|
| `min-width` | Nunca menor, mas **cresce** se o conteúdo pedir. Não limita |
| `width` | Medida fixa — é o que controla |
| `max-width` | Teto — pode ser menor, nunca maior |

### Evitar deslocamento no hover

O que muda no estado hover não pode alterar as medidas do elemento. Padding e
borda existem no estado **normal**; o hover só troca cor ou opacidade. Uma
borda que nasce no hover empurra o conteúdo.

Pelo mesmo motivo, o chevron usa `opacity: 0` e não `display: none` — com
`display: none` o ícone sai do fluxo e o texto pula quando ele aparece.

### Cores: variável global, nunca hex literal

O Elementor expõe as cores globais como variáveis CSS: `--e-global-color-primary`,
`--e-global-color-accent`, e IDs gerados para as personalizadas. Usar
`var(--e-global-color-primary)` mantém o vínculo — se a cor mudar no painel, o
CSS acompanha.

Mesmo princípio da largura herdada em vez de digitada.

### Cache: três camadas independentes

1. Elementor → Ferramentas → Limpar arquivos e dados
2. WP Rocket → Esvaziar cache
3. WP Rocket → **Limpar o CSS usado deste URL** — camada separada, não é limpa
   pelo item 2
4. `Ctrl+F5`

Durante o desenvolvimento, vale desativar a otimização de CSS do WP Rocket e
religar antes do go-live.

### Quando o CSS não aplica: inspecionar, não supor

Botão direito no elemento → Inspecionar → aba Styles. Ali aparece cada regra na
ordem de precedência, com as perdedoras riscadas. **Propor hipótese sem essa
informação multiplica o tempo de depuração** — aconteceu em 27 e 28/07.

---

## Decisões registradas (26/07/2026)

| Decisão | Definição |
|---|---|
| Fundo e paleta | Home: header transparente e Off Canvas Onix. Internas: header e Off Canvas off-white com controles Navy |
| Logo | SVG negativo na Home e positivo nas páginas internas |
| JavaScript | **Foco no ensino** — conceito explicado, Wilson escreve, revisão |
| Sticky | **Pendente.** Recomendação: sem sticky no lançamento |

## Ordem de execução sugerida

Do mais estrutural ao mais delicado, para que cada passo valide o anterior:

1. Menu no WordPress (Aparência → Menus) com a hierarquia da seção 1.2
2. Template de cabeçalho + containers aninhados
3. Widget de menu, com placeholder no lugar do logo
4. Posicionamento absoluto e z-index — validar que o header flutua sobre o hero
5. Fundo condicional (transparente na home, sólido nas internas)
6. CSS dos hovers — comportamentos 1, 2 e 3 da Parte 4
7. Dropdown por clique — primeiro conceito de JavaScript
8. Busca em Off Canvas — estrutura nativa e consulta
9. Acessibilidade de teclado e gestão de foco
10. **Tablet e mobile — etapa atual**
11. Logos SVG condicionais
