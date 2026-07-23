<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Area;
use App\Models\Department;
use App\Models\Frequency;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Perfis e Permissões
        $roles = ['Administrador', 'Gestor de Riscos', 'Auditor', 'Utilizador'];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        $admin = User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Admin Sistema',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Administrador');

        $manager = User::firstOrCreate([
            'email' => 'gestor@admin.com'
        ], [
            'name' => 'Gestor de Riscos',
            'password' => Hash::make('password'),
        ]);
        $manager->assignRole('Gestor de Riscos');

        // 2. Tabelas de Apoio
        $area = Area::firstOrCreate(['name' => 'Tecnologia da Informação']);
        Department::firstOrCreate(['name' => 'Cibersegurança', 'area_id' => $area->id]);
        Department::firstOrCreate(['name' => 'Infraestrutura', 'area_id' => $area->id]);

        Category::firstOrCreate(['name' => 'Segurança da Informação']);
        Category::firstOrCreate(['name' => 'Operacional']);
        Category::firstOrCreate(['name' => 'Financeiro']);
        Category::firstOrCreate(['name' => 'Estratégico']);
        Category::firstOrCreate(['name' => 'Conformidade (Compliance)']);

        Frequency::firstOrCreate(['name' => 'Diário']);
        Frequency::firstOrCreate(['name' => 'Semanal']);
        Frequency::firstOrCreate(['name' => 'Mensal']);

        // 3. Gerar Massa de Dados Falsos usando Factories
        \App\Models\Risk::factory(30)->create();
        \App\Models\ActionPlan::factory(60)->create();
    }
}
