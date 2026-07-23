<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Editar Risco: ') }} {{ $risk->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-100">
                    
                    <form action="{{ route('risks.update', $risk) }}" method="POST" class="space-y-6 text-sm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Categoria -->
                            <div>
                                <label for="category_id" class="block font-medium text-gray-700">Categoria</label>
                                <select name="category_id" id="category_id" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $risk->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Departamento -->
                            <div>
                                <label for="department_id" class="block font-medium text-gray-700">Departamento</label>
                                <select name="department_id" id="department_id" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $risk->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Responsável -->
                            <div>
                                <label for="owner_id" class="block font-medium text-gray-700">Responsável</label>
                                <select name="owner_id" id="owner_id" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $risk->owner_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Origem -->
                            <div>
                                <label for="origin" class="block font-medium text-gray-700">Origem</label>
                                <input type="text" name="origin" id="origin" value="{{ $risk->origin }}" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                            </div>

                            <!-- Processo -->
                            <div class="md:col-span-2">
                                <label for="process" class="block font-medium text-gray-700">Processo / Área de Negócio</label>
                                <input type="text" name="process" id="process" value="{{ $risk->process }}" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>
                            </div>

                            <!-- Descrição -->
                            <div class="md:col-span-2">
                                <label for="description" class="block font-medium text-gray-700">Descrição do Risco</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>{{ $risk->description }}</textarea>
                            </div>

                            <!-- Causa e Consequência -->
                            <div>
                                <label for="cause" class="block font-medium text-gray-700">Causas</label>
                                <textarea name="cause" id="cause" rows="3" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>{{ $risk->cause }}</textarea>
                            </div>
                            <div>
                                <label for="consequence" class="block font-medium text-gray-700">Consequências (Impacto)</label>
                                <textarea name="consequence" id="consequence" rows="3" class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring-blue-500" required>{{ $risk->consequence }}</textarea>
                            </div>

                            <!-- Avaliação Inerente -->
                            <div class="bg-gray-50 p-4 rounded-md border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                                <div class="md:col-span-2">
                                    <h4 class="font-bold text-gray-700 border-b pb-2">Avaliação de Risco Inerente</h4>
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-gray-700">Probabilidade (1 a 5)</label>
                                    <select name="inherent_probability" class="mt-1 w-full border-gray-300 rounded shadow-sm" required>
                                        @foreach(range(1,5) as $i) <option value="{{ $i }}" {{ $risk->inherent_probability == $i ? 'selected' : '' }}>{{ $i }}</option> @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-gray-700">Impacto (1 a 5)</label>
                                    <select name="inherent_impact" class="mt-1 w-full border-gray-300 rounded shadow-sm" required>
                                        @foreach(range(1,5) as $i) <option value="{{ $i }}" {{ $risk->inherent_impact == $i ? 'selected' : '' }}>{{ $i }}</option> @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Avaliação Residual -->
                            <div class="bg-blue-50 p-4 rounded-md border border-blue-200 grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                                <div class="md:col-span-2">
                                    <h4 class="font-bold text-blue-800 border-b border-blue-200 pb-2">Avaliação de Risco Residual (Pós-Mitigação)</h4>
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-gray-700">Probabilidade (1 a 5)</label>
                                    <select name="residual_probability" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                                        <option value="">Ainda não avaliado</option>
                                        @foreach(range(1,5) as $i) <option value="{{ $i }}" {{ $risk->residual_probability == $i ? 'selected' : '' }}>{{ $i }}</option> @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-gray-700">Impacto (1 a 5)</label>
                                    <select name="residual_impact" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                                        <option value="">Ainda não avaliado</option>
                                        @foreach(range(1,5) as $i) <option value="{{ $i }}" {{ $risk->residual_impact == $i ? 'selected' : '' }}>{{ $i }}</option> @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label for="status" class="block font-medium text-gray-700">Estado Atual</label>
                                <select name="status" id="status" class="mt-1 w-1/2 border-gray-300 rounded shadow-sm" required>
                                    <option value="Identificado" {{ $risk->status == 'Identificado' ? 'selected' : '' }}>Identificado</option>
                                    <option value="Em Avaliação" {{ $risk->status == 'Em Avaliação' ? 'selected' : '' }}>Em Avaliação</option>
                                    <option value="Mitigado" {{ $risk->status == 'Mitigado' ? 'selected' : '' }}>Mitigado</option>
                                    <option value="Aceite" {{ $risk->status == 'Aceite' ? 'selected' : '' }}>Aceite</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-100 gap-3">
                            <a href="{{ route('risks.show', $risk) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold transition shadow-sm">
                                Guardar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
