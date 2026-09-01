# 🗂️ Modelo de datos, reglas y permisos — Notas

> **Qué es este documento.** El dominio del proyecto escrito en castellano: qué existe, qué valores
> caben, quién puede tocar qué y qué pasa al borrar. **Es la fuente de la que salen el esquema de
> la base, la validación y la autorización** — los tres, no uno.
>
> **Fecha:** `2026-08-31` · **Versión:** `1.0` · **Manda sobre él:** `BIBLIA_PROYECTO.md`
>
> **Por qué existe.** No existía. La auditoría del `2026-08-31` encontró 6 bloqueantes mayores y
> **cuatro de ellos son la consecuencia directa de que este documento faltara**: no había rango
> para las notas, no había tipo, no había matriz de permisos y no había política de borrado.
>
> **Es el documento que se lleva a las otras tres versiones** (Django, Yii, NestJS) **sin cambiar
> una coma**, porque no menciona ningún framework.

---

## 1. Glosario — cómo se llama cada cosa

| Término | Qué es | Qué **no** es |
|---|---|---|
| **Curso** | ✅ `D7` — **el grupo de alumnos**. *«11B»* | **No** es la asignatura |
| **Materia** | ✅ `D7` — **la asignatura**. *«Matemáticas»*. Un curso tiene varias *(11B tiene 11)* | No es el grupo |
| **Usuario** | Toda persona que entra al sistema: docente, alumno, director… | No hay tablas separadas de «profesor» y «estudiante»: **son usuarios con rol distinto** |
| ~~**Programa**~~ | *Fuera de esta versión — ver `D8`* | — |
| **Profesor** | Quien imparte | — |
| **Estudiante** | Quien recibe la calificación | No es un usuario del sistema *(ver `H1`)* |
| **Nota** | El conjunto de las tres calificaciones parciales de un estudiante y su definitiva | No es una calificación suelta |
| **Definitiva** | El promedio de las tres parciales | **No se escribe a mano: se calcula** |

---

## 2. Reglas de negocio

Cada una tiene ID. **Se citan desde los tests y desde el código.** No se renumeran.

| ID | Regla | Dónde vive hoy |
|---|---|---|
| `RN1` | Una calificación va de **0 a 5**, con dos decimales | `Nota::NOTA_MINIMA` / `NOTA_MAXIMA` |
| `RN2` | La **definitiva** es el promedio de las tres parciales, redondeado a dos decimales | `Nota::calcularDefinitiva()` |
| `RN3` | La definitiva **nunca la escribe el usuario**: se deriva. El campo del formulario es informativo | `NotaController::conDefinitiva()` |
| `RN4` | El **código de curso** (`N_curso`) es único en todo el sistema | `CursoRequest` + índice único |
| `RN5` | El **correo de un profesor** es único y tiene forma de correo | `ProfesorRequest` |
| `RN6` | Un nombre o apellido admite hasta 255 caracteres, con tildes y compuestos | `RN6` nació de rechazar *«Maximiliano»* |
| `RN7` | Toda nota pertenece a un estudiante que **existe** | `exists:estudiantes,id` |

> **Regla pendiente de decidir (`RN8`):** ¿la escala es 0–5 o 0–10? Está puesta a **0–5** por ser
> la colombiana más común, **pero nadie lo ha confirmado con el centro**. Se cambia en una
> constante. ⬜

---

## 3. El MER — rediseño del `2026-09-01` (opción B)

**Estado: cerrado.** Contesta las cuatro preguntas de control. Orden de creación en dependencias,
sin ciclos.

```
1. roles          : id, nombre_rol
2. materias       : id, nombre_materia
3. users          : id, nombre, apellido, telefono, correo, contraseña
4. cursos         : id, nombre_curso, id_director   → users
5. user_rol       : id, id_user → users, id_rol → roles
6. matricula      : id, id_user → users, id_curso → cursos
7. curso_materia  : id, id_curso → cursos, id_materia → materias, id_docente → users
8. notas          : id, nota1, nota2, nota3,
                        id_alumno         → users
                        id_curso_materia  → curso_materia
```

### Las cuatro preguntas de control

| Pregunta | Por dónde se responde |
|---|---|
| ¿Qué sacó Ana en Matemáticas? | `notas → curso_materia → materias` |
| ¿Qué materias tiene 11B? | `curso_materia` filtrando por curso |
| ¿Quién da Matemáticas en 11B? | `curso_materia.id_docente` |
| ¿Qué alumnos hay en 11B? | `matricula` filtrando por curso |

### Decisiones que hay detrás

| | |
|---|---|
| **Una sola tabla de personas** | Docente, alumno y director son **roles**, no tablas. Fue el mejor cambio del rediseño: resuelve de raíz que `users` no supiera quién era cada persona |
| **`matricula` en vez de una columna** | La primera versión ponía `users.id_curso`, y eso creaba un **ciclo** (`users → cursos → users`). El ciclo era el modelo avisando de que faltaba una tabla. De regalo: se puede repetir curso y guardar el año |
| **`curso_materia` con docente dentro** | Dar clase no es entre un profesor y una materia: es entre un profesor y **una materia en un curso concreto**. Por eso el docente vive en esa fila |
| **`definitiva` no se guarda** | Es un promedio: se calcula al leer. *Se replantea si hace falta congelar la nota de cierre de año* |
| **Las columnas se llaman por su papel** | `id_director`, `id_docente`, `id_alumno` — no `id_user` tres veces. El nombre de la columna es documentación gratis |

> **Regla que falta escribir (`RN9`):** la clave foránea garantiza que la persona **existe**, no
> que **pueda**. Nada en la base impide meter a un alumno como docente. Eso se comprueba al
> guardar. ⬜

---

## 3 bis. El MER viejo — lo que había antes del `2026-09-01`

```
  ┌────────────┐         ┌────────────┐         ┌────────────┐
  │  PROGRAMA  │────1:N──│   CURSO    │────1:N──│  PROFESOR  │
  └────────────┘         └────────────┘         └────────────┘
                                                       │
                                                      1:N
                                                       │
                                                 ┌────────────┐         ┌────────────┐
                                                 │ ESTUDIANTE │────1:N──│    NOTA    │
                                                 └────────────┘         └────────────┘
```

### Atributos, con tipo y rango

**`programas`**

| Campo | Tipo | Nulo | Rango / regla |
|---|---|---|---|
| `id` | bigint auto | no | — |
| `nom_programa` | varchar(255) | no | 1–255 caracteres |

**`cursos`**

| Campo | Tipo | Nulo | Rango / regla |
|---|---|---|---|
| `N_curso` | varchar(10) | no | **único** `RN4` |
| `Nombre` | varchar(255) | no | 1–255 |
| `id_programa` | FK → `programas.id` | no | borrado: **CASCADE** ⚠️ |

**`profesores`**

| Campo | Tipo | Nulo | Rango / regla |
|---|---|---|---|
| `Nombre`, `Apellido` | varchar(255) | no | `RN6` |
| `Correo` | varchar(255) | no | forma de correo, **único** `RN5` |
| `Telefono` | varchar(20) | no | — |
| `id_cursos` | FK → `cursos.id` | no | borrado: **CASCADE** ⚠️ |

**`estudiantes`**

| Campo | Tipo | Nulo | Rango / regla |
|---|---|---|---|
| `Nombre`, `apellidos` | varchar(255) | no | `RN6` |
| `id_profesores` | FK → `profesores.id` | no | borrado: **CASCADE** ⚠️ |

**`notas`**

| Campo | Tipo | Nulo | Rango / regla |
|---|---|---|---|
| `nota1`, `nota2`, `nota3` | **decimal(5,2)** | no | 0.00–5.00 `RN1` |
| `definitiva` | **decimal(5,2)** | no | derivada `RN2` |
| `id_estudiantes` | FK → `estudiantes.id` | no | borrado: **CASCADE** ⚠️ |

> **Los cuatro campos de nota eran `VARCHAR(255)`** hasta el `2026-08-31`. Corregido por la
> migración `2026_08_31_120000`.

---

## 4. ⚠️ El problema del modelo, y hay que decidirlo

**Dibujar el MER saca a la luz que este modelo no puede representar la realidad.** Tres cosas:

| # | Lo que dice el modelo | Lo que pasa de verdad |
|---|---|---|
| **1** | Un profesor imparte **un** curso | Un profesor imparte varios |
| **2** | Un estudiante tiene **un** profesor | Un estudiante cursa varias asignaturas con varios profesores |
| **3** | **Una nota pertenece a un estudiante, no a un curso** | Una nota es siempre *de una asignatura* |

**La tercera es la grave.** Hoy no se puede responder *«¿qué sacó Ana en Matemáticas?»*, porque
la nota no sabe de qué asignatura es. Un estudiante tiene notas, sin más. Con dos asignaturas, el
sistema no distingue.

### El modelo que pide el dominio

```
  PROGRAMA ──1:N── CURSO ──N:M── PROFESOR      (un profesor imparte varios cursos)
                     │
                    N:M  ← MATRÍCULA: el estudiante se inscribe en un curso
                     │
                ESTUDIANTE
                     
  NOTA ──── pertenece a la MATRÍCULA (estudiante + curso), no al estudiante
```

Entra una entidad que hoy no existe: **`matricula`** (estudiante × curso). Y la nota cuelga de
ella. Con eso sí se puede responder *«¿qué sacó Ana en Matemáticas?»* y *«¿cuál es su promedio
del semestre?»*.

> **Decisión pendiente `D1`.** ⬜
>
> - **Opción A — dejarlo como está.** Es un ejercicio de CRUD, no un producto. Coste: 0.
> - **Opción B — meter `matricula`.** El modelo pasa a ser correcto y aparece el N:M, que es la
>   relación que **no sale en ningún tutorial de CRUD** y la que hay que saber.
>
> **Recomendación: opción B, pero no en Laravel.** Notas ya está hecho y sirve como línea base.
> **Métela en la versión de Django**: te obliga a aprender tablas intermedias, `through`, y
> consultas con dos saltos. Es la diferencia entre repetir un CRUD y aprender algo.

---

## 5. Política de borrado

**Hoy las cinco relaciones son `ON DELETE CASCADE`,** heredado del generador, no decidido.
Consecuencia real, medida el `2026-08-31`:

> Borrar **un** programa borraba sus cursos → sus profesores → sus estudiantes → sus notas.
> **Un botón vaciaba el colegio.**

Lo que debería ser:

| Al borrar | Hoy | Lo correcto | Por qué |
|---|---|---|---|
| Programa con cursos | Cascada silenciosa | **RESTRICT** | Si tiene cursos, no se borra: primero se vacía |
| Curso con profesores | Cascada | **RESTRICT** | Igual |
| Profesor con estudiantes | Cascada | **RESTRICT** | Un profesor que se va **no se lleva a sus alumnos** |
| Estudiante con notas | Cascada | **Borrado lógico** | Un expediente académico no se destruye: se archiva |

> **Decisión pendiente `D2`:** pasar a `RESTRICT` + borrado lógico en estudiantes. ⬜
> Es un cambio de migración y de mensaje de error, no de arquitectura.

---

## 6. Matriz de permisos

**Este es el documento que no existía y por eso no había autorización.** Se lee: fila = rol,
celda = qué puede hacer. `C` crear · `L` listar · `E` editar · `B` borrar · `—` nada.

| | Programa | Curso | Profesor | Estudiante | Nota |
|---|---|---|---|---|---|
| **Anónimo** | — | — | — | — | — |
| **Sin rol asignado** | — | — | — | — | — |
| **ESTUDIANTE** | — | — | — | — | **L** *(solo las suyas)* ⬜ |
| **PROFESOR** | — | — | — | `C L E B` *(los suyos)* ⬜ | `C L E B` *(de sus alumnos)* ⬜ |
| **ADMINISTRADOR** | `C L E B` | `C L E B` | `C L E B` | `C L E B` | `C L E B` |

### Lo que está en verde y lo que no

| Estado | Qué |
|---|---|
| ✅ | Anónimo y sin rol: bloqueados en el servidor. Verificado por HTTP |
| ✅ | Autorización **de tipo**: cada `—` de la tabla devuelve 403. 22 tests |
| ⬜ | Autorización **de instancia**: los paréntesis. **Nada de eso existe todavía** |

> ### La deuda que queda, dicha claramente
>
> Hoy un `ESTUDIANTE` que entra en `/notas` **ve las notas de todo el colegio**. El permiso de
> tipo funciona —no puede editar ni borrar— pero el de instancia no existe.
>
> Y no se arregla con un `where`: **no hay ninguna relación entre la tabla `users` y la tabla
> `estudiantes`**. El sistema no sabe qué estudiante es cada usuario. Es un cambio de modelo de
> datos, no un parche. Ver `D3`.

> **Decisión pendiente `D3`:** añadir `estudiantes.user_id` (y `profesores.user_id`) para poder
> filtrar por *«los míos»*. ⬜ **Es el paso `P2.1` del plan.**

---

## 7. Los flujos y sus desvíos

### Registrar una nota

| | |
|---|---|
| **Quién** | `PROFESOR` o `ADMINISTRADOR` |
| **Camino feliz** | Abre el formulario → elige alumno → tres notas → guarda → vuelve al listado con el aviso |

| Desvío | Qué tiene que pasar | Estado |
|---|---|---|
| El alumno no existe | 422, error junto al campo `RN7` | ✅ |
| Una nota es `7` en escala 0–5 | 422, *«La nota 1 debe estar entre 0 y 5»* `RN1` | ✅ |
| Una nota no es un número | 422, sin reventar | ✅ |
| Pulsa Guardar dos veces | **Un** registro. POST-Redirect-GET | ✅ |
| Otro profesor guardó la misma nota entretanto | **Sin decidir.** Hoy gana el último y nadie se entera | ⬜ `D4` |
| No es su alumno | 403 | ⬜ `D3` |

### Borrar un programa

| Desvío | Qué tiene que pasar | Estado |
|---|---|---|
| Tiene cursos colgando | **Se rechaza** y se dice cuántos cursos lo impiden | ⬜ `D2` |
| Lo intenta un anónimo | 302 al login | ✅ |
| Lo intenta un usuario sin rol | 403 | ✅ |

---

## 7 bis. Alcance negativo — lo que esta versión NO hace

**Crece, no se borra.** Un «no» sin motivo escrito se vuelve a discutir en tres meses.

| ID | Fuera de alcance | Por qué | Cuándo se replantea |
|---|---|---|---|
| `D8` | **Programa / titulación** *(«Ingeniería de Sistemas», una ficha del SENA)* | Es un concepto de formación técnica, no de colegio. Esta versión va a lo general | Cuando se haga el **módulo SENA**. Entra como módulo aparte, **no** tocando el modelo base |

> **Decidido el `2026-08-31`.** El proyecto ya tenía la tabla `programas` con datos: si se retira,
> hace falta una migración que la elimine — y decidir qué pasa con lo que hubiera dentro.

---

## 8. Decisiones pendientes — la lista corta

| ID | Qué hay que decidir | Bloquea |
|---|---|---|
| ~~`D7`~~ | ✅ `2026-08-31` — **curso = el grupo · materia = la asignatura**. Un curso tiene varias materias | *resuelto* |
| `D9` | **Cómo se conecta un usuario con un curso.** No es una sola relación: un **alumno** pertenece a **un** curso (1:N, basta una columna), pero un **docente** da varias materias en varios cursos (M:N, hace falta intermedia). La misma tabla `users` se conecta de dos formas según el rol | 🔴 El MER |
| `RN8` | ¿Escala 0–5 o 0–10? | Nada. Una constante |
| `D1` | ¿Entra la entidad `matricula`? | El modelo correcto |
| `D2` | `RESTRICT` + borrado lógico en vez de cascada | Que un clic no vacíe el colegio |
| `D3` | Relacionar `users` con `estudiantes` / `profesores` | **Toda la autorización de instancia** |
| `D4` | Edición simultánea: ¿gana el último o se avisa? | — |

> `D3` es la que más desbloquea: sin ella no hay *«mis alumnos»* ni *«mis notas»*, y sin eso el
> sistema no puede usarse de verdad en un centro.
