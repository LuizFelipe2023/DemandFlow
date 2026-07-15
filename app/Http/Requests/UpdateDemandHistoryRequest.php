<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDemandHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $isPatch = $this->isMethod('PATCH');

        return [
            'type' => [
                $isPatch ? 'sometimes' : 'required',
                'string',
                Rule::in([
                    'COMMENT',
                    'STATUS_CHANGE',
                    'CORRECTION',
                    'DEPLOY',
                ]),
            ],

            'description' => [
                $isPatch ? 'sometimes' : 'required',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Nomes amigáveis dos atributos para as mensagens de erro.
     */
    public function attributes(): array
    {
        return [
            'type' => 'tipo da atualização',
            'description' => 'atualização',
        ];
    }
}