<?php

namespace App\Http\Requests\Partidos;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartidosRequest extends FormRequest
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
            'fecha' => 'nullable|date',
            'cancha' => 'nullable|int',
            'equipos' => 'nullable|array',
            'equipos.*' => 'nullable|exists:equipos,id',
            'resultado' => 'nullable|string',
            'estado' => 'nullable|in:PENDIENTE,JUGADO'
        ];
    }
}
