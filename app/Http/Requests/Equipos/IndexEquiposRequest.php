<?php

namespace App\Http\Requests\Equipos;

use Illuminate\Foundation\Http\FormRequest;

class IndexEquiposRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pagina' => 'sometimes|integer|min:1',
            'cantidad' => 'sometimes|integer|min:1|max:100',
            'nombre' => 'sometimes|string|max:255',
            'grupo' => 'sometimes',
            'grupo.*' => 'nullable',
            'puntero' => 'sometimes|boolean',
            'id' => 'sometimes|array',
            'id.*' => 'integer|exists:equipos,id',
            'genero' => 'sometimes|in:M,F',
        ];
    }
}
