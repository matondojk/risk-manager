<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Planos de Ação (5W2H)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Lista Geral de Planos de Ação</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Acompanhamento e controlo das medidas de mitigação.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-gray-500 dark:text-gray-400">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm border-b border-gray-200 dark:border-gray-700">
                                <th class="p-4 font-semibold">O Quê (What)</th>
                                <th class="p-4 font-semibold">Quem (Who)</th>
                                <th class="p-4 font-semibold">Quando (When)</th>
                                <th class="p-4 font-semibold">Risco Associado</th>
                                <th class="p-4 font-semibold text-center">Custo (How Much)</th>
                                <th class="p-4 font-semibold text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 dark:text-gray-300 divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($actionPlans as $plan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="p-4 font-medium text-gray-800 dark:text-gray-200">{{ $plan->what }}</td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ substr($plan->who->name ?? '?', 0, 1) }}
                                            </div>
                                            {{ $plan->who->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        {{ \Carbon\Carbon::parse($plan->when_date)->format('d/m/Y') }}
                                        @if($plan->status !== 'Concluído' && \Carbon\Carbon::parse($plan->when_date)->isPast())
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">Atrasado</span>
                                        @endif
                                    </td>
                                    <td class="p-4"><a href="{{ route('risks.show', $plan->risk_id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $plan->risk->code ?? 'N/A' }}</a></td>
                                    <td class="p-4 text-center">{{ number_format($plan->how_much, 2, ',', '.') }} Kz</td>
                                    <td class="p-4 text-center">
                                        @php
                                            $badgeClass = match($plan->status) {
                                                'Concluído' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'Em Andamento' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                'Não Iniciado' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                                'Atrasado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                            {{ $plan->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                        Nenhum plano de ação encontrado no sistema.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($actionPlans->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                        {{ $actionPlans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
