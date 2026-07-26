# Módulo 2 — Header

**Projeto:** Site Fachini Máquinas
**Pré-requisito:** Módulo 1 concluído (design system cadastrado)
**Objetivo:** construir o cabeçalho do site — a peça que aparece em todas as
páginas e concentra a maior parte do código customizado do projeto.

---

## Por que o header é o módulo mais difícil

Ele reúne os dois únicos itens que sobreviveram à triagem de código customizado:
o **dropdown por clique** e a **busca expansível**. Nenhum dos dois existe pronto
no Elementor.

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
   ├── Calhas
   ├── Perfiladeiras
   ├── Corte e Dobra
   └── Laser
QUEM SOMOS
BLOG
CONTATO
```

**Por quê:** oito itens soltos na barra ficam apertados em 1280px, diluem a
navegação e pioram no mobile. O guarda-chuva preserva todas as categorias do
mapa e mantém o header respirável.

> **Registrado como pendência:** o relatório de análise aponta que faltam
> "Soluções" no menu e telefone/WhatsApp no header (bloqueadores 1.3 e 1.4).
> Ambos ficam para quando as decisões correspondentes fecharem. A estrutura
> construída aqui comporta os dois sem redesenho.

### 1.3 Comportamentos a implementar

| # | Comportamento | Onde |
|---|---|---|
| 1 | Hover nos itens: retângulo arredondado cinza translúcido | CSS |
| 2 | "MÁQUINAS": chevron ▾ aparece no hover | CSS |
| 3 | Dropdown abre por **clique**, não por hover | JS |
| 4 | Itens do dropdown: deslocamento lateral no hover, marcador vermelho | CSS |
| 5 | Busca expande ocupando o header; itens do menu somem | CSS + JS |
| 6 | "X" fecha a busca e restaura o menu | JS |
| 7 | Navegação por teclado: Tab, Enter/Espaço abre, Esc fecha | JS |

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
└── Container Interno  (largura 1280px, centralizado)
    ├── Container Logo
    ├── Container Menu
    └── Container Busca
```

**Por que dois containers aninhados:** o externo pinta a barra de ponta a ponta
da tela; o interno mantém o conteúdo dentro dos 1280px do design system. É o
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
| Largura | 1280px (ou "Largura da caixa" = 1280) |
| Direção | Horizontal |
| Justificar conteúdo | Espaço entre (`space-between`) |
| Alinhar itens | Centro |
| Padding | 0 lateral, 16px vertical |

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
| `background-color` | O retângulo. Use `rgba(255, 255, 255, 0.12)` — branco a 12% |
| `border-radius` | Os cantos arredondados |
| `padding` | Faz o retângulo ser maior que o texto |
| `transition` | Suaviza a aparição (200ms) |

**Sobre `rgba()`:** é uma forma de declarar cor com transparência. Os três
primeiros números são vermelho, verde e azul (0 a 255); o quarto é a opacidade
(0 a 1). `rgba(255,255,255,0.12)` é branco a 12% — é assim que se faz um
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

## Parte 5 — A busca expansível

Esta é a parte mais complexa do módulo e a única que exige JavaScript.

### 5.1 A lógica

O estado é binário: **fechado** ou **aberto**.

| | Fechado | Aberto |
|---|---|---|
| Itens do menu | visíveis | ocultos |
| Campo de busca | ícone só | largura total |
| Botão | lupa | X |

A técnica: o JavaScript não altera estilo diretamente. Ele **adiciona ou remove
uma classe** no header — algo como `busca-ativa` — e o CSS reage a essa classe.

Isso é um padrão importante e vale internalizar: **JavaScript controla estado,
CSS controla aparência.** Misturar os dois deixa o código impossível de manter.

```
CSS define:
  .header .menu           → visível
  .header.busca-ativa .menu → oculto

JS faz apenas:
  header.classList.toggle('busca-ativa')
```

### 5.2 O que você escreve e o que eu escrevo

**Você escreve o CSS:** as regras dos dois estados, com transição.

**O JavaScript:** decisão tomada (26/07/2026) — **foco no ensino.** Eu explico
o conceito em passos pequenos, você escreve, eu reviso. Se em algum momento o
ritmo comprometer o prazo, você recalibra pedindo com "escreve".

Os três conceitos que você vai aprender aqui, em ordem:

1. **Selecionar um elemento** — como o JavaScript encontra um pedaço da página
   para trabalhar (`document.querySelector`)
2. **Escutar um evento** — como fazer código rodar quando alguém clica
   (`addEventListener`)
3. **Alternar uma classe** — como mudar o estado sem tocar em estilo
   (`classList.toggle`)

São três conceitos, não três linhas — mas com eles você resolve o dropdown, a
busca e qualquer interação futura do site. É a base de JavaScript no navegador.

### 5.3 Onde o JS vive

Elementor → Configurações do Site → **CSS Personalizado** não aceita JavaScript.
Duas alternativas:

- **Elementor → Configurações Avançadas → Código customizado** (Elementor Pro)
- Widget **HTML** dentro do próprio header

A primeira é mais limpa. O arquivo fica versionado em `css/` ou `scripts/` no
repositório de qualquer forma.

---

## Parte 6 — Acessibilidade de teclado

Não é item opcional: navegação que só funciona com mouse é falha de qualidade
que o Google mede, além de excluir quem depende de teclado.

| Tecla | Comportamento esperado |
|---|---|
| `Tab` | Percorre logo → itens do menu → busca |
| `Enter` ou `Espaço` | Abre o dropdown de Máquinas |
| `Esc` | Fecha o dropdown ou a busca |
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
- [ ] Template de cabeçalho criado no Construtor de Temas, condição "Todo o site"
- [ ] Menu criado em Aparência → Menus com a hierarquia da seção 1.2
- [ ] Container externo full width + interno em 1280px
- [ ] Logo em SVG, com link para a home
- [ ] Alinhamento vertical central em todos os elementos

**Comportamentos:**
- [ ] Hover dos itens com retângulo translúcido e transição
- [ ] Chevron aparecendo no hover do "MÁQUINAS"
- [ ] Dropdown abrindo por clique
- [ ] Subitens com deslocamento e marcador vermelho
- [ ] Busca expandindo e ocultando o menu
- [ ] "X" restaurando o estado normal

**Qualidade:**
- [ ] Navegação por teclado completa
- [ ] Foco visível
- [ ] Hambúrguer funcional no mobile
- [ ] Testado em 1280, 1440 e 390px de largura
- [ ] CSS versionado em `css/header.css` no repositório

---

## Decisões registradas (26/07/2026)

| Decisão | Definição |
|---|---|
| Fundo do header | **Transparente sobre o hero**, sólido navy nas páginas internas |
| Logo | SVG existe. **Tratamento do logo fica para o fim do módulo** |
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
8. Busca expansível — CSS e depois JavaScript
9. Acessibilidade de teclado
10. Mobile
11. **Logo em SVG** — por último, conforme decidido
