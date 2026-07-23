<!DOCTYPE html>
<html>
<head>
    <title>Inventário de Riscos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; }
        h2 { text-align: center; margin-top: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .level-Crítico { color: red; font-weight: bold; }
        .level-Alto { color: orange; font-weight: bold; }
        .level-Médio { color: #b8860b; font-weight: bold; }
        .level-Baixo { color: green; font-weight: bold; }
    </style>
</head>
<body>
    @php
        $logo = \App\Models\Setting::get('app_logo');
        $logoSrc = null;
        if ($logo && Storage::disk('public')->exists($logo)) {
            $path = Storage::disk('public')->path($logo);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $logoSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    @endphp

    <div class="header">
        @if($logoSrc)
            <img src="{{ $logoSrc }}" alt="Logo" style="max-height: 60px; margin-bottom: 10px;">
        @endif
        <h2>Relatório de Inventário de Riscos</h2>
    </div>
    <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Processo</th>
                <th>Categoria</th>
                <th>Departamento</th>
                <th>Responsável</th>
                <th>Status</th>
                <th>Inerente</th>
            </tr>
        </thead>
        <tbody>
            @foreach($risks as $risk)
            <tr>
                <td>{{ $risk->code }}</td>
                <td>{{ $risk->process }}</td>
                <td>{{ $risk->category->name ?? '-' }}</td>
                <td>{{ $risk->department->name ?? '-' }}</td>
                <td>{{ $risk->owner->name ?? '-' }}</td>
                <td>{{ $risk->status }}</td>
                <td class="level-{{ $risk->inherent_level }}">{{ $risk->inherent_level }} ({{ $risk->inherent_score }})</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
