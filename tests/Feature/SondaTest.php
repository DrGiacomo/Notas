<?php

namespace Tests\Feature;

use App\Models\Programa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Sondas de diagnóstico: no afirman nada, imprimen lo que pasa de verdad.
 * Sirven para no publicar un hallazgo sin comprobarlo (LECCIONES A1/A7).
 */
class SondaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function que_devuelve_show_realmente(): void
    {
        $p = new Programa();
        $p->nom_programa = 'X';
        $p->save();

        $r = $this->actingAs(User::factory()->create())->get('/programas/'.$p->id);
        fwrite(STDERR, "\n[SONDA] GET /programas/{id} -> HTTP ".$r->getStatusCode()
            .' | cuerpo: '.var_export(substr($r->getContent(), 0, 60), true)."\n");

        $this->assertTrue(true);
    }

    /** @test */
    public function que_pasa_si_un_anonimo_entra_al_listado_de_notas(): void
    {
        $r = $this->get('/notas');
        fwrite(STDERR, "\n[SONDA] GET /notas anónimo -> HTTP ".$r->getStatusCode()."\n");

        $this->assertTrue(true);
    }

    /** @test */
    public function los_use_de_los_controladores_coinciden_con_los_archivos_reales(): void
    {
        $modelos = array_map(
            fn ($f) => basename($f, '.php'),
            glob(app_path('Models/*.php'))
        );

        $desajustes = [];
        foreach (glob(app_path('Http/Controllers/*.php')) as $ctrl) {
            preg_match_all('/^use App\\\\Models\\\\(\w+);/m', file_get_contents($ctrl), $m);
            foreach ($m[1] as $importado) {
                if (! in_array($importado, $modelos, true)) {
                    $real = array_values(array_filter(
                        $modelos,
                        fn ($x) => strcasecmp($x, $importado) === 0
                    ));
                    $desajustes[] = basename($ctrl).": use App\\Models\\$importado"
                        .'  ->  el archivo es '.($real[0] ?? '???').'.php';
                }
            }
        }

        fwrite(STDERR, "\n[SONDA] imports que fallan en Linux:\n  ".implode("\n  ", $desajustes)."\n");

        $this->assertTrue(true);
    }
}
