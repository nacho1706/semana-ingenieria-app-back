<?php

namespace App\Http\Requests\Equipos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquiposRequest extends FormRequest
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
            'genero' => 'sometimes|in:M,F',
            'nombre' => 'sometimes|string|max:255',
            'id_grupo' => 'sometimes|integer|exists:grupos,id',
            'puntos' => 'sometimes|integer|min:0',
            'PJ' => 'sometimes|integer|min:0',
            'PG' => 'sometimes|integer|min:0',
            'PE' => 'sometimes|integer|min:0',
            'PP' => 'sometimes|integer|min:0',
            'GF' => 'sometimes|integer|min:0',
            'GC' => 'sometimes|integer|min:0',
            'DG' => 'sometimes|integer|min:0',
        ];
    }
}
