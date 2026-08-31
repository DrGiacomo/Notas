<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = ['Nombre', 'apellidos', 'id_profesores'];

    public function profesores(): BelongsTo
    {
        return $this->belongsTo(Profesor::class, 'id_profesores');
    }

    public function notas(): HasMany
    {
        return $this->hasMany(Nota::class, 'id_estudiantes');
    }
}
