# Módulo 1 — Design System no Elementor

**Projeto:** Site Fachini Máquinas
**Objetivo:** cadastrar a fundação visual do site nos Estilos Globais do
Elementor, de modo que toda página construída depois herde cor, tipografia e
espaçamento automaticamente.
**Executor:** Wilson (fundação) → designer (montagem das páginas)

---

## Por que este módulo vem primeiro

Estilos Globais são a diferença entre um site e uma pilha de páginas. Cadastrado
corretamente, mudar o azul da marca é uma edição em um lugar. Não cadastrado,
é caçar o hex em 20 páginas e rezar para não esquecer nenhuma.

É também o que torna o treinamento da designer viável: com a fundação pronta,
ela não decide cor nem tamanho de fonte — ela escolhe de uma lista curta. O
trabalho dela vira composição, não design de sistema.

---

## Parte 1 — Paleta

### 1.1 Cores travadas (dossiê)

| Nome | Hex | Uso |
|---|---|---|
| Navy Fachini | `#15274E` | Cor institucional. Fundos de seção escura, títulos, footer |
| Vermelho Fachini | `#E01E26` | **Exclusivo de CTA e destaque.** Nunca em texto corrido |

**Regra de disciplina:** o vermelho é o recurso mais escasso da paleta. Se ele
aparecer em tudo, para de significar "clique aqui". No layout atual ele está
bem usado — botões e a palavra "ORÇAMENTO" no formulário. Mantenha assim.

### 1.2 Cores de apoio (proposta — validar)

O layout precisa de mais que dois tons para funcionar. Estas são derivadas das
duas travadas, não concorrem com elas:

| Nome | Hex | Uso |
|---|---|---|
| Navy Profundo | `#0E1A36` | Hover de seções escuras, footer, sobreposição em imagem |
| Vermelho Hover | `#B01319` | Estado hover dos botões vermelhos |
| Texto Escuro | `#1F2937` | Corpo de texto sobre fundo claro |
| Texto Médio | `#5B6472` | Legendas, texto de apoio, placeholders |
| Cinza Claro | `#F4F6F8` | Fundo de seção alternada, cards |
| Borda | `#DDE2E8` | Divisores, contornos de input |
| Branco | `#FFFFFF` | Fundo padrão, texto sobre navy |
| Texto sobre Navy | `#C9D2E0` | Corpo de texto dentro de seções navy |

**Por que "Texto Escuro" não é preto puro:** `#000000` sobre branco produz
contraste alto demais e cansa a leitura em telas. `#1F2937` tem uma leve
inclinação para o azul, o que amarra o corpo de texto com o navy da marca sem
que ninguém perceba conscientemente.

---

## Parte 2 — Tipografia

### 2.1 A fonte

**Archivo**, do Google Fonts. Licença SIL Open Font License — uso comercial
livre, sem custo, web e impresso.

**Pesos a carregar: apenas 3.**

| Peso | Nome | Uso |
|---|---|---|
| 400 | Regular | Corpo de texto |
| 700 | Bold | Subtítulos, botões, destaques |
| 900 | Black | Headlines |

Cada peso é um arquivo baixado pelo visitante. Archivo tem 9 pesos disponíveis
— carregar todos seria desperdiçar orçamento de performance num site cuja
métrica de sucesso é Core Web Vitals verde no mobile.

**A confirmar com a designer:** o Figma usa o eixo de largura (versão variável)
ou os cortes estáticos? Se ela usou uma versão mais larga nas headlines, o
cadastro muda — precisa ser a fonte variável, não os pesos fixos.

### 2.2 Escala tipográfica (proposta — validar contra o Figma)

**Desktop (acima de 1024px)**

| Nível | Tamanho | Peso | Line-height | Observação |
|---|---|---|---|---|
| H1 | 56px | 900 | 1.1 | Caixa alta, letter-spacing 0.01em |
| H2 | 40px | 900 | 1.15 | Caixa alta |
| H3 | 28px | 700 | 1.25 | |
| H4 | 22px | 700 | 1.3 | |
| Corpo | 17px | 400 | 1.6 | |
| Corpo pequeno | 15px | 400 | 1.6 | Legendas, footer |
| Botão | 15px | 700 | 1 | Caixa alta, letter-spacing 0.05em |

**Mobile (até 767px)**

| Nível | Tamanho | Peso | Line-height |
|---|---|---|---|
| H1 | 34px | 900 | 1.15 |
| H2 | 28px | 900 | 1.2 |
| H3 | 22px | 700 | 1.3 |
| H4 | 19px | 700 | 1.35 |
| Corpo | 16px | 400 | 1.65 |
| Corpo pequeno | 14px | 400 | 1.6 |
| Botão | 15px | 700 | 1 |

**Regra que não se quebra:** corpo de texto no mobile nunca abaixo de 16px.
Além da legibilidade, o Safari do iOS dá zoom automático em campos de
formulário com fonte menor que 16px — o que faria a página saltar quando o
usuário tocasse no formulário de orçamento. Problema clássico e invisível em
teste de desktop.

**Sobre o line-height:** quanto maior o texto, menor o valor. Headline com 1.6
fica com buracos entre as linhas; corpo com 1.1 fica sufocado. Por isso a
escala desce de 1.65 no corpo até 1.1 no H1.

---

## Parte 3 — Espaçamento

Escala base de 8px. Todo espaçamento do site sai desta lista:

```
8 · 16 · 24 · 32 · 48 · 64 · 96 · 128
```

**Por que uma escala fechada:** sem ela, cada seção ganha um valor
improvisado — 30px aqui, 35px ali, 42px acolá. Ninguém nota individualmente,
mas o site inteiro fica com uma frouxidão que não se consegue nomear. Escala
fechada resolve isso sem esforço: só existem 8 opções.

**Padrões de aplicação:**

| Contexto | Desktop | Mobile |
|---|---|---|
| Padding vertical de seção | 96px | 56px |
| Padding horizontal do container | 24px | 20px |
| Espaço entre título e texto | 24px | 16px |
| Espaço entre texto e botão | 32px | 24px |
| Gap entre cards | 32px | 24px |

**Largura máxima do container:** 1200px.

---

## Parte 4 — Execução no Elementor

### Passo 1 — Hospedar a fonte localmente

Antes de cadastrar tipografia, a fonte precisa estar servida do seu próprio
servidor, não do CDN do Google. Dois motivos: performance (elimina uma conexão
externa no carregamento inicial, ganho direto de LCP) e LGPD (carregar do
Google transfere o IP do visitante a um terceiro, o que complica o consentimento
no CookieAdmin).

O WP Rocket PRO tem a opção de hospedagem local de Google Fonts. Ative antes de
seguir.

### Passo 2 — Cadastrar as cores globais

**Caminho:** Elementor → hambúrguer no canto superior esquerdo do editor →
**Site Settings** → **Global Colors**

O Elementor traz 4 slots nomeados. Use assim:

| Slot | Cor | Hex |
|---|---|---|
| Primary | Navy Fachini | `#15274E` |
| Secondary | Texto Médio | `#5B6472` |
| Text | Texto Escuro | `#1F2937` |
| Accent | Vermelho Fachini | `#E01E26` |

Depois adicione as demais como **cores personalizadas**, com nome descritivo —
"Navy Profundo", "Cinza Claro", "Borda". Nome importa: a designer vai escolher
por nome numa lista, não por hex.

> **Não pule a nomenclatura.** Cor sem nome vira "aquele azul" e alguém acaba
> digitando o hex na mão em algum lugar. Cada hex digitado à mão é um ponto
> onde o sistema vaza.

### Passo 3 — Cadastrar as fontes globais

**Caminho:** Site Settings → **Global Fonts**

| Slot | Configuração |
|---|---|
| Primary | Archivo, 900 — headlines |
| Secondary | Archivo, 700 — subtítulos |
| Text | Archivo, 400 — corpo |
| Accent | Archivo, 700 — botões e links |

### Passo 4 — Aplicar aos elementos (o passo que quase todo mundo pula)

Global Fonts cria os slots reutilizáveis, mas **não define automaticamente
como um H1 aparece na página**. Isso é outro lugar:

**Caminho:** Site Settings → **Theme Style** → **Typography**

Ali você configura Body e H1 até H6 com os valores da tabela da Parte 2.
Faça o mesmo em **Theme Style → Buttons** para o botão padrão (fundo Accent,
texto branco, hover Vermelho Hover).

Sem este passo, cada texto colocado na página nasce com o padrão do Elementor
e alguém acaba ajustando manualmente — que é exatamente o descontrole que este
módulo existe para impedir.

### Passo 5 — Configurar os breakpoints

**Caminho:** Site Settings → **Layout** → Breakpoints

Confirme que os breakpoints ativos são os que a designer usou no Figma.
Padrão do Elementor: Mobile até 767px, Tablet até 1024px. Se o Figma usou
outros valores, alinhe agora — depois significa revisar página por página.

Aproveite e defina **Content Width: 1200px** na mesma tela.

### Passo 6 — Cadastrar a escala de espaçamento em Custom CSS

O Elementor não tem campo nativo para escala de espaçamento. A forma limpa é
declarar variáveis CSS uma vez, em Site Settings → **Custom CSS**:

```css
:root {
  --esp-1: 8px;
  --esp-2: 16px;
  --esp-3: 24px;
  --esp-4: 32px;
  --esp-5: 48px;
  --esp-6: 64px;
  --esp-7: 96px;
  --esp-8: 128px;
}
```

**O que isso faz:** `:root` é o elemento raiz do documento — o `<html>`.
Declarar variáveis ali as torna disponíveis em qualquer lugar da página.
Cada linha cria uma variável CSS (o prefixo `--` é o que a identifica como
variável). Depois, em qualquer CSS customizado, você usa `var(--esp-5)` em vez
de digitar `48px`.

Ganho prático: se um dia a escala mudar, muda aqui e propaga para tudo. É a
mesma lógica das cores globais, aplicada a espaçamento.

Você ainda vai preencher os campos de padding do Elementor com os números
diretamente — as variáveis servem para o CSS customizado que vem nos próximos
módulos, como o header.

---

## Parte 5 — Verificação

Antes de considerar o módulo fechado:

- [ ] Fonte Archivo servida localmente (checar em DevTools → Network se não há
      requisição para `fonts.googleapis.com`)
- [ ] Apenas 3 pesos carregando
- [ ] As 4 cores globais cadastradas nos slots corretos
- [ ] Cores de apoio cadastradas **com nome**
- [ ] Theme Style → Typography preenchido para Body e H1–H6, desktop e mobile
- [ ] Theme Style → Buttons configurado com hover
- [ ] Breakpoints alinhados com o Figma
- [ ] Content Width em 1200px
- [ ] Variáveis de espaçamento no Custom CSS
- [ ] Teste: criar uma página de rascunho, jogar um H1, um H2 e um parágrafo
      sem tocar em nenhuma configuração de estilo. Se saírem certos, a fundação
      está de pé. Depois apague a página.

---

## O que este módulo destrava

Com a fundação cadastrada:

- A designer pode ser treinada em composição, não em design de sistema
- O header (Módulo 2) tem sobre o que ser construído
- Todo CSS customizado dos módulos seguintes pode referenciar variáveis em vez
  de valores fixos
- Mudanças de marca viram edição em um lugar

## Pendências para fechar

1. **Escala tipográfica validada** — a designer confere a tabela da Parte 2
   contra o Figma e ajusta o que estiver fora
2. **Eixo de largura** — Archivo variável ou cortes estáticos?
3. **Breakpoints do Figma** — quais valores ela usou?
