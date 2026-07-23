<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiskStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autenticação e permissões serão tratadas pelos middlewares
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'owner_id' => ['required', 'exists:users,id'],
            
            'process' => ['required', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'cause' => ['required', 'string'],
            'consequence' => ['required', 'string'],
            'origin' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Identificado,Em Avaliação,Mitigado,Aceite,Fechado'],
            
            'inherent_probability' => ['required', 'integer', 'min:1', 'max:5'],
            'inherent_impact' => ['required', 'integer', 'min:1', 'max:5'],
            
            'existing_controls' => ['nullable', 'string'],
            'control_effectiveness' => ['nullable', 'in:Inexistente,Fraco,Adequado,Forte'],
            
            'evidences.*' => ['nullable', 'file', 'max:10240'], // max 10MB
        ];
    }
}
