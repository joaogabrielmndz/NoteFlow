# Guia de Contribuição 🤝

Que bom que você resolveu contribuir com o NoteFlow! Nossa proposta de unir gestão pessoal e inteligência artificial de forma simples é ambiciosa, e precisamos de toda ajuda possível para evoluir essa ideia.

Neste guia, explicamos como funcionam os nossos processos e como podemos trabalhar juntos da melhor forma possível para melhorar o ecossistema do NoteFlow.

## Como contribuir

Existem diversas formas de contribuir com o projeto:

- Reportando bugs
- Indicando melhorias
- Pedindo recursos
- Discutindo as issues
- Fazendo pull requests
- Outras formas de ajudar
- Reportando bugs

Se encontrou um bug no NoteFlow, você pode reportá-lo usando a aba de Issues do GitHub. Porém, antes de abrir o chamado, é importante fazer as seguintes verificações:

1. Atualize seu repositório local na branch main mais recente. Talvez seu bug já tenha sido corrigido.
2. Verifique se o bug já foi reportado por outra pessoa fazendo uma busca pelas issues existentes.
3.  Se o problema persistir e não estiver mapeado, crie uma nova issue. Evite títulos genéricos como "Falha no sistema" ou "Erro no PDF". Tente detalhar o problema no título.

---

### No corpo da issue, siga esta estrutura:

**CONTEXTO:** Em qual funcionalidade ocorreu o erro (ex: Requisição de Clima, Geração de PDF, Cadastro de Estoque).

**DESCRIÇÃO:** Descreva detalhadamente o que aconteceu.

**COMO REPRODUZIR:**
1. Acesse a rota X
2. Envie o payload Y
3. Clique em Z

### Exemplo:

---

**CONTEXTO:** Geração de Relatório PDF de IA

**DESCRIÇÃO:** Ao solicitar uma recomendação de perfume durante o período da noite, a IA retorna o texto corretamente, mas o gerador de PDF quebra por falha de formatação na view, retornando erro 500 no Laravel.

**COMO REPRODUZIR:** Enviar POST para /api/recommendations com o parâmetro occasion definido como "balada".

Se possível, informe detalhes do seu ambiente: sistema operacional, se estava rodando via Laravel Sail e qual versão do PHP. Adicione a label bug à issue.

## Nota sobre falhas de segurança

Se você encontrou alguma falha que comprometa a chave da API (Open-Meteo ou da IA) ou exponha dados indevidos, não abra uma issue pública. Entre em contato diretamente comigo via e-mail (**jgquadros2005@gmail.com**) para que a falha seja corrigida de forma segura antes da divulgação.

## Indicando melhorias

Se você tem ideias de refatoração de código, otimização de consultas ao banco de dados ou formas de tornar as instruções de IA (prompts) mais assertivas, siga estes passos:

- Verifique se a ideia já não está em discussão nas nossas issues.
- Abra uma nova issue com a label enhancement (melhoria).
- Explique o problema que sua ideia resolve e por que ela é melhor do que a abordagem atual (ex: trocar a biblioteca de PDF por uma mais leve, ou otimizar a tabela inventories).

## Pedindo recursos

Novos recursos são muito bem-vindos, especialmente aqueles que melhoram a precisão das recomendações olfativas. Vale a pena sugerir se:

- O recurso não existe hoje.
- Ele agrega valor real ao usuário final.
- Exemplo de bom recurso: Adicionar suporte a famílias olfativas secundárias para que a IA faça cruzamentos mais complexos em dias chuvosos.
- Abra uma issue com a label feature e descreva a sua ideia.

## Discutindo as issues

Toda e qualquer questão complexa deve ser colocada em discussão nas issues antes de partirmos para o código. Isso garante que não haja retrabalho.

Se você está pesquisando uma solução, publique suas descobertas indicando caminhos e receba o feedback antes de abrir um Pull Request (PR) enorme. Use a label discussão caso precise debater ideias de arquitetura.

## Fazendo pull requests (PR)

Depois de ter um plano de ação claro (preferencialmente atrelado a uma issue existente), você está pronto para enviar código:

1. Faça um fork do repositório.
2. Crie uma nova branch a partir da main (ex: feature/novo-gerador-pdf ou fix/erro-clima).
3. Faça seus commits.

### Antes de abrir o PR, certifique-se de que:

- Seu PR resolve apenas um problema por vez. Não misture uma correção de banco de dados com uma mudança no layout.
- Seu código adere ao padrão adotado pelo Laravel e passa pelas validações locais.
- Se você testar uma nova rota ou integração, garanta que ela funciona rodando no Laravel Sail.

As mensagens dos seus commits descrevem claramente o que foi feito.

(Nota: PRs que realizam apenas mudanças cosméticas irrelevantes, como remoção excessiva de espaços em branco sem alterar lógica, poderão ser fechados para manter o histórico de commits limpo e focado em valor).

## Outras formas de ajudar

Não programa em PHP ou não quer mexer com código agora? Tudo bem!

- Ajude a melhorar a documentação e os arquivos da pasta docs/.
- Teste a aplicação na sua máquina e reporte falhas de usabilidade.
- Avalie se as recomendações geradas pela IA fazem sentido olfativo e sugira melhorias nos Prompts.
- Dê uma estrela (⭐) no repositório do NoteFlow!

Obrigado por ajudar a construir um software cada vez mais inteligente e organizado!