<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Programa extends Model
{
    use HasFactory;

    protected $table = 'programas';

    protected $fillable = ['nom_programa'];

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'id_programa');
    }
}
