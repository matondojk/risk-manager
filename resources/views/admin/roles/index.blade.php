<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestão de Perfis (Roles)') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('roles.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 dark:bg-gray-50 border border-transparent rounded-md font-medium text-sm text-white dark:text-gray-900 shadow hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                    + Novo Perfil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-sm sm:rounded-lg overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nome do Perfil</th>
                                <th scope="col" class="px-6 py-3">Permissões Associadas</th>
                                <th scope="col" class="px-6 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($roles as $role)
                                <tr class="bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                        {{ $role->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($role->permissions as $permission)
                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $permission->name }}
                                                </span>
                                            @empty
                                                <span class="text-gray-400 italic">Sem permissões</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 flex gap-3">
                                        <a href="{{ route('roles.edit', $role) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Editar</a>
                                        @if($role->name !== 'Administrador')
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar este perfil?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline font-medium">Apagar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">Nenhum perfil encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
