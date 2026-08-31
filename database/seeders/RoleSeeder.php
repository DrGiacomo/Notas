<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Antes buscaba User::find(1), find(2) y find(3) sin comprobar el resultado:
     * con la tabla ya poblada, el seeder moría a mitad y dejaba los roles creados
     * pero sin asignar. Ahora busca por el correo que fija DatabaseSeeder.
     */
    public function run(): void
    {
        $asignaciones = [
            'test@example.com' => 'ADMINISTRADOR',
            'profesor@example.com' => 'PROFESOR',
            'estudiante@example.com' => 'ESTUDIANTE',
        ];

        foreach ($asignaciones as $correo => $rol) {
            Role::findOrCreate($rol);

            $usuario = User::where('email', $correo)->first();

            if (! $usuario) {
                $this->command->warn("No existe el usuario $correo: rol $rol sin asignar.");

                continue;
            }

            $usuario->assignRole($rol);
        }
    }
}
