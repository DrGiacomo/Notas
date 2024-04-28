<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota extends Model
{
    use HasFactory;
    public function estudiantes(){
        return $this->belongsTo(Estudiante::class, 'id_estudiantes', 'id');
    }
}
