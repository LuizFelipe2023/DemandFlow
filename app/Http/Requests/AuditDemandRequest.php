<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuditDemandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'audit_approved' => filter_var($this->audit_approved, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
    }

    public function rules(): array
    {
        return [
            'audit_approved' => ['required', 'boolean'],
            'justification'  => [
                'nullable',
                'string',
                'max:1000',
                'required_if:audit_approved,false', 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'audit_approved.required' => 'O resultado da auditoria é obrigatório.',
            'audit_approved.boolean'  => 'O campo de aprovação deve ser verdadeiro ou falso.',
            'justification.required_if' => 'A justificativa é obrigatória quando a demanda for recusada.',
            'justification.max'       => 'A justificativa não pode ter mais de 1000 caracteres.',
        ];
    }
}
