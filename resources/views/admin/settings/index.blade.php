<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Configurações do Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nome da Aplicação -->
                        <div>
                            <label for="app_name" class="block font-medium text-gray-700 mb-1">Nome da Aplicação</label>
                            <input type="text" name="app_name" id="app_name" value="{{ old('app_name', $app_name) }}" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <p class="text-sm text-gray-500 mt-1">Este nome será exibido no cabeçalho e na barra de título do navegador.</p>
                            @error('app_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Logotipo -->
                        <div class="pt-4 border-t border-gray-100">
                            <label for="app_logo" class="block font-medium text-gray-700 mb-1">Logotipo (Logo)</label>
                            
                            @if($app_logo)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 mb-2">Logotipo Atual:</p>
                                    <div class="p-4 bg-gray-50 rounded inline-block">
                                        <img src="{{ Storage::url($app_logo) }}" alt="Logotipo Atual" class="h-12 object-contain">
                                    </div>
                                </div>
                            @endif

                            <input type="file" name="app_logo" id="app_logo" class="w-full border border-gray-300 p-2 rounded shadow-sm">
                            <p class="text-sm text-gray-500 mt-1">Formatos aceites: JPG, PNG, SVG (Máx 2MB). Ideal para o menu superior.</p>
                            @error('app_logo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Favicon -->
                        <div class="pt-4 border-t border-gray-100">
                            <label for="app_favicon" class="block font-medium text-gray-700 mb-1">Favicon (Ícone do Navegador)</label>
                            
                            @if($app_favicon)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 mb-2">Favicon Atual:</p>
                                    <div class="p-2 bg-gray-50 rounded inline-block">
                                        <img src="{{ Storage::url($app_favicon) }}" alt="Favicon Atual" class="h-6 w-6 object-contain">
                                    </div>
                                </div>
                            @endif

                            <input type="file" name="app_favicon" id="app_favicon" class="w-full border border-gray-300 p-2 rounded shadow-sm">
                            <p class="text-sm text-gray-500 mt-1">Formatos aceites: ICO, PNG, SVG (Máx 1MB). Aparece na aba do navegador.</p>
                            @error('app_favicon') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-100">
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold transition shadow-sm">
                                Guardar Configurações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
