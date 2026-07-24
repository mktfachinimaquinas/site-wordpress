# Site Fachini Máquinas — Repositório de Trabalho

Repositório de documentação, design system e código customizado do novo site da
**Fachini Máquinas**, construído em WordPress + Elementor Pro.

> **Este repositório não é o site.** O site roda num servidor. Aqui ficam a
> documentação do projeto, os valores do design system, o CSS que será colado no
> Elementor, os mapas de SEO e os scripts de apoio.

**Confidencial.** O dossiê contém faixas de preço e estratégia competitiva.
Mantenha o repositório privado.

---

## Ambientes

| Ambiente | URL |
|---|---|
| Desenvolvimento | `wordpress.fachinimaquinas.com.br` |
| Produção | `fachinimaquinas.com.br` |

---

## Estrutura

```
site-wordpress/
├── README.md              # este arquivo — orientação para pessoas
├── CLAUDE.md              # contexto e regras para o Claude Code
├── docs/
│   ├── DOSSIE_FACHINI_projeto_site.md   # FONTE DE VERDADE
│   ├── controle-projeto.md              # decisões, pendências, go-live
│   ├── relatorio-analise-homepage.md    # análise do layout
│   └── modulo-01-design-system.md       # guia de execução
├── design-system/
│   └── tokens.md          # valores extraídos do Figma
├── css/                   # CSS customizado para o Elementor
├── seo/                   # mapa de páginas, keywords, titles
└── scripts/               # automações em Node
```

---

## Por onde começar

1. **`docs/DOSSIE_FACHINI_projeto_site.md`** — a fonte de verdade. Empresa,
   portfólio, análise competitiva, árvore de páginas, especificação do
   formulário e regras de governança. As seções 1 a 12 são o dossiê original;
   a seção 13 é o adendo de decisões de execução.

2. **`docs/controle-projeto.md`** — o estado atual. O que foi decidido, o que
   está pendente e com quem, e a checklist de go-live. **É o documento que se
   atualiza com mais frequência.**

3. **`docs/modulo-01-design-system.md`** — o guia que se executa no Elementor.

---

## Regra de governança

**O dossiê vence.** Se qualquer proposta conflitar com o que está em
`docs/DOSSIE_FACHINI_projeto_site.md`, o dossiê prevalece. O que está decidido
lá não se rediscute — executa-se.

---

## Convenção de commits

Prefixo por tipo, para que o histórico conte uma história legível:

| Prefixo | Uso |
|---|---|
| `docs:` | documentação |
| `feat:` | funcionalidade nova |
| `fix:` | correção |
| `style:` | ajuste visual, CSS |
| `chore:` | configuração, manutenção |

Exemplo: `docs: consolida escala tipografica no modulo 1`

Mensagens sem acento, para evitar problema de codificação em terminal.

---

## Método de trabalho

O projeto avança em **módulos sequenciais com validação**: propõe-se, valida-se,
avança-se. Nada de executar vários módulos em paralelo.

| Módulo | Escopo | Status |
|---|---|---|
| 1 | Design System no Elementor | em execução |
| 2 | Header — menu, dropdown, busca expansível | |
| 3 | Formulário qualificador e medição | bloqueado pela spec |
| 4 | Produção de páginas | |
| 5 | SEO on-page | |
| 6 | Performance | |
| 7 | Go-live | |
| 8 | Pós-lançamento | |

---

## Ambiente de desenvolvimento

**Requisitos:** Git, Node.js, VS Code.

**Extensão recomendada:** EditorConfig for VS Code — sem ela, o `.editorconfig`
não é aplicado.

**Configuração já feita no repositório:**

- `.gitignore` — ignora `node_modules/`, `.env` e arquivos de sistema
- `.gitattributes` — normaliza fim de linha em LF, evitando diffs falsos entre
  máquinas Windows e Mac
- `.editorconfig` — padroniza codificação, indentação e espaços em branco

---

## Aviso sobre o CLAUDE.md

O `CLAUDE.md` é lido automaticamente pelo Claude Code em toda sessão. Ele contém
as decisões travadas e as regras de trabalho. **Mantenha-o atualizado**: se uma
decisão muda e o arquivo não acompanha, a ferramenta trabalha com informação
velha sem avisar.

Quando precisar conferir se dois documentos concordam, peça a comparação
explicitamente e instrua a não alterar nada — relatório é mais útil que
conserto automático.
