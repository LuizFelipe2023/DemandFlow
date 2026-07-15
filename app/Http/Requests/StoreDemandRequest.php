<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDemandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepara os dados antes da validação (Definir padrões se vierem vazios)
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->status ?? 'Open',
            'priority' => $this->priority ?? 'Medium',
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'requester' => [
                'required',
                'string',
                'max:255',
            ],

            'system' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required', // Agora é required porque o prepareForValidation garante um valor padrão
                Rule::in([
                    'Open',
                    'In Progress',
                    'Completed',
                ]),
            ],

            'priority' => [
                'required',
                Rule::in([
                    'Low',
                    'Medium',
                    'High',
                ]),
            ],

            // ALTERADO AQUI: Agora valida se o ID existe na tabela 'users'
            'responsible_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],

            'demand_date' => [
                'required',
                'date',
            ],
        ];
    }

    /**
     * Nomes personalizados para as mensagens de erro (Opcional, mas melhora a UX)
     */
    public function attributes(): array
    {
        return [
            'responsible_id' => 'responsável',
            'demand_date' => 'data da demanda',
            'requester' => 'solicitante',
        ];
    }
}