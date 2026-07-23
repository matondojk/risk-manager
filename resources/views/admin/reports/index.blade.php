<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Módulo de Relatórios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Gerador de Relatórios Customizados</h3>
                        <p class="text-sm text-gray-500">Selecione os filtros abaixo para extrair a informação em formato PDF ou Excel.</p>
                    </div>

                    <form action="{{ route('reports.generate') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-100">
                            
                            <!-- Departamento -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Departamento</label>
                                <select name="department_id" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Todos os Departamentos</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Categoria -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Categoria de Risco</label>
                                <select name="category_id" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Todas as Categorias</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Estado</label>
                                <select name="status" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Qualquer Estado</option>
                                    <option value="Identificado">Identificado</option>
                                    <option value="Em Avaliação">Em Avaliação</option>
                                    <option value="Mitigado">Mitigado</option>
                                    <option value="Aceite">Aceite</option>
                                </select>
                            </div>

                            <!-- Nível -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-1">Nível de Risco (Inerente)</label>
                                <select name="inherent_level" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Qualquer Nível</option>
                                    <option value="Crítico">Crítico</option>
                                    <option value="Alto">Alto</option>
                                    <option value="Médio">Médio</option>
                                    <option value="Baixo">Baixo</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-end pt-4 border-t border-gray-100">
                            
                            <button type="submit" name="format" value="pdf" class="flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Gerar PDF
                            </button>

                            <button type="submit" name="format" value="excel" class="flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Exportar para Excel
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
