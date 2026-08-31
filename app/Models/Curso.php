<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = ['N_curso', 'Nombre', 'id_programa'];

    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    public function profesores(): HasMany
    {
        return $this->hasMany(Profesor::class, 'id_cursos');
    }
}
