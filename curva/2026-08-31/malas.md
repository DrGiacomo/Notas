# 2026-08-31 · Lo malo

## Titular

**Tres fallos míos, y los tres del mismo tipo: afirmar o cambiar algo sin comprobarlo
en el sitio donde vivía.** Uno de ellos rompió cuatro archivos que funcionaban.

---

## 1. 🔴 Publiqué una consecuencia que no había medido (`A7`, `M7`)

**Qué pasó.** El informe decía, sobre el hallazgo 8: *«`show()` vacío en los cinco
controladores → 5 rutas garantizan un 500»*. Al ejecutarlo, `GET /programas/{id}`
devuelve **HTTP 200 con el cuerpo vacío**. Laravel convierte el `null` en una respuesta
vacía sin protestar.

**Causa.** Razoné sobre el framework de memoria en vez de probarlo. Recordaba el error
«The Response content must be a string…» y lo di por hecho. El defecto era real —cinco
rutas publicadas que no hacen nada— pero la consecuencia que le adjudiqué era inventada,
y era la que lo convertía en bloqueante.

**Lección.** `A7` dice que si no se ha ejecutado se escribe «sospecho», no «es». Aquí
escribí «garantizan». **El grado de certeza de una frase es parte del hallazgo, no del
estilo.** Un bloqueante mal calificado hace perder el tiempo a quien lo arregla primero.

## 2. 🔴 Mi propio instrumento aprobó su propio examen (`I8`)

**Qué pasó.** Escribí un test para el hallazgo 9 (PSR-4 y las mayúsculas). Comparaba el
nombre de cada archivo de `app/Models/` con el de la clase que declara. **Pasó.** Y pasó
porque `nota.php` sí declara `class nota`: coincidían perfectamente.

El desajuste real estaba en **los `use` de los controladores**, que importaban
`App\Models\Curso` mientras el archivo era `curso.php`. Mi test no miraba ahí.

**Causa.** Escribí el test mirando el hallazgo tal y como yo lo había redactado
(«los modelos están en minúscula») en vez de mirar el mecanismo que rompe
(«el autoloader busca el archivo por el nombre que aparece en el `use`»).

**Lección.** Es `I8` exacto: *un instrumento escrito mirando su propia entrada siempre
pasa su propio examen*. **Un test verde donde esperabas rojo no es una buena noticia:
es el primer sospechoso.** Aquí se cazó porque la expectativa estaba escrita antes.

## 3. 🔴 Una sustitución automática rompió cuatro archivos que funcionaban

**Qué pasó.** Para añadir `@include('partials.aviso')` a los diez formularios usé una
expresión regular sobre `<form action=[^>]*>`. En cinco vistas la etiqueta estaba
partida en dos líneas:

```blade
<form action="{{ url('programas/'.$programa->
    @include('partials.aviso')id) }}" method="post">
```

El `[^>]*` paró en el `>` de `->`. **Cuatro vistas de edición pasaron a dar HTTP 500**, y
solo lo vi porque los tests lo cazaron: dos tests que estaban en verde se pusieron rojos.

**Causa.** Asumí que la etiqueta `<form>` cabía en una línea sin comprobarlo, en un
proyecto cuyo formato ya sabía que era irregular. Y no miré el resultado de la
sustitución: solo comprobé que el `@include` estuviera «en su propia línea», que era
verdad y no significaba nada.

**Lección.** **Un regex sobre HTML mal formateado es una edición a ciegas.** Si se usa,
la verificación no es «¿se insertó?» sino **«¿sigue compilando lo que toqué?»**. Y el
detector no puede ser una segunda inspección del mismo tipo que la que falló: aquí lo
que salvó el día fueron los tests, no mi grep de comprobación — que también dio verde.

**Corolario incómodo:** el arreglo del hallazgo 13 (`old()` sin valor por defecto en la
quinta vista de cinco) lo escribí burlándome de aplicar algo en cuatro sitios de cinco.
Media hora después rompí cuatro archivos con una sustitución que no revisé en ninguno.

---

## 4. Un aviso caro que no fue culpa mía pero costó igual

`composer require doctrine/dbal` sin fijar versión instaló la **4.4.4**, incompatible con
Laravel 10, y tumbó la aplicación entera con un error de firma de método
(`ConnectsToDatabase::connect()`). Composer no lo impidió porque Laravel 10 no declara
esa dependencia.

**Lección para la próxima:** al añadir una dependencia que el framework «pide» pero no
declara, **la versión se fija a mano**. `^3.5` en este caso.

---

## Reincidencias

Ninguna de las tres es segunda vez en este proyecto. Pero **la 1 y la 2 son las filas
más pobladas de `LECCIONES.md §1`**:

- La 1 entra en *«el documento que dice dónde estamos miente»* por su cara de arriba:
  prometí de más y se cayó en cuanto alguien lo probó.
- La 2 es la fila de *«el instrumento acusa al examinado de su propio fallo»* en su
  variante suave: el instrumento no acusó a nadie, **absolvió**. Que es peor, porque
  nadie audita un test que pasa.
