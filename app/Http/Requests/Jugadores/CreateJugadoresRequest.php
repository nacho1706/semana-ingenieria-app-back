<?php

namespace App\Http\Requests\Jugadores;

use Illuminate\Foundation\Http\FormRequest;

class CreateJugadoresRequest extends FormRequest
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
            'nombre' => 'nullable|string|max:255',
            'id_equipo' => 'nullable|exists:equipos,id',

            'jugadores' => 'nullable|array',
            'jugadores.*.nombre' => 'required|string|max:255',
            'jugadores.*.id_equipo' => 'required|exists:equipos,id'
        ];
    }
}
