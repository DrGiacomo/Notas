<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profesor extends Model
{
    use HasFactory;

    /** La tabla no se puede derivar del nombre: "Profesor" pluraliza a "profesors". */
    protected $table = 'profesores';

    protected $fillable = ['Nombre', 'Apellido', 'Correo', 'Telefono', 'id_cursos'];

    public function cursos(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'id_cursos');
    }

    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'id_profesores');
    }
}
