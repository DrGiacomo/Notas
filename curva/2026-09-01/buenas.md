# 2026-09-01 · Lo bueno

## Titular

**Buen día.** El MER quedó rediseñado y contesta las cuatro preguntas de control. Pero lo que más
vale del día no es el MER: es la regla que se puso él solo al darse cuenta de que se lo estaban
dando hecho.

---

## 1. ⭐ Se cazó a sí mismo cayendo en lo que vino a evitar

> *«ya tengo un MER que no hice yo, volví a caer en el vibe code»*

Nadie se lo dijo. Estaba el MER terminado, funcionando, con las cuatro preguntas en verde — y en
vez de darlo por bueno, miró **cómo** había llegado ahí.

De ahí sale la **regla 3 del ejercicio**: *la IA explica y señala el hueco, no lo rellena.*
Escrita en `retomar/README.md` y en la memoria del asistente.

Es `auditar-el-instrumento-no-el-resultado` aplicado a sí mismo, que es la versión difícil.

## 2. Dedujo el orden de dependencias sin que se lo dijeran

Preguntó por qué `Cursos` aparecía «tan arriba» si se creaba después, **y tenía razón**: el orden
propuesto no se podía migrar. Además había una dependencia circular que el asistente no había
visto al escribirlo.

Y lo explicó con una paradoja de viaje en el tiempo. La analogía era mejorable —se afinó a «el
registro civil»— pero el mecanismo lo tenía entero.

## 3. El rediseño del MER es suyo en lo esencial

De siete tablas, las decisiones de fondo las tomó él:

| | |
|---|---|
| **Unificar a las personas en `users`** | El mejor cambio del rediseño. Docente, alumno y director pasan a ser roles, no tablas |
| **`Curso_Materia`** | La intermedia del N:M |
| **Colgar la nota de `Curso_Materia`** | Más fino de lo que se le había pedido: la nota es de *«Matemáticas en 11B»*, no de *«Matemáticas»* |

Lo que se le dio hecho fueron **dos columnas**, tras cuatro rondas.

## 4. Vio que sus preguntas eran material, no ruido

> *«esto le puede gustar al gusano»*

Convirtió su propia ignorancia en corpus. Y es corpus con una propiedad que a `LECCIONES.md §12`
le falta en los cuatro proyectos: **nadie eligió estos casos, surgieron.** La pregunta `V4`
—*«¿quién eligió los casos?»*— aquí no tiene a quién señalar.

Nace `Docs/GUSANO_BANCO_TERMINOS.md` con siete términos y el primer perfil de cliente objetivo
que no sale de una suposición.

## 5. Separó planeación de ejecución

El plan mezclaba papel y código y no se entendía. Lo pidió partido en dos, y con eso la pregunta
*«¿los permisos van con el CRUD o no?»* se contesta sola: **decidir** quién puede qué es papel;
**impedir** que otro lo haga es código.

## 6. Se organizó el material fuera de un proyecto

`retomar/` deja de ser «cosas de Notas» y pasa a ser el santo y seña del ejercicio para los cuatro
frameworks. Movido, no copiado — una sola copia, heredada.
