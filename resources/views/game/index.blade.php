<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detetives do Porto - Transmissão Urgente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #050505;
            color: #00ff41;
            font-family: 'Courier Prime', monospace;
            overflow-x: hidden;
        }
        .glass-card {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 255, 65, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
        }
        .scanline {
            width: 100%;
            height: 2px;
            background: rgba(0, 255, 65, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            pointer-events: none;
            animation: scanline 6s linear infinite;
        }
        @keyframes scanline {
            0% { top: -2px; }
            100% { top: 100%; }
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" x-data="{ state: 'intro' }">
    <div class="scanline"></div>

    <div class="relative w-full max-w-6xl" x-cloak>
        
        <!-- INTRO STORY OVERLAY -->
        <div x-show="state === 'intro'" 
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="flex flex-col items-center text-center space-y-12 py-12">
            
            <div class="px-6 py-2 border-2 border-red-500 text-red-500 animate-pulse text-sm font-bold uppercase tracking-[0.5em]">
                Sinal de Alerta Recebido: Código Vermelho
            </div>
            
            <h1 class="text-6xl font-black text-white tracking-widest uppercase italic">
                O Caso Tom Riddle
            </h1>

            <div class="max-w-xl mx-auto space-y-10 text-xl md:text-2xl leading-relaxed text-[#00ff41] font-bold px-6 break-words text-left">
                <p x-init="
                    const text = 'Atenção, Agente. O infame Tom Riddle atacou novamente. Informantes confirmam que ele {{ $currentVillany }}';
                    let i = 0;
                    const el = $el;
                    el.textContent = '';
                    const timer = setInterval(() => {
                        if(i < text.length) {
                            el.textContent += text.charAt(i);
                            i++;
                        } else {
                            clearInterval(timer);
                        }
                    }, 40);
                "></p>
                <p class="text-white pt-10 opacity-0 animate-[fadeIn_0.5s_ease-in_forwards_4s] text-center italic">
                    Ele foi visto fugindo para o aeroporto internacional. <br>
                    Precisamos de um especialista para assumir a caçada imediatamente.
                </p>
            </div>

            <button @click="state = 'choosing'" 
                    class="mt-12 group relative bg-[#00ff41] text-black font-black px-16 py-6 rounded-lg text-3xl uppercase tracking-widest hover:shadow-[0_0_60px_rgba(0,255,65,0.6)] transition-all">
                Assumir Investigação
            </button>
        </div>

        <!-- INVESTIGATOR SELECTION -->
        <div x-show="state === 'choosing'"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="transform scale-90 opacity-0"
             x-transition:enter-end="transform scale-100 opacity-100">
            
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold bg-[#00ff41] text-black inline-block px-10 py-3 transform -skew-x-12 mb-4 uppercase">Dossiê de Agentes Disponíveis</h2>
                <p class="text-[#00ff41]/60 uppercase tracking-[0.6em] text-xs">Selecione o perfil adequado para a missão</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($investigators as $i)
                    <div class="glass-card group hover:border-[#00ff41] transition-all p-8 text-center flex flex-col items-center rounded-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-2 text-[10px] bg-[#00ff41]/10 text-[#00ff41]">LVL: {{ $i->countries_count }}</div>
                        
                        <div class="w-28 h-28 border-2 border-[#00ff41]/30 group-hover:border-[#00ff41] rounded-full overflow-hidden mb-8 bg-black shadow-[0_0_20px_rgba(0,255,65,0.1)]">
                            <img src="{{ str_contains($i->avatar_path, 'http') ? $i->avatar_path : asset('storage/' . $i->avatar_path) }}" alt="{{ $i->name }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                        </div>
                        
                        <h3 class="text-2xl font-black text-white mb-3 tracking-widest uppercase">{{ $i->name }}</h3>
                        <p class="text-xs text-[#00ff41]/70 mb-8 h-16 flex-grow overflow-hidden font-bold">"{{ $i->description }}"</p>
                        
                        <div class="w-full bg-[#00ff41]/5 p-4 rounded-xl border border-[#00ff41]/10 mb-8">
                            <span class="text-[10px] tracking-widest opacity-60">DISTÂNCIA DA PERSEGUIÇÃO:</span>
                            <div class="flex justify-center gap-1.5 mt-2">
                                @for($j=0; $j < ($i->countries_count / 2); $j++)
                                    <div class="w-5 h-1.5 bg-[#00ff41] rounded-full"></div>
                                @endfor
                            </div>
                        </div>

                        <form action="{{ route('game.start', $i->id) }}" method="GET" class="w-full">
                            <button type="submit" class="w-full py-4 bg-transparent border-2 border-[#00ff41] text-[#00ff41] hover:bg-[#00ff41] hover:text-black font-black transition-all uppercase tracking-widest rounded-lg">
                                DESIGNAR
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</body>
</html>
