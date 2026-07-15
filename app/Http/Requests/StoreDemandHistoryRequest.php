<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDemandHistoryRequest extends FormRequest
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
        return [
            'type' => [
                'required',
                'string',
                Rule::in([
                    'COMMENT',
                    'STATUS_CHANGE',
                    'CORRECTION',
                    'DEPLOY',
                ]),
            ],

            'description' => [
                'required',
                'string',
                'max:1000', // Alinhado com o maxlength="1000" do textarea
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