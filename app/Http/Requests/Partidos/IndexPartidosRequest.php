<?php

namespace App\Http\Requests\Partidos;

use Illuminate\Foundation\Http\FormRequest;

class IndexPartidosRequest extends FormRequest
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
            'cantidad' => 'sometimes|numeric|min:1|max:100',
            'pagina' => 'sometimes|numeric|min:1',
            'fecha' => 'sometimes|date',
            'fecha_array' => 'sometimes|array',
            'fecha_array.*' => 'date_format:Y-m-d',
            'cancha' => 'sometimes|string|max:255',
            'grupo' => 'sometimes|numeric',
        ];
    }
}
