<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Registar Novo Risco') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-100">
                    
                    <form action="{{ route('risks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Categoria -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Selecione...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Departamento -->
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700">Departamento</label>
                                <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Selecione...</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Responsável -->
                            <div>
                                <label for="owner_id" class="block text-sm font-medium text-gray-700">Responsável pelo Risco</label>
                                <select name="owner_id" id="owner_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Selecione...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Origem -->
                            <div>
                                <label for="origin" class="block text-sm font-medium text-gray-700">Origem</label>
                                <input type="text" name="origin" id="origin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required placeholder="Ex: Fator Externo, Processo Interno...">
                            </div>

                            <!-- Processo -->
                            <div class="md:col-span-2">
                                <label for="process" class="block text-sm font-medium text-gray-700">Processo / Área de Negócio</label>
                                <input type="text" name="process" id="process" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Descrição -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição do Risco</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                            </div>

                            <!-- Causa e Consequência -->
                            <div>
                                <label for="cause" class="block text-sm font-medium text-gray-700">Causas</label>
                                <textarea name="cause" id="cause" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                            </div>
                            <div>
                                <label for="consequence" class="block text-sm font-medium text-gray-700">Consequências (Impacto)</label>
                                <textarea name="consequence" id="consequence" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                            </div>

                            <!-- Avaliação Inerente -->
                            <div class="bg-gray-50 p-4 rounded-md border border-gray-200 md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                <div class="md:col-span-3">
                                    <h4 class="font-bold text-gray-700 border-b pb-2">Avaliação de Risco Inerente</h4>
                                </div>
                                
                                <div>
                                    <label for="inherent_probability" class="block text-sm font-medium text-gray-700">Probabilidade (1 a 5)</label>
                                    <select name="inherent_probability" id="inherent_probability" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Selecione...</option>
                                        @foreach(range(1,5) as $i) <option value="{{ $i }}">{{ $i }}</option> @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="inherent_impact" class="block text-sm font-medium text-gray-700">Impacto (1 a 5)</label>
                                    <select name="inherent_impact" id="inherent_impact" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Selecione...</option>
                                        @foreach(range(1,5) as $i) <option value="{{ $i }}">{{ $i }}</option> @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Estado Atual</label>
                                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="Identificado" selected>Identificado</option>
                                        <option value="Em Avaliação">Em Avaliação</option>
                                        <option value="Mitigado">Mitigado</option>
                                        <option value="Aceite">Aceite</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-100 gap-3">
                            <a href="{{ route('risks.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold transition shadow-sm">
                                Guardar Risco
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
