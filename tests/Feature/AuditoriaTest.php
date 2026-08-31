<?php

namespace Tests\Feature;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Nota;
use App\Models\Profesor;
use App\Models\Programa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Cada test de aquí corresponde a un hallazgo de REVISION_2026-08-31.md.
 * Escritos ANTES de arreglar nada: todos deben fallar contra el código original.
 */
class AuditoriaTest extends TestCase
{
    use RefreshDatabase;

    private Programa $programa;
    private Curso $curso;
    private Profesor $profesor;
    private Estudiante $estudiante;
    private Nota $nota;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['ADMINISTRADOR', 'PROFESOR', 'ESTUDIANTE'] as $rol) {
            Role::findOrCreate($rol);
        }

        $this->programa = new Programa();
        $this->programa->nom_programa = 'Ingenieria';
        $this->programa->save();

        $this->curso = new Curso();
        $this->curso->N_curso = 'C-01';
        $this->curso->Nombre = 'Matematicas';
        $this->curso->id_programa = $this->programa->id;
        $this->curso->save();

        $this->profesor = new Profesor();
        $this->profesor->Nombre = 'Ada';
        $this->profesor->Apellido = 'Lovelace';
        $this->profesor->Correo = 'ada@colegio.test';
        $this->profesor->Telefono = '600123456';
        $this->profesor->id_cursos = $this->curso->id;
        $this->profesor->save();

        $this->estudiante = new Estudiante();
        $this->estudiante->Nombre = 'Ana';
        $this->estudiante->apellidos = 'Perez';
        $this->estudiante->id_profesores = $this->profesor->id;
        $this->estudiante->save();

        $this->nota = new Nota();
        $this->nota->nota1 = '3';
        $this->nota->nota2 = '4';
        $this->nota->nota3 = '5';
        $this->nota->definitiva = '4';
        $this->nota->id_estudiantes = $this->estudiante->id;
        $this->nota->save();
    }

    private function admin(): User
    {
        $u = User::factory()->create();
        $u->assignRole('ADMINISTRADOR');

        return $u;
    }

    // ---------- Hallazgo 1: no hay control de acceso ----------

    /** @test */
    public function un_anonimo_no_puede_ver_el_listado_de_programas(): void
    {
        $this->get('/programas')->assertRedirect('/login');
    }

    /** @test */
    public function un_anonimo_no_puede_borrar_un_programa(): void
    {
        $this->delete('/programas/'.$this->programa->id);

        $this->assertDatabaseHas('programas', ['id' => $this->programa->id]);
    }

    /** @test */
    public function un_usuario_registrado_sin_rol_no_puede_borrar_un_programa(): void
    {
        // /register está abierto: cualquiera llega hasta aquí.
        $intruso = User::factory()->create();

        $this->actingAs($intruso)
            ->delete('/programas/'.$this->programa->id)
            ->assertForbidden();

        $this->assertDatabaseHas('programas', ['id' => $this->programa->id]);
    }

    /** @test */
    public function borrar_un_programa_arrastra_en_cascada_todo_el_colegio(): void
    {
        // Demuestra por qué el hallazgo 1 es grave, no teórico.
        $intruso = User::factory()->create();

        $this->actingAs($intruso)->delete('/programas/'.$this->programa->id);

        $this->assertDatabaseHas('cursos', ['id' => $this->curso->id]);
        $this->assertDatabaseHas('profesores', ['id' => $this->profesor->id]);
        $this->assertDatabaseHas('estudiantes', ['id' => $this->estudiante->id]);
        $this->assertDatabaseHas('notas', ['id' => $this->nota->id]);
    }

    // ---------- Hallazgo 2: editar estudiante da 500 ----------

    /** @test */
    public function el_formulario_de_editar_estudiante_carga(): void
    {
        $this->actingAs($this->admin())
            ->get('/estudiantes/'.$this->estudiante->id.'/edit')
            ->assertOk();
    }

    // ---------- Hallazgo 3: las notas se validan por longitud ----------

    /** @test */
    public function una_nota_de_diez_cifras_es_rechazada(): void
    {
        $this->actingAs($this->admin())
            ->post('/notas', [
                'nota1' => '9999999999',
                'nota2' => '4',
                'nota3' => '5',
                'id_estudiantes' => $this->estudiante->id,
            ])
            ->assertSessionHasErrors('nota1');
    }

    /** @test */
    public function una_nota_negativa_es_rechazada(): void
    {
        $this->actingAs($this->admin())
            ->post('/notas', [
                'nota1' => '-500',
                'nota2' => '4',
                'nota3' => '5',
                'id_estudiantes' => $this->estudiante->id,
            ])
            ->assertSessionHasErrors('nota1');
    }

    /** @test */
    public function una_nota_que_no_es_un_numero_es_rechazada_sin_reventar(): void
    {
        $this->actingAs($this->admin())
            ->post('/notas', [
                'nota1' => 'patata',
                'nota2' => '4',
                'nota3' => '5',
                'id_estudiantes' => $this->estudiante->id,
            ])
            ->assertSessionHasErrors('nota1');
    }

    /** @test */
    public function store_y_update_aplican_las_mismas_reglas_a_la_nota_3(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/notas', [
            'nota1' => '3', 'nota2' => '4', 'nota3' => '99999',
            'id_estudiantes' => $this->estudiante->id,
        ])->assertSessionHasErrors('nota3');

        $this->actingAs($admin)->put('/notas/'.$this->nota->id, [
            'nota1' => '3', 'nota2' => '4', 'nota3' => '99999',
            'id_estudiantes' => $this->estudiante->id,
        ])->assertSessionHasErrors('nota3');
    }

    // ---------- Hallazgo 4: las notas se guardan como texto ----------

    /** @test */
    public function la_definitiva_se_guarda_redondeada_y_no_con_dieciseis_decimales(): void
    {
        $this->actingAs($this->admin())->post('/notas', [
            'nota1' => '3', 'nota2' => '3', 'nota3' => '4',
            'id_estudiantes' => $this->estudiante->id,
        ]);

        $guardada = (string) Nota::latest('id')->first()->definitiva;

        $this->assertLessThanOrEqual(
            2,
            strlen(substr(strrchr($guardada, '.') ?: '.', 1)),
            "La definitiva se guardó como '$guardada'"
        );
    }

    /** @test */
    public function ordenar_por_nota_definitiva_es_numerico_y_no_alfabetico(): void
    {
        // "9" contra "10": si la columna es texto, gana el 9.
        $baja = new Nota();
        $baja->nota1 = '9'; $baja->nota2 = '9'; $baja->nota3 = '9';
        $baja->definitiva = '9';
        $baja->id_estudiantes = $this->estudiante->id;
        $baja->save();

        $alta = new Nota();
        $alta->nota1 = '10'; $alta->nota2 = '10'; $alta->nota3 = '10';
        $alta->definitiva = '10';
        $alta->id_estudiantes = $this->estudiante->id;
        $alta->save();

        $primera = Nota::orderByDesc('definitiva')->first();

        $this->assertEquals($alta->id, $primera->id, 'El ranking de notas sale al revés');
    }

    // ---------- Hallazgo 5: find() en vez de findOrFail() ----------

    /** @test */
    public function editar_un_id_inexistente_da_404_y_no_500(): void
    {
        $this->actingAs($this->admin())
            ->get('/notas/99999/edit')
            ->assertNotFound();
    }

    /** @test */
    public function actualizar_un_id_inexistente_da_404_y_no_500(): void
    {
        $this->actingAs($this->admin())
            ->put('/notas/99999', [
                'nota1' => '3', 'nota2' => '4', 'nota3' => '5',
                'id_estudiantes' => $this->estudiante->id,
            ])
            ->assertNotFound();
    }

    // ---------- Hallazgo 6 + 8: las vistas y show() ----------

    /** @test */
    public function el_listado_de_notas_no_revienta_para_un_estudiante(): void
    {
        $alumno = User::factory()->create();
        $alumno->assignRole('ESTUDIANTE');

        $this->actingAs($alumno)->get('/notas')->assertOk();
    }

    /** @test */
    public function un_anonimo_no_llega_al_listado_de_notas(): void
    {
        // El original daba HTTP 500: layouts/panel llamaba a Auth::user()->hasRole()
        // sin sesión. Medido con SondaTest antes de tocar nada.
        $this->get('/notas')->assertRedirect('/login');
    }

    /** @test */
    public function la_ruta_show_no_existe_en_vez_de_devolver_una_pagina_en_blanco(): void
    {
        // Corrección de mi propio informe: show() vacío NO daba 500, daba 200 con
        // el cuerpo vacío. Medido con SondaTest. Publicar rutas que no hacen nada
        // sigue siendo un defecto, pero es de otra gravedad.
        $admin = $this->admin();

        foreach (['programas' => $this->programa->id, 'cursos' => $this->curso->id] as $ruta => $id) {
            // 405: la URI existe para PUT/DELETE pero ya no acepta GET. Es la
            // respuesta correcta de Laravel al quitar 'show' del resource.
            $this->actingAs($admin)->get("/$ruta/$id")->assertStatus(405);
        }
    }

    // ---------- Hallazgo 7: sin POST-Redirect-GET ----------

    /** @test */
    public function guardar_un_programa_redirige_en_vez_de_devolver_html(): void
    {
        $this->actingAs($this->admin())
            ->post('/programas', ['nom_programa' => 'Enfermeria'])
            ->assertRedirect();
    }

    // ---------- Hallazgo 9: PSR-4 y las mayúsculas ----------

    /**
     * Primera versión de este test: comparaba el nombre del archivo con el de la
     * clase que declara — y PASABA, porque 'nota.php' sí declaraba 'class nota'.
     * Medía lo que no era. El desajuste real está en los `use` de los controladores,
     * que importaban App\Models\Curso mientras el archivo se llamaba curso.php.
     *
     * @test
     */
    public function los_imports_de_los_controladores_existen_con_esas_mayusculas(): void
    {
        $modelos = array_map(fn ($f) => basename($f, '.php'), glob(app_path('Models/*.php')));

        foreach (glob(app_path('Http/Controllers/*.php')) as $ctrl) {
            preg_match_all('/^use App\\\\Models\\\\(\w+);/m', file_get_contents($ctrl), $m);

            foreach ($m[1] as $importado) {
                $this->assertContains(
                    $importado,
                    $modelos,
                    basename($ctrl)." importa App\\Models\\$importado, pero no existe "
                    ."un archivo con ese nombre exacto. En Linux es Class not found."
                );
            }
        }
    }

    /** @test */
    public function cada_modelo_declara_una_clase_con_el_nombre_exacto_de_su_archivo(): void
    {
        foreach (glob(app_path('Models/*.php')) as $archivo) {
            $esperado = basename($archivo, '.php');
            preg_match('/^\s*(?:final\s+|abstract\s+)?class\s+(\w+)/m', file_get_contents($archivo), $m);

            $this->assertSame($esperado, $m[1] ?? '', "PSR-4 en $archivo");
        }
    }

    // ---------- Hallazgo 11: el nombre limitado a 10 caracteres ----------

    /** @test */
    public function un_estudiante_puede_llamarse_maximiliano(): void
    {
        $this->actingAs($this->admin())
            ->post('/estudiantes', [
                'Nombre' => 'Maximiliano',
                'apellidos' => 'Garcia',
                'id_profesores' => $this->profesor->id,
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('estudiantes', ['Nombre' => 'Maximiliano']);
    }

    // ---------- Hallazgo 12: correo sin validar ----------

    /** @test */
    public function un_correo_que_no_es_un_correo_se_rechaza(): void
    {
        $this->actingAs($this->admin())
            ->post('/profesores', [
                'Nombre' => 'Alan', 'Apellido' => 'Turing',
                'Correo' => 'patata', 'Telefono' => '600111222',
                'id_cursos' => $this->curso->id,
            ])
            ->assertSessionHasErrors('Correo');
    }

    // ---------- Hallazgo 13: el form de editar programa sale vacío ----------

    /** @test */
    public function el_formulario_de_editar_programa_muestra_el_valor_actual(): void
    {
        $this->actingAs($this->admin())
            ->get('/programas/'.$this->programa->id.'/edit')
            ->assertOk()
            ->assertSee('value="Ingenieria"', false);
    }
}
