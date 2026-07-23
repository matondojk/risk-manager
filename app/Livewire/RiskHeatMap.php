<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Risk;

class RiskHeatMap extends Component
{
    public $matrix = [];
    public $selectedRisks = [];
    public $selectedLevel = null;
    public $selectedCell = null;

    public function mount()
    {
        $this->buildMatrix();
    }

    public function buildMatrix()
    {
        // Inicializar matriz 5x5 com contadores zerados
        for ($p = 5; $p >= 1; $p--) {
            for ($i = 1; $i <= 5; $i++) {
                $score = $p * $i;
                $this->matrix[$p][$i] = [
                    'count' => 0,
                    'level' => $this->calculateLevel($score),
                    'color' => $this->getColor($score)
                ];
            }
        }

        // Preencher com os dados reais
        $risks = Risk::select('inherent_probability', 'inherent_impact')->get();
        
        foreach ($risks as $risk) {
            $p = $risk->inherent_probability;
            $i = $risk->inherent_impact;
            if ($p && $i && isset($this->matrix[$p][$i])) {
                $this->matrix[$p][$i]['count']++;
            }
        }
    }

    public function selectCell($probability, $impact)
    {
        $this->selectedCell = "P{$probability} x I{$impact}";
        $this->selectedLevel = $this->calculateLevel($probability * $impact);
        $this->selectedRisks = Risk::with('owner')
            ->where('inherent_probability', $probability)
            ->where('inherent_impact', $impact)
            ->get();
    }

    private function calculateLevel($score)
    {
        if ($score >= 1 && $score <= 4) return 'Baixo';
        if ($score >= 5 && $score <= 9) return 'Médio';
        if ($score >= 10 && $score <= 16) return 'Alto';
        return 'Crítico';
    }

    private function getColor($score)
    {
        if ($score <= 2) return 'bg-green-600 dark:bg-green-700';
        if ($score <= 4) return 'bg-green-500 dark:bg-green-600';
        if ($score <= 6) return 'bg-lime-500 dark:bg-lime-600';
        if ($score <= 9) return 'bg-yellow-400 dark:bg-yellow-500';
        if ($score <= 12) return 'bg-orange-400 dark:bg-orange-500';
        if ($score <= 16) return 'bg-red-500 dark:bg-red-600';
        return 'bg-red-700 dark:bg-red-800';
    }

    public function render()
    {
        return view('livewire.risk-heat-map');
    }
}
