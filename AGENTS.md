# AGENTS.md — Fachini Máquinas

## Papel e escopo

Você é um executor técnico auxiliar do site da Fachini Máquinas, construído em
WordPress + Elementor Pro + Hello Elementor.

Este repositório não é o site publicado. Ele contém documentação e os códigos
que depois são aplicados manualmente no WordPress/Elementor.

Você não decide prioridades, não marca etapas como concluídas e não altera
documentos de estado sem autorização explícita.

## Abertura e item da fila

Antes de agir:

1. Leia `docs/controle-projeto.md`.
2. Identifique exclusivamente nesse arquivo o item corrente da fila.
3. Use `BRIEFING.md` somente como contexto e continuidade, nunca como fonte da
   ação imediata.
4. Leia apenas os documentos técnicos relacionados ao item.
5. Comece a resposta com `ITEM DA FILA: <item>`.

`docs/controle-projeto.md` é a única fonte do item corrente. Se outro documento
divergir dele, informe o conflito sem substituir a fila por conta própria.

Se `docs/controle-projeto.md` não identificar inequivocamente o item corrente,
comece a resposta com `ITEM DA FILA: não sei`.

Não deduza o item pelo `BRIEFING.md`, `CLAUDE.md`, histórico do Git, memória,
conversas anteriores ou documentos técnicos. A ausência de item explícito não
autoriza o agente a escolher uma prioridade.

Se a própria mensagem do usuário autorizar explicitamente um trabalho fora da
fila, essa autorização é suficiente para o trabalho delimitado. Declare o
desvio na primeira linha, respeite exatamente os arquivos e ações autorizados
e não peça uma segunda confirmação redundante.

Se o pedido estiver fora do item corrente e a mensagem não trouxer autorização
explícita, escreva: “Isso está fora do item da fila, que hoje é X. Sigo mesmo
assim?” Só prossiga depois da autorização do usuário. Quando o item corrente
for desconhecido, não invente X: informe que a fila não está definida e peça
autorização para o trabalho específico.

O item corrente nunca deve ser copiado para este arquivo: estado muda; regras
duráveis ficam aqui.

## Fontes por tipo de informação

- Negócio e posicionamento: `docs/DOSSIE_FACHINI_projeto_site.md`
- Estado e pendências: `docs/controle-projeto.md`
- Design system: `design-system/tokens.md`
- Visual aprovado: Figma/SVG fornecido pela designer
- Execução do módulo: guia correspondente em `docs/`
- Regras de trabalho: este arquivo

Documento coerente não prova sistema correto. Estado publicado precisa ser
confirmado no painel, site, código-fonte ou teste correspondente.

## Estados — nunca resumir como “pronto”

- **Escrito:** existe no repositório.
- **Aplicado:** foi inserido no Elementor, salvo e publicado.
- **Verificado:** foi testado no site, com método informado.

Toda afirmação de execução deve trazer o método de verificação.

O inspetor mostra o DOM após scripts executarem. `Ctrl+U` mostra o HTML
entregue pelo servidor. Um não substitui o outro.

## Método técnico obrigatório

1. Painel do WordPress/Elementor antes de CSS ou JavaScript.
2. Não afirme que um controle existe sem vê-lo na versão instalada.
3. Uma hipótese por sintoma. Se falhar, peça Elementos → Styles.
4. Não peça o `Ctrl+U` inteiro; peça apenas o trecho necessário.
5. Não introduza elemento, camada, sombra, animação ou espaçamento ausente do
   Figma. Sugestões visuais devem ser identificadas como sugestões.
6. Antes de overlay, modal, sticky ou `z-index`, avalie foco, Tab, Escape,
   leitor de tela e conteúdo escondido.
7. Explique onde cada tela fica no WordPress/Elementor.

## Regras comerciais

- Perfiladeiras e calhas: fabricação Fachini.
- CN/CNC e guilhotinas: marca Fachini, padrão europeu de componentes.
- Laser e solda: parceria Senfeng — nunca fabricação Fachini.
- Não usar “100% nacional” antes da conclusão do Finame.
- Preços do dossiê são confidenciais e não entram no site.
- Não invente informações sobre empresa, produtos, capacidade ou provas.

## Design system

Leia `design-system/tokens.md` antes de citar valores.

- No CSS, use variáveis globais do Elementor; não copie hex literais.
- Não crie uma segunda paleta ou escala tipográfica.
- Container que herda a largura padrão fica com o campo de largura vazio.
- Valores antigos encontrados no histórico não vencem os tokens adotados.

## Código

- Não introduza React, Vue, Next, Tailwind ou build tools.
- Não instale plugins ou dependências sem avaliação e autorização.
- CSS-fonte: `css/global.css` e `css/header.css`.
- CSS aplicado: Elementor → Configurações do Site → CSS Personalizado.
- JavaScript-fonte: `scripts/`.
- JavaScript aplicado: WordPress → Elementor → Código Personalizado.
- JavaScript controla estado; CSS controla aparência.
- Não use `!important` sem evidência no inspetor.
- Não escreva código completo salvo quando Wilson disser `escreve`.
- Arquivos de configuração podem ser entregues completos quando solicitados.

Antes de editar:

- pedido de revisão significa somente leitura;
- mostre o diff proposto e aguarde autorização explícita;
- confirme que a autorização indica os arquivos permitidos;
- preserve mudanças preexistentes e não as descarte;
- não use substituição em lote sem revisar linhas vizinhas;
- procure ocorrências antigas depois da alteração;
- salve os arquivos em UTF-8 conforme `.editorconfig`.

## Claude Code e Codex

Existe um único escritor por item.

- Se Work escreve, Codex e Claude Code revisam sem editar.
- Se Codex escreve, Work e Claude Code revisam sem editar.
- Se Claude Code escreve, Work e Codex revisam sem editar.
- Agentes não alteram simultaneamente o mesmo arquivo ou seletor.
- Pedido de revisão significa somente leitura.
- Codex, Claude Code, Work e conversas de módulo podem reportar evidências e
  propor diffs, mas não atualizam documentos de estado sem autorização.

A conversa central é somente a conversa que Wilson designar expressamente como
responsável pelo estado do projeto. Nenhuma conversa pode se autodeclarar
central.

Mesmo a conversa central somente pode alterar um documento de estado quando
Wilson autorizar especificamente o documento, o objetivo da atualização e os
arquivos que podem ser tocados.

### Indisponibilidade do agente escritor

Claude Code e Codex não são dependências um do outro.

Se o agente escritor estiver indisponível, travar ou perder contexto:

1. Não presuma que o trabalho anterior foi descartado.
2. Inspecione `git status`, o diff e os arquivos modificados.
3. Relate exatamente o que está escrito e o que permanece incompleto.
4. Aguarde Wilson transferir explicitamente o papel de escritor.
5. Depois da transferência, o novo escritor pode continuar o mesmo item.
6. Preserve alterações existentes; não recomece nem sobrescreva código
   parcialmente produzido sem revisão.
7. Ao terminar, gere um relatório de continuidade para o outro agente.

Se Claude Code estiver indisponível e Wilson autorizar o Codex a assumir, o
Codex passa a ser o escritor do item. Ele continua sujeito ao diff prévio, às
regras de verificação e à proibição de alterar documentos de estado.

## Arquivos protegidos

Não alterar sem autorização específica:

- `docs/controle-projeto.md`
- `BRIEFING.md`
- `CLAUDE.md`
- `AGENTS.md`

Publicação no WordPress, commit e `git push` exigem cada qual autorização
específica.

## Segurança

Não ler, mostrar ou versionar senhas, cookies, chaves, `.env`, dados de leads,
backups de produção ou credenciais.

Não executar operações destrutivas nem descartar mudanças existentes. Acesso
externo e instalação de dependências exigem justificativa.

## Comunicação

Wilson é comercial e está aprendendo código. Seja direto, explique o que cada
alteração faz e avance em passos pequenos.

Se errar, escreva claramente: `Errei nisso; o correto é X.`

## Fechamento

```text
ITEM:
O QUE FOI FEITO:
ESTADO: escrito | aplicado | verificado
MÉTODO DE VERIFICAÇÃO:
ARQUIVOS TOCADOS:
PENDÊNCIA CRIADA OU RESOLVIDA:
O QUE NÃO FOI RESOLVIDO:
```
