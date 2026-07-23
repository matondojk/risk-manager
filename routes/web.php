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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Executivo (Módulo 2) - Sobrescrevemos a rota padrão do Breeze
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Matriz de Risco (Módulo 7)
    Route::get('/heatmap', function () {
        return view('admin.heatmap'); 
    })->name('heatmap');

    // Relatórios (Módulo 8)
    Route::get('/risks/export/excel', [RiskController::class, 'exportExcel'])->name('risks.export.excel');
    Route::get('/risks/export/pdf', [RiskController::class, 'exportPdf'])->name('risks.export.pdf');

    // Reports Module
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [\App\Http\Controllers\ReportController::class, 'generate'])->name('reports.generate');

    // Settings Module
    Route::group(['middleware' => ['permission:gerir configuracoes']], function () {
        Route::get('settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    });

    // Users & Roles Module
    Route::group(['middleware' => ['permission:gerir utilizadores']], function () {
        Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show']);
        Route::resource('roles', \App\Http\Controllers\RoleController::class)->except(['show']);
    });
    // Gestão de Riscos (Módulos 3 e 4)
    Route::resource('risks', RiskController::class);

    // Planos de Ação / Mitigação (Módulos 5 e 6)
    Route::resource('action-plans', \App\Http\Controllers\ActionPlanController::class);
});

require __DIR__.'/auth.php';
