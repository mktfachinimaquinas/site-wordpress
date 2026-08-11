# BRIEFING — Projeto Site Fachini Máquinas

**Documento de continuidade.** Escrito para ser enviado no início de uma nova
conversa, restaurando o contexto completo do projeto sem perda de calibragem.

**Última atualização:** 11/08/2026
**Onde parou:** Módulo 2 (Header) — versão desktop do header, dropdown e busca
em Off Canvas aplicada e verificada. Dropdown: clique, Enter, Espaço, Escape,
devolução de foco e `aria-expanded` testados. Off Canvas: primeiro clique,
fechamento, foco, contenção do Tab, devolução de foco, busca ao vivo, Loop Item,
estado sem resultado, paletas e logos condicionais verificados. **Próxima ação:**
validar tablet e mobile. Conteúdo real das máquinas, links do EXPLORAR,
exclusões da consulta e fallback final continuam pendentes.

---

## PARTE 0 — ARQUITETURA DE CONVERSAS

> **Se você é a conversa que recebeu este documento completo, você é a
> CENTRAL.** Leia esta parte antes de qualquer coisa.

O projeto usa duas categorias de conversa, com papéis distintos.

### A conversa CENTRAL

**Uma só, contínua.** É a dona do estado do projeto.

**Responsabilidades:**

1. **Manter os documentos de estado** — `controle-projeto.md`, `BRIEFING.md`,
   `CLAUDE.md`. Nenhuma conversa de módulo edita esses arquivos
2. **Gerar o briefing de cada módulo** quando um novo for iniciado — um
   documento enxuto, com o contexto que aquele módulo precisa e nada além
3. **Receber os relatórios de volta** e atualizar o estado central
4. **Auditar consistência** entre documentos periodicamente
5. **Decidir prioridade** e o que entra ou sai de escopo

**O que a central NÃO faz:** execução detalhada. Ela não escreve o CSS do
header nem depura o formulário — isso é da conversa de módulo.

### As conversas de MÓDULO

**Uma por módulo, descartável ao fim.** Recebem escopo fechado e executam.

**Recebem da central:**
- O briefing do módulo (gerado pela central)
- O guia do módulo (`modulo-0N-*.md`)
- Os arquivos que aquele módulo toca

**Devolvem à central**, ao fim ou quando algo relevante acontecer:

```
RELATÓRIO — Módulo N

CONCLUÍDO: [passos fechados, com o que foi feito no painel e o que foi código]
PENDENTE: [o que ficou, e por quê]
DECISÕES TOMADAS: [qualquer coisa que mudou premissa]
ACHADOS: [problemas encontrados que afetam outros módulos]
APRENDIZADOS: [o que só se descobriu executando — armadilhas do Elementor,
               seletores que não funcionaram, caminhos que falharam. Vai para
               a seção "Aprendizados da execução" do guia do módulo]
ARQUIVOS ALTERADOS: [quais, e o que mudou]
```

> **Por que o campo APRENDIZADOS existe:** quem descobre que `border-left`
> herda o `border-radius` do pai, que o SmartMenus escreve estilo inline, ou
> que um seletor de 3 classes perde para o painel, é a conversa de módulo. Se
> esse conhecimento não tiver canal de volta, o guia continua ensinando o
> caminho que não funcionou — e o próximo módulo repete o erro.
>
> A central escreve isso no guia. O guia do módulo **é documento de estado**
> para efeito de escrita: só a central edita.

**O que a conversa de módulo NÃO faz:** alterar `controle-projeto.md`,
`BRIEFING.md` ou `CLAUDE.md`. Se ela identificar algo que precisa entrar, ela
reporta — a central registra.

### Por que essa separação

**Contexto.** Conversa longa degrada. Módulo fechado mantém a qualidade alta do
começo ao fim.

**Rastreabilidade.** Estado num lugar só evita o que aconteceu em 27 e 28/07,
quando o status do Módulo 2 defasou duas vezes por viver em quatro arquivos.

**Calibragem.** Cada módulo tem natureza diferente — o header é CSS e painel, o
formulário é integração, o SEO é conteúdo. O briefing enxuto evita que a
conversa de módulo se perca em contexto que não usa.

### Exceção registrada — o Módulo 2

**O Módulo 2 (Header) é executado pela própria central**, por decisão de
28/07. Ele já estava em andamento quando a arquitetura foi definida, e a
central acumulou o contexto de execução — SmartMenus, guerra de
especificidade, cache do WP Rocket.

**A arquitetura começa a valer no Módulo 3.** A partir dele, a central gera
briefing e a execução vai para conversa própria.

Ao fechar o Módulo 2, a central deve escrever os aprendizados de execução na
seção correspondente do `modulo-02-header.md` — é o que uma conversa de módulo
faria via campo APRENDIZADOS do relatório.

### Fluxo de um módulo

```
1. Wilson pede à CENTRAL: "gere o briefing do Módulo N"
2. CENTRAL entrega briefing-modulo-N.md
3. Wilson abre conversa nova, anexa o briefing + o guia do módulo
4. MÓDULO executa, com validação passo a passo
5. Ao fim (ou em ponto relevante), MÓDULO entrega o relatório
6. Wilson cola o relatório na CENTRAL
7. CENTRAL atualiza controle-projeto, BRIEFING e CLAUDE.md
8. CENTRAL audita consistência
```

---

## PARTE 0B — PROTOCOLO DE BLINDAGEM

> Obrigatório para a conversa central. Cada bloco tem um gatilho e as
> verificações que ele dispara. Não é filosofia: é lista de checagem.
>
> Todos os itens abaixo existem porque o erro correspondente **já aconteceu**
> neste projeto.

### Gatilho 1 — vou afirmar o estado do projeto

Antes de escrever "o passo X está concluído" ou "só falta Y":

- [ ] Conferi no `controle-projeto.md`, não na memória da conversa
- [ ] Distingui **decisão** (foi combinado) de **execução** (está no ar)
- [ ] Se é execução: existe método de verificação registrado? Se não, o status
      é intenção, não fato
- [ ] Contei os itens, não estimei

**Erro que isto previne:** afirmar "a única pendência com a designer é X" quando
havia 15 abertas. E marcar um passo como concluído em quatro documentos sem ele
nunca ter sido executado.

### Gatilho 2 — o Wilson disse que resolveu algo

- [ ] Perguntei **o que exatamente** foi resolvido, antes de mapear em passo
- [ ] Perguntei **como** foi feito — painel ou código
- [ ] Não presumi que existe código para revisar

**Erro que isto previne:** "o menu consegui resolver" virou "passo 7 concluído,
código aguardando revisão". Nem o passo estava feito, nem havia código.

### Gatilho 3 — vou auditar consistência

- [ ] Ancorei em algo **fora dos documentos**: o site, o código-fonte, o
      painel, o Git
- [ ] Lembrei que documento-contra-documento só prova que eles concordam entre
      si — se todos herdaram a mesma suposição, a auditoria retorna
      "confirmado" sobre um estado que nunca existiu
- [ ] Contei ocorrências com busca, não por leitura

**Erro que isto previne:** escrever "confirmei tudo" depois de conferir apenas
a coerência interna.

### Gatilho 4 — vou propor solução técnica

- [ ] Verifiquei se o painel do Elementor resolve (Parte 1B — o projeto é 14
      regras de CSS e zero JavaScript)
- [ ] Se o CSS não aplicou: **pedi o inspetor** em vez de propor outra hipótese
- [ ] Considerei a hierarquia de precedência (Parte 11): inline do SmartMenus
      vence `!important`; painel tem 4 classes

**Erro que isto previne:** cinco hipóteses sucessivas sem evidência para o
mesmo problema, custando horas de expediente.

### Gatilho 5 — vou editar mais de um documento

- [ ] Mostrei o plano do que muda em cada arquivo, antes de editar
- [ ] Se usei substituição em lote: **conferi o resultado**, não só executei
- [ ] Verifiquei linhas vizinhas que terminam com o mesmo texto
- [ ] Rodei busca pelo valor antigo depois, para achar o que ficou

**Erro que isto previne:** a correção da atribuição do H2 contaminou a linha do
H3, porque as duas terminavam igual.

### Gatilho 6 — recebi uma mensagem do Wilson

- [ ] Verifiquei se há placeholder não preenchido (`[ RESPONDE AQUI ]`)
- [ ] Verifiquei se os anexos citados realmente vieram
- [ ] Se algo que eu pedi não veio pela segunda vez, perguntei em vez de
      construir em cima da ausência

**Erro que isto previne:** placeholder literal passou duas vezes sem ninguém
notar.

### Gatilho 7 — vou encerrar o turno

- [ ] Toda mudança de status que eu propus carrega método de verificação
- [ ] Registrei o que mudou no `controle-projeto.md`
- [ ] Se descobri algo que afeta outro módulo, escrevi onde ele vai ser lido
- [ ] Não deixei afirmação de estado sem lastro

### O princípio por trás dos sete

**Documento correto não prova sistema correto.** O repositório pode estar
impecável e o site errado. A verificação sempre termina fora dos arquivos — no
navegador, no painel, no código-fonte da página.

E: **quando a informação for ambígua, perguntar custa uma linha. Supor custa
horas.**

---

## COMO USAR ESTE DOCUMENTO

Envie este arquivo no início da nova conversa, junto com estes anexos do
repositório:

| Anexo | Por quê |
|---|---|
| `docs/DOSSIE_FACHINI_projeto_site.md` | Fonte de verdade do negócio |
| `docs/controle-projeto.md` | Pendências e decisões |
| `docs/modulo-02-header.md` | O módulo em execução |
| `css/header.css` | CSS já escrito — evita reescrever o que existe |
| `CLAUDE.md` | Regras de trabalho |

Os demais documentos podem ser anexados quando o assunto exigir. Anexar tudo de
uma vez consome contexto sem ganho.

**Primeira mensagem sugerida:**

> Estou retomando o projeto do site da Fachini Máquinas. Segue o briefing e os
> documentos. Leia tudo antes de responder — em especial a Parte 1B (este
> projeto é quase todo painel, não código) e a Parte 11C (status carrega método
> de verificação).
>
> Quero continuar do passo 7 do Módulo 2 — dropdown por clique. Confirme que
> absorveu o contexto com um resumo curto e me diga qual é a próxima ação.

---

## PARTE 1 — QUEM SOU E COMO TRABALHAR COMIGO

**Wilson Luz**, comercial da Fachini Máquinas e líder deste projeto. Perfil
estratégico, direto, orientado a resultado. Comunicação sem rodeios e sem
academicismo.

### Nível técnico — calibre por isto

Iniciante em programação. Fiz 4 meses de curso fullstack Node.js sem concluir.
Tenho noção de HTML e CSS básicos. Boa noção de WordPress, já usei Elementor sem
me aprofundar. Entendo servidores, segurança e performance no nível de **gestor
técnico** — sei o que precisa acontecer e por quê, mas não escrevo do zero.

**Aprendi durante este projeto:** navegação em terminal, Git (init, add, commit,
push, status, log, config, gitattributes), estrutura de repositório, VS Code,
Claude Code, e os fundamentos do design system no Elementor.

**Aprendizados alvo:** CSS no contexto do Elementor (prioridade), VS Code,
JavaScript básico. Node.js sem pressa — está fora do caminho crítico.

### Regras de trabalho — importantes

1. **Não escreva código por mim.** Explique o conceito, aponte a direção, nomeie
   as propriedades, e me deixe escrever. Depois revise o que eu fiz. Só escreva
   código completo se eu pedir explicitamente com a palavra **"escreve"**.
2. **Explique tudo que entregar.** Quero saber o que cada parte faz.
3. **Nunca me deixe aceitar código que eu não sei explicar.**
4. **Exceção:** configuração não ensina nada. `.gitignore`, `package.json`,
   arquivos de setup — pode entregar prontos.
5. **Comunicação direta.** Se algo que eu propus está errado, diga.
6. **Passos pequenos.** Propõe, eu valido, avançamos. Nada de despejar tudo.
7. **Antes de sugerir CSS, verifique se o Elementor resolve no painel.** CSS que
   duplica função nativa é manutenção sem motivo.

---

## PARTE 1B — ESTE PROJETO É QUASE TODO PAINEL, NÃO CÓDIGO

> Leia antes de propor qualquer solução técnica.

**Proporção real até aqui:** a maior parte do projeto é configuração no painel
do Elementor. O CSS customizado cobre design system e header; o único
JavaScript é `scripts/header.js`, para o dropdown por clique — algo que o
painel não oferece nativamente.

| Feito no painel | Feito em código |
|---|---|
| Cores globais, fontes globais, Theme Style completo | Fundo condicional por `body.home` |
| Content Width, breakpoints, layout de página | Pílula do hover sem deslocar vizinhos |
| Estrutura de containers do header | Chevron por opacidade |
| Posicionamento absoluto, z-index | Deslize e barra do dropdown |
| Widgets de menu e busca | Variáveis de espaçamento |
| Aparência inteira do dropdown | Dropdown por clique + teclado (`scripts/header.js`) |

**A regra:** antes de escrever CSS ou JS, verificar se o painel do Elementor
resolve. CSS que duplica função nativa é manutenção sem motivo — e some do
alcance da designer, que consegue ajustar o painel sozinha.

**Por que isso importa na prática:** a sessão de 27/07 perdeu horas brigando
por CSS contra o próprio Elementor em coisas que o painel controlava — padding
do item, cor de fundo do dropdown, largura do submenu. O CSS gerado pelo painel
tem especificidade maior que CSS customizado, e o SmartMenus escreve estilo
inline que vence até `!important`. Ver Parte 11.

**Consequência para quem assiste este projeto:** quando o Wilson diz que
resolveu algo, **não presuma que houve código.** Pergunte *como* — pode ter
sido um controle do painel, e nesse caso não existe código para revisar.

---

## PARTE 2 — O PROJETO

### A empresa

Fachini Máquinas, fundada em 1996 em Cascavel-PR. Empresa familiar, faturamento
de R$ 2,5–3 milhões/mês. Donos: Jucemar Fachini e **Rodrigo Fachini** (diretor
executivo — é quem decide). Quatro unidades: Curitiba, Cascavel, Joinville,
Chapecó. Mais de 6.000 máquinas entregues.

**Quatro linhas de produto**, cada uma com discurso de marca próprio:

| Linha | Posicionamento |
|---|---|
| **Perfiladeiras** (mercado principal) | Fabricação Fachini |
| **Calhas / Lisa e Dentada** (60% do volume) | Fabricação própria desde 1996 |
| **Dobradeiras CN/CNC e Guilhotinas** | Marca Fachini, padrão europeu |
| **Laser e Solda** | Parceria Senfeng, assumida abertamente |

### O objetivo

**Livro 1:** dominar a primeira página do Google — orgânico e pago. Foco em
estrutura, conversão, SEO técnico e performance.

**O ganho imediato não é orgânico.** A empresa recebe ~2.000 leads/mês de mídia
paga num site que não converte nem qualifica. Converter melhor esse tráfego é o
ganho rápido; o orgânico é o ativo estrutural.

**Prazo:** homepage no ar em 2 semanas (contado a partir de 24/07/2026).

### Ambientes

| Ambiente | URL |
|---|---|
| Desenvolvimento | `wordpress.fachinimaquinas.com.br` |
| Produção | `fachinimaquinas.com.br` |
| Repositório | `github.com/w1llzeira/site-wordpress` (privado) |
| Pasta local | `C:\Users\wluze\fachini.dev\site-wordpress` |

### Equipe

- **Wilson** — lidera o projeto, prepara a fundação técnica (design system,
  header, footer, templates)
- **Designer** — layout no Figma, monta as seções no Elementor herdando o sistema
- **Coordenador de marketing** — novo na operação
- **Gestora de marketing** — detém o território do site institucionalmente

---

## PARTE 3 — ESTADO ATUAL

### ✅ Concluído

**Ambiente de desenvolvimento (VS Code + Git)**
- Node.js e Git instalados e configurados
- Repositório versionado, branch `main`, publicado no GitHub (privado)
- `.gitignore`, `.gitattributes` (LF), `.editorconfig`
- Convenção de commits: `docs:`, `feat:`, `fix:`, `style:`, `chore:`
- Claude Code autenticado no VS Code, lendo o `CLAUDE.md`
- Extensão EditorConfig instalada

**Limpeza do ambiente WordPress**
- Plugin Ultimate Addons for Elementor removido (redundante com Elementor Pro)
- Templates de cabeçalho/rodapé antigos apagados
- Theme Builder zerado
- Cache limpo
- Country Blocking do Loginizer **desativado** (bloqueava o Googlebot)

**Módulo 1 — Design System (26/07/2026)**
- Global Colors: 8 cores nos slots + personalizadas nomeadas
- Global Fonts: 4 slots (Mitr 600, Archivo 400/600/700), sem tamanho
- Theme Style → Tipografia: corpo e H1–H6
- Theme Style → Links: navy com sublinhado, hover vermelho
- Theme Style → Botões: vermelho, hover mais escuro
- Content Width: 1200px
- Layout de página padrão: **Elementor Largura Total** (evita H1 duplicado)
- Variáveis de espaçamento no Custom CSS
- **Teste de herança validado** — H1/H2/H3/parágrafo/botão nascem corretos

**Documentação**
- 10 documentos no repositório, auditados e consistentes entre si

### 🔄 Em execução — Módulo 2 (Header)

Progresso: **desktop aplicado e verificado; responsividade em execução.**

| # | Passo | Status |
|---|---|---|
| 1 | Menu no WordPress (Aparência → Menus) | ✅ criado |
| 2 | Template de cabeçalho + containers aninhados | ✅ criado |
| 3 | Widgets (menu, busca) | ✅ inseridos |
| 4 | Posicionamento absoluto — header flutua sobre o hero | ✅ **funcionando** |
| 5 | Fundo condicional (Home transparente; internas off-white) | ✅ verificado |
| 6 | CSS dos hovers (3 comportamentos) | ✅ |
| 7 | **Dropdown por clique** | ✅ clique, Enter, Espaço, Escape, foco e `aria-expanded` verificados |
| 8 | **Busca em Off Canvas** | ✅ desktop aplicado e verificado; substitui a busca expansível inline |
| 9 | Acessibilidade de teclado | ✅ desktop verificado no menu e no Off Canvas |
| 10 | Mobile / hambúrguer | ⬅ **ATUAL** — falta validar e ajustar tablet/mobile |
| 11 | Logos SVG condicionais | ✅ negativo na Home; positivo nas internas |

**Estado visual e funcional verificado no desktop (11/08):**
- Header atravessa a tela, flutua sobre o hero
- Home: header transparente, logo negativo e Off Canvas Onix
- Internas: header e Off Canvas off-white, logo positivo e controles Navy
- Menu com pílula translúcida no hover, sem deslocar os vizinhos
- Chevron do "Máquinas" aparecendo no hover
- Dropdown legível nos dois contextos, com cantos arredondados
- Itens do dropdown deslizando 8px com barra vermelha reta
- Header e Off Canvas alinhados em 1200px, altura de 86px; busca 178 × 35px

**Passo 7 — dropdown por clique, aplicado e verificado:**
- ✅ Abre e fecha ao clicar em "Máquinas", não mais por hover
- ✅ `aria-expanded` alterna entre `true`/`false` no link — confirmado no inspetor
- ✅ Enter e Espaço abrem sem rolar a página
- ✅ Escape fecha e devolve o foco ao item pai
- ✅ Atraso de JS do WP Rocket não engole o primeiro clique — testado
- ✅ `scripts/header.js` está versionado e publicado no Elementor dentro de
  `<script>...</script>`

**Busca em Off Canvas — desktop aplicado e verificado:**
- abre no primeiro clique e fecha pelo X, por Escape e por clique fora;
- foco entra no campo; Tab e Shift+Tab permanecem no diálogo; ao fechar, o foco
  retorna ao acionador;
- busca ao vivo usa Páginas, mínimo de 3 caracteres, 3 colunas e 3 itens;
- Loop Item `Busca — Card de resultado`, navegação do card e estado sem
  resultado testados com a página Home;
- `scripts/search-offcanvas.js` está publicado no fim do `<body>` para todo o
  site;
- falta validar tablet/mobile e integrar as páginas reais das máquinas.

**CSS escrito e versionado:** `css/global.css` (variáveis de espaçamento) e
`css/header.css` (4 seções). O arquivo `elementor-css-completo.txt` é a junção
dos dois, para colar no campo do Elementor.

**Classes CSS aplicadas no Elementor:**
- Container externo: `fachini-header`
- Container do logo: `fachini-logo`
- Container do menu: `fachini-menu`
- Container da busca: `fachini-busca`
- Off Canvas: `fachini-header-offcanvas`, `fachini-logo-offcanvas`,
  `fachini-menu-offcanvas`, `fachini-exit-offcanvas` e
  `fachini-busca-offcanvas`

**Menu criado (Aparência → Menus, "Menu Principal"):**
```
Home
Máquinas
    ├── Perfiladeiras
    ├── Laser
    ├── Corte e Dobra
    └── Serralheria   (rótulo adiado para teste A/B pós-lançamento)
Quem somos
Blog
Contato
```

---

## PARTE 4 — DECISÕES TRAVADAS

### Stack (não rediscutir)

- **Tema:** Hello Elementor (casca vazia)
- **Builder:** Elementor Pro — **toda** página montada nele, nunca no editor de
  blocos do WordPress
- **Performance:** WP Rocket PRO · **SEO:** RankMath PRO
- **Segurança:** Loginizer PRO · **Backup:** Backuply PRO
- **Outros instalados:** GoSMTP, CookieAdmin, ACF, reCAPTCHA

### Posicionamento (decisão da diretoria, 26/07/2026)

**Perfiladeira é FABRICAÇÃO Fachini.** A empresa tem insumos e estrutura para
fabricar cada componente da máquina; há histórico de refabricação completa. A
composição atual de importados é decisão econômica, não limitação técnica.
Finame para perfiladeiras em andamento (etapa inicial superada).

**Limite:** o discurso de fabricante **não se aplica à linha laser** — a marca
Senfeng está no equipamento e assumi-la é estratégia declarada.

Evitar "100% nacional" até a conclusão do Finame.

**Keywords liberadas:** `fabricante de perfiladeiras`, `fábrica de
perfiladeiras`, `perfiladeira nacional`.

### Design System

**Paleta — 8 cores:**

| Nome | Hex | Uso |
|---|---|---|
| Navy Primário | `#15274E` | Títulos, fundos de seção escura |
| Navy Secundário | `#00224E` | Footer, sobreposição em imagem |
| Vermelho | `#E01E26` | CTA — exclusivo |
| Vermelho Hover | `#B01319` | Hover de botões |
| Onix | `#0F0F0F` | Corpo de texto |
| Off-white | `#FBFBFB` | Fundo padrão |
| Cinza Névoa | `#F1F3F6` | Seção alternada, cards, inputs |
| Cinza Médio | `#5C6675` | Texto de apoio, barras de slide inativas |

**Estados translúcidos não geram cor nova.** Hover do menu = branco a 15%;
texto sobre navy = off-white a ~80%.

**Botões sem sombra** (26/07/2026) — superfícies planas.

**Tipografia — 2 famílias, 4 arquivos:**

| Fonte | Peso | Onde |
|---|---|---|
| Mitr | 600 | H1 e H2 — **sempre em CAIXA ALTA** |
| Archivo | 400 | Corpo |
| Archivo | 600 | H3, H4, H5, menu |
| Archivo | 700 | Botões, subtítulo do hero |

- Mitr usa 600 (SemiBold). O Figma marca Bold — divergência a comunicar
- Mitr **só** em caixa alta (em caixa mista fica macia demais)
- Toska: exclusiva do logo, em SVG. Roboto: descontinuada
- Ambas hospedadas localmente (WP Rocket faz automático)

**Escala tipográfica desktop — razão 1.25:**

| Nível | Fonte | Tamanho | Line-height | Tracking | Caixa |
|---|---|---|---|---|---|
| H1 | Mitr 600 | 56px | 1.1 | 0.06em | ALTA |
| H2 | Mitr 600 | 45px | 1.15 | 0.06em | ALTA |
| H3 | Archivo 600 | 36px | 1.25 | 0.02em | normal |
| H4 | Archivo 600 | 29px | 1.3 | 0 | normal |
| H5 | Archivo 600 | 23px | 1.35 | 0 | normal |
| Corpo | Archivo 400 | 16px | 1.6 | 0 | normal |
| Botão | Archivo 700 | 15px | 1 | 0.05em | ALTA |
| Menu | Archivo 600 | 15px | 1 | 0 | ALTA |

Mobile: razão 1.18 (H1 32, H2 27, H3 23, H4 19, H5 17, corpo 16).
**Corpo nunca abaixo de 16px no mobile** (o iOS dá zoom em campo de formulário).

**Larguras — sistema de 4 camadas:**

| Camada | Largura | Onde |
|---|---|---|
| Full-bleed | 100% | Hero, seções navy, footer |
| Larga | `min(94vw, 1560px)` | Mosaico, grid de notícias |
| Padrão | **1200px** | Content Width do Elementor |
| Texto | 720px | Parágrafo corrido |

**Espaçamento:** escala base 8px (`8·16·24·32·48·64·96·128`), disponível como
variáveis CSS `--esp-1` a `--esp-8`.

### Hierarquia de headings

Nível de heading é **significado**, não tamanho. Um H1 por página.
Números de estatística ("+50", "+300") **não** são heading.
H1 de página interna = nome da máquina ou categoria, com a palavra-chave.

### Escopo da entrega de 2 semanas

- Hero em slider **sem vídeo** (removeu o maior risco de CWV)
- Scrollytelling **adiado** para depois do go-live
- Header **transparente** sobre o hero, sólido nas páginas internas
- Sticky: **pendente** — recomendação é sem sticky no lançamento
- Árvore de navegação: seguir Figma por ora, foco na entrega

---

## PARTE 5 — OS DOCUMENTOS DO REPOSITÓRIO

```
site-wordpress/
├── README.md                     orientação para pessoas
├── CLAUDE.md                     contexto e regras para o Claude Code
├── BRIEFING.md                   este arquivo
├── .gitignore · .gitattributes · .editorconfig
├── docs/
│   ├── DOSSIE_FACHINI_projeto_site.md
│   ├── controle-projeto.md
│   ├── analise-360-ux-seo.md
│   ├── relatorio-analise-homepage.md
│   ├── conflito-arvore-navegacao.md
│   ├── modulo-01-design-system.md
│   └── modulo-02-header.md
├── design-system/
│   └── tokens.md
├── css/
│   ├── global.css            variaveis de espacamento + reduced motion
│   ├── header.css            CSS do cabecalho (6 secoes)
│   └── elementor-css-completo.txt   juncao dos dois, para colar no painel
├── seo/         (vazio — receberá o mapa de palavras-chave)
└── scripts/
    └── header.js  dropdown por clique + teclado (passo 7 do Módulo 2)
```

### O que há em cada um

**`DOSSIE_FACHINI_projeto_site.md` (630 linhas) — FONTE DE VERDADE**
Seções 1–12: empresa, portfólio por linha, faixas de preço (confidencial),
análise competitiva, diagnóstico do site atual, posicionamento, árvore de
páginas (7.1) com diretrizes de title, especificação do formulário (seção 9),
riscos e governança.
Seção 13: adendo de execução. Seção 14: adendo de posicionamento (fabricante).

**`controle-projeto.md` (361 linhas) — PAINEL MESTRE**
Registro de decisões datadas, pendências com status (🔴 aberta / 🟡 aguardando /
🟢 resolvida), checklist de go-live, correções pendentes de layout, backlog de
páginas. **É o índice único de pendências** — se não está aqui, não está no radar.

**`analise-360-ux-seo.md` (522 linhas) — ESTRATÉGIA**
Parte A: diagnóstico. B: UX/UI (estados, microinterações, mobile, prova,
acessibilidade). C: SEO técnico (fundação, on-page, schema, interlinking, local,
pesquisa de palavra-chave, lacuna competitiva). D: conteúdo e SEM. **E:
autoridade — o fator que decide o top 1**. F: medição. G: priorização com
expectativa realista por horizonte.

**`relatorio-analise-homepage.md` (326 linhas) — ANÁLISE DO LAYOUT**
4 bloqueadores de governança, 5 riscos de conversão/SEO, instrumentação
(eventos GTM), fila de código customizado, performance, triagem das 2 semanas.

**`conflito-arvore-navegacao.md` (148 linhas)**
A árvore definida pelo dono vs. a seção 7.1 do dossiê. 4 conflitos documentados
com argumento de negócio para defesa junto à diretoria.

**`modulo-01-design-system.md` (413 linhas) — CONCLUÍDO**
Guia de execução do design system + seção de aprendizados da execução.

**`modulo-02-header.md` — EM EXECUÇÃO**
Anatomia do header, teoria de flexbox, montagem no Elementor, o CSS a escrever,
busca em Off Canvas, acessibilidade, mobile, checklist, ordem de execução.

**`tokens.md` (205 linhas)**
Valores medidos no Figma vs. adotados, com a razão de cada divergência.

---

## PARTE 6 — ESTADO DO WORDPRESS E ELEMENTOR

### Configurações aplicadas

**WP Rocket**
- LazyLoad ativo para imagens, iframes e vídeos
- Dimensões de imagem faltantes: ativo
- Pré-carregar fontes: ativo
- **Auto-hospedar Fontes Google: ativo** ← resolve a hospedagem local

**Loginizer**
- Brute force ativo
- **Country Blocking DESATIVADO** (bloqueava Googlebot, PageSpeed, crawler do
  WhatsApp)

**WordPress**
- "Desencorajar indexação" **ATIVO** (correto para dev)
- ⚠ **PRECISA SER DESMARCADO NO GO-LIVE** — é o erro mais caro de lançamento

**Elementor → Configurações do Site**
- Global Colors: 8 cores (4 slots + 4 personalizadas)
- Global Fonts: 4 slots, **sem tamanho** (só família e peso)
- Theme Style → Tipografia: corpo + H1–H6, desktop e mobile
- Theme Style → Links: navy `#15274E` sublinhado, hover `#B01319`
- Theme Style → Botões: fundo `#E01E26`, texto off-white, hover `#B01319`
- Layout → Content Width: **1200px**
- Layout → Layout de página padrão: **Elementor Largura Total**
- Custom CSS: variáveis `--esp-1` a `--esp-8`

### Aprendizados de execução (evitam retrabalho)

1. **Line-height e letter-spacing usam EM, não PX.** Em px, `1.1` colapsa as
   linhas. Regra: decimal → EM; inteiro grande (tamanho de fonte) → PX.
2. **Decimal com ponto, nunca vírgula.** `1.1`, não `1,1`.
3. **Slots de Global Fonts não carregam tamanho** — só família e peso.
4. **O título da página gera um H1 extra.** Resolve trocando o Modelo de página
   para "Elementor Largura Total" (melhor que esconder por CSS).
5. **Global Fonts ≠ Theme Style.** O primeiro cria os slots; o segundo define
   como cada tag aparece. Pular o segundo é o erro mais comum.
6. **Escolher cor pelo nome global**, nunca digitando o hex — mantém o vínculo.
7. **Nomear classes CSS próprias** (`fachini-header`) em vez de mirar nas
   classes geradas pelo Elementor, que mudam se o elemento for recriado.

---

## PARTE 7 — O PLANO COMPLETO

| Módulo | Escopo | Status |
|---|---|---|
| 1 | Design System no Elementor | ✅ concluído 26/07 |
| 2 | **Header** — menu, dropdown e busca em Off Canvas | 🔄 desktop verificado; responsividade em execução |
| 3 | Formulário qualificador e medição | 🔒 bloqueado pela spec |
| 4 | Produção de páginas | ⬜ |
| 5 | SEO on-page | ⬜ |
| 6 | Performance | ⬜ |
| 7 | Go-live | ⬜ |
| 8 | Pós-lançamento | ⬜ |

**Ordem sugerida de continuidade:** terminar o Módulo 2 (header), depois o
footer (não estava no plano original mas é pré-requisito da homepage), depois
os templates de página, depois a montagem da home.

---

## PARTE 8 — PENDÊNCIAS CRÍTICAS

### Que só o Wilson resolve

| # | Pendência | Bloqueia |
|---|---|---|
| 1 | **Spec do formulário** — 13 opções de segmento, roteamento, formato de integração com RD. O dossiê diz que já foi aprovada em projeto separado — é caçá-la | Módulo 3 inteiro |
| 2 | **Medição** — reaproveitar o GTM existente ou criar limpo? Existe GA4? Quem tem acesso ao Search Console? | Baseline de conversão |
| 3 | **Data do go-live do site completo** (as 2 semanas cobrem só a home) | Cronograma |
| 4 | **Dono do copy** — ninguém designado para ~20 páginas | Módulo 4 |
| 5 | **Papel do WhatsApp** — CTA rastreado? Qual número por unidade? | Header, footer |
| 6 | **Números institucionais** — "+50 modelos" e "+300 máquinas/ano" conferem? | Seção de estatísticas |
| 7 | **Finame** — confirmar conclusão do credenciamento | Afirmações sobre financiamento |
| 8 | **Sticky no header** — sim ou não? | Módulo 2 |

### Com a designer

Breakpoints do Figma · frames de 1366 e 390px · quebra do H1 a 1200px · raio de
borda · sombra dos cards · medição de espaçamentos · menu mobile · estados dos
componentes · página de resultados de busca · página de obrigado · template de
post do blog · texto do mosaico visível no mobile · rótulo "DOBRADEIRA CNC"
sobre máquina de laser.

### Correção imediata

**Rótulo da linha Lisa/Dentada:** adiado para teste A/B pós-lançamento por
decisão do Wilson (27/07). "Serralheria" permanece no menu por ora. Duas
versões serão testadas — uma de marketing, uma de vendas.

---

## PARTE 9 — BOAS PRÁTICAS DE TRABALHO

O que funcionou bem neste projeto e vale repetir.

### 1. Auditoria cruzada em vez de revisão isolada

O padrão que mais pegou erro real:

> "Compare o arquivo A com o arquivo B e liste qualquer divergência em [lista de
> pontos]. **Não altere nada, só reporte.**"

Duas coisas fazem funcionar: **comparar** dá critério objetivo em vez de opinião;
**"não altere"** força relatório em vez de conserto, e você decide o que é bug e
o que é intencional. Pegou três erros que passariam na leitura manual.

### 2. Peça o plano antes da execução

> "Mostre o plano do que vai mudar em cada arquivo antes de editar."

Especialmente quando são vários arquivos. Você aprova o escopo antes do trabalho.

### 3. Instrução negativa explícita quando algo não pode ser tocado

> "Não toque no README.md em hipótese nenhuma."

Repetir a proibição no começo, meio e fim reduz a chance de "ajuda demais".

### 4. Confie no Git, não na memória do assistente

Depois de crash ou mudança de arquivo, o assistente pode responder do contexto
antigo. **Git compara bytes.** Para "esse arquivo está atualizado?", use:

```powershell
Select-String -Path arquivo.md -Pattern "termo-que-deveria-existir"
git status
```

Retorno vazio nunca é confirmação — pode ser "não existe o problema" ou
"procurei a coisa errada".

### 5. Um commit por assunto

`git add arquivo-especifico` em vez de `git add .` quando as mudanças são de
naturezas diferentes. Assim a mensagem descreve de verdade o que está dentro.

### 6. Quando uma decisão muda, ela muda todos os documentos que se apoiavam nela

Perguntar "os outros documentos mudam também?" evita divergência silenciosa.
Aconteceu com o posicionamento de fabricante: mexeu em 5 arquivos.

### 7. Documento correto ≠ sistema correto

Verificar o documento não prova que o Elementor está configurado. O teste de
herança (página de rascunho sem estilo manual) foi o que provou a fundação.
Sempre buscar a verificação empírica, não a documental.

### 8. Gestão de contexto em conversas longas

Conversa muito longa degrada a qualidade. **Comece conversa nova nos limites
naturais de módulo**, com este briefing atualizado. Anexe só os documentos
relevantes ao módulo em execução.

### 9. Calibragem explícita

Quando a resposta não estiver no tom certo, diga. Exemplos que funcionaram neste
projeto: *"quero codar manualmente pra aprender"*, *"não achei de bom tom"*,
*"pode fazer por mim, essa parte não tem a ver com aprender a programar"*.

---

## PARTE 10 — A PRÓXIMA AÇÃO

**Módulo 2: validar a responsividade do header e da busca em Off Canvas.**

### O que está verificado no desktop

- dropdown por clique e teclado, inclusive foco e `aria-expanded`;
- Off Canvas nativo abrindo no primeiro clique e fechando por X, Escape e clique
  fora;
- contenção do foco e devolução ao acionador;
- busca ao vivo, Loop Item, card navegável e estado sem resultado;
- paletas e logos condicionais na Home e em páginas internas;
- alinhamento de 1200px, header de 86px e busca de 178 × 35px.

### Ação atual

1. Testar o header e o Off Canvas nos breakpoints tablet e mobile.
2. Validar menu/hambúrguer, submenu, abertura e fechamento da busca.
3. Verificar Tab, Shift+Tab, Escape, devolução de foco e teclado virtual.
4. Ajustar pelo painel antes de qualquer CSS; não existe prancheta mobile
   aprovada, portanto nenhuma medida visual nova pode ser inventada.

### Depois da responsividade

- criar as páginas reais de categoria e de máquina, com imagem destacada;
- conectar os links do bloco EXPLORAR;
- excluir da consulta páginas institucionais inadequadas;
- concluir e testar `Resultados de pesquisa — Fallback`;
- testar palavras comerciais e códigos reais das máquinas.

---

## PARTE 11C — STATUS CARREGA MÉTODO DE VERIFICAÇÃO

> Regra criada em 28/07, depois de o passo 7 do Módulo 2 ser marcado como
> concluído em quatro documentos sem nunca ter sido executado.

**Como o erro aconteceu:** o Wilson disse "o menu consegui resolver". Isso foi
mapeado no passo 7 sem perguntar *o que exatamente* tinha sido resolvido. A
suposição virou linha no `CLAUDE.md`, depois no `BRIEFING`, depois no guia — e
endureceu. Uma seção inteira do controle (o risco de dependência de JavaScript)
nasceu descrevendo algo que não tinha acontecido.

**A regra:**

- **Nunca inferir status a partir de fala genérica.** "Resolvi o menu" pode ser
  o passo 6, o 7, ou parte de ambos. Perguntar qual
- **Toda mudança de status de execução carrega como foi verificada.** Sem
  método, é intenção e não fato
- **Distinguir três estados:** escrito (está no repositório) · aplicado (foi
  colado no Elementor e publicado) · verificado (confirmado no site)

**Como uma auditoria pode falhar:** conferir documento contra documento só
prova que eles concordam entre si. Se todos herdaram a mesma suposição errada,
a auditoria retorna "confirmado" sobre um estado que nunca existiu. A
verificação precisa ancorar em algo fora dos documentos — o site, o
código-fonte, o painel.

---

## PARTE 11B — FONTE ÚNICA POR TIPO DE DADO

> Regra criada em 28/07, depois de o status do Módulo 2 defasar duas vezes
> em dois dias.

O mesmo dado vive em vários documentos, e cada atualização precisa alcançar
todos. Quando um fica para trás, o Claude Code lê informação velha como
verdade.

**Onde cada tipo de dado é a fonte:**

| Dado | Fonte única | Os outros documentos |
|---|---|---|
| Status dos módulos e passos | `controle-projeto.md` | referenciam, não repetem |
| Pendências (todas) | `controle-projeto.md` §2 | citam com link |
| Valores do design system | `design-system/tokens.md` | copiam, mas conferem contra ele |
| Decisões de negócio | dossiê (seções 13 e 14) | citam a seção |
| Regras de trabalho | `CLAUDE.md` | — |

**Ao atualizar qualquer dado, rodar a busca antes de dar por encerrado:**

```powershell
Select-String -Path *.md, docs\*.md -Pattern "valor-antigo"
```

Se retornar linha em documento que não é a fonte, ali está a defasagem.

**Cuidado com find-and-replace:** substituição global pode contaminar linhas
vizinhas que terminam com o mesmo texto. Aconteceu em 28/07 no `tokens.md` —
a correção da atribuição do H2 entrou também na linha do H3. Sempre conferir
o resultado, não só executar.

---

## PARTE 11 — LIÇÕES DE DEPURAÇÃO (leia antes de propor CSS)

> Esta seção existe porque a sessão de 27/07 perdeu várias horas de expediente
> depurando por tentativa e erro. Os erros abaixo são de método, não de
> conhecimento — e são evitáveis.

### 11.1 O erro central: adivinhar em vez de medir

Foram cinco hipóteses sucessivas para um mesmo problema (largura do dropdown):
especificidade, `!important`, `min-width` vs `width`, cache do WP Rocket, CSS
usado. **Nenhuma baseada em evidência.**

A informação que resolveu estava no HTML do elemento desde o início.

**Regra:** quando um CSS não aplica, a primeira ação é **inspecionar o elemento
e ler as regras aplicadas** — não propor outra hipótese. Se a proposta seguinte
também for chute, o custo se multiplica.

**O que pedir:** *"inspeciona o elemento X, aba Styles, e me manda print"* —
ali aparece cada regra, na ordem de precedência, com as perdedoras riscadas.

### 11.2 A hierarquia que explica quase tudo no Elementor

Do mais forte para o mais fraco:

| # | Origem | Exemplo |
|---|---|---|
| 1 | Inline com `!important` | — |
| 2 | **Estilo inline** | SmartMenus escreve `style="width: auto"` no `<ul>` do submenu |
| 3 | Folha de estilo com `!important` | nosso CSS customizado |
| 4 | **CSS gerado pelo painel** | `.elementor-367 .elementor-element.elementor-element-40786ca ...` — 4 classes |
| 5 | Folha de estilo normal | nosso CSS sem `!important` |

**Consequências práticas:**

- CSS customizado com 3 classes **perde** para qualquer coisa configurada no
  painel do widget. Precisa de 5 classes para vencer
- Contra estilo inline (SmartMenus), **nada em folha de estilo funciona** —
  nem `!important`. A saída é mexer nos elementos filhos, que não recebem inline

### 11.3 A regra do projeto que foi violada

O `CLAUDE.md` diz: *antes de sugerir CSS, verifique se o Elementor resolve no
painel.*

A sessão inteira brigou por CSS contra o próprio Elementor em coisas que o
painel controla: padding do item, cor de fundo do dropdown, largura do submenu.

**Divisão de território correta:**

| Onde | O quê |
|---|---|
| **Painel do widget** | Cores, tipografia, padding, border-radius, espaçamento |
| **CSS customizado** | Comportamento que o painel não oferece: pseudo-elementos, `transform`, transições específicas, regras condicionais por classe do body |

Isso também importa para a equipe: o que está no painel, a designer ajusta
sozinha. O que está em CSS, depende do Wilson.

### 11.4 Três propriedades que se confundem

| Propriedade | Comportamento |
|---|---|
| `min-width` | Piso — nunca menor, mas **cresce** se o conteúdo pedir. Não serve para limitar |
| `width` | Medida fixa — é o que controla de fato |
| `max-width` | Teto — pode ser menor, nunca maior |

Um `min-width` foi usado para tentar **reduzir** um elemento. Não funciona por
definição.

### 11.5 Cache: três camadas independentes

Uma mudança de CSS só aparece depois de limpar todas:

1. **Elementor → Ferramentas → Limpar arquivos e dados** (regenera o CSS)
2. **WP Rocket → Esvaziar cache**
3. **WP Rocket → Limpar o CSS usado deste URL** — camada separada, **não é
   limpa pelo item 2**
4. `Ctrl+F5` no navegador

Durante o desenvolvimento, vale desativar a otimização de CSS do WP Rocket
(Otimizar Arquivos → remover CSS não usado) e religar antes do go-live.

### 11.6 Padrão de trabalho que funcionou bem

- **Auditoria cruzada** entre documentos: *"compare A e B, liste divergências,
  não altere nada"* — pegou três erros reais ao longo do projeto
- **Pedir o plano antes da execução** quando são vários arquivos
- **Instrução negativa explícita** quando algo não pode ser tocado
- **Confiar no Git, não na memória do assistente** — depois de crash ou
  mudança de arquivo, verificar com `Select-String` e `git status`

### 11.7 Calibragem de tom

Wilson trabalha durante o expediente e a função principal dele é vendas
técnicas. Quando a depuração se arrasta:

- **Não sugerir que ele pare** — o trabalho faz parte do expediente dele
- **Não repetir instrução já executada** — acompanhar o que já foi feito
- **Assumir o erro diretamente** quando a orientação estiver errada, sem
  rodeios e sem excesso de desculpas
