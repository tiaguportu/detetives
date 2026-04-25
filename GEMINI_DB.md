# Detetives do Porto - Banco de Dados

Este documento descreve a estrutura do banco de dados do jogo de investigação geográfica.

## Tabelas

### `investigators`
- `id`: primary key
- `name`: string (Rafael, Celina, Samuel, Joaquim)
- `countries_count`: integer (10, 8, 6, 2)
- `avatar_path`: string
- `description`: text
- `deleted_at`: timestamp (soft deletes)

### `countries`
- `id`: primary key
- `name`: string
- `slug`: string (unique)
- `history`: text (Fatos históricos)
- `culture`: text (Fatos culturais)
- `geography`: text (Geografia e clima)
- `fauna`: text (Animais típicos)
- `flora`: text (Flora local)
- `image_path`: string (Imagem do local)
- `flag_path`: string (Caminho da bandeira do país)
- `coord_x`: decimal (Posição X no mapa mundi - 0 a 100)
- `coord_y`: decimal (Posição Y no mapa mundi - 0 a 100)
- `latitude`: decimal (Latitude geográfica real)
- `longitude`: decimal (Longitude geográfica real)

### `country_informant` (tabela pivô)
- `id`: primary key
- `country_id`: foreign key
- `informant_id`: foreign key

### `informants`
- `id`: primary key
- `name`: string
- `image_path`: string (Upload de foto do informante)
- `created_at`: timestamp
- `updated_at`: timestamp

### `clues`
- `id`: primary key
- `country_id`: foreign key
- `type`: string (history, culture, geography, fauna, flora, economy, climate, landmark, food, etc.)
- `content`: text (A pista em si)

### `game_sessions`
- `id`: primary key
- `investigator_id`: foreign key (cascade delete)
- `status`: enum (playing, won, lost)
- `current_step`: integer
- `total_steps`: integer
- `path`: json (IDs dos países sorteados para a partida)

### `game_steps`
- `id`: primary key
- `game_session_id`: foreign key
- `step_number`: integer
- `target_country_id`: foreign key
- `is_correct`: boolean

### `intro_stories`
- `id`: primary key
- `content`: text (A vilania cometida)
- `is_active`: boolean (default true)
- `created_at`: timestamp
- `updated_at`: timestamp

### `country_curiosities`
- `country_id`: foreign key (cascade delete)
- `type`: string (history, culture, geography, fauna, flora)
- `content`: text
- `created_at`: timestamp
- `updated_at`: timestamp

### `country_images`
- `id`: primary key
- `country_id`: foreign key (cascade delete)
- `image_path`: string (Caminho da imagem em 16:9)
- `sort_order`: integer
- `created_at`: timestamp
- `updated_at`: timestamp

## Modificações Recentes
- **2026-04-21**: Adicionadas colunas `latitude` e `longitude` à tabela `countries` para suportar o mapa de satélite durante as viagens.
- **2026-04-21**: Configurado `onDelete('cascade')` na relação entre `investigators` e `game_sessions` para permitir a exclusão de investigadores que possuem partidas registradas.
- **2026-04-21**: Alterado `clues.type` de `enum` para `string` para permitir maior variedade de tipos (economy, climate, etc.).
- **2026-04-21**: Aprimorado o seed de pistas com 5 pistas detalhadas por país e adicionados novos países: Inglaterra, Índia, Austrália, Rússia e Argentina.
- **2026-04-21**: Populados campos `culture` e `geography` para todos os países para garantir a exibição completa das curiosidades no jogo.
- **2026-04-21**: Implementado Soft Deletes na tabela `investigators` para evitar que registros excluídos apareçam na tela de seleção do jogo, mantendo a integridade para referências históricas se necessário.
- **2026-04-21**: Expansão massiva para **26 países** e mais de **280 pistas** no total (aumento de 200+ pistas). Novos países: Espanha, Canadá, Grécia, Turquia, Tailândia, Holanda, Suíça, África do Sul, Chile e Colômbia.
- **2026-04-21**: Implementada a entidade `Informantes` como uma tabela separada para permitir a gestão centralizada e reutilização de informantes entre países (embora inicialmente mantida a relação 1:1 via `informant_id` em `countries`).
- **2026-04-21**: Adicionado `InformantResource` no Filament, integrado ao Shield para controle de permissões.
- **2026-04-21**: Criada a tabela `intro_stories` para permitir a configuração dinâmica das introduções narrativas do jogo através do painel administrativo.
- **2026-04-21**: Implementado `IntroStoryResource` no Filament v5, configurável via Filament Shield.
- **2026-04-23**: Implementada a estrutura de **Múltiplas Curiosidades** por País. Criada a tabela `country_curiosities` que permite cadastrar diversas informações (História, Cultura, Geografia, Fauna e Flora) para cada destino, substituindo o modelo de campos únicos e limitados na tabela `countries`.
- **2026-04-23**: Populada a tabela `country_curiosities` com **650 registros** (5 curiosidades de cada um dos 5 tipos para todos os 26 países), garantindo conteúdo rico e variado desde o primeiro dia.
- **2026-04-23**: Criado o `CountryCuriosityResource` no Filament, integrado ao Shield, e adicionado o `CuriositiesRelationManager` ao `CountryResource` para gerenciamento facilitado.
- **2026-04-23**: Implementado sistema de **Múltiplas Imagens** por país com proporção fixa de **16:9**. Adicionada galeria dinâmica com transições suaves e editor de recorte automático no painel administrativo.
- **2026-04-23**: Adicionado suporte para **Bandeiras dos Países**. As bandeiras agora são exibidas visualmente no painel de decolagem, auxiliando o jogador na identificação rápida dos destinos.
- **2026-04-23**: Criado e executado o `CountryFlagSeeder`, que realiza o download automatizado das bandeiras oficiais de todos os 26 países via API externa (FlagCDN), populando o sistema instantaneamente.
- **2026-04-23**: Criado e executado o `CountryImageSeeder`, que automatiza a busca e o download de imagens de paisagens e monumentos para a galeria de todos os países, garantindo que nenhum destino esteja sem conteúdo visual.
