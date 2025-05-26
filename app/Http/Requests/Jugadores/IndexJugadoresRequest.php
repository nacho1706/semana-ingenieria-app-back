<?php

namespace App\Http\Requests\Jugadores;

use Illuminate\Foundation\Http\FormRequest;

class IndexJugadoresRequest extends FormRequest
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
            'cantidad' => 'numeric|min:1|max:100',
            'pagina' => 'numeric|min:1',
            'id_equipo' => 'nullable|exists:equipos,id',
        ];
    }
}
