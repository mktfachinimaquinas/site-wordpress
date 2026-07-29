# Site Fachini Máquinas — Repositório de Trabalho

Repositório de documentação, design system e código customizado do novo site da
**Fachini Máquinas**, construído em WordPress + Elementor Pro.

> **Este repositório não é o site.** O site roda num servidor. Aqui ficam a
> documentação do projeto, os valores do design system, o CSS que será colado no
> Elementor, os mapas de SEO e os scripts de apoio.

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
├── BRIEFING.md            # continuidade entre sessões de trabalho
├── docs/
│   ├── DOSSIE_FACHINI_projeto_site.md   # documento base do projeto
│   ├── controle-projeto.md              # decisões, pendências, go-live
│   ├── analise-360-ux-seo.md            # estratégia de UX/UI e SEO
│   ├── relatorio-analise-homepage.md    # análise do layout
│   ├── conflito-arvore-navegacao.md     # árvore do dono vs. dossiê
│   ├── modulo-01-design-system.md       # guia de execução (concluído)
│   └── modulo-02-header.md              # guia de execução (em andamento)
├── design-system/
│   └── tokens.md          # valores extraídos do Figma
├── css/
│   ├── global.css                    # variáveis e ajustes de base
│   ├── header.css                    # CSS do cabeçalho
│   └── elementor-css-completo.txt    # junção, para colar no painel
├── seo/                   # mapa de páginas, keywords, titles
└── scripts/               # automações em Node
```

---

## Por onde começar

1. **`docs/DOSSIE_FACHINI_projeto_site.md`** — o documento base. Empresa, portfólio, 
análise competitiva, árvore de páginas e especificação do formulário.

2. **`docs/controle-projeto.md`** — o estado atual. O que foi decidido, o que
   está pendente e com quem, e a checklist de go-live. **É o documento que se
   atualiza com mais frequência.**

3. **`docs/modulo-01-design-system.md`** — o guia que se executa no Elementor.

---

## Documentação de referência

A pasta `docs/` contém o material que fundamenta as decisões do projeto —
contexto de negócio, análise, design system e o controle de pendências.
Consulte antes de propor mudanças estruturais.

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
| 1 | Design System no Elementor | ✅ concluído |
| 2 | Header — menu, dropdown, busca expansível | em execução — passo 7/11 |
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
