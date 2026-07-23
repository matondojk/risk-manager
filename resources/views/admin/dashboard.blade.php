<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Executivo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KPIs (Tailwind Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Riscos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total de Riscos</p>
                        <h4 class="text-3xl font-bold text-gray-800">{{ $totalRisks }}</h4>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>

                <!-- Riscos Críticos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Riscos Críticos</p>
                        <h4 class="text-3xl font-bold text-red-600">{{ $risksByLevel['Crítico'] ?? 0 }}</h4>
                    </div>
                    <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>

                <!-- Taxa de Mitigação -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Taxa de Mitigação</p>
                        <h4 class="text-3xl font-bold text-green-600">{{ $mitigationRate }}%</h4>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <!-- Planos em Atraso -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Planos em Atraso</p>
                        <h4 class="text-3xl font-bold text-orange-500">{{ $delayedPlans }}</h4>
                    </div>
                    <div class="p-3 bg-orange-50 text-orange-500 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Gráfico de Riscos por Categoria -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Riscos por Categoria</h3>
                    <div class="h-64 relative">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- Gráfico de Estado dos Planos de Ação -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Estado dos Planos de Ação</h3>
                    <div class="h-64 relative">
                        <canvas id="actionPlansChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Riscos por Nível</h3>
                <div class="flex flex-wrap gap-4">
                    @foreach($risksByLevel as $level => $count)
                        <div class="flex-1 min-w-[120px] bg-gray-50 rounded p-4 text-center border-t-4 
                            {{ $level === 'Crítico' ? 'border-red-600' : 
                              ($level === 'Alto' ? 'border-orange-500' : 
                              ($level === 'Médio' ? 'border-yellow-400' : 'border-green-500')) }}">
                            <p class="text-xs text-gray-500 uppercase font-semibold">{{ $level }}</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $count }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Injection -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chartData = @json($chartData);
            
            // Gráfico 1: Categoria
            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctxCategory, {
                type: 'bar',
                data: {
                    labels: Object.keys(chartData.risksByCategory),
                    datasets: [{
                        label: 'Qtd de Riscos',
                        data: Object.values(chartData.risksByCategory),
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            // Gráfico 2: Planos de Ação
            const ctxPlans = document.getElementById('actionPlansChart').getContext('2d');
            new Chart(ctxPlans, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(chartData.actionPlansStatus),
                    datasets: [{
                        data: Object.values(chartData.actionPlansStatus),
                        backgroundColor: ['#ef4444', '#f59e0b', '#10b981', '#6b7280'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
