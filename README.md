# Notas — gestor académico

Aplicación web para llevar los programas, cursos, profesores, estudiantes y notas
de un centro educativo. Laravel 10 + Blade + Bootstrap (plantilla Argon).

Tres perfiles, con permisos distintos **comprobados en el servidor**:

| Rol | Qué puede hacer |
|---|---|
| `ADMINISTRADOR` | Todo: programas, cursos, profesores, estudiantes y notas |
| `PROFESOR` | Estudiantes y notas |
| `ESTUDIANTE` | Ver el listado de notas, sin editar ni borrar |

---

## Cómo levantarlo

**Necesitas:** PHP 8.1 o superior (con `pdo_mysql` o `pdo_sqlite`, `mbstring`,
`openssl`, `fileinfo`), Composer 2 y, si vas a tocar el CSS, Node 18+.

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Elige base de datos en `.env`. Para probar rápido, SQLite no necesita servidor:

```env
DB_CONNECTION=sqlite
```

```bash
touch database/database.sqlite     # solo para SQLite
php artisan migrate --seed
php artisan serve
```

Queda en <http://127.0.0.1:8000>.

### Usuarios de prueba

Los crea `DatabaseSeeder`. **Son de desarrollo: no sembrar en producción.**

| Correo | Rol |
|---|---|
| `test@example.com` | ADMINISTRADOR |
| `profesor@example.com` | PROFESOR |
| `estudiante@example.com` | ESTUDIANTE |

Las contraseñas están en `database/seeders/DatabaseSeeder.php`.

---

## Tests

```bash
php artisan test
```

`tests/Feature/AuditoriaTest.php` cubre los defectos que tuvo el proyecto: control
de acceso, rango de las notas, formularios de edición y respuestas 404 frente a 500.
Cada test lleva escrito de qué hallazgo salió. Si tocas un controlador o una vista,
ese archivo es el que dice si lo has roto.

`tests/Feature/SondaTest.php` no afirma nada: imprime lo que hace la aplicación de
verdad. Sirve para comprobar una sospecha antes de escribir un test que la dé por buena.

---

## Cómo está montado

```
app/Http/Controllers/     un controlador por recurso; el middleware del constructor
                          decide quién entra
app/Http/Requests/        las reglas de validación y el authorize() de cada recurso,
                          una sola vez para crear y para editar
app/Models/               modelos Eloquent; Nota lleva la escala y el cálculo del promedio
resources/views/          Blade; layouts/panel.blade.php es el marco de todo el CRUD
```

**Dónde vive el control de acceso:** en el constructor de cada controlador y en el
`authorize()` de cada FormRequest. **Nunca en las plantillas** — lo que se pinte o no
en el menú es cosmética, no seguridad.

**La escala de notas** está en `App\Models\Nota::NOTA_MINIMA` y `NOTA_MAXIMA`.
Si el centro califica de 0 a 10, se cambia ahí y solo ahí.

---

## Qué queda pendiente

- La carpeta `resources/views/examples/` es la demo de la plantilla Argon y no la usa
  nada: se puede borrar entera.
- El panel de `/home` sigue mostrando las gráficas de ejemplo de la plantilla
  ("Sales value", "Total orders"): son datos inventados, no del centro.
- Un estudiante ve **todas** las notas, no solo las suyas. Falta filtrar por su usuario,
  y para eso hace falta relacionar `users` con `estudiantes`, que hoy no existe.
