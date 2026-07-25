# Tokens do Design System — Fachini Máquinas

**Fonte:** arquivo Figma `fachini`, páginas `2- site` e `3 - MARCA`
**Extraído por:** Wilson Luz · **Data:** 23/07/2026

> Valores medidos no Figma, com as correções indicadas. Onde há divergência
> entre o medido e o adotado, a razão está registrada.

---

## 1. Estado do arquivo Figma

| Item | Situação |
|---|---|
| Local Styles / Variables | Não utilizados — valores aplicados elemento a elemento |
| Página `3 - MARCA` | **Desatualizada** — cita Toska e Roboto, que não valem mais |
| Prancheta mobile | **Não existe** — só desktop |
| Prancheta tablet | **Não existe** |

---

## 2. Prancheta e largura

| Item | Medido | Adotado | Razão |
|---|---|---|---|
| Largura da prancheta desktop | 1920px | — | Referência de desenho |
| Bloco de conteúdo (logo → busca) | 1558px | **1280px** | 1558 não cabe em monitor de 1440; escala do Windows a 125% entrega 1536px de viewport |
| Texto corrido | não delimitado | **720px** | Acima de ~75 caracteres por linha a leitura despenca |

**Sistema de 4 camadas adotado:**

| Camada | Largura |
|---|---|
| Full-bleed | 100% |
| Larga | `min(94vw, 1560px)` |
| Padrão | 1280px |
| Texto | 720px |

---

## 3. Fontes

| Item | Valor |
|---|---|
| Headlines (H1, H2) | **Mitr** Bold 700 — Google Fonts, SIL OFL |
| Texto (H3+, corpo, menu, botões) | **Archivo** 400 / 600 / 700 — Google Fonts, SIL OFL |
| Logo | **Toska Bold** — exclusiva do logo, em SVG vetorizado |
| Descontinuada | Roboto |
| Eixo de largura variável | Não utilizado |
| Total de arquivos a carregar | **4** — Mitr 700 · Archivo 400, 600, 700 |

**Restrição:** Mitr vai de ExtraLight (200) a Bold (700). Não existe Black.
Mais impacto na headline só via tamanho.

---

## 4. Tipografia — Desktop

**Medido no Figma:**

| Elemento | Fonte | Peso | Tamanho | Line-height | Tracking |
|---|---|---|---|---|---|
| "Encontre a máquina ideal..." | Mitr | Bold | 64px | 65px (1.02) | 6% |
| "Aumente a produtividade..." | Mitr | Bold | 58px | 68px (1.17) | 6% |
| "Suporte Técnico" | Archivo | SemiBold | 36px | 75px (2.08) | 0% |
| Subtítulo do hero | Archivo | Bold | 23px | auto | 0% |
| "Solicite um orçamento" | Archivo | Bold | 15px | auto | 0% |
| Menu "Máquinas" | Archivo | Medium | 15px | auto | 0% |
| Corpo de texto | Archivo | Regular | 16px | auto | 0% |

**Adotado** — escala modular razão 1.333 (`64 → 48 → 36 → 27 → 20`):

| Nível | Fonte | Peso | Tamanho | Line-height | Tracking | Caixa |
|---|---|---|---|---|---|---|
| H1 | Mitr | 700 | 64px | 1.1 | 0.06em | ALTA |
| H2 | Mitr | 700 | 48px | 1.15 | 0.06em | ALTA |
| H3 | Archivo | 600 | 36px | 1.25 | 0.02em | ALTA |
| H4 | Archivo | 600 | 27px | 1.3 | 0 | normal |
| H5 | Archivo | 600 | 20px | 1.35 | 0 | normal |
| Subtítulo hero | Archivo | 700 | 23px | 1.4 | 0 | ALTA |
| Corpo | Archivo | 400 | 16px | 1.6 | 0 | normal |
| Corpo pequeno | Archivo | 400 | 14px | 1.6 | 0 | normal |
| Botão | Archivo | 700 | 15px | 1 | 0.05em | ALTA |
| Menu | Archivo | 600 | 15px | 1 | 0 | ALTA |

### Divergências entre medido e adotado

| # | Item | Medido | Adotado | Razão |
|---|---|---|---|---|
| 1 | H2 tamanho | 58px | **48px** | 58 dá só 10% de diferença do H1. Como ambos usam mesma fonte, peso, caixa e tracking, o tamanho é o único diferenciador — 10% está abaixo do limiar em que o olho lê hierarquia. **Validado pela designer em 25/07/2026** |
| 2 | H3 line-height | 75px (2.08) | **1.25** | Resíduo. Invisível porque "Suporte Técnico" é uma linha só. No primeiro H3 de duas linhas, abriria vão de 75px. **Validado pela designer em 25/07/2026** |
| 3 | H1 line-height | 1.02 | **1.1** | Em português, acentos em caixa alta ficam acima da altura das maiúsculas. A 1.02 o "Á" de MÁQUINA encosta na linha de cima |
| 4 | Menu peso | Medium 500 | **SemiBold 600** | A 15px a diferença é imperceptível e evita carregar um quinto arquivo de fonte |
| 5 | H3 tracking | 0% | **0.02em** | Maiúsculas precisam de mais respiro entre letras que minúsculas |

---

## 5. Tipografia — Mobile

**Não existe prancheta mobile no Figma.** Escala proposta, razão 1.2.

| Nível | Tamanho | Peso | Line-height |
|---|---|---|---|
| H1 | 34px | 700 | 1.15 |
| H2 | 28px | 700 | 1.2 |
| H3 | 23px | 600 | 1.3 |
| H4 | 19px | 600 | 1.35 |
| H5 | 17px | 600 | 1.4 |
| Subtítulo hero | 17px | 700 | 1.45 |
| Corpo | 16px | 400 | 1.65 |
| Corpo pequeno | 14px | 400 | 1.6 |
| Botão | 15px | 700 | 1 |

**Corpo nunca abaixo de 16px.** O Safari do iOS dá zoom automático em campo de
formulário com fonte menor, e a página saltaria no formulário de orçamento.

---

## 6. Cores

**Manual de marca (página `3 - MARCA`):**

| Nome no manual | Hex |
|---|---|
| Azul Primário | `#15274E` |
| Azul Secundário | `#00224E` |
| Vermelho Primário | `#E01E26` |
| Vermelho Secundário | `#DD0C14` |
| Branco | `#FFFFFF` |
| Preto | `#000000` |

**Paleta adotada — 8 cores:**

| Nome | Hex | Origem | Uso |
|---|---|---|---|
| Navy Primário | `#15274E` | Manual | Títulos, fundos de seção escura |
| Navy Secundário | `#00224E` | Manual | Footer, sobreposição em imagem |
| Vermelho | `#E01E26` | Manual | CTA — exclusivo |
| Vermelho Hover | `#B01319` | Sistema | Hover de botões |
| Onix | `#0F0F0F` | Sistema | Corpo de texto |
| Off-white | `#FBFBFB` | Sistema | Fundo padrão |
| Cinza Névoa | `#F1F3F6` | Sistema | Seção alternada, cards, contorno de input |
| Cinza Médio | `#5C6675` | Sistema | Texto de apoio, barras de slide inativas |

### Decisões de cor

**Vermelho Secundário `#DD0C14` descartado como hover.** É praticamente tão
claro quanto o primário — a mudança seria imperceptível. Hover precisa de um
vermelho visivelmente mais escuro.

**Preto puro `#000000` não é usado em texto.** Contraste máximo cansa a leitura
em tela. Fica reservado ao logo e ao impresso.

**O manual não tem cinzas.** Foram acrescentados por necessidade funcional:
texto de apoio, fundo alternado, bordas de input, divisores.

**Cinzas são frios, não taupe.** Uma proposta inicial de `#B4ADA7` e `#6E655E`
foi descartada: ambos puxam para o quente (diferença azul−vermelho de −13 e
−16), enquanto o navy é fortemente frio (+57). A distância de 70 pontos produz
sensação de sujeira. Além disso `#B4ADA7` reprova em contraste sobre fundo
claro (2.1:1, mínimo é 4.5:1).

### Contraste verificado (WCAG)

| Combinação | Contraste | Status |
|---|---|---|
| Onix sobre Off-white | 18.5:1 | AAA |
| Navy sobre Off-white | 14.2:1 | AAA |
| Off-white sobre Navy Secundário | 15.2:1 | AAA |
| Cinza Médio sobre Off-white | 5.6:1 | AA |
| Branco sobre Vermelho | 4.8:1 | AA |
| Branco sobre Vermelho Hover | 7.1:1 | AAA |

**Estados translúcidos não geram cor nova.** Hover do menu = branco a ~12%;
texto de apoio sobre navy = off-white a ~80%; sobreposição de imagem = navy com
opacidade.

---

## 7. Espaçamento

Escala base 8px: `8 · 16 · 24 · 32 · 48 · 64 · 96 · 128`

| Contexto | Desktop | Mobile |
|---|---|---|
| Padding vertical de seção | 96px | 56px |
| Padding horizontal do container | 24px | 20px |
| Entre título e texto | 24px | 16px |
| Entre texto e botão | 32px | 24px |
| Gap entre cards | 32px | 24px |

> Valores de espaçamento não foram medidos individualmente no Figma. Conferir
> contra o layout durante a montagem e ajustar a escala se houver divergência
> sistemática.

---

## 8. Pendências de extração

| # | Item | Com quem |
|---|---|---|
| 1 | Breakpoints usados no Figma | Designer |
| 2 | Raio de borda de botões, cards e campos de formulário | Designer |
| 3 | Sombra nos cards de notícia | Designer |
| 4 | Medição dos espaçamentos reais seção a seção | Designer |
