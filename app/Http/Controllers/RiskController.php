<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Http\Requests\RiskStoreRequest;
use App\Http\Requests\RiskUpdateRequest;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    public function index(Request $request)
    {
        $risks = Risk::with(['category', 'department', 'owner'])
                    ->when($request->search, function($q) use ($request) {
                        $q->where('code', 'like', "%{$request->search}%")
                          ->orWhere('description', 'like', "%{$request->search}%");
                    })
                    ->latest()
                    ->paginate(15);

        return view('admin.risks.index', compact('risks'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $departments = \App\Models\Department::all();
        $users = \App\Models\User::all();
        
        return view('admin.risks.create', compact('categories', 'departments', 'users'));
    }

    public function store(RiskStoreRequest $request)
    {
        $risk = Risk::create($request->validated());

        if ($request->hasFile('evidences')) {
            foreach ($request->file('evidences') as $file) {
                $risk->addMedia($file)->toMediaCollection('risk_evidences');
            }
        }

        return redirect()->route('risks.index')
                         ->with('success', 'Risco registado com sucesso.');
    }

    public function show(Risk $risk)
    {
        $risk->load(['category', 'department', 'owner', 'actionPlans.who']);
        return view('admin.risks.show', compact('risk'));
    }

    public function edit(Risk $risk)
    {
        $categories = \App\Models\Category::all();
        $departments = \App\Models\Department::all();
        $users = \App\Models\User::all();
        return view('admin.risks.edit', compact('risk', 'categories', 'departments', 'users'));
    }

    public function update(RiskUpdateRequest $request, Risk $risk)
    {
        $risk->update($request->validated());
        
        return redirect()->route('risks.show', $risk)
                         ->with('success', 'Avaliação de risco atualizada.');
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RisksExport, 'riscos.xlsx');
    }

    public function exportPdf()
    {
        $risks = Risk::with(['category', 'department', 'owner'])->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.risks.pdf', compact('risks'))->setPaper('a4', 'landscape');
        return $pdf->download('inventario_riscos.pdf');
    }
}
