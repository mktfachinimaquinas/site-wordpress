# Controle do Projeto — Site Fachini Máquinas

**Documento vivo.** Atualizar a cada decisão tomada ou pendência resolvida.
**Última atualização:** 27/07/2026 (fim da sessão 2)

---

## 1. Decisões travadas (registro)

| Data | Decisão | Observação |
|---|---|---|
| 26/07 | **POSICIONAMENTO: perfiladeira é fabricação Fachini** | Decisão da diretoria. Sustentado por capacidade instalada — insumos e estrutura para fabricar cada componente, histórico de refabricação completa. Finame em andamento. Ver seção 14 do dossiê |
| 26/07 | **Árvore de navegação: seguir Figma por ora** | Foco na entrega. Ajustes de estrutura ficam para depois do lançamento |
| 26/07 | **MÓDULO 1 CONCLUÍDO** | Global Colors, Global Fonts, Theme Style completo, Content Width 1280, Layout Full Width, variáveis de espaçamento. Teste de herança validado |
| 26/07 | **Ultimate Addons for Elementor removido** | Redundante com Elementor Pro. Templates de cabeçalho/rodapé apagados, ambiente limpo, cache limpo |
| 27/07 | **Módulo 2 — passos 5 e 6 concluídos** | Fundo condicional, hover do menu, chevron, dropdown com deslizar e barra vermelha. CSS versionado em `css/header.css` |
| 27/07 | **Largura do dropdown fica automática** | O SmartMenus escreve estilo inline no `<ul>`, que vence qualquer CSS. Ajuste via Espaçamento horizontal no painel do widget |
| 27/07 | **Mitr em SemiBold 600** | O Bold da Mitr é visivelmente mais pesado que o de uma grotesca ocidental — origem tailandesa, contraste maior entre pesos. Em caixa alta ficava excessivo. Alinhado com a equipe |
| 27/07 | **Escala tipográfica revista — razão 1.25** | H1 alinhado aos 56px do Figma (a 64px ficava desproporcional em notebook). H3 permanece em 36px. Novos valores: 56 · 45 · 36 · 29 · 23 |
| 26/07 | **Botões sem sombra** | Superfícies planas. Sombra em cards de notícia segue pendente da designer |
| 26/07 | **Header transparente sobre o hero** | Sólido navy nas páginas internas via `body.home`. Sticky pendente — recomendação é sem sticky no lançamento |
| 26/07 | **Menu: "Máquinas" como guarda-chuva** | As categorias do mapa do dono ficam no dropdown. Oito itens soltos apertariam o header em 1280px |
| 26/07 | **JavaScript: foco no ensino** | Conceito explicado, Wilson escreve, revisão. Recalibra com "escreve" se comprometer o prazo |
| 26/07 | **H3 sem transformação de caixa** | Aparece em caixa alta nos diferenciais e caixa baixa nos cards de notícia. Caixa alta aplicada por seção |
| 23/07 | **Paleta de 8 cores** | Navy `#15274E` · Navy Sec. `#00224E` · Vermelho `#E01E26` · Verm. Hover `#B01319` · Onix `#0F0F0F` · Off-white `#FBFBFB` · Cinza Névoa `#F1F3F6` · Cinza Médio `#5C6675` |
| 23/07 | **Mitr 700 para H1/H2**, sempre caixa alta | Mitr não tem peso acima de 700 |
| 23/07 | **Archivo 400/600/700** para o resto | 4 arquivos de fonte no total, hospedados localmente |
| 23/07 | **Toska exclusiva do logo**, em SVG | Não é webfont |
| 23/07 | **Roboto descontinuada** | Página `3 - MARCA` do Figma desatualizada |
| 23/07 | **Sistema de 4 camadas de largura** | Full-bleed 100% · Larga `min(94vw,1560px)` · Padrão 1280px · Texto 720px |
| 23/07 | **Escala tipográfica razão 1.333** | H2 de 48px e line-height do H3 de 1.25 validados pela designer em 25/07 |
| 23/07 | **Hierarquia de headings definida** | Um H1 por página; números de estatística não são heading |
| 23/07 | **Vídeo fora do hero** | Remove o maior risco de CWV mobile |
| 23/07 | **Scrollytelling adiado** | Versão intermediária no lançamento: sticky + fade |
| 23/07 → 27/07 | **Rótulo da linha Lisa/Dentada** | Decisão revista: "Serralheria" é segmento e não produto, mas "Calhas" subdimensiona a máquina. **Adiado para teste A/B pós-lançamento** (ver 6.4) |
| 23/07 | **Country Blocking do Loginizer DESATIVADO** | Ver 1.1 abaixo |

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
| 8 | 🔴 | **Números institucionais** — "+50 modelos" e "+300 máquinas/ano" batem com o dossiê? | Seção de estatísticas |

### 2.2 Com a designer

| # | Status | Pendência |
|---|---|---|
| 1 | 🟡 23/07 | **Anotar a camada de largura de cada seção** (full-bleed / larga / padrão / texto) |
| 2 | 🟢 25/07 | **H2 em 48px validado** pela designer (Figma marcava 58px — só 10% de diferença do H1) |
| 3 | 🟢 25/07 | **Line-height do H3 corrigido para 1.25**, validado pela designer (Figma marcava 75px sobre 36px = 2.08) |
| 4 | 🟡 23/07 | **Conferir quebra do H1** a 1280px em vez de 1558px |
| 5 | 🟡 23/07 | **Breakpoints** — quais valores usou no Figma |
| 6 | 🟡 23/07 | **Frames de 1366px e 390px** (wireframe basta) |
| 7 | ⏸️ | **Rótulo da linha Lisa/Dentada** — adiado para teste A/B pós-lançamento (ver 6.4). "Serralheria" fica no ar por ora |
| 8 | 🔴 | **Texto do mosaico visível no mobile** (hover não existe em toque) |
| 9 | 🔴 | **Corrigir rótulo "DOBRADEIRA CNC"** sobre a máquina SF3015G (que é laser) |
| 10 | 🔴 | **Desenhar página de resultados de busca** — ver 3.1 |
| 11 | 🔴 | **Desenhar página de obrigado** — ver 3.2 |
| 12 | 🔴 | **Desenhar template de post do blog** — ver 3.3 |
| 13 | 🔴 | **Desenhar o menu mobile (hamburguer)** — só existe desktop no Figma |
| 14 | 🔴 | **Definir os estados dos componentes** — hover, foco, erro, carregando (ver análise 360, B.1) |
| 15 | 🔴 | **Raio de borda de botões, cards e campos de formulário** — pendência de extração do Figma (fonte: `design-system/tokens.md`, seção 8) |
| 16 | 🔴 | **Sombra nos cards de notícia** — pendência de extração do Figma (fonte: `design-system/tokens.md`, seção 8) |
| 17 | 🔴 | **Medição dos espaçamentos reais seção a seção no Figma** — pendência de extração (fonte: `design-system/tokens.md`, seção 8) |
| 18 | 🔴 | **Hierarquia de headings** — alinhar a marcação semântica da Parte 3 antes da montagem (fonte: `docs/modulo-01-design-system.md`, "Pendências com a designer") |

### 2.3 Verificações técnicas

**Resolvidas em 26/07/2026:**

| Item | Método de verificação |
|---|---|
| 🟢 Ambiente de dev limpo | Templates UAE e Theme Builder apagados; plugin desativado e excluído; cache limpo. Site retornou ao Hello Elementor puro |
| 🟢 Módulo 1 validado no Elementor | Página de rascunho com H1/H2/H3/parágrafo/botão herdou tipografia, cores e hover sem configuração manual |
| 🟢 H1 duplicado corrigido | Modelo de página trocado para Elementor Largura Total — o título da página deixou de gerar um segundo H1 |

**Pendentes:**

| # | Status | Item |
|---|---|---|
| 1 | 🟢 24/07 | **Country Blocking do Loginizer desativado** — confirmado por print, "Enable" desmarcado |
| 2 | 🟢 24/07 | **Repositório publicado no GitHub** (privado) — confirmado por `git remote -v` |
| 3 | 🔴 | **Escopo do firewall geográfico** — resolvido pela desativação acima, mas confirmar em produção no go-live |
| 4 | 🟡 24/07 | **noindex do subdomínio de dev** — Wilson marcou "desencorajar indexação". Confirmar que está ativo em dev e DESMARCAR no go-live |
| 5 | 🔴 | **Plugins da véspera** — GoSMTP, CookieAdmin, ACF, reCAPTCHA já aparecem instalados. Confirmar configuração de cada um |

---

## 3. Achados novos — o que tinha passado

### 3.1 ⚠ Não existe página de resultados de busca

A busca expansível está especificada em detalhe — expansão ao clique, itens
somem, "X" para fechar. **Mas não existe tela para onde os resultados vão.**

O Elementor não gera essa página; ela vem do tema. Com Hello Elementor (casca
vazia), o resultado sai sem estilo nenhum — fundo branco, Times New Roman,
lista crua. É a primeira coisa que o usuário vê depois de usar uma
funcionalidade que a gente investiu tempo construindo.

**Ação:** desenhar a página de resultados e montar como template no Elementor.

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

**Prioridade: alta se a busca subir no lançamento.**

A busca expansível está especificada em detalhe — expansão ao clique, itens do
menu somem, "X" para fechar. Mas o Elementor não gera a página de resultados;
ela vem do tema. Com Hello Elementor (casca vazia), o resultado sai sem estilo
nenhum: fundo branco, fonte serifada, lista crua.

É a primeira coisa que o usuário vê depois de usar a funcionalidade que mais
deu trabalho construir.

**Precisa ter:**
- Template no Elementor com o design system aplicado
- Estado de "nenhum resultado encontrado" com sugestão de navegação
- Exibição do termo buscado

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
