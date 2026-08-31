<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfesorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('ADMINISTRADOR') ?? false;
    }

    public function rules(): array
    {
        return [
            'Nombre' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
            'Correo' => [
                'required', 'email', 'max:255',
                Rule::unique('profesores', 'Correo')->ignore($this->route('profesore')),
            ],
            'Telefono' => 'required|string|max:20',
            'id_cursos' => 'required|exists:cursos,id',
        ];
    }
}
