<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return auth()->check();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pes_nome' => 'required|string|max:200',
            'pes_data_nascimento' => 'required|date',
            'pes_sexo' => 'required|string|in:M,F',
            'pes_mae' => 'required|string|max:200',
            'pes_pai' => 'required|string|max:200',
        ];
    }
}
