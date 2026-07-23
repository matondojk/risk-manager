<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Inventário de Riscos') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('risks.export.pdf') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-md font-medium text-sm text-gray-900 dark:text-gray-50 shadow-sm hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Exportar PDF
                </a>
                <a href="{{ route('risks.export.excel') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-md font-medium text-sm text-gray-900 dark:text-gray-50 shadow-sm hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Exportar Excel
                </a>
                <a href="{{ route('risks.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 dark:bg-gray-50 border border-transparent rounded-md font-medium text-sm text-white dark:text-gray-900 shadow hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                    + Novo Risco
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-sm sm:rounded-lg overflow-x-auto border border-gray-100 dark:border-gray-800">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Código</th>
                            <th scope="col" class="px-6 py-3">Processo</th>
                            <th scope="col" class="px-6 py-3">Categoria</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Nível Inerente</th>
                            <th scope="col" class="px-6 py-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Risk::with('category')->get() as $risk)
                            <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">{{ $risk->code }}</td>
                                <td class="px-6 py-4 font-medium">{{ $risk->process }}</td>
                                <td class="px-6 py-4">{{ $risk->category->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $risk->status }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'Baixo' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'Médio' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'Alto' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                                            'Crítico' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                        $color = $colors[$risk->inherent_level] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $color }}">
                                        {{ $risk->inherent_level }} ({{ $risk->inherent_score }})
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex gap-4">
                                    <a href="{{ route('risks.show', $risk) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold hover:underline">Detalhes</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">Nenhum risco registado. Comece por adicionar um "Novo Risco".</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
