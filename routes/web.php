<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ProfesoreController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\NotaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('/cursos',CursoController::class);
Route::resource('/programas',ProgramaController::class);
Route::resource('/profesores',ProfesoreController::class);
Route::resource('/estudiantes',EstudianteController::class);
Route::resource('/notas',NotaController::class);
