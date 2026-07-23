<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Risk;
use App\Models\ActionPlan;
use App\Mail\RiskAlertMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckRiskAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risks:check-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica riscos a precisar de revisão e planos de ação em atraso, notificando os responsáveis.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando verificação de alertas...');

        // 1. Planos de Ação em Atraso
        $delayedPlans = ActionPlan::with(['owner', 'risk'])
            ->where('status', '!=', 'Concluído')
            ->where('status', '!=', 'Cancelado')
            ->where('end_date', '<', Carbon::today())
            ->get();

        foreach ($delayedPlans as $plan) {
            if ($plan->owner && $plan->owner->email) {
                // Em ambiente real deveríamos ter a rota criada, aqui usamos '#' caso falhe temporariamente
                $url = route('dashboard'); // fallback route
                
                Mail::to($plan->owner->email)->send(new RiskAlertMail(
                    'Plano de Ação em Atraso',
                    "O plano de ação '{$plan->action}' referente ao risco {$plan->risk->code} encontra-se em atraso desde {$plan->end_date->format('d/m/Y')}.",
                    $url
                ));
            }
        }

        $this->info("Enviados " . $delayedPlans->count() . " alertas de planos em atraso.");

        // 2. Revisões de Risco Próximas ou em atraso (<= 7 dias)
        $risksToReview = Risk::with('owner')
            ->where('status', '!=', 'Fechado')
            ->whereNotNull('next_review_date')
            ->where('next_review_date', '<=', Carbon::today()->addDays(7))
            ->get();

        foreach ($risksToReview as $risk) {
            if ($risk->owner && $risk->owner->email) {
                $isOverdue = $risk->next_review_date->isPast();
                $subject = $isOverdue ? 'Revisão de Risco em Atraso' : 'Revisão de Risco Próxima';
                $message = "O risco {$risk->code} ({$risk->process}) tem revisão marcada para {$risk->next_review_date->format('d/m/Y')}. Por favor, atualize a avaliação.";
                
                // fallback route
                $url = route('risks.edit', $risk->id);
                
                Mail::to($risk->owner->email)->send(new RiskAlertMail($subject, $message, $url));
            }
        }

        $this->info("Enviados " . $risksToReview->count() . " alertas de revisões de risco.");
        
        $this->info('Verificação concluída!');
    }
}
