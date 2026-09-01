# Protocolo de Evidência do Figma

## 1. Propósito e fronteira

Este protocolo define como adquirir, nomear, registrar, corrigir e interpretar
evidência do Figma dentro dos handoffs existentes da frente de Design System.

Ele não cria ledger separado, pasta `evidence/figma/` nem nova família de
artefatos. A separação vigente é:

```text
handoff de Design System
→ evidência factual e proveniência

Design System ou documento canônico correspondente
→ decisão aprovada

conversa/memória
→ método, contexto e continuidade
```

Fato observado, derivação e decisão aprovada não são equivalentes.

## 2. Princípios

1. Medida sem referente e método não orienta implementação com segurança.
2. Coordenada dependente de referencial declara seu espaço de coordenadas.
3. Toda evidência relevante registra o que prova e o que não prova.
4. Uma medição correta não se torna automaticamente decisão de design.
5. O detalhamento é proporcional ao risco e à reutilização futura.
6. Correção importante preserva a cadeia de supersessão; não apaga
   silenciosamente a leitura anterior.

## 3. Objeto e classe do artefato

Antes da medida, identificar o objeto observado. Classes úteis incluem:

| Classe | Definição |
|---|---|
| **Composição original** | Frame, grupo ou componente no contexto em que foi desenhado. |
| **CLEAN_ARTWORK** | Arte limpa e isolada para análise ou exportação. |
| **Artefato exportado** | Arquivo resultante, como SVG, PNG ou WebP. |
| **Implementação renderizada** | Resultado observado no navegador ou superfície final. |

`CLEAN_ARTWORK` é classe do objeto ou artefato, não tipo de bound.

## 4. Tipos de medida

### `STRUCTURAL_BOUNDS`

Caixa estrutural do frame, grupo ou componente. Pode incluir espaço interno,
filhos, máscaras ou áreas sem artwork visível.

### `VISUAL_ARTWORK_BOUNDS`

Limite da arte ou geometria visual relevante. Deve declarar qual conteúdo foi
considerado visível quando efeitos, clipping ou máscaras tornarem a leitura
ambígua.

### `EXPORT_BOUNDS`

Dimensões, canvas ou `viewBox` do artefato exportado. Prova a caixa do arquivo,
não necessariamente a caixa estrutural da composição original nem o tamanho em
que será renderizado no site.

### `SELECTION_ENVELOPE`

Envelope mostrado pela seleção ou ferramenta. Pode refletir a seleção atual,
efeitos, transformações ou múltiplos filhos; não deve ser tratado
automaticamente como artwork visível.

### `DERIVATION`

Valor calculado a partir de outras medidas. Deve registrar entradas, fórmula,
unidade e arredondamento quando relevantes. Derivação não é observação direta.

## 5. Registro nos handoffs

Quando relevante, registrar:

| Campo | Conteúdo |
|---|---|
| Objeto/referente | Elemento cuja propriedade está sendo medida. |
| Chave semântica | Nome estável para localizar o fato, independente do nome visual da layer. |
| Fonte | Arquivo ou documento de origem e sua revisão, quando disponível. |
| Página | Página do Figma. |
| Frame | Frame ou contexto principal. |
| Layer path / node | Caminho e identificador observados. |
| Classe do objeto | Composição original, `CLEAN_ARTWORK`, exportado ou renderizado. |
| Tipo da medida | Um dos tipos definidos neste protocolo. |
| Espaço de coordenadas | Referencial no qual posição ou dimensão foi interpretada. |
| Valor e unidade | Número, par, retângulo ou conjunto de valores, com unidade. |
| Método | Ferramenta, inspeção, exportação ou cálculo usado. |
| PROVA | Afirmação sustentada pela evidência. |
| NÃO PROVA | Limites e inferências não autorizadas. |
| Data/revisão | Momento ou versão relevante da aquisição. |
| Supersessão/correção | Relação com evidência anterior, quando houver. |

Nem toda medição trivial exige todos os campos. Quanto maior o risco, a
reutilização, a densidade geométrica ou a possibilidade de ambiguidade, maior
deve ser a completude.

### Exemplo de bloco proporcional

```text
EVIDÊNCIA FIGMA
CHAVE SEMÂNTICA:
OBJETO:
FONTE: página → frame → layer/node
CLASSE DO OBJETO:
TIPO DA MEDIDA:
ESPAÇO DE COORDENADAS:
VALOR/UNIDADE:
MÉTODO:
PROVA:
NÃO PROVA:
DATA/REVISÃO:
SUPERSEDE:
MOTIVO DA CORREÇÃO:
```

Campos sem utilidade para o caso podem ser omitidos; não preencher por ritual.

## 6. Espaço de coordenadas

Toda coordenada cuja interpretação dependa do referencial deve declarar o
coordinate space. Não misturar silenciosamente:

- coordenadas locais do frame;
- coordenadas da página;
- coordenadas do frame da Home;
- coordenadas da composição;
- coordenadas ou pixels do artefato exportado;
- coordenadas da implementação renderizada.

Se um valor for convertido entre espaços, registrar a transformação como
`DERIVATION`, com entradas e fórmula.

## 7. PROVA e NÃO PROVA

Para evidência relevante, responder:

```text
O que esta medida prova?
O que ela não prova?
```

Exemplos de limites:

- `STRUCTURAL_BOUNDS` não prova o limite do artwork visível;
- `EXPORT_BOUNDS` não prova o tamanho renderizado no site;
- `SELECTION_ENVELOPE` não prova sozinho a área visual relevante;
- medida de composição não prova que o asset limpo possui a mesma caixa;
- medida factual não prova que o valor deve ser adotado na implementação;
- equivalência numérica não prova sozinha equivalência visual.

## 8. Aquisição de assets

Para logo, ícone ou SVG, distinguir:

1. composição original;
2. artwork limpo, quando existir;
3. artefato exportado;
4. implementação renderizada.

Registrar separadamente os bounds relevantes de cada objeto. Quando o arquivo
exportado for SVG, verificar `viewBox`, dimensões e presença de raster ou
Base64 conforme `docs/ARQUITETURA-IA.md`.

## 9. Supersessão e correção

Não sobrescrever silenciosamente evidência anterior importante. Quando uma
leitura for corrigida:

1. registrar a nova evidência;
2. identificar a evidência anterior;
3. declarar que foi superada ou corrigida;
4. explicar o motivo;
5. preservar a cadeia causal quando ela for relevante para evitar repetição do
   erro.

Uma correção de evidência não altera automaticamente a decisão canônica. Se a
decisão aprovada for afetada, sua atualização segue a autoridade e o fluxo do
documento correspondente.

## 10. Títulos dos handoffs

Usar títulos previsíveis e pesquisáveis, contendo apenas o necessário para
identificar frente, objeto, atividade e sequência. Formato recomendado:

```text
Design System — <objeto> — Evidência Figma — <sequência>
```

Variações são aceitáveis quando preservam busca e contexto. Este protocolo não
reorganiza as pastas existentes nem impõe novo sistema físico de nomenclatura.

## 11. Fronteira com o Design System

| Destino | Responsabilidade |
|---|---|
| Handoff da frente de Design System | Evidência factual, proveniência, limites e supersessões. |
| `design-system/` ou documento canônico correspondente | Decisão aprovada e valor adotado. |

Uma medida no Figma não vira token automaticamente. O arquivo
`design-system/tokens.md` não recebe a metodologia deste protocolo.

## 12. Critério futuro para ledger separado

Um ledger próprio só deve ser reavaliado se surgir necessidade concreta, como:

- grande volume de medidas reutilizadas entre componentes;
- dificuldade real de localizar fatos nos handoffs;
- muitas correções ou supersessões;
- necessidade de consulta estruturada ou automatizada;
- handoffs excessivamente grandes apenas para preservar medições.

Até que uma dessas condições seja comprovada e haja decisão específica, os
handoffs continuam como recipiente factual e nenhum ledger separado deve ser
criado por antecipação.
