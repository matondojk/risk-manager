<?php

namespace App\Exports;

use App\Models\Risk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RisksExport implements FromCollection, WithHeadings, WithMapping
{
    protected $risks;

    public function __construct($risks = null)
    {
        $this->risks = $risks ?? Risk::with(['category', 'department', 'owner'])->get();
    }

    public function collection()
    {
        return collect($this->risks);
    }

    public function headings(): array
    {
        return [
            'Código', 'Processo', 'Categoria', 'Departamento', 'Responsável',
            'Descrição', 'Status', 'Score Inerente', 'Nível Inerente'
        ];
    }

    public function map($risk): array
    {
        return [
            $risk->code,
            $risk->process,
            $risk->category->name ?? 'N/A',
            $risk->department->name ?? 'N/A',
            $risk->owner->name ?? 'N/A',
            $risk->description,
            $risk->status,
            $risk->inherent_score,
            $risk->inherent_level
        ];
    }
}
