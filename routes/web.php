<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\ProfesoreController;
use App\Http\Controllers\ProgramaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| El control de acceso NO vive aquí ni en las plantillas: vive en el
| constructor de cada controlador y en el authorize() de cada FormRequest.
|
*/

Route::get('/', fn () => redirect()->route('login'));

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 'show' queda fuera a propósito: ninguno de los cinco recursos tiene ficha
// individual, y publicar la ruta solo servía para devolver una página en blanco.
Route::resource('cursos', CursoController::class)->except('show');
Route::resource('programas', ProgramaController::class)->except('show');
Route::resource('profesores', ProfesoreController::class)->except('show');
Route::resource('estudiantes', EstudianteController::class)->except('show');
Route::resource('notas', NotaController::class)->except('show');
