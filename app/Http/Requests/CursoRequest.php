<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('ADMINISTRADOR') ?? false;
    }

    public function rules(): array
    {
        return [
            'N_curso' => [
                'required', 'string', 'max:10',
                Rule::unique('cursos', 'N_curso')->ignore($this->route('curso')),
            ],
            'Nombre' => 'required|string|max:255',
            'id_programa' => 'required|exists:programas,id',
        ];
    }
}
