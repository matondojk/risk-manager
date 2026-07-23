<?php

namespace App\Http\Controllers;

use App\Models\ActionPlan;
use App\Models\Risk;
use App\Models\User;
use Illuminate\Http\Request;

class ActionPlanController extends Controller
{
    public function index(Request $request)
    {
        $actionPlans = ActionPlan::with(['risk', 'who'])->latest()->paginate(15);
        return view('admin.action-plans.index', compact('actionPlans'));
    }

    public function create(Request $request)
    {
        $risk = Risk::findOrFail($request->risk_id);
        $users = User::all();
        return view('admin.action-plans.create', compact('risk', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'what' => 'required|string|max:255',
            'why' => 'required|string',
            'where' => 'required|string|max:255',
            'when_date' => 'required|date',
            'who_id' => 'required|exists:users,id',
            'how' => 'required|string',
            'how_much' => 'nullable|numeric',
            'status' => 'required|string|max:50'
        ]);

        ActionPlan::create($validated);

        return redirect()->route('risks.show', $validated['risk_id'])
                         ->with('success', 'Plano de Ação 5W2H adicionado com sucesso e anexado ao risco!');
    }
}
