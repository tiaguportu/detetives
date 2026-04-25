<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\CountryImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountryImageSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::all();

        foreach ($countries as $country) {
            $this->command->info("Buscando imagem para: {$country->name}...");
            
            // Usando o Unsplash Source redirecionado (funciona para downloads simples)
            // Ou usando o LoremFlickr que é bem estável para seeds
            $keyword = str_replace(' ', ',', $country->name);
            $url = "https://loremflickr.com/1280/720/{$keyword},landmark/all";

            try {
                $response = Http::get($url);

                if ($response->successful()) {
                    $slug = Str::slug($country->name);
                    $filename = "countries/{$slug}_" . time() . ".jpg";
                    
                    Storage::disk('public')->put($filename, $response->body());
                    
                    // Cria o registro na galeria
                    CountryImage::create([
                        'country_id' => $country->id,
                        'image_path' => $filename,
                        'sort_order' => 0
                    ]);

                    $this->command->info("Imagem salva para {$country->name}!");
                } else {
                    $this->command->error("Falha ao baixar imagem para {$country->name}");
                }
            } catch (\Exception $e) {
                $this->command->error("Erro ao processar {$country->name}: " . $e->getMessage());
            }

            // Pequeno delay para evitar rate limit
            usleep(200000); 
        }
    }
}
