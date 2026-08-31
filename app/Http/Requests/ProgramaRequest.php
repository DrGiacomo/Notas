<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('ADMINISTRADOR') ?? false;
    }

    public function rules(): array
    {
        return [
            'nom_programa' => 'required|string|max:255',
        ];
    }
}
