<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDemandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        $isPatch = $this->isMethod('PATCH');
        $rulePrefix = $isPatch ? 'sometimes|' : '';

        return [
            'title' => [
                $isPatch ? 'sometimes' : 'required',
                'string',
                'max:255',
            ],

            'description' => [
                $isPatch ? 'sometimes' : 'required',
                'string',
            ],

            'requester' => [
                $isPatch ? 'sometimes' : 'required',
                'string',
                'max:255',
            ],

            'system' => [
                $isPatch ? 'sometimes' : 'required',
                'string',
                'max:255',
            ],

            'status' => [
                $isPatch ? 'sometimes' : 'required',
                Rule::in([
                    'Open',
                    'In Progress',
                    'Completed',
                ]),
            ],

            'priority' => [
                $isPatch ? 'sometimes' : 'required',
                Rule::in([
                    'Low',
                    'Medium',
                    'High',
                ]),
            ],

            // ALTERADO AQUI: Validação do responsável como FK na tabela 'users'
            'responsible_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],

            'demand_date' => [
                $isPatch ? 'sometimes' : 'required',
                'date',
            ],
        ];
    }

    /**
     * Nomes amigáveis dos atributos para mensagens de erro
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