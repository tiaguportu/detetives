<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountryFlagSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'portugal' => 'pt',
            'brasil' => 'br',
            'japao' => 'jp',
            'egito' => 'eg',
            'italia' => 'it',
            'franca' => 'fr',
            'eua' => 'us',
            'china' => 'cn',
            'alemanha' => 'de',
            'mexico' => 'mx',
            'peru' => 'pe',
            'inglaterra' => 'gb', // Usando Reino Unido para simplificar
            'india' => 'in',
            'australia' => 'au',
            'russia' => 'ru',
            'argentina' => 'ar',
            'espanha' => 'es',
            'canada' => 'ca',
            'grecia' => 'gr',
            'turquia' => 'tr',
            'tailandia' => 'th',
            'holanda' => 'nl',
            'suica' => 'ch',
            'africa-sul' => 'za',
            'chile' => 'cl',
            'colombia' => 'co',
        ];

        foreach ($mapping as $slug => $code) {
            $country = Country::where('slug', $slug)->first();
            if ($country) {
                $this->command->info("Baixando bandeira para: {$country->name}...");
                
                try {
                    // API da flagcdn.com (geralmente estável e gratuita)
                    $url = "https://flagcdn.com/w320/{$code}.png";
                    $response = Http::get($url);

                    if ($response->successful()) {
                        $filename = "flags/{$slug}.png";
                        Storage::disk('public')->put($filename, $response->body());
                        
                        $country->update(['flag_path' => $filename]);
                        $this->command->info("Sucesso!");
                    } else {
                        $this->command->error("Falha ao baixar bandeira para {$country->name} (Status: {$response->status()})");
                    }
                } catch (\Exception $e) {
                    $this->command->error("Erro ao processar {$country->name}: " . $e->getMessage());
                }
            }
        }
    }
}
