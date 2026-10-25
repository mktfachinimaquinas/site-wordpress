# Manual do site Fachini Máquinas

Documento de operação do site novo. Serve para a equipe da Fachini no dia a dia
e para qualquer desenvolvedor WordPress que venha a assumir o projeto.

Atualizado em 25/10/2026.

---

## 1. Como o site é montado

O site tem três camadas separadas de propósito. Entender isso evita a maior
parte dos problemas:

| Camada | O que é | Onde mora |
|---|---|---|
| Conteúdo | As máquinas, categorias, pedidos e textos | Banco de dados, via plugin **Fachini Core** |
| Estrutura | Tipo de conteúdo, categorias, campos, endereços, formulário, integrações | Plugin **Fachini Core** (código, neste repositório) |
| Visual | Layout das páginas, cores, fontes | Elementor + tema filho **Hello Elementor Child - Fachini** |

A regra que sustenta tudo: **o conteúdo não mora dentro do Elementor**. Trocar o
visual do site, ou até sair do Elementor, não apaga nenhum cadastro de máquina
nem nenhum pedido de orçamento.

## 2. Como cadastrar uma máquina

1. No painel, vá em **Máquinas > Adicionar nova**.
2. **Título**: nome da máquina como aparece no site.
3. **Texto principal** (o editor da página): a descrição completa, em parágrafos.
   Aparece na seção "Descrição".
4. **Categoria de máquina**: marque a subcategoria mais específica. Ex.: para a
   dobradeira automática de régua dentada, marque *Dobradeiras de régua
   dentada*, e não apenas *Calhas*. É a subcategoria que define o endereço.
5. Preencha os campos abaixo do texto. O que ficar vazio simplesmente não
   aparece na página.
   - **Dados da máquina**
     - *Modelo / série*: ex. Série "HWM". Aparece nos cards das listagens.
     - *Descrição curta*: uma ou duas frases. Usada nos cards das listagens.
     - *Especificações técnicas*: uma por linha, no formato `Rótulo: valor`.
       Exemplo:
       ```
       Espessura: 0,43 mm
       Velocidade: 18 m/min
       Potência: 7,5 cv
       ```
     - *Vídeo (YouTube)*: aparece na seção "Mídia".
     - *Fotos adicionais 2, 3 e 4*: completam a galeria ao lado da descrição.
     - *Destacar na home*: a máquina passa a aparecer entre os destaques da
       busca do site (a lupa do menu).
     - *Catálogo em PDF* e *Máquinas relacionadas*: os campos já existem, mas o
       modelo atual da página (que segue o Figma) ainda não mostra essas áreas.
   - **Topo da página**: *Foto do topo*. Sem ela, o topo usa a foto da
     categoria.
   - **Modelos de telha**: título da seção e até 6 modelos, cada um com nome,
     imagem da telha (ou peça) e desenho técnico.
   - **Aplicações**: até 2 fotos com uma legenda curta cada.
6. **Imagem destacada** (coluna da direita): a foto principal. Aparece no card
   da listagem e no início da galeria.
7. **Publicar**.

O endereço da página é montado sozinho, a partir da categoria:
`/calhas/dobradeiras-regua-dentada/automatica/`.

**Fotos**: envie em JPG com cerca de 2000 px de largura. O site gera sozinho as
versões menores e em WebP. Evite imagens geradas por inteligência artificial
como foto de produto, porque mostram uma máquina que não existe.

**Quem pode cadastrar**: usuários com o perfil *Cadastro de máquinas* criam e
editam as próprias máquinas. Um administrador pode passar a autoria de uma
máquina para outro usuário no campo *Autor*.

### Cuidado importante com o Elementor

Nunca mude uma página publicada para rascunho. Ela sai do ar na hora e passa a
dar erro 404 para quem acessar. Se precisar testar uma mudança grande, duplique
a página e trabalhe na cópia.

## 3. Estrutura de endereços

Três níveis, conforme a planilha aprovada:

```
/calhas/                                    categoria principal
/calhas/dobradeiras-regua-dentada/          subcategoria
/calhas/dobradeiras-regua-dentada/automatica/  máquina
/maquinas/                                  listagem geral
```

As categorias e subcategorias são criadas automaticamente pelo plugin, a partir
da lista em `wp-content/plugins/fachini-core/includes/seed-categorias.php`.

**Se mudar a árvore de categorias**, atualize esse arquivo, altere a constante
`FACHINI_CATEGORIAS_VERSAO` e salve os links permanentes em
*Configurações > Links permanentes*.

### Endereços do site antigo

Os endereços do site antigo (`/site/...`) redirecionam com 301 para as páginas
novas, conforme a planilha aprovada. A lista fica em
`wp-content/plugins/fachini-core/includes/redirecionamentos.php`. Se um endereço
antigo aparecer no Monitor 404 do Rank Math (seção 9), ele entra nessa lista.

## 4. Pedidos de orçamento

O formulário da página **Contato** grava cada pedido no painel, em
**Pedidos de orçamento**. Cada pedido mostra:

- o protocolo (ex.: 2026-10-0151), os dados da pessoa ou da empresa e a máquina
  de interesse;
- os dois consentimentos (contato comercial e comunicações de marketing);
- a origem da visita (Google, anúncio, Instagram, campanha, página de entrada);
- se o e-mail e o envio ao RD Station deram certo.

Os pedidos ficam visíveis só para administradores e não aparecem no site.

**Configurações** (*Pedidos de orçamento > Configurações*):

- *E-mails que recebem os pedidos*: um ou mais, separados por vírgula.
- *WhatsApp do atendimento*: só números, com país e DDD (ex.: 554533281313).
  Depois do envio, a página de confirmação leva a pessoa para este WhatsApp com
  uma mensagem pronta e o protocolo.

O formulário tem proteção contra robôs (campo invisível, tempo mínimo de
preenchimento e limite de envios por hora). O botão "Solicitar orçamento" de
cada máquina já abre o formulário com a categoria e o modelo escolhidos.

## 5. Perguntas frequentes da página Contato

Ficam na própria página **Contato** (*Páginas > Contato*), nos campos
*Pergunta 1* a *Pergunta 8* e *Resposta 1* a *Resposta 8*, abaixo do editor.
Pergunta sem resposta não aparece. Sem nenhuma, a seção some.

## 6. Política de privacidade e banner de cookies

- O texto da **Política de privacidade** é o aprovado pelo jurídico e fica no
  código (`includes/politica.php`), para não ser alterado por engano. Mudança
  no texto passa pelo desenvolvedor.
- O **banner de cookies** aparece na primeira visita, com as categorias da
  política: essenciais (sempre ativos), desempenho e análise, marketing e
  remarketing. A pessoa pode aceitar, recusar ou escolher, e rever a escolha
  pelo link *Preferências de cookies* da política.
- Nenhuma ferramenta de medição carrega antes do consentimento (Consent Mode do
  Google incluído).
- Se as categorias ou as ferramentas mudarem, altere a constante
  `FACHINI_COOKIES_VERSAO` em `includes/consentimento.php`: o banner volta a
  aparecer para todos.

## 7. Integrações e medição

Em **Configurações > Integrações**:

| Campo | Para quê | Carrega com |
|---|---|---|
| Google Analytics 4 | Visitas, cliques no WhatsApp (`whatsapp_click`) e pedidos (`generate_lead`) | consentimento de análise |
| Google Ads (+ rótulo da conversão) | Remarketing; com o rótulo, cada pedido conta como conversão | consentimento de marketing |
| Pixel da Meta | Visitas, cliques no WhatsApp (`Contact`) e pedidos (`Lead`) | consentimento de marketing |
| Google Tag Manager | Opcional, para quem quiser gerenciar tags por lá | qualquer consentimento |
| Script do RD Station | Rastreamento do RD e RD Conversas | qualquer consentimento |
| Token público do RD Station | Cada pedido entra no RD como conversão `pedido-de-orcamento-site`, com a origem da visita | (no servidor) |

Campo em branco desliga a integração. Se o GA4 também estiver configurado
dentro do GTM, deixe o campo do GA4 em branco, senão as visitas contam em
dobro. Nenhum dado pessoal (nome, e-mail, telefone) é enviado ao Google ou à
Meta.

## 8. E-mail do site

Os e-mails dos pedidos saem por uma caixa própria do site (SMTP), configurada
no arquivo `wp-config.php` do servidor, nunca no painel:

```php
define( 'FACHINI_SMTP_HOST', 'smtp.hostinger.com' );
define( 'FACHINI_SMTP_PORT', 465 );
define( 'FACHINI_SMTP_SECURE', 'ssl' );
define( 'FACHINI_SMTP_USER', 'site@fachinimaquinas.com.br' );
define( 'FACHINI_SMTP_PASS', 'senha da caixa' );
define( 'FACHINI_SMTP_FROM_NAME', 'Site Fachini Máquinas' );
```

Depois de configurar, use o botão *Enviar e-mail de teste* em
*Configurações > Integrações*. Ninguém precisa ler essa caixa: ela só envia.

## 9. SEO (Rank Math)

- Título e descrição de cada página ou máquina: caixa do Rank Math na tela de
  edição. Em branco, ele monta sozinho a partir do título e do texto.
- Dados da empresa para o Google (endereço da matriz em Cascavel, telefone,
  razão social, CNPJ, logo e redes sociais): *Rank Math > Títulos e meta >
  SEO local* e *Meta social*.
- Sitemap: `/sitemap_index.xml`, enviado ao Google Search Console.
- *Rank Math > Monitor 404*: mostra endereços que deram erro. Útil nas primeiras
  semanas depois do lançamento.
- As páginas de autor (`/author/...`) redirecionam para a Home, para não expor
  o login dos usuários.
- **Atenção ao salvar configurações do Rank Math**: o navegador pode preencher
  sozinho o login e a senha do painel em campos da tela (como "App ID do
  Facebook" ou "Chave da API do Google Maps"). Confira esses campos antes de
  salvar.

## 10. Plugins instalados e por que cada um está aqui

A lista é fechada. Plugin novo só entra com aprovação da Fachini.

| Plugin | Para quê |
|---|---|
| Elementor | Construtor visual das páginas |
| Elementor Pro | Theme Builder (modelos de página) |
| Advanced Custom Fields | Campos das máquinas e das perguntas frequentes |
| Rank Math SEO | Títulos, descrições, sitemap e dados estruturados |
| LiteSpeed Cache | Cache e otimização, aproveitando o servidor LiteSpeed da hospedagem |
| **Fachini Core** | Plugin próprio da empresa: máquinas, categorias, campos, endereços, formulário e pedidos, política e banner de cookies, integrações, e-mail e redirecionamentos |

O que **não** usa plugin, de propósito: formulário, envio de e-mail (SMTP),
banner de consentimento LGPD e scripts de marketing. Tudo isso está em código
no Fachini Core.

## 11. Kit de estilos

Cores, fontes, tamanhos e largura de conteúdo ficam em
*Elementor > Configurações do site*. Os valores vêm do design system do projeto
e são aplicados por código em `includes/style-kit.php`.

Resumo: títulos e textos em **Archivo**, destaque do topo em **Geist**, azul
`#15274E`, vermelho de ação `#E01E26`, conteúdo com 1200px de largura. As
fontes são servidas pelo próprio site (sem Google Fonts).

Editar pelo painel funciona normalmente. A rotina de código só roda uma vez.

## 12. Desempenho e cache

- **LiteSpeed Cache** guarda as páginas prontas para os visitantes e otimiza
  CSS e JavaScript (minificar, combinar, carregar o JavaScript depois da
  página). A otimização vale só para visitantes; quem está logado vê a versão
  normal.
- Ao publicar ou editar uma máquina, o cache das páginas ligadas a ela é
  atualizado sozinho. Se algo não aparecer, use *LiteSpeed Cache > Caixa de
  ferramentas > Limpar tudo*.

## 13. Backup e publicação

- **Backup automático**: JetBackup, no painel da hospedagem.
- **Backup manual antes de qualquer mudança grande**: cPanel > Backup >
  Diretório inicial, mais o banco de dados.
- **Regra de publicação**: conteúdo novo (máquina, texto, imagem) é cadastrado
  direto na produção. O ambiente de homologação serve apenas para código,
  atualização e modelo de página.
- **Nunca** use um recurso de "publicar staging por cima do site", porque ele
  sobrescreve o banco inteiro e apaga cadastros e pedidos feitos no meio do
  caminho.

## 14. Código e versionamento

Todo o código personalizado está neste repositório:

```
wp-content/plugins/fachini-core/            plugin da empresa
wp-content/themes/hello-elementor-child/    tema filho
```

Para atualizar no servidor: gerar o .zip da pasta e enviar em *Plugins >
Adicionar novo > Enviar plugin* (ou *Aparência > Temas > Adicionar novo >
Enviar tema*), escolhendo "Substituir a versão atual". Guarde o .zip da versão
anterior para poder voltar.

O layout feito dentro do Elementor fica no banco de dados, não no Git. Por isso
os modelos do Theme Builder são exportados em JSON e guardados junto ao
repositório quando ficarem prontos.

## 15. Ambientes

| Ambiente | Endereço | Para quê |
|---|---|---|
| Construção | wordpress.fachinimaquinas.com.br | Onde o site está sendo montado. Protegido por senha e bloqueado para buscadores. |
| Produção | fachinimaquinas.com.br | Entra no ar no lançamento, com os redirecionamentos do site antigo. |
