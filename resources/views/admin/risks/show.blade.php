<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Risco: ') }} <span class="text-blue-600">{{ $risk->code }}</span>
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('risks.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">Voltar</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Detalhes do Risco -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-100">
                <div class="bg-gray-50 border-b border-gray-200 p-4 px-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Ficha do Risco</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 text-sm">
                    <div><span class="font-bold text-gray-700 uppercase text-xs block mb-1">Processo</span> <span class="text-gray-900 text-base">{{ $risk->process }}</span></div>
                    <div><span class="font-bold text-gray-700 uppercase text-xs block mb-1">Status</span> <span class="px-2 py-1 bg-gray-100 rounded text-gray-700 font-semibold">{{ $risk->status }}</span></div>
                    <div><span class="font-bold text-gray-700 uppercase text-xs block mb-1">Categoria</span> <span class="text-gray-900">{{ $risk->category->name ?? '-' }}</span></div>
                    <div><span class="font-bold text-gray-700 uppercase text-xs block mb-1">Departamento</span> <span class="text-gray-900">{{ $risk->department->name ?? '-' }}</span></div>
                    <div><span class="font-bold text-gray-700 uppercase text-xs block mb-1">Origem</span> <span class="text-gray-900">{{ $risk->origin }}</span></div>
                    <div><span class="font-bold text-gray-700 uppercase text-xs block mb-1">Responsável</span> <span class="text-gray-900">{{ $risk->owner->name ?? '-' }}</span></div>
                    
                    <div class="md:col-span-2 mt-2 p-4 bg-gray-50 rounded-lg">
                        <span class="font-bold text-gray-700 uppercase text-xs block mb-1">Descrição do Risco</span>
                        <p class="text-gray-900 text-base leading-relaxed">{{ $risk->description }}</p>
                    </div>

                    <div class="p-4 border border-red-100 bg-red-50 rounded-lg">
                        <span class="font-bold text-red-800 uppercase text-xs block mb-1">Causas</span>
                        <p class="text-gray-900">{{ $risk->cause }}</p>
                    </div>

                    <div class="p-4 border border-orange-100 bg-orange-50 rounded-lg">
                        <span class="font-bold text-orange-800 uppercase text-xs block mb-1">Consequências</span>
                        <p class="text-gray-900">{{ $risk->consequence }}</p>
                    </div>
                </div>

                <!-- Avaliações -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 p-6 pt-0 text-sm">
                    <div class="p-5 border border-gray-200 rounded-xl bg-white shadow-sm">
                        <span class="font-bold text-gray-800 uppercase text-sm block mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Risco Inerente
                        </span>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Probabilidade</span>
                            <span class="font-bold text-lg">{{ $risk->inherent_probability }} / 5</span>
                        </div>
                        <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
                            <span class="text-gray-600">Impacto</span>
                            <span class="font-bold text-lg">{{ $risk->inherent_impact }} / 5</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-semibold">Classificação</span>
                            @php
                                $colors = [
                                    'Baixo' => 'bg-green-100 text-green-800',
                                    'Médio' => 'bg-yellow-100 text-yellow-800',
                                    'Alto' => 'bg-orange-100 text-orange-800',
                                    'Crítico' => 'bg-red-100 text-red-800',
                                ];
                                $color = $colors[$risk->inherent_level] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-black uppercase {{ $color }}">
                                {{ $risk->inherent_level }} ({{ $risk->inherent_score }})
                            </span>
                        </div>
                    </div>

                    <div class="p-5 border border-gray-200 rounded-xl bg-white shadow-sm">
                        <span class="font-bold text-gray-800 uppercase text-sm block mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Risco Residual (Pós-Mitigação)
                        </span>
                        @if($risk->residual_probability)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Probabilidade</span>
                                <span class="font-bold text-lg">{{ $risk->residual_probability }} / 5</span>
                            </div>
                            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
                                <span class="text-gray-600">Impacto</span>
                                <span class="font-bold text-lg">{{ $risk->residual_impact }} / 5</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-semibold">Classificação</span>
                                @php
                                    $res_color = $colors[$risk->residual_level] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-black uppercase {{ $res_color }}">
                                    {{ $risk->residual_level }} ({{ $risk->residual_score }})
                                </span>
                            </div>
                        @else
                            <div class="h-full flex flex-col justify-center items-center text-center pb-6">
                                <p class="text-gray-400 italic mb-2">Avaliação residual ainda não efetuada.</p>
                                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Aguardando planos de ação</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Planos de Ação (5W2H) -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-100">
                <div class="bg-gray-50 border-b border-gray-200 p-4 px-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Planos de Ação (Metodologia 5W2H)
                    </h3>
                    <a href="{{ route('action-plans.create', ['risk_id' => $risk->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-bold uppercase tracking-wide hover:bg-blue-700 shadow-sm transition">
                        + Adicionar Plano
                    </a>
                </div>
                
                @if($risk->actionPlans->count() > 0)
                    <div class="overflow-x-auto p-0">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-4">O Quê (What)</th>
                                    <th class="px-6 py-4">Quem (Who)</th>
                                    <th class="px-6 py-4">Quando (When)</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($risk->actionPlans as $plan)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-900">{{ $plan->what }}</td>
                                        <td class="px-6 py-4">{{ $plan->who->name ?? '-' }}</td>
                                        <td class="px-6 py-4 font-medium">{{ $plan->when_date ? \Carbon\Carbon::parse($plan->when_date)->format('d/m/Y') : '-' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded text-xs font-bold">{{ $plan->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <p class="text-gray-500 text-lg font-medium">Nenhum plano de ação (5W2H) estabelecido.</p>
                        <p class="text-gray-400 mt-1">Crie planos de mitigação para reduzir o risco residual.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
