<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação para edição de usuário.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      
        $userId = $this->route('id') ?? $this->route('user');

        return [
            'name'         => ['required', 'string', 'max:255'],
            'email'        => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password'     => ['nullable', 'string', 'min:8'], // Opcional no Update
            'user_type_id' => ['required', 'exists:user_types,id'],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'         => 'O campo nome é obrigatório.',
            'email.required'        => 'O e-mail é obrigatório.',
            'email.unique'          => 'Este e-mail já pertence a outro usuário.',
            'password.min'          => 'A nova senha deve conter no mínimo 8 caracteres.',
            'user_type_id.required' => 'Selecione um tipo de usuário válido.',
            'user_type_id.exists'   => 'O tipo de usuário selecionado é inválido.',
        ];
    }
}

