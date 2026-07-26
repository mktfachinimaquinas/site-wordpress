# Árvore de Navegação — Conflito a Resolver

**Data:** 24/07/2026
**Situação:** o dono da empresa definiu uma árvore de navegação (mapa mental no
Figma) que diverge da arquitetura da seção 7.1 do dossiê em três pontos.

> **Status atual:** a árvore do dono **prevalece por enquanto**, por decisão do
> Wilson. Este documento registra os conflitos com argumento de negócio para
> eventual defesa junto à diretoria. Não altera nada — é material de decisão.

---

## A árvore definida pelo dono

```
Máquinas
├── Home
├── Quem somos
├── Calhas
├── Perfiladeiras
│   ├── Cobertura e Fachada → Simples / Dupla / Tripla
│   ├── Estruturais → C purlin / C·U·Z / Dry wall / Steel frame / Porta de enrolar
│   ├── Armazenagem → Prateleira coluna / Prateleira longarina
│   ├── Infraestrutura → Guard rail
│   ├── Agrícola → Silo chapa / Silo coluna
│   └── Desbobinadores → 1500kg / 10 ton manual / 10 ton elétrico hidráulico
├── Corte e dobra
│   ├── Dobradeiras → CN
│   ├── Guilhotinas
│   └── Metaleira
├── Laser
│   ├── Corte a laser → Chapa aberto / Chapa fechado / Combinado tubos e chapas / Tubos
│   └── Solda a laser
├── Contato
└── Como chegar
```

---

## Conflito 1 — Camada de Soluções ausente ⚠ o mais grave

**A árvore do dono não contém a camada de Soluções por segmento.**

O dossiê (7.1, Camada 2) define 5 LPs de Soluções — `/solucoes/calhas-e-coifas`,
`/solucoes/fabrica-de-telhas`, `/solucoes/serralherias`,
`/solucoes/metalurgica-e-industria`, `/solucoes/como-montar-fabrica-de-telhas`
— e as descreve como **o destino do tráfego pago segmentado**.

**Por que importa:** o dossiê aponta ~2.000 leads/mês vindos de mídia paga. A
recomendação estratégica é não jogar esse tráfego na home, e sim em LPs de
segmento com mensagem casada ao anúncio. Sem essa camada, o maior canal de
aquisição atual perde seu destino otimizado.

**Hipótese conciliadora:** o dono pode ter mapeado apenas o menu de produtos, e
Soluções viver em outro caminho (rodapé, LPs sem entrada no menu principal,
campanhas). **Isso precisa ser confirmado antes de tratar como conflito real.**

**Pergunta para o dono/diretoria:** onde moram as páginas de Soluções por
segmento? Se não existirem, o tráfego pago perde o destino que o dossiê
desenhou.

---

## Conflito 2 — "CNC" enterrado dentro de "Corte e dobra"

**Árvore do dono:** Corte e dobra → Dobradeiras → CN

**Dossiê (7.1, Camada 1):** `/dobradeiras-industriais` como LP própria, com a
diretriz literal: *"title/H1 devem conter CNC — termo de alta intenção;
avaliar LP adicional `/dobradeira-cnc` para capturar a busca técnica."*

**Por que importa:** "dobradeira CNC" é uma busca de alta intenção de compra —
quem digita isso está perto de comprar. O dossiê manda destacar o termo. A
árvore do dono o enterra três níveis abaixo (Corte e dobra > Dobradeiras > CN),
onde tem pouco peso de SEO e fica difícil de achar.

**Argumento para a diretoria:** cada nível de profundidade dilui autoridade de
SEO e adiciona um clique. Uma LP de primeiro nível para "Dobradeira CNC" captura
busca que hoje vai para o concorrente. É dinheiro na mesa.

---

## Conflito 3 — "Calhas" subdimensionada

**Árvore do dono:** "Calhas" como item solto no topo, sem subdivisões.

**Dossiê:** a linha Lisa/Dentada (dobradeiras/viradeiras de calha) é **60% do
volume de vendas** e a **linha de fabricação própria mais antiga (desde 1996)** — o maior ativo de
comunicação da empresa. Slug definido: `/dobradeiras-de-chapa`, com a diretriz
de que title/H1 contenham "viradeira" (sinônimo forte no Sul).

**Por que importa:** o produto que mais vende aparece como um link simples,
sem a estrutura que Perfiladeiras (que tem 6 subcategorias) recebe. Há risco de
subaproveitar comercialmente a linha mais forte e o único diferencial de
"fabricação própria".

**Argumento para a diretoria:** a linha de maior volume merece, no mínimo,
paridade de destaque com Perfiladeiras. E a origem em 1996 é um argumento
de venda que nenhum concorrente importador pode usar — esconder isso é abrir
mão de vantagem única.

---

## Conflito 4 — Profundidade de navegação

**Árvore do dono:** até 4 níveis (Máquinas → Perfiladeiras → Estruturais →
C·U·Z).

**Evidência interna:** a própria análise de concorrentes feita pela designer
anotou como pontos negativos: *"muitas subdivisões dificulta o caminho"* e
*"breadcrumbs escondidas demais"* (observações sobre DSM e outros).

**Por que importa:** 4 cliques até o produto é fricção de conversão, e a
autoridade de SEO se dilui a cada nível. O padrão recomendado é no máximo 3
níveis até qualquer produto.

**Argumento para a diretoria:** a granularidade é boa para SEO de cauda longa
(cada subtipo pode ser uma página que captura busca específica), mas não precisa
estar toda no **menu**. A estrutura de URLs pode ser profunda; a navegação
visível deve ser rasa. Menu mostra as categorias principais; as subcategorias
aparecem na página da categoria, não no dropdown.

---

## O que NÃO conflita (a árvore do dono acerta)

- **"Calhas" em vez de "Serralheria"** — resolve o bloqueador nº 1 do dossiê. O
  dono usou o termo de produto, não o de segmento. ✔
- **Perfiladeiras abertas por aplicação** (Cobertura, Estrutural, Agrícola...) —
  é exatamente a lógica "produto + aplicação" que o dossiê pede. ✔
- **Laser com Corte e Solda separados** — coerente com o dossiê. ✔
- **"Como chegar"** — bom para SEO local, reforça as 4 unidades. ✔

---

## Recomendação de encaminhamento

1. **Confirmar primeiro o Conflito 1** (Soluções) — pode não ser conflito, e é o
   de maior impacto. Pergunta direta ao dono.
2. **Levar Conflitos 2 e 3 à diretoria com argumento de receita** — CNC e Calhas
   são busca de alta intenção e o produto de maior volume. O argumento não é
   estético, é comercial.
3. **Conflito 4 tem meio-termo técnico** — manter a profundidade nas URLs (bom
   para SEO), reduzir no menu visível (bom para UX). Não exige escolher um lado.

**Enquanto não há decisão:** a árvore do dono vale. Nenhuma página é construída
sobre estrutura em disputa até isso fechar — o que reforça começar pela
fundação (Módulo 1) e pelo header, que não dependem da árvore final de produtos.
