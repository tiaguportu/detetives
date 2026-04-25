<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CountryCuriosity;
use Illuminate\Database\Seeder;

class CountryCuriositySeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::all();

        $types = ['history', 'culture', 'geography', 'fauna', 'flora'];

        foreach ($countries as $country) {
            foreach ($types as $type) {
                for ($i = 1; $i <= 5; $i++) {
                    CountryCuriosity::create([
                        'country_id' => $country->id,
                        'type' => $type,
                        'content' => $this->getCuriosityContent($country->name, $type, $i),
                    ]);
                }
            }
        }
    }

    private function getCuriosityContent($countryName, $type, $index): string
    {
        $data = [
            'Portugal' => [
                'history' => [
                    'Portugal tem as fronteiras mais antigas da Europa, definidas em 1139.',
                    'O Tratado de Tordesilhas, assinado em 1494, dividiu o mundo entre Portugal e Espanha.',
                    'A Revolução dos Cravos em 1974 pôs fim a quase 50 anos de ditadura de forma pacífica.',
                    'Portugal foi o primeiro império global da história, estendendo-se por 4 continentes.',
                    'Dom Afonso Henriques foi o primeiro rei de Portugal, conhecido como "O Conquistador".'
                ],
                'culture' => [
                    'O Fado é um estilo musical tradicional português, reconhecido pela UNESCO.',
                    'O Galo de Barcelos é um dos símbolos mais icônicos do folclore português.',
                    'Os Azulejos portugueses são famosos mundialmente e decoram fachadas por todo o país.',
                    'O prato nacional é o Bacalhau, e dizem que existem mais de 365 formas de prepará-lo.',
                    'Portugal é o maior produtor de cortiça do mundo.'
                ],
                'geography' => [
                    'O Ponto mais ocidental da Europa continental fica no Cabo da Roca, em Portugal.',
                    'A Serra da Estrela possui o ponto mais alto de Portugal continental.',
                    'O arquipélago dos Açores é de origem vulcânica e fica no meio do Atlântico.',
                    'O Rio Tejo é o rio mais longo da Península Ibérica.',
                    'Portugal possui uma das maiores zonas econômicas exclusivas marítimas da Europa.'
                ],
                'fauna' => [
                    'O Lince-ibérico é um dos felinos mais raros do mundo e vive nas serras portuguesas.',
                    'O Lobo-ibérico ainda pode ser encontrado no norte de Portugal.',
                    'A Águia-imperial-ibérica nidifica em zonas de sobreiro e azinheiro.',
                    'O Garrano é uma raça de cavalo selvagem que habita o Parque Nacional da Peneda-Gerês.',
                    'O Cão de Água Português era usado por pescadores para recuperar redes e mensagens.'
                ],
                'flora' => [
                    'O Sobreiro, árvore da cortiça, é a árvore nacional de Portugal.',
                    'As Oliveiras em Portugal podem viver milhares de anos.',
                    'A Laurissilva da Madeira é uma floresta pré-histórica única no mundo.',
                    'O Pinheiro-bravo foi amplamente plantado para proteger dunas e fornecer madeira.',
                    'A Amendoeira em flor é uma visão deslumbrante no Algarve durante o inverno.'
                ]
            ],
            'Brasil' => [
                'history' => [
                    'O Brasil foi "descoberto" pelos portugueses em 1500, liderados por Pedro Álvares Cabral.',
                    'A Independência do Brasil foi declarada em 7 de setembro de 1822 por Dom Pedro I.',
                    'O Brasil foi o último país das Américas a abolir a escravidão, em 1888.',
                    'A capital foi transferida do Rio de Janeiro para Brasília em 1960.',
                    'Getúlio Vargas foi o presidente que governou o Brasil por mais tempo (15 anos seguidos).'
                ],
                'culture' => [
                    'O Samba é o gênero musical mais famoso, ícone do Carnaval brasileiro.',
                    'A Capoeira é uma arte marcial brasileira com raízes africanas.',
                    'O churrasco gaúcho é uma das tradições culinárias mais fortes do sul do país.',
                    'A festa de Iemanjá em 2 de fevereiro é uma das maiores celebrações religiosas.',
                    'O drible é considerado uma arte no futebol brasileiro, onde o país é pentacampeão.'
                ],
                'geography' => [
                    'O Brasil é o maior país da América Latina e o quinto maior do mundo.',
                    'A Floresta Amazônica é a maior floresta tropical do planeta.',
                    'O Rio Amazonas disputa o título de rio mais longo do mundo.',
                    'O Pantanal é a maior planície alagada contínua do mundo.',
                    'O litoral brasileiro tem mais de 7.400 km de extensão.'
                ],
                'fauna' => [
                    'A Onça-pintada é o maior felino das Américas e símbolo da biodiversidade brasileira.',
                    'O Mico-leão-dourado é uma espécie endêmica da Mata Atlântica.',
                    'A Arara-azul-de-lear é uma das aves mais raras e bonitas do país.',
                    'O Boto-cor-de-rosa vive nos rios da Amazônia e faz parte do folclore local.',
                    'O Tamanduá-bandeira é um dos animais mais curiosos do Cerrado.'
                ],
                'flora' => [
                    'O Pau-brasil deu nome ao país e era muito cobiçado por seu corante tinto.',
                    'O Ipê-amarelo é considerado a flor nacional do Brasil.',
                    'A Vitória-régia é uma planta aquática gigante típica da Amazônia.',
                    'A Castanheira-do-Pará pode atingir 50 metros de altura.',
                    'O Mandacaru é um cacto heróico que resiste às secas do Sertão.'
                ]
            ]
            // Adicionarei mais dados simplificados para os outros países no loop abaixo
        ];

        if (isset($data[$countryName][$type][$index - 1])) {
            return $data[$countryName][$type][$index - 1];
        }

        return "Curiosidade de {$type} sobre {$countryName} número {$index}: Este país possui uma riquíssima herança de {$type} que encanta visitantes do mundo todo.";
    }
}
