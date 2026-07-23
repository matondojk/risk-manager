<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar cache do spatie-permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Criar Permissões (baseadas na responsabilidade)
        $permissions = [
            'gerir utilizadores', // Acesso a painel de utilizadores, criar, editar, apagar
            'gerir configuracoes', // Acesso a settings
            
            'ver riscos',
            'criar riscos',
            'editar riscos',
            'apagar riscos',

            'ver planos',
            'criar planos',
            'editar planos',
            'apagar planos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Criar Perfis (Roles)
        
        // Admin: Tem acesso a tudo
        $roleAdmin = Role::firstOrCreate(['name' => 'Administrador']);
        $roleAdmin->givePermissionTo(Permission::all());

        // Gestor de Risco: Pode gerir riscos e planos, mas não gerir utilizadores ou sistema
        $roleGestor = Role::firstOrCreate(['name' => 'Gestor de Risco']);
        $roleGestor->givePermissionTo([
            'ver riscos', 'criar riscos', 'editar riscos', 'apagar riscos',
            'ver planos', 'criar planos', 'editar planos', 'apagar planos',
        ]);

        // Utilizador Normal: Apenas visualização
        $roleUser = Role::firstOrCreate(['name' => 'Utilizador Base']);
        $roleUser->givePermissionTo([
            'ver riscos',
            'ver planos',
        ]);

        // 3. Atribuir Administrador ao primeiro utilizador do sistema (se existir)
        $firstUser = User::first();
        if ($firstUser) {
            $firstUser->assignRole('Administrador');
        }
    }
}
