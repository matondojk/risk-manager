<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Mitigação: Adicionar 5W2H') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 overflow-hidden">
                <div class="bg-blue-50 border-b border-blue-100 p-6">
                    <h3 class="text-blue-900 font-bold text-lg">Risco Associado: {{ $risk->code }}</h3>
                    <p class="text-blue-700 mt-1 text-sm">{{ Str::limit($risk->description, 150) }}</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('action-plans.store') }}" method="POST" class="space-y-6 text-sm">
                        @csrf
                        <input type="hidden" name="risk_id" value="{{ $risk->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block font-bold text-gray-700 mb-1">O Quê fazer? <span class="text-xs text-gray-500 font-normal uppercase ml-2 bg-gray-100 px-2 py-1 rounded">What</span></label>
                                <input type="text" name="what" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required placeholder="Ação específica a ser realizada">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block font-bold text-gray-700 mb-1">Porquê fazer? <span class="text-xs text-gray-500 font-normal uppercase ml-2 bg-gray-100 px-2 py-1 rounded">Why</span></label>
                                <input type="text" name="why" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required placeholder="Justificativa para esta ação">
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Onde será feito? <span class="text-xs text-gray-500 font-normal uppercase ml-2 bg-gray-100 px-2 py-1 rounded">Where</span></label>
                                <input type="text" name="where" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required placeholder="Local ou sistema">
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Quando? (Data Limite) <span class="text-xs text-gray-500 font-normal uppercase ml-2 bg-gray-100 px-2 py-1 rounded">When</span></label>
                                <input type="date" name="when_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Quem vai fazer? <span class="text-xs text-gray-500 font-normal uppercase ml-2 bg-gray-100 px-2 py-1 rounded">Who</span></label>
                                <select name="who_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Selecione o responsável...</option>
                                    @foreach($users as $user) <option value="{{ $user->id }}">{{ $user->name }}</option> @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Quanto vai custar? <span class="text-xs text-gray-500 font-normal uppercase ml-2 bg-gray-100 px-2 py-1 rounded">How much</span></label>
                                <input type="number" step="0.01" name="how_much" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="0.00 Kz (Opcional)">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block font-bold text-gray-700 mb-1">Como será feito? <span class="text-xs text-gray-500 font-normal uppercase ml-2 bg-gray-100 px-2 py-1 rounded">How</span></label>
                                <textarea name="how" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" rows="3" required placeholder="Procedimento passo a passo"></textarea>
                            </div>

                            <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <label class="block font-bold text-gray-700 mb-1">Status Atual</label>
                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="Não Iniciado" selected>Não Iniciado</option>
                                    <option value="Em Andamento">Em Andamento</option>
                                    <option value="Concluído">Concluído</option>
                                    <option value="Atrasado">Atrasado</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-6 mt-2 border-t border-gray-100">
                            <a href="{{ route('risks.show', $risk->id) }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-semibold transition">Cancelar</a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 shadow-sm transition">
                                Guardar Plano 5W2H
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
