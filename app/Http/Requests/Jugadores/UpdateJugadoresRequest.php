<?php

namespace App\Http\Requests\Jugadores;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJugadoresRequest extends FormRequest
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
            'nombre' => 'sometimes|required|string|max:255',
            'id_equipo' => 'sometimes|required|exists:equipos,id',
            'goles' => 'sometimes|numeric|min:0',
        ];
    }
}
