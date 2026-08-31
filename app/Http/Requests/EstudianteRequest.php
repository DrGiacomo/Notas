<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstudianteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['ADMINISTRADOR', 'PROFESOR']) ?? false;
    }

    public function rules(): array
    {
        return [
            // Antes era max:10, copiado de N_curso: rechazaba "Maximiliano".
            'Nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'id_profesores' => 'required|exists:profesores,id',
        ];
    }
}
