<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curso extends Model
{
    use HasFactory;
    public function programa(){
        return $this->belongsTo(Programa::class, 'id_programa', 'id');
    }
    
}
