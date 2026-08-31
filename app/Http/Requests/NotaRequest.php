<?php

namespace App\Http\Requests;

use App\Models\Nota;
use Illuminate\Foundation\Http\FormRequest;

class NotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['ADMINISTRADOR', 'PROFESOR']) ?? false;
    }

    /**
     * Las reglas viven aquí una sola vez: store() y update() usaban dos listas
     * distintas y ya se habían desincronizado (max:233 frente a max:255).
     */
    public function rules(): array
    {
        $escala = 'required|numeric|between:'.Nota::NOTA_MINIMA.','.Nota::NOTA_MAXIMA;

        return [
            'nota1' => $escala,
            'nota2' => $escala,
            'nota3' => $escala,
            'id_estudiantes' => 'required|exists:estudiantes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nota1.between' => 'La nota 1 debe estar entre :min y :max.',
            'nota2.between' => 'La nota 2 debe estar entre :min y :max.',
            'nota3.between' => 'La nota 3 debe estar entre :min y :max.',
            'id_estudiantes.exists' => 'El estudiante seleccionado no existe.',
        ];
    }
}
