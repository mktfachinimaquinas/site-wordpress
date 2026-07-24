# Análise Estratégica 360 — UX/UI e SEO/SEM

**Projeto:** Site Fachini Máquinas — Livro 1
**Data:** 24/07/2026
**Objetivo do documento:** consolidar tudo que foi levantado e mapear o que
falta para (a) uma experiência UX/UI à altura da régua competitiva e (b) um SEO
técnico e de conteúdo que sustente as primeiras posições no orgânico.

> Este documento é estratégico e serve de norte para os módulos seguintes. As
> ações entram no `controle-projeto.md` conforme forem priorizadas. Nada aqui
> rediscute o dossiê — detalha a execução do que ele define.

---

## Parte A — Diagnóstico do ponto de partida

### A régua competitiva (dossiê seção 4)

O dossiê define três concorrentes como referência, cada um forte em um eixo:

| Concorrente | Força | O que significa para nós |
|---|---|---|
| **Esquadros** | Experiência digital — configurador 360° | A barra de UX/UI está alta. Site institucional comum não compete |
| **WeldVision** | Conteúdo + e-commerce, mesma cidade da unidade de Joinville | O motor de autoridade é conteúdo que responde objeção de compra |
| **Marafon** | Tradição + financiamento | Financiamento e prova têm que estar visíveis, não escondidos |

**Leitura:** o site não precisa vencer os três no mesmo eixo. Precisa não perder
feio em nenhum e vencer no que é exclusivo da Fachini — ser a voz da Senfeng no
Brasil, com conteúdo que nenhum concorrente de perfiladeiras tem.

### O que o site atual desperdiça (dossiê seção 5)

Contexto que justifica a urgência: ~2.000 leads/mês de mídia paga chegam a um
site que tem SEO de imobiliária (meta keywords de template de construtora nunca
trocadas), produto nº 1 escondido sob "Serralheria", formulário que aceita CNPJ
"00000" e zero conteúdo. **A conversão do tráfego que já existe é o ganho mais
rápido; o orgânico é o ganho estrutural.**

---

## Parte B — UX/UI: o que falta para "sofisticado"

O layout entregue é bom. Mas sofisticação de verdade está em camadas que o
mockup estático não mostra: microinterações, estados, consistência e a
experiência mobile. Abaixo, o que separa "bonito" de "sofisticado".

### B.1 Sistema de estados — o que quase todo site esquece

Um mockup mostra o estado ideal. Sofisticação é ter todos os estados desenhados:

| Componente | Estados que precisam existir |
|---|---|
| Botões | normal, hover, foco (teclado), pressionado, desabilitado, carregando |
| Campos de formulário | vazio, foco, preenchido, erro, sucesso, desabilitado |
| Links | normal, hover, visitado, foco |
| Cards | normal, hover, foco |
| Imagens | placeholder de carregamento (evita salto de layout) |

**Ação:** definir cada estado no design system antes da montagem. É o tipo de
coisa que, sem definir, cada seção resolve de um jeito.

### B.2 Microinterações com propósito

Não é enfeite — é feedback. O usuário precisa saber que o sistema respondeu.

- **Transições suaves** em hover e abertura de menu (200–300ms, nunca instantâneo
  nem lento)
- **Feedback de envio** no formulário: o botão vira "Enviando..." e desabilita,
  evitando duplo clique e mostrando que algo aconteceu
- **Scroll suave** nas âncoras internas (o CTA "Seja Cliente Fachini" que rola
  até o formulário)
- **Estados de carregamento** em qualquer coisa que dependa de rede

**Princípio:** toda ação do usuário recebe uma reação visível em menos de 100ms,
mesmo que a ação em si demore.

### B.3 A experiência mobile é a experiência principal

~90% do tráfego é mobile (dossiê). Isso inverte a lógica de design: o mobile
não é a versão reduzida do desktop, é o caso principal.

Pontos críticos já identificados:

- **Hover não existe em toque** — o CTA do mosaico, que hoje mora no hover,
  precisa de solução mobile (texto sempre visível sobre gradiente)
- **Alvos de toque** com no mínimo 44×44px — botão pequeno demais frustra
- **Menu hamburguer** precisa ser desenhado; o mockup só mostra o desktop
- **Formulário mobile** — campo com fonte ≥16px (senão o iOS dá zoom e a página
  salta), teclado correto por campo (numérico para telefone, e-mail para e-mail)
- **Peso da página** — imagem de máquina é pesada; sem otimização agressiva, o
  mobile sofre

**Ação:** desenhar os frames de 390px (mobile) e 1366px, hoje inexistentes.

### B.4 Hierarquia visual e ritmo

Sofisticação é o olho saber para onde ir sem esforço.

- **Um CTA primário por tela** — se tudo é vermelho e chama atenção, nada chama.
  O vermelho é o recurso escasso da paleta
- **Espaço em branco como ferramenta** — o dossiê nota que os concorrentes usam
  "muito espaço em branco"; respiro comunica sofisticação e confiança
- **Ritmo vertical consistente** — a escala de espaçamento de 8px serve a isso
- **Âncoras de leitura** — o olho descansa em pontos previsíveis a cada seção

### B.5 Confiança e prova (conversão é design, não só copy)

A decisão de compra é de R$25 mil a R$1,2 milhão. O site precisa transmitir
solidez em cada tela:

- **Prova social estruturada** — o dossiê aponta que os logos de clientes (WEG,
  Schneider, Açovisa nos concorrentes; os da Fachini) existem mas sem case. Logo
  solto vale pouco; logo + resultado vale muito
- **Números de credibilidade** — 28 anos, 6.000 máquinas, 4 unidades. Já estão
  no layout; precisam de destaque e veracidade conferida
- **Selos de financiamento** — Finame, BNDES. Os concorrentes exibem; a Fachini
  precisa igualar (dossiê define financiamento como paridade competitiva)
- **Fotografia real** — o layout já acerta nisso. Manter máquina real, não stock

### B.6 Acessibilidade — que também é SEO e alcance

Não é caridade: é alcance de mercado e sinal de qualidade para o Google.

- **Navegação por teclado** completa — o dropdown de "Máquinas" precisa abrir com
  Enter/Espaço e fechar com Esc
- **Contraste WCAG AA** — já verificado na paleta (feito)
- **Alt text** em todas as imagens — invisível ao Google e ao leitor de tela sem
  isso
- **Foco visível** — quem navega por teclado precisa ver onde está
- **`prefers-reduced-motion`** — versão sem animação para quem tem sensibilidade

---

## Parte C — SEO técnico: a blindagem para o orgânico

O objetivo do Livro 1 é primeira página no orgânico. Isso se sustenta em três
camadas: técnica (o site é rastreável e rápido), on-page (cada página sinaliza
seu assunto) e conteúdo (autoridade). Esta parte cobre a técnica e a on-page.

### C.1 Fundação técnica — o que não pode falhar

| Item | Status | Observação |
|---|---|---|
| Googlebot não bloqueado | ✅ resolvido | Country Blocking do Loginizer desativado |
| noindex removido no go-live | ⬜ checklist | O erro mais caro de lançamento |
| Sitemap XML calibrado | ⬜ | RankMath gera; precisa revisar o que entra |
| robots.txt correto | ⬜ | Não pode bloquear CSS/JS nem páginas relevantes |
| IndexNow ativo | ⬜ | RankMath suporta — avisa o Bing/Google de mudanças |
| Core Web Vitals verde mobile | ⬜ | Métrica de sucesso do Livro 1 |
| HTTPS em tudo | ⬜ | Sem conteúdo misto |
| URLs limpas | ✅ definido | Slugs da árvore 7.1 já são limpos |
| Canonical tags | ⬜ | Evita conteúdo duplicado |
| Redirects 301 do site antigo | ⬜ | Preserva autoridade das URLs com tráfego |

### C.2 On-page página a página (a partir da árvore de navegação)

> ⚠ **A árvore de navegação está em disputa** (ver
> `docs/conflito-arvore-navegacao.md`). O dono definiu uma árvore só de produto;
> a camada de Soluções do dossiê pode não existir nela. As diretrizes de title
> abaixo, vindas do dossiê, valem para as páginas que forem construídas — mas
> **quais páginas existem** depende da decisão pendente. O pacote on-page (title,
> description, H1, schema) se aplica a qualquer estrutura que vencer.

O dossiê entrega as diretrizes de title. O trabalho é executar página a página —
sobre a árvore que for decidida.

**Camada 1 — LPs de produto** (já com diretrizes no dossiê):

| Página | Diretriz de title do dossiê |
|---|---|
| `/dobradeiras-de-chapa` | title/H1 devem conter "viradeira" (sinônimo forte no Sul) |
| `/dobradeiras-industriais` | title/H1 devem conter "CNC" — alta intenção. Avaliar LP extra `/dobradeira-cnc` |
| `/corte-a-laser-senfeng` | title: "Máquina de Corte a Laser Fibra Senfeng" — captura busca ampla + marca |
| `/perfiladeira-drywall` | slug cobre só drywall; não misturar Porta Palete/Painel EPS |

**Camada 2 — Soluções por segmento** (LPs para tráfego pago + orgânico de cauda):

> ⚠ **Esta camada não aparece na árvore do dono.** É a de maior impacto na
> conversão — destino dos ~2.000 leads/mês de mídia paga. Confirmar com o dono
> onde as Soluções moram antes de tratar como definitiva. Ver Conflito 1 em
> `docs/conflito-arvore-navegacao.md`.

| Segmento | Slug |
|---|---|
| Calheiros e funileiros | `/solucoes/calhas-e-coifas` |
| Fabricantes de telhas | `/solucoes/fabrica-de-telhas` |
| Serralherias e móveis metálicos | `/solucoes/serralherias` (serralheria válido como SEGMENTO) |
| Metalúrgicas e caldeirarias | `/solucoes/metalurgica-e-industria` |
| Guia do Empreendedor | `/solucoes/como-montar-fabrica-de-telhas` (captura com material rico) |

**Para cada página, o pacote on-page:**

- Title único, ≤60 caracteres, com a palavra-chave no começo
- Meta description ≤155 caracteres, com chamada à ação
- Um H1 único, com a palavra-chave
- Hierarquia H2/H3 correta
- URL limpa (já definida)
- Imagens com alt text descritivo
- Interlinking (ver C.4)

### C.3 Schema / dados estruturados

Schema é o que faz o Google entender o conteúdo e exibir resultado rico (estrelas,
preço, FAQ expandido). Ganho de clique sem ganho de posição.

| Schema | Onde | Ganho |
|---|---|---|
| `Organization` | Home | Painel de conhecimento, logo na busca |
| `LocalBusiness` | Cada unidade (4x) | Aparece no map pack — "perfiladeira Curitiba" |
| `Product` | Cada LP de máquina | Resultado rico de produto |
| `BreadcrumbList` | Todas as páginas internas | Trilha na busca |
| `FAQPage` | LPs com dúvidas frequentes | Ocupa mais espaço na SERP |
| `Article` | Posts do blog | Elegibilidade a destaque de notícia |

RankMath configura todos. Precisa ser feito página a página no módulo de SEO.

### C.4 Interlinking — a arma subestimada

Link interno distribui autoridade e ensina o Google a relação entre páginas.
É o que mais falta nos concorrentes e é de graça.

Estrutura:

- **LP de produto → Soluções** que a usam ("esta perfiladeira atende [fábrica de
  telhas]")
- **Soluções → LPs de produto** indicadas para o segmento
- **Blog → LP** relacionada (artigo "quanto custa fábrica de telhas" → LP da
  perfiladeira + Guia do Empreendedor)
- **Home → Camada 1** direto (o menu já faz parte disso)

### C.5 SEO local — 4 unidades, canal subaproveitado

Curitiba, Joinville, Cascavel, Chapecó. Busca com cidade resolve no map pack
antes do orgânico tradicional. Custo baixo, retorno direto.

- Google Business Profile das 4 unidades, completo e verificado
- NAP (Nome, Endereço, Telefone) idêntico ao do site — grafia igual, byte a byte
- Schema `LocalBusiness` por unidade
- Página de contato com as 4 unidades e mapa incorporado

---

## Parte D — Conteúdo e SEM

### D.1 Estratégia de conteúdo (dossiê 7.3)

O dossiê define 10 artigos que "resolvem o funil". Não é blog por blog — cada
artigo responde uma objeção real de compra e alimenta a nutrição do RD.

**Fronteira do Livro 1 (proposta):** entregar a estrutura do blog + o material
rico do Guia do Empreendedor (requisito da LP `/solucoes/como-montar-fabrica-de-telhas`)
+ 2-3 artigos pilares para o interlinking nascer. Os 10 completos são Livro 2.

Os 2-3 pilares sugeridos, por potencial de tráfego e posição no funil:

1. "Quanto custa montar uma fábrica de telhas em 2026" — topo de funil, alto volume
2. "Perfiladeira de telhas: guia de compra" — meio de funil, alta intenção
3. "Financiamento de máquinas: Finame, leasing, CDC" — fundo de funil, remove objeção

### D.2 A janela Senfeng

O dossiê marca como oportunidade única: a Fachini é a voz da Senfeng no Brasil,
e nenhum concorrente de laser tem conteúdo educativo. Isso é um oceano azul de
SEO — buscas técnicas sobre corte e solda a laser sem ninguém respondendo bem.

**Ação (provável Livro 2, mas registrar):** conteúdo técnico de laser posiciona
a Fachini como autoridade antes de a Senfeng abrir operação própria. Janela
temporal — aproveitar cedo.

### D.3 Integração com mídia paga (SEM)

O dossiê aponta ~2.000 leads/mês de mídia paga. O site novo precisa:

- **LPs de Soluções como destino dos anúncios** — não jogar tráfego pago na home
- **Consistência mensagem do anúncio → título da LP** — quem clica em "fábrica de
  telhas" tem que cair numa página sobre fábrica de telhas
- **Rastreamento de conversão por origem** — saber qual campanha traz lead
  qualificado, não só lead
- **Retargeting instrumentado** — pixel Meta já ativo (dossiê); estruturar público

### D.4 Open Graph — SEM orgânico no WhatsApp

Quando o vendedor manda o link de uma máquina no WhatsApp — canal principal da
linha leve — a prévia com foto e título vem das tags Open Graph. Sem elas, link
cru. RankMath configura; precisa de imagem por página de produto.

---

## Parte E — Medição: sem isso, nada acima é verificável

O dossiê define métricas de sucesso (7.4) e todas dependem de instrumentação
desde o dia 1.

| O que medir | Como | Status |
|---|---|---|
| Conversão visitante→lead | GA4 + evento de form | ⬜ |
| Origem do lead (qual CTA) | Eventos GTM distintos | ⬜ |
| % de leads com verba/prazo | Campos do form → RD | ⬜ bloqueado pela spec |
| Custo por lead qualificado | RD + origem de mídia | ⬜ |
| Posições orgânicas | Search Console | ⬜ |
| Core Web Vitals reais | Search Console + PageSpeed | ⬜ |

**Decisões pendentes que bloqueiam:** reaproveitar o GTM existente ou criar
limpo? Existe GA4? Quem tem acesso ao Search Console? (registradas no controle)

---

## Parte F — Prioridação: o que blinda o orgânico nas 2 semanas

Nem tudo cabe. Ordem por impacto no objetivo "primeira página":

**Blindagem mínima do lançamento (inegociável):**

1. Googlebot livre ✅ + noindex removido no go-live
2. 100% das páginas da árvore com title/description/H1 corretos
3. Schema Organization + Product + LocalBusiness + Breadcrumb
4. Core Web Vitals verde no mobile
5. Sitemap + Search Console + IndexNow
6. Redirects 301 do site antigo
7. Formulário qualificador + medição de conversão
8. Interlinking Camada 1 ↔ Camada 2

**Alta prioridade, logo após:**

9. SEO local das 4 unidades
10. 2-3 artigos pilares + Guia do Empreendedor
11. Open Graph por página

**Estrutural (Livro 2):**

12. Os 10 artigos completos
13. Conteúdo técnico Senfeng
14. Configurador/experiência para competir com Esquadros
15. Material rico por segmento

---

## Resumo de uma linha

O dossiê já entregou a estratégia e a arquitetura. O que falta é execução
disciplinada em três frentes paralelas: **UX/UI** com estados e mobile de
verdade, **SEO técnico** página a página com schema e interlinking, e **medição**
desde o primeiro visitante. A blindagem do orgânico não é um truque — é 100% da
árvore no ar, rastreável, rápida e sinalizando corretamente seu assunto, com
conteúdo nascendo para dar autoridade.
