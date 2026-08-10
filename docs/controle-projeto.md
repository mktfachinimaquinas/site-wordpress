# Controle do Projeto — Site Fachini Máquinas

**Documento vivo.** Atualizar a cada decisão tomada ou pendência resolvida.
**Última atualização:** 31/07/2026

## ITEM ATUAL

**Módulo 2 — estruturar a busca em Off Canvas e preparar o esqueleto da
pesquisa.**

---

## 0. Regra de registro — status carrega método de verificação

> Criada em 28/07, depois de um passo nunca executado ser marcado como
> concluído em quatro documentos sem ninguém tropeçar.

**Este documento registra duas coisas diferentes, e elas não podem se
misturar:**

| Tipo | O que é | Como registrar |
|---|---|---|
| **Decisão** | O que foi combinado | Data + o que foi decidido |
| **Execução** | O que foi feito e está no ar | Data + **como foi verificado** |

**Toda mudança de status de execução carrega o método de verificação.**
Sem isso, status é intenção, não fato.

Exemplos:

- ❌ "Passo 6 concluído"
- ✅ "Passo 6 concluído — verificado por inspeção do hover no navegador a 1366px"
- ❌ "CSS aplicado"
- ✅ "CSS aplicado — confirmado no código-fonte da página, busca por `.fachini-header`"

**A segunda cara do mesmo problema:** arquivo atualizado não é site atualizado.
O `header.css` é a fonte; o `.txt` consolidado é o que se cola no Elementor.
Registrar que o arquivo mudou não prova que o site mudou.

| Estado | Significado |
|---|---|
| Escrito | Está no repositório |
| **Aplicado** | Foi colado no Elementor, salvo e publicado |
| **Verificado** | Confirmado no site, com o método anotado |

---

## 1. Decisões travadas (registro)

| Data | Decisão | Observação |
|---|---|---|
| 31/07 | **Dropdown “MÁQUINAS” aplicado e verificado** | JavaScript completo publicado no Elementor. Clique, Enter, Espaço, Escape e devolução de foco foram testados; ver registro detalhado abaixo |
| 31/07 | **Busca do header: arquitetura Off Canvas** | A busca expansível inline foi substituída pela estrutura Off Canvas. A etapa atual prepara a interface; integração e resultados reais ficam pendentes |
| 26/07 | **POSICIONAMENTO: perfiladeira é fabricação Fachini** | Decisão da diretoria. Sustentado por capacidade instalada — insumos e estrutura para fabricar cada componente, histórico de refabricação completa. Finame em andamento. Ver seção 14 do dossiê |
| 26/07 | **Árvore de navegação: seguir Figma por ora** | Foco na entrega. Ajustes de estrutura ficam para depois do lançamento |
| 26/07 | **MÓDULO 1 CONCLUÍDO** | Global Colors, Global Fonts, Theme Style completo, Content Width 1200, Layout Full Width, variáveis de espaçamento. Teste de herança validado |
| 26/07 | **Ultimate Addons for Elementor removido** | Redundante com Elementor Pro. Templates de cabeçalho/rodapé apagados, ambiente limpo, cache limpo |
| 28/07 | **CSS usa variáveis globais do Elementor, não hex** | `var(--e-global-color-primary)` em vez de `#15274E`. Mantém o vínculo com a paleta — se a cor mudar no painel, o CSS acompanha |
| 28/07 | **Barra do dropdown por pseudo-elemento** | `border-left` herdava o `border-radius` do painel e ficava curvada. `::before` é independente e permanece reto |
| 28/07 | **Largura do dropdown fica automática** | O SmartMenus escreve estilo inline no `<ul>`, que vence qualquer CSS. Ajuste via Espaçamento horizontal no painel |
| 28/07 | **Rolagem suave adicionada ao global.css** | `scroll-behavior: smooth` com `prefers-reduced-motion`. ⚠ **Escrito, não verificado como aplicado no site** |
| 28/07 | **"Máquinas" não terá página de categoria** | O item existe só para abrir o submenu. Exige que ele se comporte como botão e não como link — ver 4.0b |
| 28/07 | **Dropdown por clique confirmado** | Caminho definido para o passo 7. O hover continua ativo até a execução |
| 28/07 | **Arquitetura de conversas** | Central (dona do estado) + conversas de módulo (execução). Detalhe na Parte 0 do BRIEFING. **Exceção:** o Módulo 2 é executado pela central; a arquitetura vale a partir do Módulo 3 |
| 28/07 | **Content Width: 1280 → 1200px** | Alinha ao novo layout da designer (tela 1366, conteúdo 1200). O container interno do header deve ficar com o campo VAZIO para herdar — valor digitado não acompanha mudanças |
| 28/07 | **H2 fechado em 45px** | Confirmado pela designer. Substitui os 48px validados em 25/07 |
| 27/07 | **Módulo 2 — passos 5 e 6 concluídos** | Fundo condicional, hover do menu, chevron, dropdown com deslizar e barra vermelha. CSS versionado em `css/header.css` |
| 27/07 | **Largura do dropdown fica automática** | O SmartMenus escreve estilo inline no `<ul>`, que vence qualquer CSS. Ajuste via Espaçamento horizontal no painel do widget |
| 27/07 | **Mitr em SemiBold 600** | O Bold da Mitr é visivelmente mais pesado que o de uma grotesca ocidental — origem tailandesa, contraste maior entre pesos. Em caixa alta ficava excessivo. Alinhado com a equipe |
| 27/07 | **Escala tipográfica revista — razão 1.25** | H1 alinhado aos 56px do Figma (a 64px ficava desproporcional em notebook). H3 permanece em 36px. Novos valores: 56 · 45 · 36 · 29 · 23 |
| 26/07 | **Botões sem sombra** | Superfícies planas. Sombra em cards de notícia segue pendente da designer |
| 26/07 | **Header transparente sobre o hero** | Sólido navy nas páginas internas via `body.home`. Sticky pendente — recomendação é sem sticky no lançamento |
| 26/07 | **Menu: "Máquinas" como guarda-chuva** | As categorias do mapa do dono ficam no dropdown. Oito itens soltos apertariam o header em 1200px |
| 26/07 | **JavaScript: foco no ensino** | Conceito explicado, Wilson escreve, revisão. Recalibra com "escreve" se comprometer o prazo |
| 26/07 | **H3 sem transformação de caixa** | Aparece em caixa alta nos diferenciais e caixa baixa nos cards de notícia. Caixa alta aplicada por seção |
| 23/07 | **Paleta de 8 cores** | Navy `#15274E` · Navy Sec. `#00224E` · Vermelho `#E01E26` · Verm. Hover `#B01319` · Onix `#0F0F0F` · Off-white `#FBFBFB` · Cinza Névoa `#F1F3F6` · Cinza Médio `#5C6675` |
| 23/07 | **Mitr 700 para H1/H2**, sempre caixa alta | Mitr não tem peso acima de 700 |
| 23/07 | **Archivo 400/600/700** para o resto | 4 arquivos de fonte no total, hospedados localmente |
| 23/07 | **Toska exclusiva do logo**, em SVG | Não é webfont |
| 23/07 | **Roboto descontinuada** | Página `3 - MARCA` do Figma desatualizada |
| 23/07 | **Sistema de 4 camadas de largura** | Full-bleed 100% · Larga `min(94vw,1560px)` · Padrão 1200px · Texto 720px |
| 23/07 | **Escala tipográfica razão 1.333** | H2 de 48px e line-height do H3 de 1.25 validados pela designer em 25/07 |
| 23/07 | **Hierarquia de headings definida** | Um H1 por página; números de estatística não são heading |
| 23/07 | **Vídeo fora do hero** | Remove o maior risco de CWV mobile |
| 23/07 | **Scrollytelling adiado** | Versão intermediária no lançamento: sticky + fade |
| 23/07 → 27/07 | **Rótulo da linha Lisa/Dentada** | Decisão revista: "Serralheria" é segmento e não produto, mas "Calhas" subdimensiona a máquina. **Adiado para teste A/B pós-lançamento** (ver 6.4) |
| 23/07 | **Country Blocking do Loginizer DESATIVADO** | Ver 1.1 abaixo |

### Estado comprovado — dropdown “MÁQUINAS” (31/07/2026)

**ESCRITO:**

- `scripts/header.js` contém somente JavaScript;
- o arquivo do repositório não contém tags HTML;
- o comentário informa que o conteúdo deve ser envolvido por `<script>` ao
  aplicar no Elementor.

**APLICADO:**

- o código foi envolvido por `<script>...</script>`;
- foi inserido em WordPress → Elementor → Código Personalizado;
- foi salvo e publicado.

**VERIFICADO:**

- Tab posiciona o foco em “MÁQUINAS”;
- Enter abre o submenu;
- Espaço abre sem rolar quando “MÁQUINAS” está focado;
- Escape fecha;
- Escape devolve o foco ao item pai;
- fora do menu, Espaço mantém a rolagem normal da página;
- `aria-expanded` alterna entre `true` e `false`, verificado no Inspetor;
- o JavaScript não aparece mais escrito no rodapé;
- o menu voltou a funcionar após a correção da forma de aplicação.

**Convenção definitiva:**

- no repositório, `scripts/header.js` contém somente JavaScript;
- no Elementor → Código Personalizado, o conteúdo fica envolvido por
  `<script>...</script>`;
- não colocar tags HTML dentro do arquivo `.js`;
- não retirar as tags da versão aplicada no Elementor.

### 1.1 Registro — Loginizer Country Blocking

**O que era:** regra "Allow selected countries = Brazil" ativa no Country Block.

**O problema:** a documentação do Loginizer confirma que Country Blocking
restringe acesso ao **site inteiro**, não ao login. Com a regra ativa, todo
tráfego de IP não-brasileiro era barrado.

**O que isso custava:**

- Googlebot (rastreia de IPs americanos) não conseguia acessar o site →
  inviabilizava o objetivo central do Livro 1
- PageSpeed Insights e Lighthouse rodam de servidores do Google → impossível
  medir Core Web Vitals
- Search Console podia falhar na verificação e no "Testar URL ativa"
- Crawler do WhatsApp bloqueado → prévia de link não renderiza quando o
  vendedor manda o link de uma máquina
- Meta e LinkedIn idem → quebra prévia de anúncios e publicações

**Por que a proteção não compensava:** bloqueio por país não detém atacante
(proxy e VPN resolvem em minutos). O login já está protegido por brute force
em 3 tentativas, XML-RPC desativado e blacklist de usernames — camadas que
atuam onde o ataque acontece.

**Princípio:** o site público precisa ser público. Restrição geográfica se
aplica ao admin, não ao conteúdo.

**Resolução:** "Enable Country Blocking" desmarcado em 23/07/2026.

**Saída de emergência (se algum dia travar o acesso):** no gerenciador de
arquivos do servidor, abrir `wp-content/uploads/loginizer-config/firewall-config.php`
e mudar a chave `enabled` para `false`.

---

## 2. Pendências abertas

> Este é o índice único de pendências. Qualquer pendência registrada em
> outro documento (tokens.md, modulo-01, etc.) deve também aparecer aqui.
> Se não está aqui, não está no radar.

**Convenção de status:**
- 🔴 **Aberta** — ninguém mexeu
- 🟡 **Aguardando** — passada a alguém, esperando retorno
- 🟢 **Resolvida [data]** — fechada, com o método de verificação anotado

### 2.1 Com o Wilson — informação que só ele tem

| # | Status | Pendência | Bloqueia |
|---|---|---|---|
| 0 | 🟡 | **Árvore de navegação** — decisão 26/07: seguir Figma por ora, foco na entrega. Confirmar com o dono onde moram as Soluções por segmento quando houver espaço. Ver `docs/conflito-arvore-navegacao.md` | Camada 2, interlinking |
| 0b | 🟡 | **Finame para perfiladeiras** — processo em andamento, etapa inicial superada. Até concluir, evitar "100% nacional" no site. Ao concluir, vira prova a exibir | Afirmações sobre financiamento |
| 1 | 🔴 | **Spec completa do formulário** — 13 opções de Segmento, roteamento por verba/prazo, formato de integração (form nativo do RD embedado ou próprio via API?). O dossiê diz que a spec já foi aprovada em projeto separado — é caçá-la, não criá-la | Formulário e integrações |
| 2 | 🔴 | **Medição** — reaproveitar o GTM-T2J3MRFP existente ou criar limpo? Existe GA4? Quem tem acesso ao Search Console? | Baseline de conversão |
| 3 | 🔴 | **Data-alvo do go-live do site completo** — as 2 semanas cobrem só a homepage | Cronograma |
| 4 | 🔴 | **Dono do copy** — ninguém designado para escrever ~20 páginas nem validar specs | Produção de páginas |
| 5 | 🔴 | **Papel do WhatsApp** — CTA secundário rastreado? Qual número por unidade? | Header, footer, instrumentação |
| 6 | 🔴 | **Fronteira de conteúdo do Livro 1** — quem produz o material rico do Guia? Quantos artigos entram? | Blog e LP do Guia |
| 7 | 🔴 | **Planilha de capacidade e fotos por modelo** | Páginas de produto |
| 8b | 🔴 | **A designer já tem acesso ao painel do WordPress e já começou a montar no Elementor?** Se ainda não abriu o builder, o gargalo do prazo não é código (fonte: `relatorio-analise-homepage.md`, seção 8) | Cronograma da entrega |
| 8 | 🔴 | **Números institucionais** — "+50 modelos" e "+300 máquinas/ano" batem com o dossiê? | Seção de estatísticas |

### 2.2 Com a designer

| # | Status | Pendência |
|---|---|---|
| 1 | 🟡 23/07 | **Anotar a camada de largura de cada seção** (full-bleed / larga / padrão / texto) |
| 2 | 🟢 28/07 | **H2 em 45px** — confirmado pela designer. Histórico: Figma marcava 58px; 48px validado em 25/07; revisto para 45px na escala de razão 1.25 em 27/07 |
| 3 | 🟢 25/07 | **Line-height do H3 corrigido para 1.25**, validado pela designer (Figma marcava 75px sobre 36px = 2.08) |
| 4 | 🟡 23/07 | **Conferir quebra do H1** a 1200px em vez de 1558px |
| 5 | 🟡 23/07 | **Breakpoints** — quais valores usou no Figma |
| 6 | 🟡 23/07 | **Frames de 1366px e 390px** (wireframe basta) |
| 7 | ⏸️ | **Rótulo da linha Lisa/Dentada** — adiado para teste A/B pós-lançamento (ver 6.4). "Serralheria" fica no ar por ora |
| 8 | 🔴 | **Texto do mosaico visível no mobile** (hover não existe em toque) |
| 9 | 🔴 | **Corrigir rótulo "DOBRADEIRA CNC"** sobre a máquina SF3015G (que é laser) |
| 10 | 🟡 28/07 | **Página de resultados de busca** — em processo de resolução |
| 11 | 🟡 28/07 | **Página de obrigado** — em processo de resolução |
| 12 | 🟡 28/07 | **Template de post do blog** — em processo de resolução |
| 13 | 🔴 | **Desenhar o menu mobile (hamburguer)** — só existe desktop no Figma |
| 14 | 🔴 | **Definir os estados dos componentes** — hover, foco, erro, carregando (ver análise 360, B.1) |
| 15 | 🔴 | **Raio de borda de botões, cards e campos de formulário** — pendência de extração do Figma (fonte: `design-system/tokens.md`, seção 8) |
| 16 | 🔴 | **Sombra nos cards de notícia** — pendência de extração do Figma (fonte: `design-system/tokens.md`, seção 8) |
| 17 | 🔴 | **Medição dos espaçamentos reais seção a seção no Figma** — pendência de extração (fonte: `design-system/tokens.md`, seção 8) |
| 19 | 🟢 31/07 | **Arquitetura da busca** — a busca expansível inline foi superada pela decisão de usar Off Canvas. A antiga transição dos itens do menu não bloqueia mais a etapa atual |
| 21 | 🟢 28/07 | **Destino do link "MÁQUINAS"** — decidido: **não haverá página de categoria por ora.** O item existe apenas para abrir o submenu. Isso cria uma exigência técnica no passo 7 — ver 4.0b |
| 20 | 🔴 | **Camada "Larga" a 1200px** — com o padrão em 1200, `min(94vw, 1560px)` entrega 1284px numa tela de 1366, 84px acima do padrão. Ou ganha número novo, ou sai do sistema e o mosaico vira full-bleed |
| 18 | 🔴 | **Hierarquia de headings** — alinhar a marcação semântica da Parte 3 antes da montagem (fonte: `docs/modulo-01-design-system.md`, "Pendências com a designer") |

### 2.3 Verificações técnicas

**Resolvidas em 26/07/2026:**

| Item | Método de verificação |
|---|---|
| 🟢 Ambiente de dev limpo | Templates UAE e Theme Builder apagados; plugin desativado e excluído; cache limpo. Site retornou ao Hello Elementor puro |
| 🟢 Módulo 1 validado no Elementor | Página de rascunho com H1/H2/H3/parágrafo/botão herdou tipografia, cores e hover sem configuração manual |
| 🟢 H1 duplicado corrigido | Modelo de página trocado para Elementor Largura Total — o título da página deixou de gerar um segundo H1 |

**Pendentes:**

| Item | O que verificar |
|---|---|
| 🔴 **O CSS consolidado foi colado no Elementor?** | O `scroll-behavior` e o `prefers-reduced-motion` entraram no `global.css` em 28/07. Se o consolidado não foi recolado, a rolagem suave não existe no site. Verificar: código-fonte da página, buscar por `scroll-behavior` |

| # | Status | Item |
|---|---|---|
| 1 | 🟢 24/07 | **Country Blocking do Loginizer desativado** — confirmado por print, "Enable" desmarcado |
| 2 | 🟢 24/07 | **Repositório publicado no GitHub** (privado) — confirmado por `git remote -v` |
| 3 | 🔴 | **Escopo do firewall geográfico** — resolvido pela desativação acima, mas confirmar em produção no go-live |
| 4 | 🟡 24/07 | **noindex do subdomínio de dev** — Wilson marcou "desencorajar indexação". Confirmar que está ativo em dev e DESMARCAR no go-live |
| 5 | 🔴 | **Plugins da véspera** — GoSMTP, CookieAdmin, ACF, reCAPTCHA já aparecem instalados. Confirmar configuração de cada um |

### 2.4 Busca Off Canvas — estrutura e integração

**Arquitetura decidida:**

- a solução atual usa o widget Off Canvas;
- descrições antigas de busca expansível inline estão superadas;
- o Off Canvas será usado como estrutura da interface de pesquisa;
- o campo de pesquisa permanece dentro do Off Canvas;
- a estrutura pode ser preparada antes da integração completa dos resultados;
- links, campos retornados e consulta real ficam para etapa posterior.

**Pendências — não classificadas como aplicadas ou verificadas:**

- Off Canvas encavalando ou afetando o header;
- hierarquia correta dos containers;
- foco inicial ao abrir;
- fechamento por Escape;
- devolução de foco ao acionador;
- ordem do Tab;
- comportamento de `aria-modal`;
- comportamento de `inert`;
- bloqueio de rolagem;
- conteúdo real dos resultados;
- links dos resultados;
- campos exibidos;
- Loop Item final;
- template final de resultados;
- teste de uma pesquisa real.

**Estado atual:** arquitetura decidida; aplicação e verificação estrutural
pendentes. A integração dos resultados não faz parte da verificação funcional
desta etapa.

---

## 3. Achados novos — o que tinha passado

### 3.1 ⚠ Integração e fallback de resultados de busca pendentes

A experiência principal escolhida usa Off Canvas. O campo de pesquisa e a área
destinada aos resultados podem ser estruturados antes de a consulta real, os
campos retornados e os links estarem finalizados.

Isso não torna a pesquisa funcional. O Loop Item, o template final de
resultados, o estado sem resultado e uma pesquisa real continuam pendentes.

**Ação atual:** preparar a estrutura do Off Canvas.
**Ação posterior:** integrar e verificar os resultados e o fallback.

### 3.2 ⚠ Não existe página de obrigado

Depois de enviar o formulário, o usuário precisa ir para algum lugar.

Isso não é detalhe de UX — **é requisito de medição**. A forma mais confiável de
contar conversão é o carregamento de uma URL específica (`/obrigado`). Sem ela,
o rastreamento depende de detectar mudança na tela, que é mais frágil e quebra
com mais facilidade.

E é onde se coloca o próximo passo: link para o catálogo, prazo de retorno do
comercial, botão de WhatsApp.

**Ação:** desenhar e criar a página. Entra no baseline do dia 1.

### 3.3 ⚠ Não existe template de post do blog

A homepage tem a seção "Notícias" puxando do blog. Mas o post individual não
foi desenhado — e sem template, ele herda o padrão do Hello Elementor, que é
nenhum.

Consequência dupla: o artigo fica sem identidade visual, e a estratégia de
conteúdo do dossiê (blog como motor de autoridade) nasce sem casa.

**Ação:** template de post no Elementor, com o mesmo design system.

### 3.4 Open Graph — prévia de link no WhatsApp

Quando o vendedor manda o link de uma máquina no WhatsApp, a prévia com foto e
título vem das tags Open Graph. Sem elas configuradas, vira link cru.

Impacto comercial direto no canal que a linha leve mais usa. O RankMath faz
isso, mas precisa ser configurado — imagem padrão do site e imagem específica
por página de produto.

**Ação:** configurar no módulo de SEO on-page.

### 3.5 Alt text nas imagens

O site é intensamente visual — mosaico de máquinas, galerias de produto. Cada
imagem sem alt text é conteúdo invisível para o Google e para leitor de tela.

Numa página de produto, o alt correto ("perfiladeira Fachini para telha
trapezoidal") é sinal de relevância adicional para a busca por imagem, que no
mercado industrial tem volume real.

**Ação:** regra de nomenclatura de arquivo e alt text, entregue à designer
antes de ela subir a biblioteca de mídia. Refazer depois é caro.

### 3.6 Método de migração dev → produção

O site vive em `wordpress.fachinimaquinas.com.br` e vai substituir o domínio
principal. Isso **não é** só apontar DNS: todas as URLs gravadas no banco —
links internos, caminhos de imagem, configurações do Elementor — apontam para o
subdomínio de dev.

Sem uma substituição controlada de URLs no banco, o site novo carrega imagens
do subdomínio antigo e os links internos apontam para o lugar errado.

**Ação:** definir o método antes do go-live. Não é tarefa de véspera.

### 3.7 Acessibilidade de teclado no menu

O dropdown de "Máquinas" abre por clique. Precisa funcionar também por teclado
(Tab para navegar, Enter ou Espaço para abrir, Esc para fechar).

Não é só acessibilidade: o Google usa sinais de usabilidade, e navegação que só
funciona com mouse é falha de qualidade.

**Ação:** incluir no Módulo 2, junto do CSS do header.

---

## 4. Checklist de go-live

> ⚠ **Item 1 é o erro mais caro que existe em lançamento de site.**

### 4.0 ⚠ Risco VIGENTE — dependência de JavaScript no menu

**Passou a valer em 30/07/2026.** O passo 7 do Módulo 2 foi executado: o
dropdown de "MÁQUINAS" agora abre por **clique**, via `scripts/header.js`,
não mais por hover nativo.

A abertura do submenu passou a depender do script rodar sem erro.

**Se o JavaScript falhar** (erro de sintaxe, conflito com outro plugin, bloqueio
por otimização do WP Rocket), o submenu não abre. Como "MÁQUINAS" é o
guarda-chuva de todas as categorias de produto, **a linha principal fica
inalcançável pelo menu**.

**Agravante:** o link do "MÁQUINAS" aponta para `#`. Mesmo que alguém clique
esperando ir a uma página de categoria, não vai a lugar nenhum.

**Mitigações a implementar:**

- [ ] Dar destino real ao item "MÁQUINAS" — uma página de categoria que liste
      todas as linhas. Assim o clique funciona mesmo sem JS
- [ ] Testar o menu com JavaScript desativado no navegador antes do go-live
- [x] Confirmar que a minificação/adiamento de JS do WP Rocket não quebra o
      script — testado em janela anônima, o atraso não engole o primeiro
      clique (`BRIEFING-conversa-03.md`, B1)
- [ ] Garantir que as categorias também estejam alcançáveis pelo footer

**Nenhuma das pendentes foi verificada ainda.**

---

### 4.0b Exigência técnica — "Máquinas" como abridor, não como link

**Decorre da decisão de 28/07** de não criar página de categoria.

Hoje o item é um link customizado apontando para `#`. Com **hover** isso não
incomoda — ninguém clica no pai. Com **clique**, o mesmo gesto dispara duas
coisas: abre o submenu **e** navega para `#`, o que salta a página para o topo.

E no teclado, link com `#` recebe Enter e navega. Para ser um abridor de
submenu, ele precisa se comportar como **botão**, não como link.

**O que o passo 7 precisa resolver:**

- [x] Impedir a navegação padrão do link ao clicar — `e.preventDefault()` —
      **verificado no site**
- [x] Anunciar o estado para leitor de tela (`aria-expanded` alternando entre
      `true` e `false`) — **verificado no site**, inspetor confirma a troca
- [x] Enter e Espaço abrem o submenu, em vez de navegar — Enter funciona pelo
      clique nativo do link; Espaço foi testado com o item em foco e não rola
      a página
- [x] Escape fecha e devolve o foco ao item pai — **verificado no site**
- [x] Fora do menu, Espaço preserva a rolagem normal — **verificado no site**

**Escrito:** `scripts/header.js` contém o clique e o tratamento de teclado,
sem tags HTML.

**Aplicado:** conteúdo envolvido por `<script>...</script>` no Código
Personalizado do Elementor, salvo e publicado.

**Verificado:** clique, Enter, Espaço, Escape e devolução de foco foram
testados. O código não aparece como texto no rodapé e o menu funciona após a
correção da forma de aplicação.

---

### 4.1 Antes de virar

- [ ] **DESMARCAR "desencorajar indexação"** em Configurações → Leitura.
      Site novo entra no ar com noindex ativo, ninguém percebe, e semanas
      depois descobrem que o Google nunca rastreou nada
- [ ] Confirmar que **Country Blocking continua desativado** em produção
- [ ] `robots.txt` de produção não bloqueia nada relevante
- [ ] Certificado SSL válido no domínio principal
- [ ] Mapa de redirects 301 das URLs antigas com tráfego ou backlink
- [ ] Substituição de URLs no banco (dev → produção) — ver 3.6
- [ ] Backup completo antes da virada
- [ ] GoSMTP configurado com e-mail autenticado
- [ ] Cloudflare Turnstile no lugar do reCAPTCHA
- [ ] CookieAdmin ativo (LGPD)
- [ ] Páginas jurídicas publicadas (Política de Privacidade, Termos)
- [ ] Favicon
- [ ] ACF configurado para specs técnicas das máquinas
- [ ] Página 404 personalizada
- [ ] Página de resultados de busca funcionando
- [ ] Página de obrigado funcionando
- [ ] Template de post do blog publicado
- [ ] Teste de envio do formulário ponta a ponta, com lead chegando no RD
- [ ] E-mail de confirmação do duplo opt-in funcionando
- [ ] Teste em dispositivo real, não só no emulador do navegador

### 4.2 Logo após virar

- [ ] Verificar propriedade no Search Console
- [ ] Enviar sitemap
- [ ] IndexNow ativo
- [ ] "Testar URL ativa" no Search Console em 3 páginas — confirma que o
      Googlebot acessa
- [ ] Rodar PageSpeed Insights em mobile nas páginas principais
- [ ] Confirmar eventos do GTM disparando
- [ ] Testar prévia de link no WhatsApp com uma página de produto
- [ ] Google Business Profile das 4 unidades com NAP igual ao da `/contato`
- [ ] Monitor de 404 do RankMath ativo

### 4.3 Primeira semana

- [ ] Acompanhar cobertura no Search Console (páginas indexadas)
- [ ] Verificar se algum 301 está quebrado
- [ ] Baseline de conversão visitante→lead rodando
- [ ] Alinhar mídia paga para apontar às LPs de Soluções

---

## 5. Correções pendentes no layout

Detalhamento em `docs/relatorio-analise-homepage.md`.

| # | Item | Status |
|---|---|---|
| 1 | Rótulo da linha Lisa/Dentada | ⏸️ teste A/B pós-lançamento (ver 6.4) |
| 2 | Formulário completo conforme seção 9 do dossiê | ⬜ bloqueado pela spec |
| 3 | "Soluções" no menu principal | ⬜ |
| 4 | Telefone no header + WhatsApp | ⬜ |
| 5 | H1 com palavra-chave | ⬜ |
| 6 | Texto do mosaico visível no mobile | ⬜ |
| 7 | Padronizar linguagem dos CTAs | ⬜ |
| 8 | Corrigir rótulo "DOBRADEIRA CNC" | ⬜ |
| 9 | Validar "+50 modelos" e "+300 máquinas/ano" | ⬜ |
| 10 | Eventos de GTM em todos os CTAs | ⬜ |
| 11 | Breadcrumbs (geram schema `BreadcrumbList`) | ⬜ |


## 6. Backlog — páginas e templates

> **Estas três não são opcionais.** A homepage linka para todas. Ou elas
> existem, ou a funcionalidade correspondente não pode subir no lançamento.

### 6.1 Página de obrigado — `/obrigado`

**Prioridade: alta.** É requisito de medição, não só de UX.

A forma mais confiável de contar conversão é o carregamento de uma URL
específica. Sem ela, o rastreamento depende de detectar mudança na tela, que é
frágil e quebra com facilidade. Isso é o "baseline de conversão visitante→lead
instrumentado desde o dia 1" que consta como métrica de sucesso do Livro 1.

**Precisa ter:**
- Confirmação clara do envio
- Prazo de retorno do comercial
- Próximo passo: link para catálogo, para páginas de produto, ou WhatsApp
- Evento de conversão do GTM disparando no carregamento

**Bloqueia:** o formulário não pode subir sem ela.

### 6.2 Página de resultados de busca

**Prioridade: alta antes do lançamento da busca completa.**

A experiência principal escolhida é o Off Canvas. A etapa atual prepara o
diálogo, o campo de pesquisa e a área onde resultados poderão ser apresentados.

Não é requisito desta etapa retornar conteúdo real, definir os campos finais,
conectar links, concluir o Loop Item ou finalizar o template de resultados.

**Para a integração final:**

- consulta real configurada e testada;
- conteúdo e links dos resultados;
- Loop Item final;
- template no Elementor com o design system aplicado;
- estado de "nenhum resultado encontrado" com sugestão de navegação;
- exibição do termo buscado;
- teste de pesquisa real.

**Alternativa se o prazo apertar:** não subir a busca no lançamento. Melhor
ausente que quebrada.

### 6.3 Template de post do blog

**Prioridade: média-alta.**

A homepage tem a seção "Notícias" puxando do blog. O post individual não foi
desenhado — sem template, herda o padrão do Hello Elementor, que é nenhum.

Consequência dupla: o artigo fica sem identidade visual, e a estratégia de
conteúdo do dossiê (blog como motor de autoridade) nasce sem casa.

**Precisa ter:**
- Template de post único no Elementor
- Hierarquia de headings correta (H1 = título do post)
- Breadcrumbs
- Largura de texto corrido limitada a 720px
- CTA ao final apontando ao formulário

**Alternativa se o prazo apertar:** subir a homepage sem a seção de notícias.
Ela depende de haver post publicado de qualquer forma.

### 6.4 Teste A/B — rótulo da linha Lisa/Dentada

**Pós-lançamento.** O rótulo do menu para a linha de viradeiras/dobradeiras de
chapa fica em aberto e será decidido por teste, não por opinião.

**O impasse:**

| Rótulo | Problema |
|---|---|
| "Serralheria" | É o **segmento de cliente**, não o produto. Ninguém busca "serralheria" querendo comprar máquina |
| "Calhas" | **Subdimensiona a máquina.** A dentada com dentes ajustáveis dobra até 2mm em carbono e 1mm em inox — faz caixa, painel elétrico, duto de refrigeração, bandeja, além de calha |
| "Viradeiras" | Termo forte no Sul, é produto e não segmento, evita colisão com as dobradeiras CNC de "Corte e Dobra". Menos volume nacional |
| "Dobradeiras de Chapa" | Mais buscado nacionalmente, mas colide com "Corte e Dobra → Dobradeiras" |

**Formato do teste:** duas versões — uma proposta por marketing, outra por
Wilson junto com o time de vendas. Comparar por cliques no menu, entrada nas
páginas e leads gerados.

**Insumo técnico a preservar** (do vendedor técnico, 27/07/2026): a máquina tem
dentes ajustáveis com diversos tamanhos de trabalho, dobra até 2mm em aço
carbono e 1mm em inox. Isso abre aplicações muito além de calha — refrigeração,
painéis de energia, e uma variedade grande de dobras calculáveis.

**Este insumo vale além do rótulo:**

- **Conteúdo da página de produto** — tabela de capacidade por material e uma
  seção "o que dá para fabricar" com as aplicações
- **SEO de cauda longa** — "dobradeira para painel elétrico", "viradeira para
  duto de refrigeração" são buscas de lead qualificado que hoje não encontram a
  Fachini
- **Valida a camada de Soluções** (seção 7.1 do dossiê) — a mesma máquina serve
  calheiro, eletricista industrial e refrigerista. Três páginas de segmento
  apontando para um produto

---

### 6.5 Outros itens de página

| Item | Prioridade | Observação |
|---|---|---|
| Página 404 personalizada | Média | Barata de fazer, evita beco sem saída |
| Páginas jurídicas | Alta | Requisito legal — o footer já linka "Política de Privacidade" |

---
