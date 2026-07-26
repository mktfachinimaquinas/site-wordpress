# Relatório de Análise — Homepage Fachini Máquinas

**Data:** 23/07/2026
**Base:** layout da homepage no Figma (PNG + PDF) e especificação de
interatividade seção a seção
**Referência de governança:** `docs/DOSSIE_FACHINI_projeto_site.md`

---

## Sumário executivo

O layout está bom. A linguagem visual é coerente com o posicionamento: navy
dominante, vermelho reservado aos CTAs, fotografia de máquina real em ambiente
industrial. A designer entregou um trabalho sólido.

Os problemas apontados aqui **não são de estética** — são de conformidade com
o dossiê, de conversão, de SEO e de custo de implementação. Nenhum exige
redesenhar a página. A maioria são ajustes pontuais que, feitos agora, evitam
retrabalho.

Existem **4 bloqueadores** (conflito direto com decisões travadas), **5 riscos
de conversão e SEO** e **4 itens que exigem código customizado**, dos quais 1
deve sair do escopo das duas semanas.

---

## 1. Bloqueadores de governança

> Conflitos diretos com o dossiê. Pela regra do projeto, o dossiê vence —
> estes itens não são negociáveis, apenas executáveis.

### 1.1 "Serralheria" usada como categoria de produto

**Onde:** dropdown do menu "Máquinas" e primeira aba do mosaico de categorias.

**O problema:** o dossiê é explícito — serralheria vale como **segmento**,
nunca como **categoria de produto**. O diagnóstico do site atual aponta
justamente este erro: a linha Lisa/Dentada, que representa 60% do volume e é
a linha de fabricação própria mais antiga da empresa, está hoje enterrada sob
o rótulo "Serralheria".

Ninguém busca "serralheria" no Google querendo comprar dobradeira de calha.
Busca-se pelo nome da máquina. Manter o rótulo replica no site novo o erro que
o projeto existe para corrigir.

**A correção:** usar a nomenclatura oficial da linha (seção de nomenclaturas
do dossiê) tanto no menu quanto no mosaico. "Serralheria" migra para a camada
de **Soluções por segmento**, que é onde funciona e para onde a mídia paga vai
apontar.

**Impacto se não corrigir:** a linha de maior volume da empresa continua
invisível na busca orgânica.

---

### 1.2 Formulário não atende a especificação da seção 9

**Onde:** seção final de contato.

**O que o layout tem:** Nome completo, E-mail, Telefone, Setor de atuação,
Categoria de interesse, Observações.

**O que a spec exige e falta:**

| Campo | Status |
|---|---|
| Empresa | **ausente** |
| O que pretende fabricar | **ausente** |
| Verba (opcional) | **ausente** |
| Prazo (opcional) | **ausente** |
| Duplo opt-in LGPD | **ausente** |

**Por que é o item mais importante deste relatório:** o formulário é a resposta
ao risco nº 5 do dossiê — os cerca de 2.000 leads/mês que chegam por mídia paga
e não se qualificam. Sem "o que pretende fabricar" e sem verba/prazo, o SDR
continua ligando às cegas, e a métrica de **custo por lead qualificado** — que
é o critério de sucesso do Livro 1 — simplesmente não existe.

O site pode estar bonito e rápido: se o formulário não qualifica, o projeto
não entregou o que prometeu.

---

### 1.3 Ausência de "Soluções" na navegação

**Onde:** menu principal (HOME · MÁQUINAS · QUEM SOMOS · BLOG · CONTATO).

**O problema:** a árvore validada (seção 7.1) tem três camadas, e a de
**Soluções por segmento** é a que recebe o tráfego de mídia paga. Sem entrada
no menu, essas páginas nascem órfãs: sem link interno, sem autoridade
distribuída, sem descoberta orgânica.

**A correção:** incluir "Soluções" no menu principal, com dropdown por segmento.

---

### 1.4 Nenhum canal de contato direto visível

**Onde:** header e página inteira.

**O problema:** não há telefone no header nem WhatsApp em lugar algum. O
diagnóstico do site atual já apontava telefones vazios como falha grave — e o
perfil de compra da linha Lisa/Dentada (ticket de R$25–50 mil, decisão rápida
do dono) fecha por WhatsApp e telefone, não por formulário.

**A correção:** telefone clicável no header e WhatsApp como CTA secundário
persistente. Ambos com evento de conversão rastreado — clique em `tel:` e em
WhatsApp precisam contar no baseline, senão o lead que liga não aparece em
lugar nenhum.

---

## 2. Riscos de conversão e SEO

### 2.1 H1 sem palavra-chave

**Atual:** "Encontre a máquina ideal para sua produção".

**O problema:** zero termos de busca. Não tem perfiladeira, dobradeira,
guilhotina, laser. O H1 da home é o elemento de SEO on-page de maior peso do
site, e o objetivo declarado do Livro 1 é primeira página do Google. Do jeito
que está, a home não compete por nada.

**A correção:** a estrutura da frase comporta o termo sem prejuízo visual.
Ajuste a ser definido no mapa de SEO (Módulo 2), mas a designer deve saber
agora que o texto do hero vai mudar — para não travar o layout em uma contagem
de caracteres.

---

### 2.2 Hover como único portador do CTA no mosaico

**Onde:** seção de mosaico por categoria (Serralheria, Perfiladeiras, Corte e
Dobra, Laser).

**O problema:** título, descrição e seta de call-to-action aparecem apenas no
hover. **Toque não tem hover.** Em dispositivos móveis, o usuário vê um mosaico
de fotos sem título, sem contexto e sem chamada.

Com aproximadamente 90% do tráfego em mobile, isso significa que a maioria do
público vê a versão muda da seção.

**A correção:** no mobile, o texto aparece sempre — sobre um gradiente escuro
na base de cada imagem. No desktop, mantém-se escondido até o hover. É decisão
de design e precisa estar prevista no Figma.

---

### 2.3 CTA que não descreve a ação

**Onde:** banner "Aumente a produtividade da sua empresa" → botão "Seja
Cliente Fachini".

**O problema:** o botão é aspiracional, mas o clique leva a um formulário de
orçamento. O usuário não sabe se vai virar cadastro, contato comercial ou área
de cliente. Botão que descreve a ação converte melhor que botão que descreve o
desejo.

**A correção:** alinhar a linguagem dos CTAs do site inteiro. O hero já usa
"Solicite um orçamento", que é claro — vale padronizar por aí.

---

### 2.4 Rótulo de produto trocado

**Onde:** exemplo de hover do mosaico.

**O problema:** o texto diz "DOBRADEIRA CNC" sobre a máquina SF3015G, que é
modelo de **laser**. Se for apenas placeholder de demonstração do efeito, sem
problema. Se foi engano, precisa correção.

**Por que importa:** errar nome de produto num site cuja função é casar busca
com máquina é erro comercial, não estético.

---

### 2.5 Números institucionais a validar

**Onde:** faixa de estatísticas (+50 modelos, +30 anos, +300 máquinas/ano).

"+30 anos" fecha com a fundação em 1996. Os outros dois precisam ser
conferidos contra o dossiê antes de virarem afirmação pública — o dossiê
registra 6.000 máquinas no total, número que não se reconcilia
automaticamente com "+300 por ano".

---

## 3. Instrumentação

### 3.1 Eventos distintos por CTA

Múltiplos CTAs da homepage levam ao mesmo formulário (hero, banner
intermediário, e futuramente WhatsApp e telefone). **Sem evento separado no
GTM, é impossível saber qual seção converte.**

Isso é exatamente o "baseline de conversão visitante→lead instrumentado desde
o dia 1" que consta como métrica de sucesso do Livro 1. É barato se entrar
durante a montagem; é caro e impreciso se for retrofit depois do go-live.

**Eventos mínimos da homepage:**

- `cta_hero_orcamento`
- `cta_banner_orcamento`
- `cta_whatsapp` (por posição)
- `cta_telefone`
- `form_submit` (com os campos de qualificação como parâmetros)

---

## 4. Fila de código customizado

> O que **não** se resolve arrastando widget no Elementor. Cada item aqui
> precisa de alguém escrevendo CSS ou JavaScript à mão.

| # | Funcionalidade | Custo | Entrega em 2 semanas? |
|---|---|---|---|
| 1 | Busca expansível no menu (lupa e campo clicáveis, itens somem, "X" fecha) | CSS + JS leve | Sim, com esforço |
| 2 | Dropdown por clique com chevron e deslocamento lateral no hover | CSS, JS mínimo | Sim |
| 3 | Texto do mosaico visível no mobile / hover no desktop | CSS | Sim |
| 4 | Scrollytelling com handoff sequencial de textos | JS (`IntersectionObserver`) + CSS `position: sticky` | **Não — ver 4.1** |

### 4.1 Sobre a seção de scrollytelling

É a seção mais cara do projeto e merece decisão explícita.

**O que é:** a técnica se chama **scrollytelling**. Combina duas coisas — uma
*pinned section* (`position: sticky`, que trava o fundo enquanto o conteúdo
passa) e uma *scroll-linked text sequence* (os blocos de texto trocam de estado
conforme a rolagem: o ativo fica sólido, os vizinhos ficam fantasma).

**O que o Elementor faz sozinho:** os Motion Effects entregam sticky e efeitos
de scroll (transparência, blur, escala). Dá para chegar perto do fundo travado
sem escrever nada.

**O que exige código:** o handoff sequencial dos textos. Precisa de JavaScript
usando `IntersectionObserver` para detectar qual bloco está no centro da tela
e alternar as classes.

**Riscos adicionais:**

- Sticky combinado com listeners de scroll é o padrão que mais pesa em mobile
  — conflito direto com a métrica de Core Web Vitals verdes
- Exige versão estática de fallback para quem tem sensibilidade a movimento
  (`prefers-reduced-motion`)

**Recomendação:** entregar agora a **versão intermediária** — fundo com sticky
pelo Elementor (sem código) e textos com fade simples ao entrar na tela.
Entrega cerca de 80% da sensação por cerca de 10% do custo. O handoff
sequencial completo volta depois do go-live, como exercício de JavaScript real.

---

## 5. Performance

### 5.1 Vídeo no hero

O hero em slider pode conter vídeo (loop, sem som, sem pause). **É o maior
risco isolado de Core Web Vitals do projeto**: é o primeiro elemento a
carregar, no bloco mais pesado da página, num site com ~90% de tráfego mobile
e cuja métrica de sucesso é CWV verde no mobile.

**Mitigações — todas precisam ser decididas antes de gravar/exportar, não
depois:**

- Poster image leve exibida enquanto o vídeo carrega
- Autoplay apenas no desktop; mobile recebe imagem estática
- Compressão agressiva e duração curta
- Vídeo hospedado localmente, nunca por iframe de terceiros
- Dimensões fixas reservadas para evitar deslocamento de layout

**Decisão a tomar:** o hero da entrega de duas semanas leva vídeo ou começa só
com imagens? Imagem entrega no prazo com folga. Vídeo aperta.

---

## 6. Consistência de construção

Todas as seções da homepage — inclusive as consideradas simples — devem ser
montadas **no Elementor**, não no editor de blocos nativo do WordPress.

**Motivo:** o tema Hello Elementor é uma casca deliberadamente sem estilo.
Misturar editor de blocos e Elementor na mesma página cria dois sistemas de
design paralelos, com definições duplicadas de cor, tipografia e
responsividade, mantidas manualmente em sincronia. É o risco de "Elementor
indisciplinado" apontado na seção 11 do dossiê, agravado por haver dois
editores.

O custo de manter a disciplina é menor do que qualquer economia obtida ao
misturar.

---

## 7. Triagem sugerida para as 2 semanas

### Entra

- Correção dos 4 bloqueadores de governança (itens 1.1 a 1.4)
- Ajuste do H1 com palavra-chave
- Texto do mosaico visível no mobile
- Padronização da linguagem dos CTAs
- Eventos de GTM em todos os CTAs
- Menu completo: busca expansível, dropdown por clique
- Hero em slider **com imagens** (vídeo fica para depois)
- Scrollytelling em **versão intermediária** (sticky + fade)

### Fica para depois do go-live

- Scrollytelling com handoff sequencial completo
- Vídeo no hero, se for mantido
- Script de extração de tokens do Figma (exercício de Node)

---

## 8. Perguntas em aberto

1. A designer já tem acesso ao painel do WordPress e já começou a montar no
   Elementor? Se ainda não abriu o builder, esse é o gargalo real das duas
   semanas — não código.
2. Na busca expansível, os itens de navegação somem com transição suave ou
   seca? Precisa estar definido no Figma.
3. Os números "+50 modelos" e "+300 máquinas/ano" estão confirmados?
4. As cinco perguntas críticas do início do projeto seguem sem resposta —
   com destaque para **tipografia oficial** (bloqueia o cadastro dos Estilos
   Globais) e **escopo do firewall geográfico do Loginizer** (se bloquear o
   site inteiro e não apenas o admin, derruba o rastreamento do Googlebot e
   com ele o objetivo central do Livro 1).
