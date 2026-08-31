<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Las cuatro notas se crearon como VARCHAR(255). Consecuencias medidas:
 * ORDER BY definitiva ponía "9" por encima de "10", y el promedio se guardaba
 * con 13 decimales ("3.3333333333333335").
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->decimal('nota1', 5, 2)->change();
            $table->decimal('nota2', 5, 2)->change();
            $table->decimal('nota3', 5, 2)->change();
            $table->decimal('definitiva', 5, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->string('nota1')->change();
            $table->string('nota2')->change();
            $table->string('nota3')->change();
            $table->string('definitiva')->change();
        });
    }
};
