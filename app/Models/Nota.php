<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nota extends Model
{
    use HasFactory;

    /** Escala del centro. Vive aquí una sola vez: la validación la lee de aquí. */
    public const NOTA_MINIMA = 0;
    public const NOTA_MAXIMA = 5;

    protected $fillable = ['nota1', 'nota2', 'nota3', 'definitiva', 'id_estudiantes'];

    protected $casts = [
        'nota1' => 'decimal:2',
        'nota2' => 'decimal:2',
        'nota3' => 'decimal:2',
        'definitiva' => 'decimal:2',
    ];

    public function estudiantes(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiantes');
    }

    /** Única definición del promedio: antes estaba copiada en store() y en update(). */
    public static function calcularDefinitiva(float $n1, float $n2, float $n3): float
    {
        return round(($n1 + $n2 + $n3) / 3, 2);
    }
}
