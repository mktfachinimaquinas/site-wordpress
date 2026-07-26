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

> **Decisão 26/07/2026:** a árvore segue o Figma e o mapa do dono por ora, com
> foco na entrega. Os conflitos com a seção 7.1 do dossiê estão documentados em
> `docs/conflito-arvore-navegacao.md` para revisão depois do lançamento. O
> pacote on-page abaixo se aplica a qualquer estrutura.

O dossiê entrega as diretrizes de title. O trabalho é executar página a página.

**Camada 1 — LPs de produto** (já com diretrizes no dossiê):

| Página | Diretriz de title do dossiê |
|---|---|
| `/dobradeiras-de-chapa` | title/H1 devem conter "viradeira" (sinônimo forte no Sul) |
| `/dobradeiras-industriais` | title/H1 devem conter "CNC" — alta intenção. Avaliar LP extra `/dobradeira-cnc` |
| `/corte-a-laser-senfeng` | title: "Máquina de Corte a Laser Fibra Senfeng" — captura busca ampla + marca |
| `/perfiladeira-drywall` | slug cobre só drywall; não misturar Porta Palete/Painel EPS |
| Páginas de perfiladeira | **title/H1 devem conter "fabricante" ou "fábrica"** — território liberado pela decisão de posicionamento (seção 14 do dossiê). Ex.: "Perfiladeira de Telhas — Fabricante Nacional \| Fachini" |

**Camada 2 — Soluções por segmento** (LPs para tráfego pago + orgânico de cauda):

> **Esta camada não aparece na árvore do dono.** É a de maior impacto na
> conversão — destino dos ~2.000 leads/mês de mídia paga. Fica registrada para
> quando houver espaço de agenda; não bloqueia a entrega da homepage. Ver
> Conflito 1 em `docs/conflito-arvore-navegacao.md`.

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

### C.6 Pesquisa de palavra-chave — o que ainda não sabemos

Este é o maior buraco do plano atual, e vale nomear com franqueza: **o projeto
tem diretrizes de title, mas nenhum dado de busca.**

O dossiê diz "o title deve conter CNC" ou "deve conter viradeira" — recomendações
corretas, baseadas em conhecimento de mercado. Mas ninguém verificou volume,
dificuldade ou quem ocupa as três primeiras posições hoje. **Sem isso, mirar o
topo é palpite informado, não estratégia.**

**O que precisa ser levantado, por termo:**

| Dado | Por que importa |
|---|---|
| Volume mensal de busca | Separa o que vale esforço do que não move ponteiro |
| Quem ocupa as 3 primeiras posições | Define se o termo é vencível no curto prazo |
| Tipo de conteúdo que ranqueia | Se o topo é ocupado por blog, LP de produto não vence |
| Termos de cauda longa sem disputa | É por onde um domínio novo entra |

**Ferramentas, todas acessíveis:**

- **Planejador de Palavras-Chave do Google Ads** — a Fachini já tem conta ativa
  (gasta ~2.000 leads/mês em mídia). Dá volume e concorrência de graça
- **Search Console** — depois do go-live, mostra para o que o site já aparece,
  inclusive termos que ninguém imaginou
- **A própria SERP** — autocomplete, "As pessoas também perguntam" e buscas
  relacionadas são pesquisa qualitativa gratuita
- **Relatório de termos de pesquisa do Google Ads** — dado real de quem clicou e
  converteu, não estimativa. **Este é o mais valioso e ninguém está usando**

**Termos prioritários a validar** (com o território que a decisão de
posicionamento liberou):

```
fabricante de perfiladeiras          perfiladeira de telhas preço
fábrica de perfiladeiras             máquina de fazer telhas
perfiladeira nacional                quanto custa uma perfiladeira
dobradeira de calhas                 viradeira de calhas
dobradeira CNC                       guilhotina industrial
máquina de corte a laser preço       corte a laser fibra
como montar fábrica de telhas        perfiladeira steel frame
```

**Entrega esperada:** uma planilha em `seo/` com termo, volume, dificuldade,
página de destino e intenção. É ela que transforma a árvore em plano de SEO.

---

### C.7 Lacuna competitiva — o mapa mais barato que existe

O dossiê nomeia os concorrentes (Esquadros, Marafon, Maqperf, WeldVision, V8).
O que ninguém fez ainda é olhar **para o que eles ranqueiam e a Fachini não**.

**Método, sem ferramenta paga:** busque os 15 termos acima no Google, anônimo, e
registre quem aparece no top 3 e com que tipo de página. Em duas horas você tem
o mapa de onde há espaço e onde a briga é cara.

**O que procurar:**

- Termos onde **nenhum concorrente forte** aparece → entrada rápida
- Termos onde o topo é **conteúdo raso** → dá para superar com profundidade
- Termos onde o topo é **marketplace ou agregador** → difícil, evitar por ora
- Perguntas em "As pessoas também perguntam" sem resposta boa → pauta de blog

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

## Parte E — Autoridade: o fator que decide o top 1

> Esta é a parte que faltava no documento, e é a mais importante para o objetivo
> declarado. Vale ler antes de qualquer outra coisa desta análise.

### E.1 A verdade desconfortável

**É possível executar todo o resto deste documento com perfeição e ainda assim
não chegar ao primeiro lugar.**

SEO on-page — title, H1, schema, interlinking, performance — é condição
necessária, não suficiente. Ele coloca a página no jogo. Quem decide a posição
final, em termo competitivo, é a **autoridade do domínio**: quantos sites
relevantes apontam para o seu, e o quanto o Google confia na fonte.

O site atual da Fachini tem quase nenhuma autoridade construída. Isso não se
resolve com nada que está nas Partes A a D.

**O que isso significa na prática:**

- Termos de **cauda longa** ("perfiladeira para telha trapezoidal preço") são
  vencíveis já no lançamento, com on-page bem feito
- Termos **de cabeça** ("perfiladeira", "máquina de corte a laser") exigem
  autoridade e levam meses
- Prometer top 1 em termo de cabeça para o lançamento é promessa que não se
  cumpre. Prometer cauda longa é realista e defensável

### E.2 Os ativos de link que a Fachini tem e não usa

Aqui está a boa notícia: a empresa tem matéria-prima de autoridade que a maioria
dos concorrentes não tem, e nada disso está sendo explorado.

| Ativo | Como vira link ou citação |
|---|---|
| **4 unidades físicas** | Google Business Profile, diretórios locais, associações comerciais de cada cidade |
| **6.000 máquinas entregues** | Cases nomeados — cada cliente satisfeito é uma página e um possível link |
| **Clientes de porte** (Yoki, Aurora, Klabin, Minerva) | Menção em release, case conjunto, página de fornecedores homologados |
| **Parceria Senfeng** | Link do fabricante para o representante oficial no Brasil. Pedido simples, alto valor |
| **28 anos de operação** | Histórico rende pauta em veículos setoriais |
| **Feiras e eventos** | Listagem de expositor gera link de domínio com autoridade |
| **Fornecedores** | Muitos têm página "onde encontrar" — pedir inclusão |
| **Associações setoriais** | Filiação costuma gerar perfil com link |

**Nenhum desses exige verba de mídia.** Exigem pedido, relacionamento e tempo —
que é exatamente o que uma empresa de 28 anos tem de sobra e uma startup não.

### E.3 E-E-A-T — como o Google mede confiança

O Google avalia páginas por *Experience, Expertise, Authoritativeness, Trust*.
Em compra de ticket alto — e aqui se vende de R$ 25 mil a R$ 1,2 milhão — esse
peso é maior, porque a decisão do usuário tem consequência financeira séria.

**O que o site precisa exibir:**

| Sinal | Como implementar |
|---|---|
| **Quem escreve** | Artigos assinados por pessoa real, com cargo e experiência. Não "Equipe Fachini" |
| **Prova verificável** | CNPJ, endereços completos, telefones reais, tempo de mercado — no rodapé e na página institucional |
| **Experiência demonstrada** | Fotos próprias das máquinas e da fábrica, não banco de imagens. O layout já acerta nisso |
| **Cases com nome** | "Cliente X aumentou produção em Y%" vale muito mais que logo solto na parede |
| **Especificação honesta** | Tabelas técnicas completas, inclusive limitações. Página que só elogia o produto sinaliza publicidade, não informação |

**Ação para o Livro 1:** o site precisa **nascer preparado** para isso — estrutura
de autor no blog, página institucional com credenciais, schema de organização com
dados completos. A produção de cases e conteúdo assinado é Livro 2, mas a
estrutura não pode ser retrofit.

### E.4 A vantagem que ninguém pode copiar

O dossiê registra que a Fachini é a **única do mercado a assumir a marca Senfeng**.
Isso é mais que posicionamento comercial — é um ativo de SEO irreplicável no curto
prazo: buscas por "Senfeng Brasil", "Senfeng assistência", "corte a laser Senfeng"
deveriam todas terminar em fachinimaquinas.com.br.

Nenhum concorrente pode disputar esses termos sem assumir a mesma marca, coisa
que eles evitam por posicionamento. **É o caminho mais curto para as primeiras
posições em um conjunto de termos com intenção comercial real.**

---

## Parte F — Medição: sem isso, nada acima é verificável

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

## Parte G — Priorização e expectativa realista

### G.1 O que blinda o orgânico no lançamento (inegociável)

1. Googlebot livre ✅ + **noindex removido no go-live**
2. 100% das páginas com title/description/H1 corretos
3. Schema Organization + Product + LocalBusiness + Breadcrumb
4. Core Web Vitals verde no mobile
5. Sitemap + Search Console + IndexNow
6. Redirects 301 do site antigo
7. Formulário qualificador + medição de conversão
8. Interlinking entre páginas de produto
9. **Planilha de palavras-chave** (C.6) — sem ela, os titles são palpite

### G.2 Alta prioridade, logo após

10. SEO local das 4 unidades — o caminho mais rápido para primeira posição
11. Google Business Profile completo e verificado (é autoridade, não só mapa)
12. **Pedido de link à Senfeng** — baixo esforço, alto retorno (E.2)
13. 2-3 artigos pilares + Guia do Empreendedor
14. Open Graph por página
15. Estrutura de autor no blog e credenciais na institucional (E.3)

### G.3 Estrutural (Livro 2)

16. Os 10 artigos completos
17. Conteúdo técnico Senfeng — a vantagem irreplicável (E.4)
18. Cases nomeados com clientes
19. Construção sistemática de citações e links (E.2)
20. Configurador/experiência para competir com Esquadros

### G.4 Expectativa realista por horizonte

Vale alinhar isso com a diretoria antes de prometer resultado:

| Horizonte | O que é realista |
|---|---|
| **Lançamento + 30 dias** | Site indexado, aparecendo para o nome da marca e termos de cauda longa com pouca disputa. Search Console começando a mostrar impressões |
| **90 dias** | Primeiras posições em cauda longa e em busca local ("perfiladeira Curitiba"). Termos Senfeng bem posicionados |
| **6 meses** | Disputa real em termos de meio de cabeça, se o conteúdo e as citações avançarem |
| **12 meses+** | Termos de cabeça ("perfiladeira", "corte a laser") — dependem de autoridade acumulada |

**O ganho imediato do projeto não é orgânico.** É converter melhor os ~2.000
leads/mês de mídia paga que já chegam. O orgânico é o ativo que se constrói em
paralelo e reduz a dependência de mídia ao longo do tempo. Prometer top 1 em
termo de cabeça para o lançamento é o tipo de promessa que corrói credibilidade
interna quando não se cumpre.

---

## Resumo

O dossiê entregou a estratégia e a arquitetura. O que falta é execução
disciplinada em quatro frentes: **UX/UI** com estados e mobile de verdade,
**SEO técnico** página a página com schema e interlinking, **autoridade**
construída a partir de ativos que a empresa já tem e não usa, e **medição**
desde o primeiro visitante.

Três coisas que este documento acrescenta ao plano original:

1. **Sem pesquisa de palavra-chave, os titles são palpite** (C.6). O dado está
   disponível de graça na conta de Ads que a empresa já mantém.
2. **On-page não decide o top 1 sozinho** (E.1). Autoridade decide — e a Fachini
   tem ativos de link que nenhum concorrente tem: 4 unidades, 6.000 máquinas,
   clientes de porte e a parceria Senfeng.
3. **A janela Senfeng é o caminho mais curto para primeiras posições** (E.4).
   Nenhum concorrente pode disputar esses termos sem assumir a mesma marca.

A blindagem do orgânico não é truque — é o site inteiro no ar, rastreável,
rápido, sinalizando corretamente seu assunto, com conteúdo e autoridade
crescendo em paralelo.
