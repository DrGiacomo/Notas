<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Antes '/' devolvía view('auth.login') directamente: la misma página de
     * login vivía en dos URLs distintas y solo una tenía nombre de ruta.
     * Ahora redirige, así que el 200 de este test pasó a ser un 302.
     */
    public function test_la_raiz_lleva_al_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }
}
