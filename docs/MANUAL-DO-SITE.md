# Manual do site Fachini Máquinas

Documento de operação do site novo. Serve para a equipe da Fachini no dia a dia
e para qualquer desenvolvedor WordPress que venha a assumir o projeto.

Atualizado em 01/10/2026.

---

## 1. Como o site é montado

O site tem três camadas separadas de propósito. Entender isso evita a maior
parte dos problemas:

| Camada | O que é | Onde mora |
|---|---|---|
| Conteúdo | As máquinas, categorias e textos | Banco de dados, via plugin **Fachini Core** |
| Estrutura | Tipo de conteúdo, categorias, campos, endereços | Plugin **Fachini Core** (código, neste repositório) |
| Visual | Layout das páginas, cores, fontes | Elementor + tema filho **Hello Elementor Child - Fachini** |

A regra que sustenta tudo: **o conteúdo não mora dentro do Elementor**. Trocar o
visual do site, ou até sair do Elementor, não apaga nenhum cadastro de máquina.

## 2. Como cadastrar uma máquina

1. No painel, vá em **Máquinas > Adicionar nova**.
2. **Título**: nome da máquina como aparece no site.
3. **Categoria de máquina**: marque a subcategoria mais específica. Ex.: para a
   dobradeira automática de régua lisa, marque *Dobradeiras de régua lisa*, e
   não apenas *Calhas*. É a subcategoria que define o endereço da página.
4. Preencha os campos de **Dados da máquina**:
   - *Modelo / série*: ex. Série "HWM".
   - *Descrição curta*: uma ou duas frases, usada nos cards e no Google.
   - *Especificações técnicas*: uma por linha, no formato `Rótulo: valor`.
     Exemplo:
     ```
     Espessura: 0,43 mm
     Velocidade: 18 m/min
     Potência: 7,5 cv
     ```
   - *Catálogo em PDF*, *Vídeo*, *Fotos adicionais*: opcionais. O que estiver
     vazio simplesmente não aparece na página.
   - *Máquinas relacionadas*: até quatro, aparecem no fim da página.
5. **Foto principal**, na coluna da direita: é a imagem que aparece no card da
   listagem e no topo da página.
6. **Publicar**.

O endereço da página é montado sozinho, a partir da categoria:
`/calhas/dobradeiras-regua-lisa/automatica/`.

### Cuidado importante com o Elementor

Nunca mude uma página publicada para rascunho. Ela sai do ar na hora e passa a
dar erro 404 para quem acessar. Se precisar testar uma mudança grande, duplique
a página e trabalhe na cópia.

## 3. Estrutura de endereços

Três níveis, conforme a planilha aprovada:

```
/calhas/                                    categoria principal
/calhas/dobradeiras-regua-lisa/             subcategoria
/calhas/dobradeiras-regua-lisa/automatica/  máquina
/maquinas/                                  listagem geral
```

As categorias e subcategorias são criadas automaticamente pelo plugin, a partir
da lista em `wp-content/plugins/fachini-core/includes/seed-categorias.php`.

**Se mudar a árvore de categorias**, atualize esse arquivo, altere a constante
`FACHINI_CATEGORIAS_VERSAO` e salve os links permanentes em
*Configurações > Links permanentes*.

## 4. Plugins instalados e por que cada um está aqui

A lista é fechada. Plugin novo só entra com aprovação da Fachini.

| Plugin | Para quê |
|---|---|
| Elementor | Construtor visual das páginas |
| Elementor Pro | Theme Builder (modelos de página) e formulários |
| Advanced Custom Fields | Campos das máquinas |
| Rank Math SEO | Títulos, descrições, sitemap e dados estruturados |
| LiteSpeed Cache | Cache, aproveitando o servidor LiteSpeed da hospedagem |
| **Fachini Core** | Plugin próprio da empresa: cadastro de máquinas, categorias, campos, endereços e kit de estilos |

O que **não** usa plugin, de propósito: envio de e-mail (SMTP em código), banner
de consentimento LGPD (código), e scripts de marketing (código no tema filho).

## 5. Kit de estilos

Cores, fontes, tamanhos e largura de conteúdo ficam em
*Elementor > Configurações do site*. Os valores vêm do design system do projeto
e são aplicados por código em `includes/style-kit.php`.

Resumo: títulos em **Mitr 600**, textos em **Archivo**, azul `#15274E`,
vermelho de ação `#E01E26`, conteúdo com 1200px de largura.

Editar pelo painel funciona normalmente. A rotina de código só roda uma vez.

## 6. Backup e publicação

- **Backup automático**: JetBackup, no painel da hospedagem.
- **Backup manual antes de qualquer mudança grande**: cPanel > Backup >
  Diretório inicial, mais o banco de dados.
- **Regra de publicação**: conteúdo novo (máquina, texto, imagem) é cadastrado
  direto na produção. O ambiente de homologação serve apenas para código,
  atualização e modelo de página.
- **Nunca** use um recurso de "publicar staging por cima do site", porque ele
  sobrescreve o banco inteiro e apaga cadastros feitos no meio do caminho.

## 7. Código e versionamento

Todo o código personalizado está neste repositório:

```
wp-content/plugins/fachini-core/     plugin da empresa
wp-content/themes/hello-elementor-child/   tema filho
```

O layout feito dentro do Elementor fica no banco de dados, não no Git. Por isso
os modelos do Theme Builder são exportados em JSON e guardados junto ao
repositório quando ficarem prontos.

## 8. Ambientes

| Ambiente | Endereço | Para quê |
|---|---|---|
| Construção | wordpress.fachinimaquinas.com.br | Onde o site está sendo montado. Bloqueado para buscadores. |
| Produção | fachinimaquinas.com.br | Entra no ar na etapa 3, com os redirecionamentos do site antigo. |
