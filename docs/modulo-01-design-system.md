# Módulo 1 — Design System no Elementor

**Projeto:** Site Fachini Máquinas
**Versão:** 2 — consolidada com os valores reais extraídos do Figma (23/07/2026)
**Objetivo:** cadastrar a fundação visual nos Estilos Globais do Elementor, de
modo que toda página construída depois herde cor, tipografia e espaçamento.

---

## Por que este módulo vem primeiro

Estilos Globais são a diferença entre um site e uma pilha de páginas. Cadastrado
corretamente, mudar o azul da marca é uma edição em um lugar. Não cadastrado, é
caçar o hex em 20 páginas e rezar para não esquecer nenhuma.

É também o que torna o treinamento da designer viável: com a fundação pronta,
ela não decide cor nem tamanho de fonte — escolhe de uma lista curta. O trabalho
dela vira composição, não design de sistema.

---

## Parte 1 — Paleta (fechada)

| Nome | Hex | Uso |
|---|---|---|
| Navy Primário | `#15274E` | Títulos, fundos de seção escura |
| Navy Secundário | `#00224E` | Footer, sobreposição em imagem |
| Vermelho | `#E01E26` | CTA — **exclusivo** |
| Vermelho Hover | `#B01319` | Estado hover dos botões |
| Onix | `#0F0F0F` | Corpo de texto |
| Off-white | `#FBFBFB` | Fundo padrão |
| Cinza Névoa | `#F1F3F6` | Seção alternada, cards, contorno de input |
| Cinza Médio | `#5C6675` | Texto de apoio, barras de slide inativas |

Navy Primário, Navy Secundário e Vermelho vêm do manual de marca. Vermelho
Hover e os dois cinzas são cores de sistema — existem por necessidade funcional
e todas as combinações de texto foram verificadas contra o mínimo WCAG AA de
4.5:1.

**Regra de disciplina:** o vermelho é o recurso mais escasso da paleta. Se
aparecer em tudo, para de significar "clique aqui".

**Estados translúcidos não geram cor nova.** Hover do menu é branco a ~12%;
texto de apoio sobre navy é off-white a ~80%; sobreposição de imagem é navy com
opacidade.

---

## Parte 2 — Tipografia

### 2.1 As duas famílias

| Fonte | Peso | Onde | Arquivos |
|---|---|---|---|
| **Mitr** | 600 SemiBold | H1 e H2 — **sempre em caixa alta** | 1 |
| **Archivo** | 400 Regular | Corpo de texto | 1 |
| **Archivo** | 600 SemiBold | H3, H4, H5, menu | 1 |
| **Archivo** | 700 Bold | Botões, subtítulo do hero | 1 |

**Quatro arquivos no total.** Ambas do Google Fonts sob licença SIL OFL — uso
comercial livre, hospedagem local permitida.

**Restrições:**

- **Mitr não tem peso acima de 700.** A família vai de ExtraLight a Bold. Se um
  dia quiserem mais impacto na headline, o único recurso é aumentar o tamanho.
- **Mitr tem o Bold visivelmente mais pesado que o comum.** É uma tipografia de
  origem tailandesa — o alfabeto tailandês exige contraste maior entre pesos, e
  isso se reflete no desenho latino. Na prática, o Bold (700) dela aparenta um
  peso acima do Bold de uma grotesca ocidental típica. Somado à caixa alta, fica
  excessivo. **Por isso o projeto usa 600 (SemiBold)** — não é engano nem
  divergência a corrigir.
- **Mitr é exclusiva de caixa alta.** Os terminais arredondados desaparecem em
  maiúsculas; em caixa mista o tipo fica visivelmente mais macio, o que não
  serve ao território industrial. Headline em caixa mista usa Archivo 700.
- **O menu usa SemiBold 600, não Medium 500.** O Figma marca 500, mas a 15px a
  diferença é imperceptível e evita carregar um quinto arquivo.

### 2.2 Escala — Desktop (razão 1.25)

Os tamanhos não foram escolhidos por gosto: saem de uma progressão. Cada nível
é o anterior dividido por **1.25**.

```
56 ÷ 1.25 = 45    45 ÷ 1.25 = 36    36 ÷ 1.25 = 29    29 ÷ 1.25 = 23
```

**A escala parte dos 56px que o Figma define para o H1** — e o H3 cai
exatamente em 36px, também o valor da designer. Dois pontos de alinhamento com
o arquivo original.

**Estes são os valores a cadastrar:**

| Nível | Fonte | Tamanho | Peso | Line-height | Letter-spacing | Caixa |
|---|---|---|---|---|---|---|
| H1 | Mitr | **56px** | 600 | **1.1** | 0.06em | ALTA |
| H2 | Mitr | **45px** | 600 | **1.15** | 0.06em | ALTA |
| H3 | Archivo | 36px | 600 | **1.25** | 0.02em | normal |
| H4 | Archivo | **29px** | 600 | 1.3 | 0 | normal |
| H5 | Archivo | **23px** | 600 | 1.35 | 0 | normal |
| Subtítulo hero | Archivo | 23px | 700 | 1.4 | 0 | ALTA |
| Corpo | Archivo | 16px | 400 | 1.6 | 0 | normal |
| Corpo pequeno | Archivo | 14px | 400 | 1.6 | 0 | normal |
| Botão | Archivo | 15px | 700 | 1 | 0.05em | ALTA |
| Menu | Archivo | 15px | 600 | 1 | 0 | ALTA |

> **Escala revista em 27/07/2026.** A versão anterior partia de H1 em 64px,
> extraído do Figma numa primeira leitura. O arquivo define **56px**, e a 64px
> o título ficava desproporcional em notebook — a 150% de escala do Windows,
> 64px CSS renderiza como cerca de uma polegada física.
>
> A escala foi reconstruída a partir de 56 com razão 1.25. O H1 e o H2 mantêm
> 24% de diferença, acima do limiar em que o olho lê hierarquia (o problema
> original era o H2 a 58px, que dava apenas 10%).
>
> **Tamanho de fonte não influencia SEO.** O Google avalia se o H1 existe, se é
> único e se contém a palavra-chave — não seu tamanho. A escolha é de
> legibilidade.

> **H3 — line-height 1.25, não 75px (decisão fechada, validada pela designer
> em 25/07/2026).** O Figma marcava 75px sobre fonte de 36px, o que dava 2.08.
> Passou despercebido porque "Suporte Técnico" ocupa uma linha só. No primeiro
> H3 que quebrar em duas linhas, abriria um vão de 75px.

> **H3 sem transformação de caixa no Theme Style.** Ele aparece em dois
> contextos no layout: "SUPORTE TÉCNICO / INSTALAÇÃO PROFISSIONAL / PÓS VENDA"
> em caixa alta, e títulos de card de notícia em caixa baixa. Forçar maiúsculas
> globalmente quebraria os segundos. A caixa alta é aplicada por seção, no
> widget.

**Line-height do H1 e H2 nunca abaixo de 1.1.** O Figma marca 1.02 no H1. Em
português, acentos em caixa alta ficam acima da altura das maiúsculas — a 1.02
o acento de "MÁQUINA" encosta na linha de cima, e a cedilha de "PRODUÇÃO"
invade a linha de baixo.

**H4, H5 e Corpo pequeno** não foram medidos no Figma. Existem porque hoje há um
vão de 55% entre o H3 (36px) e o corpo (16px) — sem eles, título de card,
subtítulo de spec técnica e label de formulário recebem tamanho improvisado na
montagem.

### 2.3 Escala — Mobile (razão 1.18)

Não existe prancheta mobile no Figma. Esta escala é proposta. A razão é menor
que a de desktop porque em tela pequena saltos grandes desperdiçam espaço
vertical.

| Nível | Tamanho | Peso | Line-height |
|---|---|---|---|
| H1 | 32px | 600 | 1.15 |
| H2 | 27px | 600 | 1.2 |
| H3 | 23px | 600 | 1.3 |
| H4 | 19px | 600 | 1.35 |
| H5 | 17px | 600 | 1.4 |
| Subtítulo hero | 17px | 700 | 1.45 |
| Corpo | 16px | 400 | 1.65 |
| Corpo pequeno | 14px | 400 | 1.6 |
| Botão | 15px | 700 | 1 |

**Regra que não se quebra:** corpo nunca abaixo de 16px no mobile. Além da
legibilidade, o Safari do iOS dá zoom automático em campo de formulário com
fonte menor que 16px — a página saltaria quando o usuário tocasse no formulário
de orçamento.

**Sobre o line-height:** quanto maior o texto, menor o valor. Headline a 1.6
fica com buracos; corpo a 1.1 fica sufocado. Por isso a escala desce de 1.65 no
corpo até 1.1 no H1.

---

## Parte 3 — Hierarquia de headings

**Princípio: nível de heading é significado, não tamanho.** O H1 não é o texto
maior — é o assunto da página. A hierarquia serve ao Google e ao leitor de tela.

### Homepage

| Nível | Elementos |
|---|---|
| H1 | "Encontre a máquina ideal..." — **um só na página** |
| H2 | "Aumente a produtividade", "Tecnologia que transforma", "Notícias", "Solicite seu orçamento", título de cada aba do mosaico |
| H3 | "Suporte técnico", "Instalação profissional", "Pós venda", títulos dos cards de notícia |

### Armadilhas

- **"Aumente a produtividade" é H2, não H1.** Está em Mitr grande e parece título
  de página, mas semanticamente é seção. Dois H1 deixam o Google sem saber qual
  é o assunto.
- **Os números não são heading.** "+50", "+30", "+300" são dados. Devem sair
  como texto comum estilizado grande. Marcados como H2, entram na estrutura do
  documento e o Google lê "+50" como um dos assuntos da página.
- **Links do footer não são heading.** "MÁQUINAS", "QUEM SOMOS" ali são
  navegação.

### Páginas internas

O H1 é o nome da máquina ou da categoria, sempre contendo a palavra-chave.
Nunca "Bem-vindo" ou "Conheça nossa linha".

---

## Parte 4 — Espaçamento e largura

### 4.1 Largura de conteúdo

O Figma foi desenhado numa prancheta de **1920px**, com bloco de conteúdo de
**1558px**. Isso não pode ir direto para o Elementor:

- 1920 não é a tela típica. E há um fator que quase todo mundo esquece: a
  **escala do Windows**. Um monitor de 1920px a 125% (padrão de fábrica em muito
  notebook) entrega 1536px de viewport ao navegador; a 150%, entrega 1280px. As
  larguras reais que chegam ao site se concentram em 1280, 1366, 1440, 1536 e
  1920.
- Parágrafo com 1558px de largura dá cerca de 200 caracteres por linha. O
  confortável para leitura é 50 a 75.

**Uma medida única não resolve**, porque os dois usos se contradizem: imagem,
grid e card querem largura; texto corrido quer estreiteza. Daí o sistema de
camadas.

| Camada | Largura | Onde |
|---|---|---|
| **Full-bleed** | 100% | Hero, seções navy, banner de CTA, footer |
| **Larga** | `min(94vw, 1560px)` | Mosaico de categorias, grid de notícias, estatísticas |
| **Padrão** | **1280px** | Maioria das seções — é o Content Width do Elementor |
| **Texto** | 720px | Parágrafo corrido |

**No Elementor**, quase tudo é nativo:

- **Padrão:** Site Settings → Layout → Content Width = 1280px
- **Full-bleed:** no container, Content Width = *Full Width*
- **Larga:** container em Full Width com container interno de largura customizada
- **Texto:** limite de 720px no próprio widget

CSS entra só se quiser a largura fluida da camada Larga:

```css
.fachini-largo {
  max-width: min(94vw, 1560px);
  margin-inline: auto;
}
```

`94vw` são 94% da largura da janela (`vw` = 1% da viewport). `min()` escolhe o
menor dos dois: numa tela de 1920, 94vw dá 1805 — maior que 1560, então vence o
teto; numa de 1366, dá 1284 — menor, então vence ele e sobram 82px de cada lado.
Adaptação automática sem media query. `margin-inline: auto` centraliza,
distribuindo a sobra dos dois lados.

Aplica adicionando `fachini-largo` no campo CSS Classes do container.

> **Consequência a validar:** o H1 vai quebrar diferente a 1280px do que quebra
> a 1558px no Figma. A designer precisa conferir se as três linhas continuam
> bem distribuídas.

> **Cuidado ao alargar por "sensação de vazio":** quando uma seção parece vazia
> numa tela grande, a causa costuma ser densidade interna, não largura. Teste:
> se você alargasse a seção, o conteúdo cresceria junto ou só se afastaria? Se
> for a segunda, alargar só espalha mais o vazio.

### 4.2 Escala de espaçamento

Base 8px. Todo espaçamento do site sai desta lista:

```
8 · 16 · 24 · 32 · 48 · 64 · 96 · 128
```

Sem escala fechada, cada seção ganha um valor improvisado — 30px aqui, 35px
ali. Ninguém nota individualmente, mas o site fica com uma frouxidão que não se
consegue nomear.

| Contexto | Desktop | Mobile |
|---|---|---|
| Padding vertical de seção | 96px | 56px |
| Padding horizontal do container | 24px | 20px |
| Entre título e texto | 24px | 16px |
| Entre texto e botão | 32px | 24px |
| Gap entre cards | 32px | 24px |

---

## Parte 5 — Execução no Elementor

### Passo 1 — Hospedar as fontes localmente

Antes de cadastrar tipografia, Mitr e Archivo precisam estar servidas do próprio
servidor, não do CDN do Google. Dois motivos: performance (elimina conexão
externa no carregamento inicial, ganho direto de LCP) e LGPD (carregar do Google
transfere o IP do visitante a terceiro, o que complica o consentimento no
CookieAdmin).

O WP Rocket PRO tem a opção de hospedagem local de Google Fonts. Ative antes de
seguir.

**Carregar apenas:** Mitr 600 · Archivo 400, 600, 700.

### Passo 2 — Cores globais

**Caminho:** Elementor → menu do editor → **Site Settings** → **Global Colors**

Os 4 slots nomeados:

| Slot | Cor |
|---|---|
| Primary | Navy Primário `#15274E` |
| Secondary | Cinza Médio `#5C6675` |
| Text | Onix `#0F0F0F` |
| Accent | Vermelho `#E01E26` |

As outras quatro entram como **cores personalizadas**, com nome descritivo:
Navy Secundário, Vermelho Hover, Off-white, Cinza Névoa.

> **Não pule a nomenclatura.** Cor sem nome vira "aquele azul" e alguém acaba
> digitando o hex na mão. Cada hex digitado à mão é um ponto onde o sistema vaza.

### Passo 3 — Fontes globais

**Caminho:** Site Settings → **Global Fonts**

| Slot | Configuração |
|---|---|
| Primary | Mitr 600 — headlines |
| Secondary | Archivo 600 — subtítulos e menu |
| Text | Archivo 400 — corpo |
| Accent | Archivo 700 — botões |

### Passo 4 — Aplicar aos elementos (o passo que quase todo mundo pula)

Global Fonts cria os slots reutilizáveis, mas **não define como um H1 aparece
na página**. Isso é outra tela:

**Caminho:** Site Settings → **Theme Style** → **Typography**

Configure Body e H1 até H6 com os valores da Parte 2.2 (desktop) e 2.3 (mobile).

Depois **Theme Style → Buttons**: fundo Accent, texto Off-white, hover Vermelho
Hover, tipografia Archivo 700 / 15px / caixa alta / letter-spacing 0.05em.

**Botões sem sombra** (decisão 26/07/2026). Deixe o campo Box Shadow vazio. O
vermelho já carrega peso visual suficiente — sombra somaria ruído e destoaria
do território industrial, que pede superfícies planas e definidas.

Sem este passo, cada texto colocado na página nasce com o padrão do Elementor e
alguém acaba ajustando manualmente — que é exatamente o descontrole que este
módulo existe para impedir.

### Passo 5 — Breakpoints e largura

**Caminho:** Site Settings → **Layout**

- Content Width: **1280px**
- Breakpoints: confirmar com a designer quais valores ela usou. Padrão do
  Elementor: Mobile até 767px, Tablet até 1024px.

### Passo 6 — Variáveis de espaçamento

**Caminho:** Site Settings → **Custom CSS**

```css
:root {
  --esp-1: 8px;
  --esp-2: 16px;
  --esp-3: 24px;
  --esp-4: 32px;
  --esp-5: 48px;
  --esp-6: 64px;
  --esp-7: 96px;
  --esp-8: 128px;
}
```

`:root` é o elemento raiz do documento — o `<html>`. Declarar variáveis ali as
torna disponíveis em qualquer lugar da página. O prefixo `--` é o que identifica
uma variável CSS. Depois, em qualquer CSS customizado, você usa `var(--esp-5)`
em vez de digitar `48px`.

Se um dia a escala mudar, muda aqui e propaga. Mesma lógica das cores globais,
aplicada a espaçamento.

---

## Parte 6 — Verificação

**MÓDULO CONCLUÍDO em 26/07/2026.**

- [x] Fontes hospedadas localmente — WP Rocket, opção "Auto-hospedar Fontes
      Google" ativa
- [x] Mitr 600 · Archivo 400/600/700
- [x] 4 cores nos slots + 4 personalizadas com nome
- [x] Theme Style → Typography: corpo e H1–H6
- [x] Theme Style → Links: navy com sublinhado, hover vermelho
- [x] Theme Style → Buttons com hover configurado
- [x] Content Width em 1280px
- [x] Layout de página padrão: Elementor Largura Total (evita o H1 duplicado do
      título de página)
- [x] Variáveis de espaçamento no Custom CSS
- [x] **Teste final validado** — página de rascunho com H1, H2, H3, parágrafo e
      botão herdaram corretamente, sem configuração manual. Página apagada.
- [ ] Breakpoints alinhados com o Figma — **pendente da designer**

### Aprendizados da execução

- **Altura da linha e espaçamento entre letras usam EM, não PX.** Em px, um
  line-height de 1.1 colapsa as linhas uma sobre a outra. Regra: número com
  casa decimal → EM; número inteiro grande (tamanho de fonte) → PX.
- **Decimal com ponto, nunca vírgula.** `1.1`, não `1,1` — CSS usa o padrão
  internacional.
- **Slots de Global Fonts não carregam tamanho.** Só família e peso. O tamanho
  é definido no Theme Style, por nível. Slot com tamanho embutido "mente" sobre
  os usos em que aparece com outro tamanho.
- **O título da página gera um H1 extra.** Com o modelo "Padrão" do Hello
  Elementor, a página imprime o título como H1 além do widget. O modelo
  "Elementor Largura Total" resolve na origem — melhor que esconder por CSS,
  porque título escondido ainda conta como H1 para o Google.

---

## Pendências com a designer

1. **Breakpoints** — quais valores ela usou no Figma
2. **Quebra do H1 a 1280px** — conferir se as três linhas continuam distribuídas
3. **Hierarquia de headings** — alinhar a marcação semântica da Parte 3 antes da
   montagem

## O que este módulo destrava

- A designer pode ser treinada em composição, não em design de sistema
- O header (Módulo 2) tem sobre o que ser construído
- Todo CSS customizado dos módulos seguintes referencia variáveis, não valores
  fixos
- Mudança de marca vira edição em um lugar
