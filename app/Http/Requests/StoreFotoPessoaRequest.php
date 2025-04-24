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
        // Removi a verificação de autorização aqui pois já está sendo feita no controller
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
            'fotos' => 'required', // Primeiro valida se existe o campo
            'fotos.*' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // 5MB
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Garante que 'fotos' seja sempre tratado como array
        if ($this->hasFile('fotos') && !is_array($this->file('fotos'))) {
            $this->merge([
                'fotos' => [$this->file('fotos')]
            ]);
        }
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            'fotos.required' => 'Pelo menos uma foto deve ser enviada.',
            'fotos.*.required' => 'Todos os arquivos de imagem são obrigatórios.',
            'fotos.*.image' => 'O arquivo deve ser uma imagem válida (JPEG, PNG, JPG ou WEBP).',
            'fotos.*.mimes' => 'Apenas imagens nos formatos JPEG, PNG, JPG ou WEBP são permitidas.',
            'fotos.*.max' => 'Cada imagem não pode exceder 5MB.',
        ];
    }

    /**
     * Custom validation attributes.
     */
    public function attributes()
    {
        return [
            'fotos' => 'fotos',
            'fotos.*' => 'foto',
        ];
    }
}