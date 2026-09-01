# Manual de Diagnóstico — DevTools + Elementor

## 1. Propósito e fronteira

Este manual transforma perguntas causais sobre Elementor, layout e CSS
executado em evidência focal, reproduzível, segura e compacta. Ele detalha o
procedimento operacional dos princípios definidos em
`docs/ARQUITETURA-IA.md`.

Não registra decisões de design, estado do projeto, incidentes de
infraestrutura nem histórico de componentes. O Figma segue o protocolo
`docs/protocolo-evidencia-figma.md`.

## 2. Princípios

1. Trabalhar com uma hipótese causal por rodada.
2. Uma hipótese pode exigir coleta multivariável relacionada; não significa
   uma propriedade por turno.
3. Diagnóstico é read-only por padrão.
4. Usar o menor protocolo suficiente e buscar a máxima informação útil por
   rodada, sem reduzir a evidência exigida pelo risco.
5. Reutilizar a mesma medição antes e depois da alteração.
6. Separar fato observado, interpretação, alteração e resultado.

## 3. Fluxo recomendado

```text
pergunta causal
→ elemento real
→ seletores estáveis
→ coleta read-only
→ objeto estruturado
→ interpretação
→ alteração focal
→ mesma coleta depois
→ inspeção visual
→ critério de aceite
```

A coleta deve responder à pergunta formulada. Acumular dados sem relação com a
hipótese aumenta contexto sem melhorar o diagnóstico.

## 4. `$0` versus coletor reproduzível

`$0` é adequado quando:

- o elemento já está selecionado no painel Elements;
- a inspeção é pontual e descartável;
- poucas propriedades respondem à pergunta;
- não há comparação importante entre elementos ou estados;
- a coleta não precisa ser repetida ou transferida.

Um coletor estruturado é preferível ou necessário quando:

- haverá comparação antes/depois;
- a hipótese envolve múltiplos elementos ou irmãos;
- a causa depende da relação entre várias grandezas;
- a coleta precisa ser reproduzida;
- a evidência será transferida entre sessões.

Três ou mais grandezas relacionadas são uma heurística forte para coletar em
lote, não uma obrigação mecânica. Duas grandezas podem exigir lote; várias
propriedades independentes podem não exigir.

## 5. Seletores

Preferir classes semânticas e estáveis observadas no DOM. Quando houver
alternativa, evitar:

- IDs automáticos do Elementor;
- cadeias baseadas apenas na posição dos filhos;
- classes efêmeras de estado como única âncora;
- seletores excessivamente longos que escondem qual elemento está sendo
  medido.

Registrar o seletor usado quando a evidência precisar ser repetida. Um seletor
que retorna zero ou múltiplos elementos inesperados invalida a coleta até que
o escopo seja corrigido.

## 6. Geometria em runtime

Antes de atribuir uma distância a `gap`, distinguir:

| Grandeza | O que representa |
|---|---|
| Caixa estrutural | Caixa usada pelo layout para o elemento. |
| Envelope visual | Limite percebido da arte, texto ou conteúdo visível. |
| `margin` | Espaço externo declarado no elemento. |
| `padding` | Espaço interno entre borda e conteúdo. |
| `border` | Espessura que participa da caixa conforme `box-sizing`. |
| `gap` | Espaço do algoritmo Flex/Grid entre itens participantes. |
| `transform` | Deslocamento visual que não reposiciona o fluxo normal. |
| Bounds do pai | Limites que condicionam alinhamento e distribuição. |
| Flex/Grid computado | Algoritmo efetivamente usado e seus valores finais. |

```text
distância visual
≠ gap CSS
≠ margin
≠ padding
≠ espaço interno do container
```

`getBoundingClientRect()` inclui transformações visuais. O valor retornado não
identifica sozinho qual propriedade produziu a posição observada; precisa ser
interpretado junto com o box model, o pai e o layout computado.

## 7. Styles versus Computed

**Styles** responde principalmente:

- quem declarou a propriedade;
- qual seletor venceu;
- se uma declaração foi sobrescrita;
- qual é a precedência, origem ou especificidade.

**Computed** responde:

- qual valor final o navegador usa;
- qual display, posição, transformação, tamanho ou espaçamento foi resolvido;
- qual box model resulta da cascata.

Uma variável, declaração ou configuração visível em Styles não prova que seu
efeito está ativo. Computed não explica sozinho de onde o valor veio. As duas
superfícies respondem perguntas diferentes.

## 8. Elementor-first

```text
necessidade
→ elemento real
→ controle nativo observado na versão instalada
→ consequência no DOM/CSS
→ entrega ao navegador
→ Computed
→ visual
→ CSS somente se necessário
```

Não presumir que um controle existe porque outra versão, documentação antiga ou
memória o menciona. Se o painel resolve a necessidade sem efeito colateral,
ele permanece a primeira escolha. CSS ou JavaScript entram apenas no problema
residual comprovado.

## 9. Cadeia de evidência

| Camada | O que pode provar | O que não prova sozinha |
|---|---|---|
| Painel | Configuração exibida e salva na interface observada. | CSS gerado, entrega ou comportamento final. |
| Gerado | Regra, variável ou configuração produzida. | Que o navegador recebeu essa versão. |
| Entregue | Resposta ou folha efetivamente recebida. | Que a cascata aplicou o valor pretendido. |
| Computed | Valor final resolvido no elemento. | Que o resultado visual atende ao critério. |
| Visual | Aparência e interação observadas. | Causa técnica sem inspeção das camadas anteriores. |

Não saltar causalmente de uma camada para outra. Escolher o método de
verificação que corresponde à camada afirmada.

## 10. Freshness

Freshness é investigada quando painel ou intenção divergem do navegador, ou
quando o resultado permanece igual depois de uma alteração confirmada.

Antes de compensar visualmente o sintoma:

1. identificar a versão ou regra esperada;
2. confirmar se foi gerada, quando essa superfície estiver disponível;
3. confirmar se chegou ao navegador;
4. só então analisar cascata, Computed e visual.

Refresh, regeneração ou limpeza de cache não são rituais universais. São ações
condicionadas por evidência de estado antigo, entrega incorreta ou pelo
procedimento específico da plataforma.

## 11. CSS customizado e legado

Para cada regra existente, perguntar:

> Qual problema comprovado esta regra ainda resolve?

Se não houver resposta atual, a regra torna-se candidata à reconciliação. Isso
não autoriza remoção automática. Antes de remover ou reduzir:

- verificar o elemento e a necessidade atuais;
- identificar se o painel já cobre a função;
- procurar outros consumidores da regra;
- produzir diff focal;
- aplicar autorização e Review compatíveis com o risco;
- verificar regressões depois da alteração.

## 12. Segurança do coletor read-only

Operações adequadas incluem:

- `querySelector()` e `querySelectorAll()`;
- `getBoundingClientRect()`;
- `getComputedStyle()`;
- leitura de atributos e propriedades;
- composição de objetos e arrays para retorno.

Evitar em diagnóstico read-only:

- `click()`;
- `style.setProperty()`;
- `classList.add()`, `remove()` ou `toggle()`;
- `setAttribute()`;
- inserção, remoção ou reorganização do DOM;
- escrita em cookies ou storage;
- submissão de formulários;
- chamadas de rede mutantes.

Se uma hipótese exigir mutação, ela deixa de ser coleta read-only e precisa de
autorização, risco e critério de reversão próprios.

## 13. Acessibilidade

Antes de usar ou alterar `transform`, `order`, `position`, `z-index`, overlay,
sticky ou modal, avaliar quando aplicável:

- ordem de foco e navegação por Tab;
- ordem de leitura no DOM;
- foco inicial, Escape e devolução de foco;
- conteúdo encoberto;
- elemento visível mas logicamente inalcançável;
- diferença entre ordem visual e ordem semântica.

O ajuste geométrico não pode criar regressão funcional.

## 14. Verificação

Quando o critério for visual, combinar:

```text
medida objetiva
+ inspeção visual
+ critério de aceite
```

Uma igualdade matemática não valida sozinha composição, legibilidade ou
alinhamento percebido. Inspeção visual não é obrigatória quando a transformação
for puramente mecânica e nenhum critério visual estiver em jogo.

Na comparação antes/depois:

- executar o mesmo coletor;
- manter viewport e estado relevantes;
- registrar alterações de contexto;
- confrontar somente as grandezas ligadas à hipótese;
- verificar efeitos colaterais proporcionais ao risco.

## 15. Formato mínimo de relatório

```text
QUESTION:
HYPOTHESIS:
OBSERVATIONS:
SUPPORTS:
DOES_NOT_PROVE:
CHANGE:
POST_CHECK:
RESULT:
```

`SUPPORTS` registra o que a evidência sustenta. `DOES_NOT_PROVE` preserva o
limite epistemológico e impede que correlação seja promovida a causalidade.

## 16. Exemplos genéricos

### Retângulo e box model de um elemento

```js
(() => {
  const el = document.querySelector('.classe-estavel');
  if (!el) return { error: 'elemento não encontrado' };

  const rect = el.getBoundingClientRect();
  const style = getComputedStyle(el);

  return {
    rect: {
      x: rect.x,
      y: rect.y,
      width: rect.width,
      height: rect.height
    },
    margin: {
      top: style.marginTop,
      right: style.marginRight,
      bottom: style.marginBottom,
      left: style.marginLeft
    },
    padding: {
      top: style.paddingTop,
      right: style.paddingRight,
      bottom: style.paddingBottom,
      left: style.paddingLeft
    },
    border: {
      top: style.borderTopWidth,
      right: style.borderRightWidth,
      bottom: style.borderBottomWidth,
      left: style.borderLeftWidth
    },
    transform: style.transform
  };
})();
```

### Flex/Grid e relação pai × filhos

```js
(() => {
  const parent = document.querySelector('.container-estavel');
  if (!parent) return { error: 'container não encontrado' };

  const read = (el) => {
    const rect = el.getBoundingClientRect();
    const style = getComputedStyle(el);
    return {
      tag: el.tagName,
      classes: [...el.classList],
      rect: { x: rect.x, y: rect.y, width: rect.width, height: rect.height },
      display: style.display,
      gap: style.gap,
      flexDirection: style.flexDirection,
      flexWrap: style.flexWrap,
      gridTemplateColumns: style.gridTemplateColumns,
      alignItems: style.alignItems,
      justifyContent: style.justifyContent,
      transform: style.transform
    };
  };

  return {
    parent: read(parent),
    children: [...parent.children].map(read)
  };
})();
```

Guardar o coletor usado e repeti-lo sem alterações no pós-check. Se o seletor,
viewport ou estado mudar, registrar essa diferença antes de comparar.
