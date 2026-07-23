<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risk;
use App\Models\Department;
use App\Models\Category;
use App\Exports\RisksExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $categories = Category::all();
        
        return view('admin.reports.index', compact('departments', 'categories'));
    }

    public function generate(Request $request)
    {
        $query = Risk::with(['category', 'department', 'owner', 'actionPlans']);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('inherent_level')) {
            // inherent_level is an accessor, so we need to filter on db using probability*impact
            // For simplicity in a custom app, we can fetch all and filter collection, but let's just get all and filter
            $risks = $query->get()->filter(function($risk) use ($request) {
                return $risk->inherent_level === $request->inherent_level;
            });
        } else {
            $risks = $query->get();
        }

        if ($request->format === 'excel') {
            return Excel::download(new RisksExport($risks), 'relatorio_riscos_'.date('Ymd_Hi').'.xlsx');
        }

        // PDF Generation
        $pdf = Pdf::loadView('admin.risks.pdf', compact('risks'))->setPaper('a4', 'landscape');
        return $pdf->download('relatorio_riscos_'.date('Ymd_Hi').'.pdf');
    }
}
