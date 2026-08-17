# Site Fachini Máquinas — Repositório de Trabalho

Repositório de documentação, design system e código customizado do site da
**Fachini Máquinas**, construído em WordPress + Elementor Pro + Hello Elementor.

> **Este repositório não é o site publicado.** Os arquivos daqui são fontes e
> registros locais usados no fluxo do projeto. O código é aplicado manualmente
> no WordPress/Elementor; portanto, uma alteração local não prova que ela foi
> aplicada ou verificada no site.

---

## Ambientes

| Ambiente | URL |
|---|---|
| Desenvolvimento | `wordpress.fachinimaquinas.com.br` |
| Produção | `fachinimaquinas.com.br` |

---

## Estrutura principal

```text
site-wordpress/
├── README.md                         # orientação humana do repositório
├── AGENTS.md                         # regras universais mínimas de trabalho
├── CLAUDE.md                         # contexto específico do Claude Code
├── BRIEFING.md                       # contexto e continuidade, não estado canônico
├── docs/
│   ├── ARQUITETURA-IA.md             # arquitetura detalhada de uso de IA
│   ├── DOSSIE_FACHINI_projeto_site.md # negócio e posicionamento
│   ├── controle-projeto.md           # item corrente, estados e pendências
│   ├── analise-360-ux-seo.md         # análise de UX/UI e SEO
│   ├── relatorio-analise-homepage.md # análise do layout da homepage
│   ├── conflito-arvore-navegacao.md  # análise da árvore de navegação
│   ├── modulo-01-design-system.md    # guia técnico do design system
│   ├── modulo-02-header.md           # guia técnico do header
│   └── tarefas-designer.md           # referências de trabalho com a designer
├── design-system/
│   └── tokens.md                     # decisões vigentes do design system
├── css/
│   ├── global.css                    # CSS local de base
│   ├── header.css                    # CSS local do header
│   ├── footer.css                    # CSS local do componente Footer
│   └── elementor-css-completo.txt    # captura/consolidado do CSS do Elementor
├── scripts/
│   ├── header.js                     # comportamento do menu do header
│   └── search-offcanvas.js           # comportamento da busca Off Canvas
└── seo/                              # materiais locais de SEO
```

A árvore destaca os caminhos de uso recorrente e não pretende listar todo
artefato local. Em especial, a existência de `css/footer.css` ou a atualização
de `css/elementor-css-completo.txt` não comprovam aplicação no Elementor. O
estado aplicado deve ser confirmado pelo método registrado no projeto.

---

## Por onde começar

- **Para entender o projeto e o negócio:**
  `docs/DOSSIE_FACHINI_projeto_site.md`.
- **Para saber o item corrente, o estado e as pendências:**
  `docs/controle-projeto.md`.
- **Para seguir as regras universais de execução:** `AGENTS.md`.
- **Para consultar a arquitetura detalhada de uso de IA:**
  `docs/ARQUITETURA-IA.md`.
- **Para trabalhar com o design:** `design-system/tokens.md` e o guia técnico
  relacionado em `docs/`.

O README orienta a navegação pelo repositório, mas não substitui essas fontes.

---

## Método de trabalho

O trabalho parte de um escopo autorizado, produz uma alteração delimitada e,
quando envolve o site, segue para aplicação e verificação separadas. O estado
real de cada frente deve ser consultado em `docs/controle-projeto.md`, sem ser
duplicado aqui.

| Estado | Significado |
|---|---|
| **Escrito** | Existe no arquivo local autorizado. |
| **Aplicado** | Foi inserido ou configurado no Elementor, salvo e publicado. |
| **Verificado** | Foi confirmado no site pelo método registrado. |

**Escrito não significa aplicado; aplicado não significa verificado.**

---

## Código local e Elementor

- Os arquivos em `css/` registram CSS local de base ou de componentes.
- `css/elementor-css-completo.txt` acompanha o fluxo de captura ou consolidação
  do CSS do Elementor; seu conteúdo local, isoladamente, não prova o estado do
  site.
- Os arquivos em `scripts/` contêm JavaScript comportamental cuja aplicação é
  feita em WordPress → Elementor → Código Personalizado.
- A confirmação do estado publicado ocorre no painel, no site, no código-fonte
  ou no teste correspondente, conforme o caso.

---

## Ambiente de desenvolvimento

O trabalho local usa Git e VS Code. O repositório mantém:

- `.gitignore` — exclui dependências, variáveis de ambiente, logs, arquivos de
  sistema e artefatos locais ou transitórios listados nele;
- `.gitattributes` — normaliza arquivos de texto com fim de linha LF;
- `.editorconfig` — padroniza UTF-8, LF, indentação e espaços em branco.

---

## Convenção de commits

Prefixo por tipo, para que o histórico permaneça legível:

| Prefixo | Uso |
|---|---|
| `docs:` | documentação |
| `feat:` | funcionalidade nova |
| `fix:` | correção |
| `style:` | ajuste visual, CSS |
| `chore:` | configuração, manutenção |

Exemplo: `docs: reconcilia orientacao do repositorio`

Mensagens sem acento evitam problemas de codificação em terminais.

Commit e push dependem de autorização específica.

---

## Sobre o CLAUDE.md

O `CLAUDE.md` oferece contexto específico ao Claude Code, mas não é a fonte
canônica do item corrente, do estado do projeto nem da arquitetura de IA.

- Item corrente, estados e pendências: `docs/controle-projeto.md`.
- Regras universais de trabalho: `AGENTS.md`.
- Arquitetura detalhada de uso de IA: `docs/ARQUITETURA-IA.md`.

Se houver divergência, prevalece a fonte responsável por cada tipo de
informação.
