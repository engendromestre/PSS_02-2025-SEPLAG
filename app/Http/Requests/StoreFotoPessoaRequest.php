<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pessoa;

class StoreFotoPessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $pessoa = Pessoa::find($this->pes_id);
        return $pessoa && auth()->user()->can('update', $pessoa);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pes_id' => ['required', 'exists:pessoas,pes_id'],
            'fotos' => ['required', 'array', 'min:1', 'max:10'], // deve ser um array de arquivos
            'fotos.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // até 5MB por imagem
        ];
    }
}
