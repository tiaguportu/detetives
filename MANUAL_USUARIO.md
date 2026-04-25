# Manual do Usuário - Detetives do Porto

## Visão Geral
O sistema é um jogo de investigação geográfica onde os jogadores assumem o papel de investigadores da Interpol para capturar o vilão Tom Riddle, que está roubando tesouros ao redor do mundo.

## Recursos Administrativos
- **Gerenciamento de Investigadores**: Permite cadastrar, editar e excluir os personagens. A exclusão de um investigador removerá automaticamente todas as suas partidas históricas (cascade delete).
- **2026-04-21**: Implementado Soft Deletes na tabela `investigators` para evitar que registros excluídos apareçam na tela de seleção do jogo, mantendo a integridade para referências históricas se necessário.
- **2026-04-21**: Expansão massiva para **26 países** e mais de **280 pistas** no total (aumento de 200+ pistas). Novos países: Espanha, Canadá, Grécia, Turquia, Tailândia, Holanda, Suíça, África do Sul, Chile e Colômbia.
- **2026-04-21**: Criada a tabela `intro_stories` para permitir a configuração dinâmica das introduções narrativas do jogo através do painel administrativo.
- **2026-04-21**: Implementado `IntroStoryResource` no Filament, com suporte a Filament Shield.
- **Upload de Avatares**: Suporte para upload de fotos com redimensionamento automático (máximo 1000px) para otimização de espaço.
- **Gerenciamento de Países e Pistas**: Cadastro de destinos, fatos históricos/culturais, pistas e as **bandeiras nacionais**. Agora com suporte a **múltiplas imagens em proporção 16:9**, incluindo um editor integrado para garantir o enquadramento perfeito de cada localidade.
- **2026-04-23**: Adicionado o componente visual de **Bandeiras** na seleção de destinos, permitindo que o jogador identifique rapidamente os países através de seus símbolos nacionais.
- **2026-04-23**: Implementado sistema de galeria dinâmica para os países, com troca automática de imagens e transições suaves, proporcionando uma imersão visual muito superior.
- **2026-04-23**: Implementada a gestão de informantes via relação Muitos-para-Muitos, permitindo que um informante pertença a vários países e um país tenha diversos informantes.
- **Histórias Iniciais Configuráveis**: Permite alterar o texto narrativo que aparece no início de cada partida (as vilanias de Tom Riddle).
- **Ações em Lote**: É possível excluir ou atualizar o nível de perseguição de vários investigadores simultaneamente.
- **Melhoria de Usabilidade (2026-04-23)**: Ao criar ou editar um investigador, o sistema agora redireciona automaticamente de volta para a listagem após salvar, otimizando o fluxo de trabalho administrativo.
- **Segurança (Shield)**: Todos os novos recursos (Informantes, Histórias, Países, Curiosidades) são protegidos por permissões granulares configuráveis pelo administrador.
- **2026-04-23**: Implementado o sistema de **Múltiplas Curiosidades**. Agora cada país pode ter dezenas de fatos históricos, culturais e geográficos cadastrados. O sistema sorteia informações diferentes para cada rodada, aumentando exponencialmente o valor de replay e o aprendizado.
- **2026-04-23**: Corrigido o gerenciamento de **Países** para suportar a nova estrutura de componentes do Filament V5, garantindo que o vínculo com **Informantes Locais** funcione corretamente no painel administrativo.
- **2026-04-24**: Implementada nova **Animação Cinematográfica de Informantes**. Ao interagir com um informante, a imagem do país atual é ampliada, o personagem entra em cena através de um efeito *slide-in* e suas pistas são apresentadas em um **balão de fala estilizado (HQ)**, tornando a experiência mais dinâmica e imersiva.
- **2026-04-24**: Corrigido o gerenciamento da **Galeria Geográfica** no cadastro de países. Agora utiliza um componente de repetição (*Repeater*) que permite o upload individual, edição de recorte 16:9 e reordenação intuitiva das fotos que compõem o visual de cada destino no painel administrativo.


## Como Jogar

1.  **Introdução Narrativa**: Ao iniciar, você receberá um alerta da Interpol descrevendo o crime recente de Tom Riddle.
2.  **Seleção de Investigador**: Escolha seu personagem. Cada um oferece um nível de dificuldade diferente baseado no número de países.
3.  **Investigação**: Explore o país atual usando o PDA de bordo. O sistema fornece informações ricas sobre a **Cultura, História e Geografia** de cada local, auxiliando na imersão e no aprendizado. Procure informantes locais para obter pistas sobre o paradeiro de Riddle.
4.  **Mapa de Voo e Radar**: Ao escolher um destino, o sistema ativa o **Radar de Voo**. Você visualizará o mapa-múndi digital completo sobreposto a uma **visão de satélite real**, mostrando a trajetória direta do avião cruzando o globo.
5.  **Captura**: Capture Tom Riddle ao final do percurso para vencer o jogo.
6.  **Reiniciar**: Ao final da missão (tela de vitória), você terá a opção de **Reiniciar Missão** (jogar novamente com o mesmo investigador) ou **Finalizar Dossiê** (voltar para a tela inicial).
