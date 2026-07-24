# CLAUDE.md — Site Fachini Máquinas

## O que é este projeto

Repositório de trabalho do novo site da **Fachini Máquinas**, construído em
**WordPress + Elementor Pro**. Este repositório **não é o site**: o site roda
num servidor. Aqui ficam a documentação, o design system, o CSS customizado
que será colado no Elementor, os mapas de SEO e os scripts de apoio.

- Ambiente de desenvolvimento: `wordpress.fachinimaquinas.com.br`
- Produção: `fachinimaquinas.com.br`
- **Prazo imediato:** homepage no ar em 2 semanas. Layout finalizado no Figma.

---

## Fonte de verdade

`docs/DOSSIE_FACHINI_projeto_site.md` é a **fonte de verdade** deste projeto:
empresa, portfólio, análise competitiva, diagnóstico do site atual, árvore de
páginas validada, especificação do formulário e regras de governança.

**Se qualquer sugestão conflitar com o dossiê, o dossiê vence.** Não rediscuta
o que já está decidido lá — execute.

Leia o dossiê antes de propor qualquer coisa sobre conteúdo, estrutura de
páginas, posicionamento de produto ou copy.

### Outros documentos

| Arquivo | O que é |
|---|---|
| `docs/relatorio-analise-homepage.md` | Análise do layout: bloqueadores, riscos de conversão, fila de código customizado |
| `docs/modulo-01-design-system.md` | Guia de execução do design system no Elementor |
| `design-system/tokens.md` | Valores extraídos do Figma |

---

## Decisões travadas (não rediscutir)

### Stack
- **Tema:** Hello Elementor (casca vazia)
- **Builder:** Elementor Pro — toda página é montada nele, **nunca** no editor
  de blocos do WordPress. Misturar os dois cria dois sistemas de design.
- **Performance:** WP Rocket PRO · **SEO:** RankMath PRO
- **Segurança:** Loginizer PRO · **Backup:** Backuply PRO

### Paleta — 8 cores, fechada

| Nome | Hex | Uso |
|---|---|---|
| Navy Primário | `#15274E` | Títulos, fundos de seção escura |
| Navy Secundário | `#00224E` | Footer, sobreposição em imagem |
| Vermelho | `#E01E26` | CTA — **exclusivo**, nunca em texto corrido |
| Vermelho Hover | `#B01319` | Estado hover dos botões |
| Onix | `#0F0F0F` | Corpo de texto |
| Off-white | `#FBFBFB` | Fundo padrão |
| Cinza Névoa | `#F1F3F6` | Seção alternada, cards, contorno de input |
| Cinza Médio | `#5C6675` | Texto de apoio, barras de slide inativas |

**Estados translúcidos não geram cor nova.** Hover do menu é branco a ~12%;
texto de apoio sobre navy é off-white a ~80%; sobreposição de imagem é navy
com opacidade. Resolver com opacidade sobre cor existente.

### Tipografia
- **Archivo** (Google Fonts, licença OFL) é a fonte oficial — única família do
  sistema. Pesos: **400, 700, 900**. Servida localmente, nunca via CDN do Google.
- **Toska** é exclusiva do logo. Não entra como webfont — logo em SVG vetorizado.
- **Roboto está descontinuada** no projeto. A página `3 - MARCA` do Figma está
  desatualizada nesse ponto.

### Escopo da entrega de 2 semanas
- Hero em slider **sem vídeo** (decisão tomada — remove o maior risco de CWV)
- Scrollytelling adiado para depois do go-live
- "Serralheria" **não é categoria de produto** — é segmento. A categoria correta
  é "Calhas", conforme o mapa do Figma e o dossiê.

---

## Meu nível técnico (calibre por isto)

Sou o Wilson, comercial da Fachini e líder do projeto. Perfil estratégico,
direto, orientado a resultado.

Em programação sou **iniciante**: 4 meses de curso fullstack Node.js sem
concluir, noção de HTML básico. Considere que sei o que fiz até aqui — navegar
no terminal, comandos básicos de Git, criar e editar arquivos no VS Code.

Tenho boa noção de WordPress e já usei Elementor sem me aprofundar. Entendo
servidores, segurança e performance no nível de **gestor técnico**.

**Aprendizados alvo:** VS Code, CSS no contexto do Elementor, e Node.js
(sem pressa — não está no caminho crítico do site).

---

## Como trabalhar comigo

1. **Não escreva código por mim.** Explique o conceito, aponte a direção e
   revise o que eu escrevi. Só escreva código completo se eu pedir com a
   palavra **"escreve"**.

2. **Explique tudo que entregar.** Se um bloco de código aparecer, quero saber
   o que cada parte faz.

3. **Nunca me deixe aceitar código que eu não sei explicar.**

4. **Exceção:** configuração não ensina nada. `.gitignore`, `package.json` e
   afins pode entregar prontos.

5. **Comunicação direta.** Sem rodeios. Se algo que eu propus está errado, diga.

6. **Passos pequenos.** Propõe, eu valido, avançamos.

---

## O que NÃO fazer

- **Não sugira frameworks de frontend.** Nada de React, Vue, Next, Tailwind ou
  build tools. O destino do CSS é o campo de CSS customizado do Elementor.

- **Não tente gerar página a partir do Figma.** Não existe caminho automático
  Figma → Elementor. O Figma serve para extrair valores.

- **Não instale dependência sem necessidade real.**

- **Não invente informação sobre empresa, produtos ou preços.** Se não estiver
  no dossiê, pergunte.

- **Cuidado com posicionamento de produto.** O dossiê define o que pode e não
  pode ser dito sobre fabricação própria vs. importado, linha por linha. Erro
  aqui é erro comercial, não técnico.

---

## Estrutura do repositório

```
site-wordpress/
├── CLAUDE.md              # este arquivo
├── .gitignore
├── docs/                  # dossiê, relatórios, guias de módulo
├── design-system/         # tokens extraídos do Figma
├── css/                   # CSS customizado para o Elementor
├── seo/                   # mapa de páginas, keywords, titles
└── scripts/               # automações em Node
```
