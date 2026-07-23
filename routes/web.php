<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Redirecionar diretamente para o login em vez da página de boas vindas do Laravel
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Rotas de Perfil (Breeze)
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Executivo (Módulo 2) - Sobrescrevemos a rota padrão do Breeze
    Route::get('/painel', [DashboardController::class, 'index'])->name('dashboard');
    
    // Matriz de Risco (Módulo 7)
    Route::get('/matriz-de-risco', function () {
        return view('admin.heatmap'); 
    })->name('heatmap');

    // Relatórios (Módulo 8)
    Route::get('/riscos/exportar/excel', [RiskController::class, 'exportExcel'])->name('risks.export.excel');
    Route::get('/riscos/exportar/pdf', [RiskController::class, 'exportPdf'])->name('risks.export.pdf');

    // Reports Module
    Route::get('relatorios', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::post('relatorios/gerar', [\App\Http\Controllers\ReportController::class, 'generate'])->name('reports.generate');

    // Settings Module
    Route::group(['middleware' => ['permission:gerir configuracoes']], function () {
        Route::get('configuracoes', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::put('configuracoes', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    });

    // Users & Roles Module
    Route::group(['middleware' => ['permission:gerir utilizadores']], function () {
        Route::resource('utilizadores', \App\Http\Controllers\UserController::class)->names('users')->parameters(['utilizadores' => 'user'])->except(['show']);
        Route::resource('perfis', \App\Http\Controllers\RoleController::class)->names('roles')->parameters(['perfis' => 'role'])->except(['show']);
    });
    // Gestão de Riscos (Módulos 3 e 4)
    Route::resource('riscos', RiskController::class)->names('risks')->parameters(['riscos' => 'risk']);

    // Planos de Ação / Mitigação (Módulos 5 e 6)
    Route::resource('planos-de-acao', \App\Http\Controllers\ActionPlanController::class)->names('action-plans')->parameters(['planos-de-acao' => 'action_plan']);
});

require __DIR__.'/auth.php';
