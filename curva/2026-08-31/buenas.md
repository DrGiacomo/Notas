# 2026-08-31 · Lo bueno

## Titular

**Buen día.** El proyecto entró con 6 bloqueantes mayores y sale con 27 tests en verde y
el recorrido completo verificado por HTTP. Lo mejor no fue arreglarlo: fue que la máquina
desmintiera uno de mis hallazgos antes de que lo publicara.

---

## 1. Los tests se escribieron ANTES de tocar el código

22 tests contra el código original: **17 fallaron**. Cada fallo es la prueba de un
hallazgo, no su suposición. Sin eso, el informe habría sido una lista de opiniones bien
argumentadas.

El contraste vale más que la lista: `editar estudiante -> 500`, `nota de 10 cifras ->
aceptada`, `definitiva -> 13 decimales`. Ninguno de esos números se puede discutir.

## 2. Sondas antes de afirmar (`A1`, `A7`)

Tres tests pasaron en la primera pasada. En vez de darlos por buenos, se escribió
`SondaTest`: un archivo que **no afirma nada, solo imprime lo que pasa**. Salieron dos
cosas:

- `show()` devolvía **200 con el cuerpo vacío**, no 500 como decía mi informe.
- El test de PSR-4 comparaba archivo contra clase — y coincidían. Medía lo que no era.

**El patrón que se lleva:** cuando un test pasa y esperabas que fallara, el sospechoso
es el test. Escribir una sonda cuesta cinco minutos y evita publicar un hallazgo falso.

## 3. Se declaró el denominador desde la primera línea (`V1`)

El informe abre con «39 archivos, 1.768 líneas» y con «no he ejecutado nada, no hay PHP
en esta máquina». Cuando después sí hubo PHP, el documento no se reescribió para
disimular: se le puso un apéndice que dice **qué capa es lectura y qué capa es medida**.

## 4. Ejecutar encontró lo que leer no vio

Cuatro hallazgos aparecieron solo al correr la aplicación:

| | Cómo apareció |
|---|---|
| El alias `role` de Spatie no existía en `Kernel.php` | Al intentar usarlo: `Target class [role] does not exist` |
| TrackJS con token ajeno en todas las páginas | En el volcado HTML de un test que falló |
| `estudiantes/edit` tenía **tres** fallos, no uno | Al arreglar el primero apareció el segundo |
| jQuery nunca cargaba | Leyendo el HTML servido, no el Blade |

El del alias de Spatie es el mejor: convirtió «se olvidaron de proteger las rutas» en
**«el middleware nunca llegó a existir»**. Es un hallazgo distinto y más grave, y solo
lo da la ejecución.

## 5. La escala de notas quedó en un sitio, no en diez

`Nota::NOTA_MINIMA` y `NOTA_MAXIMA`, leídas por el `FormRequest`. Antes el mismo límite
estaba escrito en `store` y en `update` de forma distinta (`max:233` frente a `max:255`).
Un solo sitio no se puede desincronizar.

## 6. Se dijo en voz alta lo que NO se arregló

Cuatro cosas quedan fuera y están listadas con su porqué, no escondidas: el estudiante
que ve todas las notas (falta una relación que no existe), el dashboard de demo, la
carpeta `examples/` y la convención de nombres del esquema.
