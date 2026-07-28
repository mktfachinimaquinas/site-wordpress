# Tarefas e Validações — Design | Site Fachini

**Data:** 26/07/2026
**Contexto:** o design system já está cadastrado no Elementor (cores,
tipografia, espaçamentos, botões). O header está em construção. Para seguir
com a montagem das seções, preciso de algumas definições e ajustes.

**Como está organizado:** por urgência real. O Bloco 1 destrava tudo o que vem
depois — quanto antes, melhor. O Bloco 4 pode esperar a homepage estar no ar.

> Boa parte disso é **pergunta**, não correção. O layout está bom; o que falta
> são valores que só existem no seu arquivo e decisões que o mockup estático
> não mostra.

---

## BLOCO 1 — Destrava tudo (prioridade máxima)

Sem estes quatro itens, qualquer seção montada pode precisar ser refeita.

### 1.1 Breakpoints do Figma

**O que preciso:** em quais larguras você definiu as quebras de layout.

O Elementor tem os próprios breakpoints (padrão: mobile até 767px, tablet até
1024px). Se o Figma usou valores diferentes, preciso alinhar os dois antes da
montagem — depois significa revisar página por página.

**Resposta esperada:** os números. Ex.: "mobile 480, tablet 768, desktop 1200".

---

### 1.2 Camada de largura de cada seção

O site usa **quatro larguras diferentes**, conforme o tipo de conteúdo:

| Camada | Largura | Para quê |
|---|---|---|
| **Full-bleed** | 100% da tela | Hero, faixas navy, banner de CTA, footer |
| **Larga** | até 1560px | Mosaico de categorias, grid de notícias, estatísticas |
| **Padrão** | 1280px | Maioria das seções |
| **Texto** | 720px | Parágrafo corrido |

**Por que quatro e não uma:** imagem e grid ficam melhores largos; texto corrido
fica ilegível largo (acima de ~75 caracteres por linha o olho perde a linha
seguinte). Uma medida só não serve aos dois usos.

**O que preciso:** anotar no Figma, em cada seção da home, qual das quatro
camadas ela usa. Pode ser um comentário simples no frame.

---

### 1.3 Valores de componente que faltaram na extração

Peguei cores, tipografia e larguras do arquivo. Faltaram estes:

| Item | O que preciso |
|---|---|
| **Raio de borda dos botões** | Valor em px |
| **Raio de borda dos cards** | Valor em px |
| **Raio de borda dos campos de formulário** | Valor em px |
| **Altura dos campos de formulário** | Valor em px |
| **Sombra nos cards de notícia** | Existe? Se sim, os valores |

**Já definido:** botões **sem sombra** (decisão 26/07). A pergunta de sombra
acima vale só para os cards.
| **Espaçamentos reais entre seções** | Padding vertical de cada seção |

Sobre os espaçamentos: adotei uma escala de 8px
(`8 · 16 · 24 · 32 · 48 · 64 · 96 · 128`) com padding vertical de 96px por
seção no desktop. **Se os valores do Figma forem muito diferentes disso, me
avisa** — a escala pode ser ajustada, mas precisa ser uma decisão consciente e
não um acúmulo de valores diferentes por seção.

---

### 1.4 Frames de 1366px e mobile (390px)

Hoje só existe o frame de 1920px. Isso deixa duas faixas de tela sem definição:

- **1366px** — notebook comum. E atenção a um detalhe que quase todo mundo
  esquece: um monitor de 1920px com **escala do Windows em 125%** (padrão de
  fábrica em muito notebook) entrega apenas **1536px** ao navegador. As larguras
  reais que chegam ao site se concentram em 1280, 1366, 1440 e 1536
- **390px** — mobile, que é ~90% do tráfego do site

**Não precisa ser refinado.** Wireframe basta — o que preciso saber é: o que
empilha, o que some, o que vira carrossel, o que muda de ordem.

Sem isso, essas decisões acabam sendo tomadas durante a montagem, sem critério
de design.

---

## BLOCO 2 — Bloqueia seções específicas

### 2.1 Menu mobile (hambúrguer)

O Figma só tem o header desktop. Preciso saber como o menu se comporta no
celular:

- O painel abre de onde? Lateral, de cima, tela cheia?
- Como fica o submenu de "Máquinas" — acordeão, ou navega para outra tela?
- O campo de busca entra no painel ou fica fora?
- O que acontece com o logo?

---

### 2.2 Slides do hero — restrição nova

**Decisão tomada:** o header vai ser **transparente sobre o hero**, para o
visual ficar mais integrado.

Isso cria uma restrição nas fotos: **o terço superior de cada slide precisa ser
escuro**, senão o menu branco desaparece sobre uma área clara da imagem.

Vou aplicar um gradiente sutil de proteção no topo, mas ele não salva uma foto
com céu branco atrás do menu. Vale considerar isso ao escolher as imagens.

---

### 2.3 Mosaico de categorias — o texto some no mobile

**O problema:** o título e o call-to-action de cada imagem aparecem só no
**hover**. Toque não tem hover — no celular, a pessoa vê um mosaico de fotos
sem título, sem contexto e sem chamada.

Como ~90% do tráfego é mobile, **a maioria do público veria a versão muda da
seção.**

**A solução usual:** no mobile o texto aparece sempre, sobre um gradiente
escuro na base de cada imagem. No desktop, mantém o comportamento de hover.

**O que preciso:** como você quer que fique essa versão mobile.

---

### 2.4 "Serralheria" → "Calhas" no mosaico

A primeira aba do mosaico está como "Serralheria". Precisa virar **"Calhas"**.

**Por quê:** serralheria é o **tipo de cliente**, não o nome do produto. Quem
quer comprar uma dobradeira de calha busca "dobradeira de calha", nunca
"serralheria". O site atual comete esse erro e é uma das principais razões de a
linha que mais vende ser invisível no Google.

"Serralheria" volta a ser usada depois, nas páginas por segmento de cliente —
que é onde a palavra funciona.

---

### 2.5 Rótulo trocado no exemplo do mosaico

No exemplo de hover, o texto diz **"DOBRADEIRA CNC"** sobre a máquina
**SF3015G**, que é um modelo de **laser**.

Se for só placeholder para demonstrar o efeito, tudo bem. Se foi engano, vale
corrigir — errar nome de produto num site cuja função é casar busca com máquina
tem custo comercial.

---

### 2.6 Estados dos componentes

O mockup mostra o estado ideal de cada elemento. Para a montagem, preciso dos
outros estados:

| Componente | Estados que preciso |
|---|---|
| **Botões** | normal, hover, foco (teclado), pressionado, desabilitado, carregando |
| **Campos de formulário** | vazio, foco, preenchido, **erro**, sucesso |
| **Links** | normal, hover, visitado, foco |
| **Cards** | normal, hover |

**Os mais importantes são erro e foco.** Sem o estado de erro, o formulário não
tem como avisar que o e-mail está inválido. Sem o de foco, quem navega por
teclado não vê onde está.

Não precisa desenhar tudo em detalhe — pode ser uma página no Figma com os
componentes e suas variações.

---

## BLOCO 3 — Validações de conteúdo

### 3.1 O texto do H1 vai mudar

O H1 atual — *"Encontre a máquina ideal para sua produção"* — não contém
nenhum termo de busca. Nem perfiladeira, nem dobradeira, nem laser.

Como o H1 é o elemento de SEO mais importante da página, ele vai precisar
incorporar a palavra-chave principal. A estrutura da frase comporta isso sem
prejudicar o layout, mas **o texto final ainda não está definido**.

**O que preciso:** que você saiba disso e não trave o layout numa contagem
exata de caracteres. O bloco precisa comportar uma ou duas palavras a mais.

---

### 3.2 Ajustes já alinhados — atualizar o Figma

Decisões já conversadas com a equipe. Registrando para o arquivo acompanhar:

| Item | Figma | Adotado | Razão |
|---|---|---|---|
| **Peso do H1 e H2** | Mitr Bold (700) | **Mitr SemiBold (600)** | O Bold da Mitr é bem mais estourado que o de uma grotesca comum. Em caixa alta ficava excessivo |
| **Tamanho do H1** | 56px | **56px** ✔ | Alinhado ao Figma (uma versão anterior estava em 64px) |
| **Line-height do H1** | 60px (1.07) | **1.1** | Em português, acento em caixa alta encosta na linha de cima a 1.07 |
| **Sombra nos botões** | — | **sem sombra** | Superfícies planas, coerente com o território industrial |

A escala completa ficou: **H1 56 · H2 45 · H3 36 · H4 29 · H5 23 · corpo 16**
(razão 1.25). O H3 permaneceu nos 36px que você definiu.

---

### 3.3 Números institucionais

A faixa mostra **+50 modelos**, **+30 anos**, **+300 máquinas/ano**.

"+30 anos" bate com a fundação em 1996. Os outros dois precisam ser conferidos
antes de virarem afirmação pública no site.

*(Esta validação é comigo e com a diretoria, não com você — só registrando
porque pode alterar o texto da seção.)*

---

### 3.4 Hierarquia de headings

Este é técnico e vale explicar, porque afeta como as seções são montadas.

**Nível de título (H1, H2, H3) é significado, não tamanho.** O H1 não é o texto
maior da página — é o assunto dela. O Google e os leitores de tela usam essa
hierarquia para entender a estrutura.

Na homepage, a marcação correta é:

| Nível | Onde |
|---|---|
| **H1** | Só o título do hero. **Um por página** |
| **H2** | "Aumente a produtividade", "Tecnologia que transforma", "Notícias", "Solicite seu orçamento", título de cada aba do mosaico |
| **H3** | "Suporte técnico", "Instalação profissional", "Pós venda", títulos dos cards de notícia |

**Duas armadilhas:**

- **"Aumente a produtividade" é H2**, apesar de aparecer grande. Se virar H1, a
  página fica com dois H1 e o Google não sabe qual é o assunto
- **Os números (+50, +30, +300) não são título.** São dados. Se marcados como
  H2, o Google passa a ler "+50" como um dos assuntos da página

O tamanho visual pode variar dentro do mesmo nível — título de card de notícia
é H3 e pode ter 24px, mesmo que o H3 padrão seja 36px. O que não se faz é
rebaixar para H4 só porque é menor.

---

### 3.5 Padrão de nomes de arquivo e alt text

Antes de subir a biblioteca de imagens, vale combinar o padrão — refazer depois
é caro.

**Nome do arquivo:** descritivo, minúsculo, com hífen, sem acento.
`perfiladeira-telha-trapezoidal.jpg` — não `IMG_4471.jpg`.

**Alt text:** descreve o que a imagem mostra, para quem não pode vê-la.
`Perfiladeira Fachini para telha trapezoidal em operação` — não "foto 1" nem
"logo".

Isso vale posição na busca por imagens, que no mercado industrial tem volume
real.

---

## BLOCO 4 — Necessário para o lançamento, mas não para a homepage

Estas três telas não existem no Figma e o site precisa delas antes de ir ao ar.

### 4.1 Página de "obrigado"

Para onde a pessoa vai depois de enviar o formulário.

Não é só cortesia — **é como a conversão é medida.** Sem uma URL própria de
confirmação, não dá para saber quantos formulários foram enviados de verdade.

Precisa ter: confirmação clara, prazo de retorno do comercial, e um próximo
passo (catálogo, WhatsApp, outras páginas).

### 4.2 Página de resultados de busca

Para onde a busca do menu leva. O tema não tem estilo próprio — sem desenho,
essa página sai crua: fundo branco, fonte serifada, lista sem formatação.

É a primeira coisa que a pessoa vê depois de usar a funcionalidade.

Precisa ter: os resultados, o termo buscado em destaque, e um estado de
"nenhum resultado encontrado" com sugestão de navegação.

### 4.3 Template de post do blog

A seção "Notícias" da home puxa do blog. O post individual não foi desenhado —
sem template, ele herda o padrão do tema, que é nenhum.

Precisa ter: título, data, imagem, corpo de texto (largura máxima 720px),
breadcrumb e um CTA ao final.

---

## RESUMO — o que preciso de você

**Esta semana (destrava a montagem):**

- [ ] Breakpoints usados no Figma
- [ ] Camada de largura anotada em cada seção
- [ ] Raio de borda, altura de campo, sombra, espaçamentos
- [ ] Frames de 1366px e 390px (wireframe)

**Em seguida (bloqueia seções):**

- [ ] Menu mobile
- [ ] Versão mobile do texto do mosaico
- [ ] "Serralheria" → "Calhas"
- [ ] Rótulo "DOBRADEIRA CNC" (confirmar se é placeholder)
- [ ] Estados dos componentes — prioridade para erro e foco
- [ ] Considerar o terço superior escuro nos slides do hero

**Ciente, sem ação imediata:**

- [ ] O texto do H1 vai mudar por SEO
- [ ] Hierarquia de headings na montagem
- [ ] Padrão de nome de arquivo e alt text

**Para o lançamento:**

- [ ] Página de obrigado
- [ ] Página de resultados de busca
- [ ] Template de post do blog
