<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\ActionPlan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Buscar todos os riscos com relacionamentos relevantes para os gráficos
        $risks = Risk::with(['category', 'department', 'owner'])->get();
        $actionPlans = ActionPlan::all();

        // KPIs Gerais
        $totalRisks = $risks->count();
        $mitigatedRisks = $risks->where('status', 'Mitigado')->count();
        $mitigationRate = $totalRisks > 0 ? round(($mitigatedRisks / $totalRisks) * 100, 1) : 0;

        // Distribuição de Riscos por Nível (Calculado via Accessor 'inherent_level')
        $risksByLevel = [
            'Crítico' => $risks->where('inherent_level', 'Crítico')->count(),
            'Alto' => $risks->where('inherent_level', 'Alto')->count(),
            'Médio' => $risks->where('inherent_level', 'Médio')->count(),
            'Baixo' => $risks->where('inherent_level', 'Baixo')->count(),
        ];

        // Estado dos Planos de Ação
        $completedPlans = $actionPlans->where('status', 'Concluído')->count();
        $delayedPlans = $actionPlans->filter(function ($plan) {
            return $plan->status !== 'Concluído' && $plan->when_date && \Carbon\Carbon::parse($plan->when_date)->isPast();
        })->count();

        // Risco Residual Médio (score 1-25)
        $residualScores = $risks->map(fn($r) => $r->residual_score)->filter();
        $avgResidualScore = $residualScores->count() > 0 ? round($residualScores->average(), 1) : 0;

        // Preparação de dados estruturados para os gráficos Chart.js / ApexCharts
        $chartData = [
            'risksByCategory' => $risks->groupBy(fn($r) => $r->category->name ?? 'Sem Categoria')->map->count()->toArray(),
            'risksByStatus' => $risks->groupBy('status')->map->count()->toArray(),
            'risksByDepartment' => $risks->groupBy(fn($r) => $r->department->name ?? 'Sem Departamento')->map->count()->toArray(),
            'actionPlansStatus' => $actionPlans->groupBy('status')->map->count()->toArray(),
        ];

        return view('admin.dashboard', compact(
            'totalRisks', 'mitigatedRisks', 'mitigationRate', 
            'risksByLevel', 'completedPlans', 'delayedPlans', 
            'avgResidualScore', 'chartData'
        ));
    }
}
