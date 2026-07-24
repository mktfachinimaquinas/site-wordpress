# CLAUDE.md — Site Fachini Máquinas

## O que é este projeto

Repositório de trabalho do novo site da **Fachini Máquinas**, construído em
**WordPress + Elementor Pro**. Este repositório **não é o site**: o site roda
num servidor. Aqui ficam a documentação, o design system, o CSS customizado
que será colado no Elementor, os mapas de SEO e os scripts de apoio.

- Desenvolvimento: `wordpress.fachinimaquinas.com.br`
- Produção: `fachinimaquinas.com.br`
- **Prazo imediato:** homepage no ar em 2 semanas. Layout finalizado no Figma.

---

## Fonte de verdade

`docs/DOSSIE_FACHINI_projeto_site.md` é a **fonte de verdade** deste projeto.
As seções 1 a 12 são o dossiê original; a seção 13 é o adendo de execução.

**Se qualquer sugestão conflitar com o dossiê, o dossiê vence.** Não rediscuta
o que está decidido lá — execute.

| Arquivo | O que é |
|---|---|
| `docs/relatorio-analise-homepage.md` | Bloqueadores, riscos de conversão, fila de código customizado |
| `docs/modulo-01-design-system.md` | Guia de execução do design system |
| `design-system/tokens.md` | Valores extraídos do Figma |

---

## Stack (travada)

- **Tema:** Hello Elementor (casca vazia)
- **Builder:** Elementor Pro — **toda** página é montada nele, nunca no editor
  de blocos do WordPress. Misturar cria dois sistemas de design paralelos.
- **Performance:** WP Rocket PRO · **SEO:** RankMath PRO
- **Segurança:** Loginizer PRO · **Backup:** Backuply PRO

---

## Design System

### Paleta — 8 cores, fechada

| Nome | Hex | Uso |
|---|---|---|
| Navy Primário | `#15274E` | Títulos, fundos de seção escura |
| Navy Secundário | `#00224E` | Footer, sobreposição em imagem |
| Vermelho | `#E01E26` | CTA — **exclusivo** |
| Vermelho Hover | `#B01319` | Hover de botões |
| Onix | `#0F0F0F` | Corpo de texto |
| Off-white | `#FBFBFB` | Fundo padrão |
| Cinza Névoa | `#F1F3F6` | Seção alternada, cards, contorno de input |
| Cinza Médio | `#5C6675` | Texto de apoio, barras de slide inativas |

**Slots do Elementor:** Primary = Navy Primário · Secondary = Cinza Médio ·
Text = Onix · Accent = Vermelho. As outras quatro como personalizadas, com nome.

**Estados translúcidos não geram cor nova.** Hover do menu = branco ~12%; texto
sobre navy = off-white ~80%; sobreposição de imagem = navy com opacidade.

### Tipografia — duas famílias, 4 arquivos

| Fonte | Peso | Onde |
|---|---|---|
| **Mitr** | 700 | H1 e H2 — **sempre em CAIXA ALTA** |
| **Archivo** | 400 | Corpo |
| **Archivo** | 600 | H3, H4, H5, menu |
| **Archivo** | 700 | Botões, subtítulo do hero |

- Ambas do Google Fonts, licença SIL OFL. **Hospedadas localmente**, nunca via
  CDN do Google (performance + LGPD).
- **Mitr não tem peso acima de 700.** Mais impacto só via tamanho.
- **Mitr só em caixa alta.** Em caixa mista os terminais arredondados aparecem
  e o tom fica macio demais para o território industrial. Headline em caixa
  mista usa Archivo 700.
- **Toska** é exclusiva do logo, em SVG vetorizado. Não é webfont.
- **Roboto está descontinuada.** A página `3 - MARCA` do Figma está desatualizada.
- Não adicionar peso novo sem avaliar custo em Core Web Vitals.

### Escala tipográfica — razão 1.333

**Desktop**

| Nível | Fonte | Peso | Tamanho | Line-height | Tracking | Caixa |
|---|---|---|---|---|---|---|
| H1 | Mitr | 700 | 64px | 1.1 | 0.06em | ALTA |
| H2 | Mitr | 700 | 48px ⚠ | 1.15 | 0.06em | ALTA |
| H3 | Archivo | 600 | 36px | 1.25 | 0.02em | ALTA |
| H4 | Archivo | 600 | 27px | 1.3 | 0 | normal |
| H5 | Archivo | 600 | 20px | 1.35 | 0 | normal |
| Corpo | Archivo | 400 | 16px | 1.6 | 0 | normal |
| Corpo pequeno | Archivo | 400 | 14px | 1.6 | 0 | normal |
| Botão | Archivo | 700 | 15px | 1 | 0.05em | ALTA |
| Menu | Archivo | 600 | 15px | 1 | 0 | ALTA |

> ⚠ **H2 pendente de validação da designer.** O Figma marca 58px, o que dá
> apenas 10% de diferença para o H1 — abaixo do limiar em que o olho lê
> hierarquia. Proposta: 48px (33% de diferença).

**Mobile** — razão 1.2, proposta (não existe prancheta mobile no Figma)

| Nível | Tamanho | Line-height |
|---|---|---|
| H1 | 34px | 1.15 |
| H2 | 28px | 1.2 |
| H3 | 23px | 1.3 |
| H4 | 19px | 1.35 |
| H5 | 17px | 1.4 |
| Corpo | 16px | 1.65 |

**Corpo nunca abaixo de 16px no mobile** — o Safari do iOS dá zoom automático
em campo de formulário com fonte menor, e a página saltaria no formulário de
orçamento.

**Line-height do H1 e H2 nunca abaixo de 1.1.** Em português, acentos em caixa
alta ficam acima da altura das maiúsculas — a 1.02 o acento encosta na linha
de cima.

### Larguras — sistema de 4 camadas

O Figma foi desenhado em prancheta de 1920px com conteúdo de 1558px. Isso não
vai direto para o Elementor: notebook de 1366 e escala do Windows a 125% (que
entrega 1536px de viewport) são comuns.

| Camada | Largura | Onde |
|---|---|---|
| Full-bleed | 100% | Hero, seções navy, banner de CTA, footer |
| Larga | `min(94vw, 1560px)` | Mosaico, grid de notícias, estatísticas |
| Padrão | 1280px | Maioria das seções — **Content Width do Elementor** |
| Texto | 720px | Parágrafo corrido |

Motivo das camadas: imagem e grid querem largura; texto corrido quer estreiteza
(acima de ~75 caracteres por linha a leitura despenca). Uma medida única não
serve aos dois.

### Espaçamento — escala base 8px

```
8 · 16 · 24 · 32 · 48 · 64 · 96 · 128
```

Padding vertical de seção: 96px desktop / 56px mobile.

---

## Hierarquia de headings

**Nível de heading é significado, não tamanho.** O H1 é o assunto da página,
não o texto maior. A hierarquia serve ao Google e ao leitor de tela.

**Homepage:**

| Nível | Elementos |
|---|---|
| H1 | Hero — **um só por página** |
| H2 | "Aumente a produtividade", "Tecnologia que transforma", "Notícias", "Solicite seu orçamento", título de cada aba do mosaico |
| H3 | "Suporte técnico", "Instalação profissional", "Pós venda", títulos dos cards de notícia |

**Armadilhas:**
- "Aumente a produtividade" é **H2**, apesar de estar em Mitr grande. Dois H1
  deixam o Google sem saber qual é o assunto.
- **"+50", "+30", "+300" NÃO são heading.** São dados — texto comum estilizado
  grande. Marcados como H2, entram na estrutura do documento.
- Links do footer não são heading.

**Páginas internas:** H1 é o nome da máquina ou categoria, sempre com a
palavra-chave. Nunca "Bem-vindo" ou "Conheça nossa linha".

**Tamanho visual pode variar dentro do mesmo nível.** Título de card de notícia
é H3 semanticamente mas pode ter 24px em vez de 36px. O que não se faz é
rebaixar para H4 só porque é menor.

---

## Escopo da entrega de 2 semanas

- Hero em slider **sem vídeo** — remove o maior risco de CWV mobile
- Scrollytelling **adiado** para depois do go-live. No lançamento: sticky via
  Elementor + fade simples
- **"Serralheria" não é categoria de produto** — é segmento. A categoria correta
  é **"Calhas"**, conforme o mapa do Figma e o dossiê
- Divisão: Wilson prepara a fundação (Estilos Globais, header, footer, template
  mestre); designer monta as seções herdando o sistema

---

## Meu nível técnico (calibre por isto)

Wilson, comercial da Fachini e líder do projeto. Perfil estratégico, direto,
orientado a resultado.

Em programação sou **iniciante**: 4 meses de curso fullstack Node.js sem
concluir, noção de HTML básico. Boa noção de WordPress, já usei Elementor sem
me aprofundar. Entendo servidores, segurança e performance no nível de **gestor
técnico**.

**Aprendizados alvo:** VS Code, CSS no contexto do Elementor, Node.js (sem
pressa — fora do caminho crítico).

---

## Como trabalhar comigo

1. **Não escreva código por mim.** Explique o conceito, aponte a direção e
   revise o que eu escrevi. Só escreva código completo se eu pedir com a
   palavra **"escreve"**.
2. **Explique tudo que entregar.** Quero saber o que cada parte faz.
3. **Nunca me deixe aceitar código que eu não sei explicar.**
4. **Exceção:** configuração não ensina nada. `.gitignore`, `package.json` e
   afins pode entregar prontos.
5. **Comunicação direta.** Se algo que eu propus está errado, diga.
6. **Passos pequenos.** Propõe, eu valido, avançamos.

---

## O que NÃO fazer

- **Não sugira frameworks de frontend.** Nada de React, Vue, Next, Tailwind ou
  build tools. O destino do CSS é o campo de CSS customizado do Elementor.
- **Não tente gerar página a partir do Figma.** Não existe caminho automático
  Figma → Elementor.
- **Não instale dependência sem necessidade real.**
- **Não invente informação sobre empresa, produtos ou preços.** Se não estiver
  no dossiê, pergunte.
- **Cuidado com posicionamento de produto.** O dossiê define o que pode e não
  pode ser dito sobre fabricação própria vs. importado, linha por linha. Erro
  aqui é comercial, não técnico.
- **Antes de sugerir CSS, verifique se o Elementor resolve no painel.** CSS que
  duplica função nativa é manutenção sem motivo.

---

## Estrutura do repositório

```
site-wordpress/
├── CLAUDE.md
├── .gitignore · .gitattributes · .editorconfig
├── docs/                  # dossiê, relatórios, guias de módulo
├── design-system/         # tokens extraídos do Figma
├── css/                   # CSS customizado para o Elementor
├── seo/                   # mapa de páginas, keywords, titles
└── scripts/               # automações em Node
```
