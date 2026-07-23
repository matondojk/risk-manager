<div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Matriz -->
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Matriz de Risco (Inerente)</h3>
            <div class="relative pt-6 pl-6">
                <!-- Eixo Y (Probabilidade) -->
                <div class="absolute left-0 top-6 bottom-0 w-6 flex flex-col justify-between items-center text-xs text-gray-500 font-medium pb-8">
                    <span>5</span><span>4</span><span>3</span><span>2</span><span>1</span>
                </div>
                <div class="absolute -left-6 top-1/2 -translate-y-1/2 -rotate-90 text-sm font-semibold text-gray-600 tracking-widest">
                    PROBABILIDADE
                </div>

                <div class="grid grid-rows-5 gap-1">
                    @for ($p = 5; $p >= 1; $p--)
                        <div class="grid grid-cols-5 gap-1 h-16">
                            @for ($i = 1; $i <= 5; $i++)
                                <button 
                                    wire:click="selectCell({{ $p }}, {{ $i }})"
                                    class="{{ $matrix[$p][$i]['color'] }} hover:opacity-80 transition-opacity flex items-center justify-center rounded text-white font-bold text-lg shadow-inner
                                    {{ $selectedCell === "P{$p} x I{$i}" ? 'ring-4 ring-offset-2 ring-blue-500' : '' }}"
                                >
                                    {{ $matrix[$p][$i]['count'] > 0 ? $matrix[$p][$i]['count'] : '' }}
                                </button>
                            @endfor
                        </div>
                    @endfor
                </div>

                <!-- Eixo X (Impacto) -->
                <div class="flex justify-between items-center text-xs text-gray-500 font-medium mt-2 px-6">
                    <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                </div>
                <div class="text-center mt-2 text-sm font-semibold text-gray-600 tracking-widest">
                    IMPACTO
                </div>
            </div>
        </div>

        <!-- Detalhes da Célula Selecionada -->
        <div class="flex-1 bg-gray-50 p-6 rounded-lg border border-gray-200">
            @if($selectedCell)
                <div class="mb-4">
                    <h4 class="text-xl font-bold text-gray-800">Célula {{ $selectedCell }}</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800 mt-2">
                        Risco {{ $selectedLevel }}
                    </span>
                </div>
                
                @if(count($selectedRisks) > 0)
                    <div class="space-y-3 mt-4">
                        @foreach($selectedRisks as $risk)
                            <div class="bg-white p-4 rounded shadow-sm border-l-4 
                                {{ $selectedLevel === 'Baixo' ? 'border-green-500' : 
                                  ($selectedLevel === 'Médio' ? 'border-yellow-400' : 
                                  ($selectedLevel === 'Alto' ? 'border-orange-500' : 'border-red-600')) }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-semibold text-blue-600">{{ $risk->code }}</p>
                                        <p class="text-gray-800 font-medium">{{ $risk->description }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $risk->status }}</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $risk->owner->name ?? 'Sem responsável' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic mt-4">Nenhum risco classificado nesta célula.</p>
                @endif
            @else
                <div class="h-full flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    <p>Clique numa célula da matriz para ver os riscos correspondentes.</p>
                </div>
            @endif
        </div>

    </div>
</div>
