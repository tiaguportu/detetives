<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investigação em Curso - {{ $currentCountry->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body {
            background-color: #050505;
            color: #00ff41;
            font-family: 'Courier+Prime', monospace;
            overflow: hidden; /* Garantir que não haja scroll na página */
            height: 100vh;
        }
        .pda-screen {
            background: #000;
            border: 12px solid #1a1a1a;
            border-radius: 40px;
            box-shadow: inset 0 0 50px rgba(0, 255, 65, 0.05), 0 20px 60px rgba(0,0,0,0.9);
            height: 100vh; /* Ocupar toda a tela visível */
            width: 100vw;
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .flight-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.8s ease-in-out;
            backdrop-filter: blur(10px);
        }
        .radar-window {
            width: 1000px;
            height: 500px;
            background: #000;
            border: 2px solid #00ff41;
            box-shadow: 0 0 50px rgba(0, 255, 65, 0.2);
            position: relative;
            overflow: hidden;
            border-radius: 12px;
        }
        .flight-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        #satellite-map {
            position: absolute;
            inset: 0;
            z-index: 1;
            filter: brightness(0.7) contrast(1.2) hue-rotate(80deg) saturate(1.5);
            opacity: 0.6;
        }
        .world-map {
            width: 100%;
            height: 100%;
            fill: none;
            stroke: #00ff41;
            stroke-width: 0.5;
            transition: transform 3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center center;
            position: relative;
            z-index: 2;
        }
        .map-point {
            fill: #00ff41;
            filter: drop-shadow(0 0 5px #00ff41);
        }
        .flight-path {
            fill: none;
            stroke: #00ff41;
            stroke-width: 2;
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            stroke-linecap: round;
            filter: drop-shadow(0 0 8px #00ff41);
        }
        .flight-overlay.active .flight-path {
            animation: drawPath 3.5s forwards cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes drawPath {
            to { stroke-dashoffset: 0; }
        }

        .glass-panel {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 65, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
        }

        /* Novas Animações para Informante */
        .informant-bg-zoom {
            position: absolute;
            inset: 0;
            z-index: 1;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(0.6);
            transition: all 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .informant-bg-zoom.active {
            opacity: 0.5;
            transform: scale(1.1);
        }

        .informant-character {
            position: absolute;
            bottom: -100%;
            left: -100px;
            height: 50%; /* Reduzido para 50% conforme solicitado */
            z-index: 5;
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            filter: drop-shadow(0 0 30px rgba(0,0,0,0.8));
            pointer-events: none;
            transform-origin: bottom left;
        }

        .informant-character.active {
            bottom: 0;
            left: 0;
            margin: 0;
            padding: 0;
        }

        .comic-bubble {
            position: absolute;
            bottom: 45%;
            left: 32%;
            background: white;
            border: 4px solid black;
            padding: 1.5rem;
            border-radius: 30px;
            color: black;
            font-family: 'Courier Prime', monospace;
            font-weight: 800;
            width: auto;
            max-width: 60%;
            max-height: 48%; /* Leve aumento para dar mais fôlego */
            display: flex;
            flex-direction: column;
            z-index: 10;
            opacity: 0;
            transform: scale(0) rotate(-2deg);
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 12px 12px 0 rgba(0,0,0,0.3);
            overflow: visible; /* Sem barras de rolagem */
        }

        .comic-bubble::after {
            content: '';
            position: absolute;
            bottom: -22px;
            left: 45px;
            border-width: 22px 22px 0 0;
            border-style: solid;
            border-color: white transparent transparent transparent;
        }

        .comic-bubble::before {
            content: '';
            position: absolute;
            bottom: -32px;
            left: 41px;
            border-width: 28px 28px 0 0;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }

        .comic-bubble.active {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        /* Label Estilo Reportagem */
        .news-label {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: #ff0000;
            color: white;
            padding: 8px 20px;
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-left: 8px solid #000;
            box-shadow: 8px 8px 0 rgba(0,0,0,0.4);
            z-index: 100;
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.5s ease-out 0.8s; /* Aparece com delay após o informante subir */
        }

        .news-label.active {
            opacity: 1;
            transform: translateX(0);
        }

        .slide-in {
            animation: slideIn 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .slide-out {
            animation: slideOut 0.6s ease-in forwards;
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #000; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #00ff41; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" 
      x-data="{ 
        isFlying: false, 
        showInformant: false, 
        informantActive: false,
        travelingTo: '',
        destX: 0,
        destY: 0,
        destLat: 0,
        destLng: 0,
        origX: {{ $currentCountry->coord_x ?? 50 }},
        origY: {{ $currentCountry->coord_y ?? 50 }},
        origLat: {{ $currentCountry->latitude ?? 0 }},
        origLng: {{ $currentCountry->longitude ?? 0 }},
        leafletMap: null,
        
        initMap() {
            this.leafletMap = L.map('satellite-map', {
                zoomControl: false,
                attributionControl: false,
                dragging: false,
                scrollWheelZoom: false,
                doubleClickZoom: false
            }).setView([20, 0], 2);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 18
            }).addTo(this.leafletMap);
        },

        startFlight(name, x, y, lat, lng) {
            this.travelingTo = name;
            this.destX = parseFloat(x);
            this.destY = parseFloat(y);
            this.destLat = parseFloat(lat);
            this.destLng = parseFloat(lng);
            this.isFlying = true;

            if (!this.leafletMap) this.initMap();

            // O zoom permanece fixo no mapa-múndi
            this.leafletMap.setView([20, 0], 2);
        },

        get mapStyle() {
            return 'transform: scale(1)';
        }
      }">

    <!-- Flight Overlay -->
    <div class="flight-overlay" :class="{ 'active': isFlying }" x-init="initMap()">
        <div class="absolute top-8 w-full text-center z-10 pointer-events-none">
            <div class="text-3xl uppercase tracking-[0.5em] text-[#00ff41] font-black mb-2">Transição de Setor</div>
            <div class="text-sm font-bold flex justify-center items-center gap-8">
                <span class="text-white tracking-widest">{{ $currentCountry->name }}</span>
                <img src="{{ asset('images/airplane.png') }}" class="w-8 h-8 rotate-90 brightness-200">
                <span x-text="travelingTo" class="text-white tracking-widest"></span>
            </div>
        </div>

        <div class="radar-window">
            <div id="satellite-map"></div>
            
            <svg viewBox="0 0 1000 500" class="world-map" :style="mapStyle">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#00ff41" stroke-width="0.2" opacity="0.1" />
                    </pattern>
                </defs>
                <rect width="1000" height="500" fill="url(#grid)" />

                <!-- Americas -->
                <path d="M150,100 Q100,200 180,300 T250,450" fill="none" stroke="#00ff41" stroke-width="0.5" opacity="0.3" />
                <!-- Eurasia/Africa -->
                <path d="M450,100 Q600,50 750,150 T800,400" fill="none" stroke="#00ff41" stroke-width="0.5" opacity="0.3" />
                
                <circle :cx="origX * 10" :cy="origY * 5" r="4" class="map-point" />
                <circle x-show="isFlying" :cx="destX * 10" :cy="destY * 5" r="4" class="map-point" />

                <path x-show="isFlying" 
                      :d="`M ${origX * 10} ${origY * 5} L ${destX * 10} ${destY * 5}`" 
                      class="flight-path" id="flightPath" />
            </svg>

            <div x-show="isFlying" class="absolute z-50 w-16 h-16" 
                 :style="`offset-path: path('M ${origX * 10} ${origY * 5} L ${destX * 10} ${destY * 5}'); offset-distance: 0%; animation: followPath 3.5s forwards cubic-bezier(0.4, 0, 0.2, 1); offset-rotate: auto 90deg;`"
                 style="filter: drop-shadow(0 0 10px #00ff41);">
                <img src="{{ asset('images/airplane.png') }}" class="w-full h-full object-contain">
            </div>
            
            <div class="absolute bottom-4 w-full text-center text-[10px] tracking-[1em] text-[#00ff41]/60 z-10 font-bold">
                RADAR ATIVO | SETOR: [[ {{ strtoupper(Str::random(4)) }} ]] | GPS LOCK: CONFIRMADO
            </div>
        </div>

        <style>
            @keyframes followPath {
                from { offset-distance: 0%; }
                to { offset-distance: 100%; }
            }
        </style>
    </div>

    <div class="pda-screen p-8 flex flex-col" x-data="{ currentTab: 'main' }">
        <div class="scanline"></div>

        <!-- Header -->
        <div class="flex justify-between items-center border-b border-[#00ff41]/50 pb-6 mb-6">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 border-2 border-[#00ff41] rounded-full overflow-hidden bg-black shrink-0">
                    <img src="{{ str_contains($game->investigator->avatar_path, 'http') ? $game->investigator->avatar_path : asset('storage/' . $game->investigator->avatar_path) }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-2xl font-bold uppercase tracking-widest text-white">Agente: {{ $game->investigator->name }}</h1>
                    <p class="text-[10px] text-[#00ff41]/60 tracking-widest uppercase">Missão: Perseguição Internacional | Status: {{ strtoupper($game->status) }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xl">Passo: {{ $game->current_step }} / {{ $game->total_steps }}</p>
                <div class="w-48 h-2 bg-gray-800 border border-[#00ff41]">
                    <div class="h-full bg-[#00ff41]" style="width: {{ ($game->current_step / $game->total_steps) * 100 }}%"></div>
                </div>
            </div>
        </div>

        @if(session('message'))
            <div class="bg-green-900 text-green-200 p-4 mb-4 border border-green-500 animate-pulse">
                {{ session('message') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-900 text-red-200 p-4 mb-4 border border-red-500 animate-pulse">
                {{ session('error') }}
            </div>
        @endif

        @if($game->status === 'won')
            <div class="flex-grow flex items-center justify-center relative overflow-hidden">
                <div class="scanline"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 w-full max-w-6xl items-center">
                    
                    <!-- Left: Success Text & Actions -->
                    <div class="space-y-8 text-left order-2 md:order-1">
                        <div class="px-6 py-2 bg-red-600 text-white font-black text-xl uppercase tracking-[0.4em] animate-pulse inline-block rounded-full shadow-[0_0_40px_rgba(220,38,38,0.3)]">
                            ALERTA: VILÃO CAPTURADO
                        </div>

                        <div class="space-y-4">
                            <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-widest leading-none">Missão<br>Cumprida!</h2>
                            <p class="text-sm md:text-base text-[#00ff41]/80 max-w-md leading-relaxed">O gênio do crime Tom Riddle foi interceptado. Seus esforços garantiram a segurança dos artefatos globais e a paz mundial foi restaurada.</p>
                        </div>

                        <div class="flex flex-col gap-4">
                            <a href="{{ route('game.start', $game->investigator_id) }}" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-xl font-black text-black rounded-lg group bg-[#00ff41] hover:shadow-[0_0_40px_rgba(0,255,65,0.6)] transition-all px-10 py-5 uppercase tracking-[0.2em]">
                                Reiniciar Missão
                            </a>

                            <a href="{{ route('home') }}" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-xl font-black text-[#00ff41] border-2 border-[#00ff41] rounded-lg group hover:bg-[#00ff41] hover:text-black transition-all px-10 py-5 uppercase tracking-[0.2em]">
                                Finalizar Dossiê
                            </a>
                        </div>
                    </div>

                    <!-- Right: Villain Picture -->
                    <div class="flex justify-center order-1 md:order-2">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-yellow-600 rounded-2xl blur opacity-20 group-hover:opacity-100 transition duration-1000"></div>
                            <div class="relative w-[300px] h-[300px] md:w-[450px] md:h-[450px] border-4 border-red-600 rounded-2xl overflow-hidden glass-panel rotate-3 hover:rotate-0 transition-transform duration-500 shadow-[0_0_60px_rgba(220,38,38,0.2)]">
                                <img src="{{ asset('images/tom_riddle_captured.png') }}" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 w-full bg-black/80 p-4 border-t-2 border-red-500">
                                    <p class="text-xl font-black text-red-500 italic tracking-tighter animate-[typeIn_2s_steps(20)_forwards]">
                                        "Eu vou voltar..."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <style>
                @keyframes typeIn {
                    from { width: 0; opacity: 0; }
                    to { width: 100%; opacity: 1; }
                }
            </style>
        @else
            <!-- Main Game Area -->
            <div class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-8 relative overflow-hidden">
                
                <!-- Left: Location Info -->
                <div class="col-span-1 space-y-4 flex flex-col overflow-hidden">
                    <div class="glass-panel p-4 flex-grow flex flex-col rounded-xl overflow-hidden">
                        <h3 class="text-lg font-bold border-b border-[#00ff41] mb-2 uppercase tracking-tighter shrink-0">Local: {{ $currentCountry->name }}</h3>
                        <div class="bg-black border border-[#00ff41]/50 aspect-video mb-4 flex items-center justify-center overflow-hidden rounded-lg shadow-inner relative shrink-0"
                             x-data="{ 
                                images: {{ $currentCountry->images->pluck('image_path')->map(fn($p) => str_contains($p, 'http') ? $p : asset('storage/' . $p)) }},
                                currentIndex: 0
                             }"
                             x-init="if(images.length > 1) setInterval(() => { currentIndex = (currentIndex + 1) % images.length }, 5000)">
                            
                            <template x-for="(img, index) in images" :key="index">
                                <img :src="img" 
                                     x-show="currentIndex === index"
                                     x-transition:enter="transition opacity-100 duration-1000"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:leave="transition opacity-0 duration-1000"
                                     class="absolute inset-0 w-full h-full object-cover">
                            </template>

                            <div x-show="images.length > 1" class="absolute bottom-2 right-2 flex gap-1 z-10">
                                <template x-for="(img, index) in images" :key="index">
                                    <div class="w-1.5 h-1.5 rounded-full border border-[#00ff41]"
                                         :class="currentIndex === index ? 'bg-[#00ff41]' : 'bg-transparent'"></div>
                                </template>
                            </div>

                            <template x-if="images.length === 0">
                                <span class="text-6xl grayscale">🏢</span>
                            </template>
                        </div>
                        <div class="flex-grow overflow-y-auto text-sm space-y-4 pr-2 custom-scrollbar">
                            <p><strong class="text-[#00ff41]/60">CULTURA:</strong> {{ $currentCountry->culture }}</p>
                            <p><strong class="text-[#00ff41]/60">HISTÓRIA:</strong> {{ $currentCountry->history }}</p>
                            <p><strong class="text-[#00ff41]/60">GEOGRAFIA:</strong> {{ $currentCountry->geography }}</p>
                        </div>
                    </div>
                </div>

                <!-- Middle: Interaction Area -->
                <div class="col-span-1 flex flex-col space-y-4 overflow-hidden">
                    <div class="glass-panel p-6 flex-grow relative overflow-hidden rounded-xl">
                        <h3 class="text-lg font-bold border-b border-[#00ff41] mb-6 uppercase shrink-0">Investigar</h3>
                        
                        <div class="flex flex-col items-center justify-center h-full space-y-6" x-show="!showInformant">
                            <button @click="showInformant = true; 
                                            setTimeout(() => { informantActive = true }, 100);" 
                                    class="w-full py-8 border-2 border-dashed border-[#00ff41]/40 hover:border-[#00ff41] hover:bg-[#00ff41]/5 transition flex flex-col items-center rounded-xl">
                                <span class="text-4xl mb-4">🕵️‍♂️</span>
                                <span class="uppercase font-bold">Procurar Informante</span>
                            </button>
                        </div>

                        <!-- Informant Panel (Animated Transition) -->
                        <div x-show="showInformant" 
                             class="absolute inset-0 bg-black z-20 flex flex-col pointer-events-auto">
                            
                            <!-- Background Country Zoom -->
                            <div class="informant-bg-zoom" 
                                 :class="{ 'active': informantActive }"
                                 style="background-image: url('{{ $currentCountry->images->first()?->image_path ? (str_contains($currentCountry->images->first()->image_path, 'http') ? $currentCountry->images->first()->image_path : asset('storage/' . $currentCountry->images->first()->image_path)) : asset('images/default_country.jpg') }}')">
                                <div class="absolute inset-0 bg-black/40"></div>
                            </div>

                            <!-- Close Button (Top Z-Index) -->
                            <div class="absolute top-4 right-4 z-[60]">
                                <button @click="informantActive = false; setTimeout(() => { showInformant = false }, 800)" 
                                        class="bg-red-600 text-white font-bold px-4 py-1 rounded hover:bg-red-700 transition">
                                    VOLTAR [X]
                                </button>
                            </div>

                            <!-- Informant Character Slide In -->
                            <img src="{{ $randomInformant?->image_path ? (str_contains($randomInformant->image_path, 'http') ? $randomInformant->image_path : asset('storage/' . $randomInformant->image_path)) : asset('images/default_informant.png') }}" 
                                 class="informant-character grayscale brightness-110" 
                                 :class="{ 'active': informantActive }">

                            <!-- Comic Speech Bubble -->
                            <div class="comic-bubble" :class="{ 'active': informantActive }">
                                <div class="space-y-4 pr-1"
                                     x-data="{ 
                                        get fontSize() {
                                            const textLength = $el.innerText.length;
                                            if (textLength > 400) return 'text-[0.7rem] leading-tight';
                                            if (textLength > 250) return 'text-sm leading-snug';
                                            return 'text-base';
                                        }
                                     }"
                                     :class="fontSize">
                                    @foreach($clues as $clue)
                                        <p class="italic">"{{ $clue->content }}"</p>
                                    @endforeach
                                </div>
                            </div>

                            <!-- News Label Name (Bottom Right) -->
                            <div class="news-label" :class="{ 'active': informantActive }">
                                {{ $randomInformant?->name ?? 'Informante' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Travel Actions -->
                <div class="col-span-1 flex flex-col space-y-4 overflow-hidden">
                    <div class="glass-panel p-6 flex-grow rounded-xl flex flex-col overflow-hidden">
                        <h3 class="text-lg font-bold border-b border-[#00ff41] mb-4 uppercase shrink-0">Sistemas de Voo</h3>
                        <p class="text-xs mb-6 opacity-60 shrink-0">Selecione as coordenadas do próximo destino:</p>
                        
                        <div class="flex-grow overflow-y-auto custom-scrollbar pr-2 mb-4">
                            <form action="{{ route('game.travel', $game) }}" id="travelForm" method="POST" 
                                  @submit.prevent="
                                    const selected = document.querySelector('input[name=country_id]:checked');
                                    startFlight(
                                        selected.dataset.name, 
                                        selected.dataset.x, 
                                        selected.dataset.y,
                                        selected.dataset.lat,
                                        selected.dataset.lng
                                    );
                                    setTimeout(() => $el.submit(), 4000);
                                  "
                                  class="space-y-3">
                                @csrf
                                @foreach($destinations as $dest)
                                    <label class="block p-4 border border-[#00ff41]/20 hover:border-[#00ff41] hover:bg-[#00ff41]/5 cursor-pointer transition rounded-lg group">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                                                @if($dest->flag_path)
                                                    <img src="{{ asset('storage/' . $dest->flag_path) }}" class="w-8 h-5 object-cover rounded-sm border border-[#00ff41]/30">
                                                @else
                                                    <span class="text-xl">🏳️</span>
                                                @endif
                                                <span class="tracking-widest">{{ $dest->name }}</span>
                                            </div>
                                            <input type="radio" name="country_id" value="{{ $dest->id }}" 
                                                   data-name="{{ $dest->name }}"
                                                   data-x="{{ $dest->coord_x ?? 50 }}" 
                                                   data-y="{{ $dest->coord_y ?? 50 }}" 
                                                   data-lat="{{ $dest->latitude ?? 0 }}"
                                                   data-lng="{{ $dest->longitude ?? 0 }}"
                                                   class="accent-[#00ff41]" required>
                                        </div>
                                    </label>
                                @endforeach
                            </form>
                        </div>
                        
                        <button type="submit" form="travelForm" class="w-full bg-[#00ff41] text-black font-bold py-4 hover:shadow-[0_0_30px_rgba(0,255,65,0.5)] transition uppercase tracking-[0.3em] rounded-lg shrink-0">
                            Iniciar Decolagem
                        </button>
                    </div>
                </div>

            </div>
        @endif

        <!-- Footer / Tabs -->
        <div class="mt-6 border-t border-[#00ff41] pt-4 flex gap-4 text-xs font-bold uppercase">
            <div class="flex-grow">SISTEMA OPERACIONAL DETETIVE v5.0.1</div>
            <div class="flex gap-8">
                <span class="animate-pulse">ONLINE</span>
                <span>GPS: {{ rand(-90, 90) }}.{{ rand(1000, 9999) }}, {{ rand(-180, 180) }}.{{ rand(1000, 9999) }}</span>
            </div>
        </div>
    </div>

</body>
</html>
