# Arquitetura de Uso de IA — Site Fachini

## 1. Propósito, escopo e autoridade

Este documento registra a arquitetura operacional aprovada para o uso de IA no projeto Fachini Máquinas. É um manual de consulta: orienta o roteamento do trabalho e os limites de autoridade, sem substituir a decisão do usuário nem o estado canônico do projeto.

O usuário é a autoridade final sobre item da fila, prioridade, decisões de projeto, alteração de documentos canônicos, aplicação no Elementor, publicação, promoção de estado, aprovação de diff, commit, push e aceitação de risco. Nenhuma IA promove sozinha uma recomendação a decisão permanente.

A Central de Arquitetura interpreta a arquitetura aprovada, roteia tarefas segundo regras existentes, identifica conflitos e lacunas, propõe mudanças arquiteturais e consolida decisões aprovadas. Mudanças da própria arquitetura seguem: **Central propõe → usuário decide → Work documental redige → Review independente revisa → usuário aprova o diff.**

## 2. Princípios operacionais

1. Conversas processam o projeto; arquivos o preservam.
2. Conversas não são memória canônica.
3. Escrito, aplicado e verificado são estados diferentes; toda verificação exige método.
4. Arquivo local não prova aplicação no Elementor, e aplicação no Elementor não prova funcionamento publicado.
5. Elementor-first parte da necessidade e do elemento real, observa o controle nativo na versão instalada, confirma sua consequência e só então usa CSS ou JavaScript para o que permanecer sem solução adequada.
6. Diagnóstico trabalha com uma hipótese causal por rodada. A hipótese pode exigir coleta multivariável relacionada; se falhar, exige nova evidência antes de outra hipótese.
7. Não pedir o Ctrl+U inteiro. Evitar DOM, HTML ou SVG com Base64 pesado quando desnecessário.
8. Mudança de fase, superfície, autoridade ou escopo pode exigir nova sessão.
9. Handoff transmite resultado operacional, não reproduz conversa.
10. Nenhuma automação pode apagar sessões, rollouts ou arquivos automaticamente.
11. Contratos são descritos por capacidades, não por personagens.
12. Português do Brasil é o idioma operacional padrão. Termos técnicos podem permanecer no original quando isso aumenta a precisão.
13. A governança deve usar o menor protocolo suficiente para controlar o risco da tarefa e buscar a máxima informação útil por rodada, reduzindo erro e retrabalho sem diminuir a evidência exigida pelo risco.
14. Painel, configuração gerada, estado entregue ao navegador, Computed e resultado visual são camadas diferentes; cada uma prova apenas seu próprio estado.
15. Quando painel ou intenção divergirem do navegador, a entrega do estado novo deve ser comprovada antes de compensar visualmente o sintoma. Freshness é uma pré-condição condicional, não um ritual universal.

## 3. Contratos das superfícies

| Superfície | Pode | Não pode |
|---|---|---|
| **Chat comum** | Analisar prints do Elementor, evidência visual, DevTools, DOM sanitizado e perguntas focais; conduzir um passo por vez; formular hipótese; pedir a próxima evidência exata; auxiliar verificação manual. | Inferir estado do repositório; afirmar controles do painel que não foram vistos; editar arquivos; promover estado. |
| **Work de Arquitetura** | Avaliar trade-offs, propor regras, interpretar arquitetura aprovada e definir roteamento segundo regras existentes. | Virar executor diário; editar código; promover estado; publicar; criar regra permanente sem aprovação. |
| **Work de Documentos** | Transformar decisões aprovadas no documento explicitamente autorizado e produzir redação estruturada. | Reabrir arquitetura por conta própria; alterar arquivos laterais; promover estado automaticamente. |
| **Codex IDE** | Ler arquivos autorizados, diagnosticar, propor patch, editar arquivos autorizados, testar e produzir diff. | Tratar arquivo local como site publicado; expandir escopo; aplicar Elementor; publicar; commit ou push sem autorização. |
| **Codex Review** | Revisar diff e escopo, buscar regressões, verificar evidência e retornar findings ou ausência deles. | Modificar o working tree. |
| **Codex CLI** | Atuar em contingência, terminal e automação quando apropriado. | Registrar caminho versionado de runtime. A pendência não bloqueante da instalação standalone no PATH é tratada separadamente. |
| **Meta-governança** | Calibrar modelo e raciocínio, revisar prompts, analisar plataforma e saúde de sessões e propor melhorias de protocolo. | Substituir a Central, manter memória canônica ou alterar estado do projeto. |

### Diagnóstico técnico no Elementor

O encadeamento geral é: **necessidade → elemento real → controle nativo observado → consequência no DOM/CSS → verificação → código somente se necessário**. A existência de um controle não deve ser presumida por memória; ela é confirmada na versão instalada e confrontada com o comportamento real.

Painel configurado não prova configuração gerada; configuração gerada não prova entrega ao navegador; entrega não prova valor final em Computed; Computed não prova sozinho o resultado visual. Quando houver divergência entre essas camadas, freshness é verificada antes de introduzir compensação de layout ou estilo.

CSS customizado não recebe autoridade por antiguidade. Cada regra deve justificar qual problema atual ainda resolve. Se a justificativa desaparecer, a regra torna-se candidata à reconciliação, nunca à remoção automática; remoção continua sujeita a evidência, diff, autorização e Review compatíveis com o risco.

O procedimento operacional, incluindo coleta read-only, Styles versus Computed e comparação antes/depois, está em `docs/manual-diagnostico-devtools-elementor.md`.

## 4. Preflight

Antes da execução, registrar quando aplicável:

```text
ITEM:
TIPO DE SESSÃO:
ESCOPO:
SUPERFÍCIE:
MODELO:
RACIOCÍNIO:
MODO:
FAST:
COMPLEXIDADE:
RISCO:
ARQUIVOS QUE PODE LER:
ARQUIVOS QUE PODE ALTERAR:
AÇÕES PROIBIDAS:
CRITÉRIO DE SUCESSO:
CRITÉRIO DE PARADA:
GATILHO DE HANDOFF:
```

A tarefa focal e inequívoca pode usar preflight compacto:

```text
OBJETIVO:
PODE ALTERAR:
NÃO PODE ALTERAR:
CRITÉRIO DE PARADA:
```

O preflight completo é usado quando for necessário explicitar superfície, modelo, raciocínio, modo, permissões, risco, review, handoff ou critério de parada. Correção trivial dentro da mesma unidade de trabalho, mesma autoridade, mesma superfície e mesmo risco não exige nova sessão por formalidade. Nova sessão deve ser recomendada quando houver mudança material de objetivo, autoridade, superfície, risco, conjunto de evidências ou contrato de execução, ou quando a saúde exigir rotação.

A classificação C/R só precisa ser explicitada quando afeta o contrato; não deve ser repetida mecanicamente a cada turno.

## 5. Complexidade C0–C4

| Classe | Definição |
|---|---|
| **C0 — Mecânico** | Transformação determinística e pequena. |
| **C1 — Focal** | Problema local, poucos arquivos, critério claro. |
| **C2 — Diagnóstico** | Causa incerta e necessidade de evidência. |
| **C3 — Arquitetural** | Trade-offs e consequências em múltiplos módulos. |
| **C4 — Excepcional** | Recuperação, auditoria profunda ou decisão cara de reverter. |

Complexidade intelectual não é risco operacional.

## 6. Risco R0–R4

| Classe | Definição |
|---|---|
| **R0** | Somente leitura. |
| **R1** | Escrita reversível em um arquivo. |
| **R2** | Vários arquivos ou configuração local. |
| **R3** | Aplicação ou publicação em Elementor/site. |
| **R4** | Promoção de estado canônico, commit ou push. |

Exemplos: C2/R0 é diagnóstico difícil sem escrita; C0/R3 é alteração mecanicamente simples que será publicada.

## 7. Modelos e intensidade de raciocínio

| Modelo | Uso inicial |
|---|---|
| **Luna** | Tarefas mecânicas e determinísticas. |
| **Terra Medium** | Código cotidiano, diff curto e transformação focal. |
| **Sol Medium** | Interação e diagnóstico moderado que exigem julgamento. |
| **Sol High** | Diagnóstico difícil, arquitetura, trade-offs e review sensível. |
| **Sol Extra High** | C4 delimitado e excepcional. |
| **Max/Ultra** | Não usar como padrão; exige justificativa explícita. |

Reduzir raciocínio quando a decisão já estiver tomada e restar transformação determinística. Escalar quando houver conflito de fontes, incerteza relevante, trade-offs, alto custo de reversão ou diagnóstico difícil.

## 8. Normal, Plan, Goal e /fast

| Modo | Uso |
|---|---|
| **Normal** | Trabalho focal, dúvida, leitura, diagnóstico focal, patch pequeno e review; pode ocorrer em qualquer classe C quando o escopo já estiver delimitado e não houver necessidade de planejamento prévio. |
| **Plan** | Investigação antes da ação, planejamento, ambiguidade relevante, múltiplas etapas, preparação de implementação e proposta antes da implementação. Plan não autoriza implementação. |
| **Goal** | Somente quando objetivo, estado inicial, worktree, arquivos e permissões estiverem conhecidos; sucesso e parada forem verificáveis; não houver decisão de negócio pendente, publicação automática ou etapa humana intermediária obrigatória; e a sessão e o rollout estiverem saudáveis. |
| **/fast** | Somente em iteração focal C0/C1. Nunca compensa escopo ruim, contexto grande, sessão degradada ou modelo inadequado. |

Complexidade C0–C4 mede complexidade intelectual; Normal, Plan e Goal definem o formato de execução. Não encaminhar todo C2–C4 automaticamente para Plan.

Goal é proibido em escopo aberto, publicação não autorizada, ação destrutiva, dependência imediata do Elementor, decisão humana pendente ou sessão degradada.

## 9. Ciclo de vida da sessão

**Preflight → Health Baseline → Execução delimitada → Critério de parada → Scope Exit → Handoff → Health Close → Próxima sessão.**

O preflight fixa o contrato. O health baseline mede a saúde inicial. A execução fica limitada ao escopo aprovado; ao atingir o critério de parada, a IA avalia e recomenda o scope exit. O usuário confirma o encerramento. O handoff transfere apenas o resultado necessário. O health close registra a condição final para orientar a próxima sessão.

## 10. Critério de parada e Scope Exit

```text
STATUS DO ESCOPO:

CRITÉRIO DE PARADA APARENTEMENTE ATINGIDO:
sim | não

RECOMENDAÇÃO DE SCOPE EXIT:
sim | não

CONTINUAR NESTA CONVERSA:
permitido | não recomendado | fora do contrato atual

MOTIVO:

PRÓXIMA SESSÃO RECOMENDADA:
SUPERFÍCIE:
MODELO:
RACIOCÍNIO:
MODO:
FAST:
COMPLEXIDADE/RISCO:
ARQUIVOS AUTORIZADOS:
INPUT MÍNIMO:

CONFIRMAÇÃO DE ENCERRAMENTO:
depende do usuário
```

Quando aplicável, avisar: “Continuar este trabalho nesta conversa sai do escopo definido pela matriz de arquitetura.” A IA pode avaliar se o critério de parada parece atingido, recomendar Scope Exit, informar se continuar é permitido, não recomendado ou fora do contrato atual e recomendar a próxima sessão. Ela não decide sozinha o encerramento definitivo: somente o usuário o confirma na árvore de trabalho.

## 11. Handoffs semântico e preventivo

Handoff semântico ocorre por mudança material de fase, superfície, autoridade, objetivo ou contrato, independentemente do tamanho do rollout. Handoff preventivo ocorre quando a saúde exige rotação mesmo mantendo o escopo. Não criar handoff apenas para cumprir ritual.

O template de handoff é um superset: cada handoff usa somente os campos aplicáveis. Não existe tamanho mínimo nem é obrigatório preencher todos os campos; campos inúteis para a sessão sucessora devem ser omitidos. O handoff deve ser tão curto quanto possível sem obrigar a sucessora a reconstruir o trabalho. Sua completude é medida pela suficiência operacional, não pelo número de palavras.

```text
SESSÃO:
ITEM:
TIPO:
SUPERFÍCIE:
MODELO:
RACIOCÍNIO:
MODO:
FAST:
COMPLEXIDADE/RISCO:
OBJETIVO:
CRITÉRIO DE PARADA:
CRITÉRIO ATINGIDO:
EVIDÊNCIAS:
DECISÃO OU RESULTADO:
ARQUIVOS LIDOS:
ARQUIVOS ALTERADOS:
DIFF OU REFERÊNCIA:
ESCRITO:
APLICADO:
VERIFICADO:
MÉTODO DE VERIFICAÇÃO:
HIPÓTESE TESTADA:
RESULTADO:
HIPÓTESE QUE FALHOU:
NÃO REPETIR:
PENDÊNCIAS:
ROLLOUT INICIAL:
ROLLOUT FINAL:
DELTA:
FATOR:
SAÚDE:
SINAIS ANORMAIS:
PRÓXIMA SESSÃO:
SUPERFÍCIE RECOMENDADA:
MODELO:
RACIOCÍNIO:
MODO:
FAST:
COMPLEXIDADE/RISCO:
INPUT MÍNIMO:
```

Não conter Base64, logs completos, código integral, conversa reproduzida ou promoção automática de estado. Handoffs comuns são transitórios e ignorados pelo Git por padrão. A área física ainda não está decidida; `.work/handoffs/` é apenas candidata e não deve ser criada sem decisão posterior do usuário.

## 12. Diff, worktree e Review

Alteração de arquivo existente exige diff obrigatório. Em worktree previamente sujo, registrar status antes, fazer alteração focal, registrar status depois e preservar mudanças anteriores. O relato do executor não substitui diff externo.

Review independente é obrigatório quando houver R2 ou superior, mais de um arquivo, documento canônico, CSS global ou compartilhado, JavaScript comportamental, acessibilidade, segurança, configuração/build, refatoração estrutural, mudança destinada à publicação, alteração difícil de verificar objetivamente ou worktree sujo com risco de mistura.

Pode ser dispensado em C0/R1 somente se todos forem verdadeiros: um arquivo, diff pequeno, determinístico e reversível, sem mudança comportamental relevante, verificação externa objetiva e aprovação do diff pelo usuário. Mesmo nessa exceção, o diff continua obrigatório. Não há commit automático; commit e push exigem autorizações separadas.

## 13. Estados de execução e classificações de fluxo

Estados de execução:

| Estado | Significado |
|---|---|
| **Escrito** | Existe no arquivo. |
| **Aplicado** | Foi inserido ou configurado no Elementor, salvo e publicado. Algo apenas salvo e ainda não publicado não é aplicado. |
| **Verificado** | Foi confirmado no site pelo método registrado. |

Esses estados nunca devem ser colapsados em “pronto”.

`DECIDIDO` e `PENDENTE` são classificações de fluxo ou decisão, não estados de execução. Uma decisão aprovada pode ainda não estar escrita, aplicada ou verificada. Quando a ambiguidade for material, `PENDENTE` deve ser qualificado como de decisão, de aplicação ou de verificação.

Relatório executivo, resumo ou snapshot temporal é uma leitura derivada. Quando o corte temporal for material, deve declarar data, hora e fuso; não substitui a fonte canônica nem promove estado automaticamente, mesmo que represente a melhor leitura disponível naquele corte.

## 14. Arquivos canônicos e transitórios

| Classe | Referência |
|---|---|
| Regras universais mínimas | `AGENTS.md` |
| Fila, estados e pendências | `docs/controle-projeto.md` |
| Arquitetura detalhada de uso de IA | `docs/ARQUITETURA-IA.md` |
| Decisões de design vigentes | `design-system/` |
| Fontes locais de código, quando reconciliadas e aprovadas | `css/*.css` e `scripts/*.js` |

Conversas, handoffs operacionais comuns, screenshots, logs, rollouts, relatórios forenses, recovery e temporários são transitórios por padrão. A promoção para canônico exige extrair a informação, identificar sua natureza, obter aprovação e escrevê-la no arquivo correto. Copiar uma transcrição não é promoção válida.

Os handoffs da frente de Design System usados para registrar evidência factual do Figma são uma exceção funcional a essa regra de transitoriedade: preservam evidência durável, proveniência e supersessões conforme `docs/protocolo-evidencia-figma.md`. Continuam não canônicos para decisões de design; a decisão aprovada pertence ao Design System ou documento canônico correspondente.

Conversa e memória da LLM preservam método, continuidade e contexto, não geometria densa como fonte factual. Handoffs e evidência factual estruturada preservam fatos densos e sua proveniência. O documento canônico preserva somente a decisão aprovada. Essas funções não devem ser fundidas.

`AGENTS.md` deve continuar pequeno. Pode conter futuramente o padrão pt-BR, autoridade, referência para este documento, classificação C/R quando afeta o contrato, resumo de Plan/Goal e regra resumida de Scope Exit/Handoff. Não deve conter thresholds completos, matriz extensa de modelos, item da fila, histórico, troubleshooting transitório, incidente do CLI, narrativa do projeto ou logs.

## 15. Saúde de sessões e rollouts

```text
ROLLOUT INICIAL:
ROLLOUT FINAL:
DELTA:
FATOR DE CRESCIMENTO:
CLASSIFICAÇÃO:
SINAIS ANORMAIS:
```

A medição de rollout faz parte da abertura e fechamento de Work local e de sessões Codex relevantes. Inicialmente, a medição é manual e somente leitura no PowerShell; não é preciso fixar caminho versionado de runtime.

**Rollout** é o arquivo `rollout-*.jsonl` correspondente a uma sessão local Work ou Codex, usado como indicador físico do crescimento do contexto persistido dessa sessão. Health é obrigatório para toda Work local vinculada ao projeto; toda sessão Codex com R1 ou superior, C2 ou superior, em Goal, com mídia ou entrada pesada, ou prevista para múltiplos turnos ou trabalho prolongado. Health pode ser compacto ou dispensável em Codex C0/R0 ou C1/R0, em tarefa curta e de turno único, sem mídia pesada, sem Goal e sem escrita. Se surgir sinal de degradação, Health passa a ser obrigatório independentemente da classificação inicial. Chat Web comum continua fora desse mecanismo local de rollout. O objeto medido é o `rollout-*.jsonl` da sessão, seu tamanho em MB, `LastWriteTime` e o caminho completo somente para identificação.

### Health Baseline

1. Criar a sessão.
2. Enviar ou materializar um primeiro turno curto de Preflight.
3. Antes do trabalho substancial, executar o comando PowerShell somente leitura abaixo.
4. Identificar o rollout recém-criado pela data e hora.
5. Registrar o tamanho inicial.
6. Executar o trabalho.

```powershell
Get-ChildItem "$env:USERPROFILE\.codex\sessions" -Recurse -Filter "rollout-*.jsonl" -File -ErrorAction SilentlyContinue |
Sort-Object LastWriteTime -Descending |
Select-Object -First 10 LastWriteTime,@{N="TamanhoMB";E={[math]::Round($_.Length/1MB,2)}},FullName |
Format-Table -AutoSize
```

Se o rollout não puder ser identificado com confiança, registrar `ROLLOUT INICIAL: não medido`. Nunca reconstruir, inferir ou estimar o baseline retroativamente.

### Health Close

Depois do trabalho e da recomendação de Scope Exit, executar novamente o mesmo comando, localizar o rollout da sessão e registrar rollout final, delta, fator de crescimento, classificação e sinais anormais. A medição produz evidência; ela não encerra a sessão automaticamente.

| Threshold experimental do piloto | Ação |
|---|---|
| Menor que 100 MB | Normal. |
| 100–250 MB | Observação; pode continuar se saudável. |
| A partir de 250 MB | Handoff preventivo obrigatório; não iniciar novo bloco grande; finalizar somente unidade atômica segura. |
| A partir de 500 MB | Teto operacional; rotacionar; não continuar trabalho normal. |
| A partir de 1 GB | Quarentena; não reabrir nem fazer fork antes de inspeção. |

Os thresholds são experimentais do piloto, não científicos nem permanentes, e serão recalibrados após evidência adicional. Eles derivam de observações operacionais do projeto; os dados usados na calibração permanecem em artefatos de retrospectiva ou forense, não neste manual canônico.

**Sinais experimentais de observação:** crescimento maior que 3× entre medições e duas medições consecutivas com aceleração de crescimento. Eles não determinam rotação automaticamente; antecipam observação e análise dos demais sinais. A saúde combina tamanho absoluto, taxa de crescimento, tipo de conteúdo, compactações, Base64, `replacement_history`, linhas gigantes, repetição de contexto, latência, crash, corrupção e estabilidade da interface.

## 16. Mídia, DOM e Base64

São permitidos screenshots normais, recortes, imagens anexadas normalmente, SVG leve necessário e DOM sanitizado. Evitar HTML com `data:image;base64`, Ctrl+U inteiro, SVG enorme contendo raster Base64, DOM completo quando uma estrutura reduzida basta e repetir o mesmo blob em vários turnos.

### Figma e layout

Para frame ou layout completo, preferir PNG ou screenshot da frame com as medidas relevantes do Figma. Para detalhe visual, preferir crop PNG. Para logo, ícone ou geometria vetorial, preferir SVG limpo. Antes de usar SVG grande em Work ou Codex, verificar se contém raster ou Base64 incorporado.

Medida do Figma que dependa de interpretação deve declarar o referente, o tipo de medida, o espaço de coordenadas, o método e o que prova ou não prova. A evidência factual continua nos handoffs da frente de Design System; a decisão aprovada vai para o Design System ou documento canônico correspondente. O método de registro está em `docs/protocolo-evidencia-figma.md`; ele não cria um ledger separado.

Quando uma sessão solicitar SVG grande do Figma e houver risco de raster incorporado, ela deve reapresentar ao usuário este checklist; o usuário não precisa memorizar o procedimento:

1. Abrir o SVG no Illustrator.
2. Abrir **Janela → Vínculos**.
3. Identificar imagens raster incorporadas.
4. Selecionar e usar **Desincorporar** quando necessário.
5. Manter o raster resultante como arquivo vinculado.
6. Ao salvar ou exportar SVG, escolher **Local da imagem → Vincular**.
7. Se for somente para análise, não preservar recursos de edição do Illustrator.
8. Abrir o SVG resultante no VS Code.
9. Procurar `base64` e `data:image`.
10. Se essas ocorrências não existirem, usar o SVG.
11. Se raster for necessário, preferir PNG ou raster separado em vez de Base64 incorporado.

Não recomendar Image Trace como solução automática para remover Base64, pois altera a natureza da arte e pode aumentar muito a complexidade vetorial.

| Evidência | Destino |
|---|---|
| Work/browser | Comportamento visual. |
| DevTools humano | Causa observada no DOM/CSS executado. |
| Codex | Fonte local. |
| Elementor | Estado aplicado. |

## 17. Footer como piloto

Um arquivo de componente não deve ser promovido a fonte oficial antes de ser reconciliado com o Elementor, aprovado, aplicado e verificado. No piloto atual, essa regra será validada com o Footer.

O piloto segue: Preflight → Health Baseline → Chat comum/painel → handoff semântico → diagnóstico → Scope Exit → implementação focal → diff → Review → aplicação humana no Elementor → publicação → verificação → atualização de estado autorizada → Health Close → retrospectiva.

Goal não é esperado no piloto, pois Elementor exige intervenção humana. Os critérios mínimos são: zero arquivo fora do escopo; uma hipótese por rodada; painel antes de código; nenhum estado presumido; diff focal; review conforme a matriz; aplicação separada de verificação; Scope Exit respeitado; handoff curto; rollout medido; ausência de crescimento anormal; nenhuma promoção automática de estado.

### Experimento de modelo

Testar GPT-5.3-Codex-Spark em pelo menos uma tarefa focal C0/C1 de CSS ou JavaScript no piloto do Footer. Registrar latência, aderência ao escopo, qualidade do diff e necessidade de correção. O teste não promove Spark automaticamente à matriz permanente e não deve ser usado para arquitetura, diagnóstico difícil ou review sensível. A decisão sobre incorporá-lo à matriz ocorre somente após a retrospectiva do piloto.

## 18. Automação futura

Automação não entra antes desta sequência: **piloto do Footer → retrospectiva do piloto → 02 — Infra IA — Saúde de Sessões — automação**. O MVP é manual. Depois do piloto e de sua retrospectiva, a próxima tarefa relevante é **02 — Infra IA — Saúde de Sessões — automação**.

O objetivo futuro é automatizar a medição rotineira de saúde, desenvolver e manter um monitor de rollout e separar a medição rotineira do diagnóstico excepcional. O candidato é `tools/codex-session-health.ps1`, que poderá localizar rollouts, medir tamanho, comparar medições, calcular delta e fator, classificar thresholds e sinalizar anomalias. Nunca poderá excluir, mover automaticamente, matar processo, encerrar sessão, alterar estado, publicar, fazer commit/push ou promover decisão.

Sessão normal mede rotineiramente; anomalia vai para sessão especializada de Infra IA; Meta-governança calibra thresholds e protocolo; a Central só intervém se a política precisar mudar. Outras automações futuras, também após piloto e retrospectiva, são `tools/new-handoff.ps1`, checklist/skill de abertura, checklist/skill de encerramento e template de review.

## 19. Pendências técnicas não bloqueantes

**Infra IA — normalizar instalação standalone do Codex CLI no Windows.** A capacidade do Codex CLI é funcional, mas a instalação standalone atual resolvida pelo PATH não executou corretamente ferramenta sandboxed no teste. Esta é uma pendência não bloqueante: não registrar hash de runtime, caminho versionado, versão específica ou workaround transitório, nem tratá-la nesta sessão.

## 20. Governança e revisão da arquitetura

Este documento não deve virar diário de incidentes. Troubleshooting e situações efêmeras ficam fora dele. Sua mudança continua sujeita ao fluxo: **Central propõe → usuário aprova o princípio → Work documental redige → Review independente revisa → usuário aprova o diff.**
