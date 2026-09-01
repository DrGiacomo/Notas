# 2026-09-01 · Lo malo

## Titular

**Casi todo lo malo del día lo cometió el asistente, no el autor.** Y lo mismo tres veces: cifras
y modelos escritos de memoria, sin comprobarlos. Del lado del autor, un solo apunte real.

---

## 1. 🔴 El plan mintió con sus propias cifras, dos veces el mismo día

**Qué pasó.** El `PLAN_PASO_A_PASO` decía *«19 de 34 pasos»*. Al contarlos con `grep` salieron
**40**, y los cerrados **24**. Corregido — y en la corrección volvió a fallar: la cabecera decía
**25**, la tabla **26** y contando salían **24**. *Tres cifras del mismo número en el mismo
archivo.*

**Causa.** No fue despiste. **Fue escribir el número en tres sitios.** Un dato repetido se
desincroniza siempre; la primera vez, además, se escribió de memoria sin contar nada.

**Lección.** Es `A9` de `LECCIONES.md` y la fila de §1 sobre aplicar algo en unos sitios y no en
todos, juntas. El arreglo bueno no fue corregir las tres: fue **dejar el número en un solo sitio**
y poner el comando que lo cuenta. **Lo cazó una pregunta del autor, no una revisión.**

## 2. 🔴 Se le dio el MER hecho en las dos últimas columnas

**Qué pasó.** Tras cuatro rondas sin que acertara las dos columnas que faltaban, el asistente las
escribió.

**Causa.** Se interpretó que cuatro intentos fallidos significaban que el método pedagógico no
funcionaba. **Pero la salida ya estaba ofrecida y el autor no la había pedido** — siguió
iterando, que es exactamente la señal de que quería seguir intentándolo.

**Lección.** *Ofrecer la salida no es lo mismo que tomarla.* Mientras siga intentándolo, se
cambia **la forma de explicar** —filas reales, otro dominio, otra analogía— nunca el resultado.
De aquí nace la **regla 3** del ejercicio. Que la lección la escriba el que la sufrió y no el que
la cometió dice algo del método.

## 3. El orden de migraciones propuesto no se podía ejecutar

**Qué pasó.** El asistente entregó el modelo con `users → cursos` y `cursos → users` a la vez.
**Dependencia circular: no hay orden posible.** Lo detectó el autor.

**Causa.** Se escribió el listado pensando en el modelo conceptual y no se comprobó contra la
regla que el propio documento contiene: *«una tabla no puede apuntar a otra que no existe»*.

**Lección.** **Un modelo de datos no está terminado hasta que se ordena.** Ordenarlo es lo que
saca los ciclos, y un ciclo casi siempre significa que **falta una tabla en medio** — aquí,
`matricula`. El orden no es presentación: es una comprobación.

## 4. Se diagnosticó mal la causa del ciclo

**Qué pasó.** El autor supuso que `Programa` resolvía el círculo. No lo resolvía: el modelo viejo
era una cadena y no tenía ciclos por otra razón.

**Causa.** El ciclo apareció **al unificar a las personas en `users`**, no al quitar `Programa`.
Al desaparecer la separación entre profesores y estudiantes, las dos flechas pasaron a ir entre
las mismas dos tablas en direcciones opuestas.

**Lección.** Es el único apunte del día del lado del autor, y es menor: **la causa de un problema
nuevo suele estar en el último cambio que se hizo, no en el que se quitó.** Si se hubiera dado
por buena, habría vuelto `Programa` por un motivo falso.

---

## Deuda que queda del día

**El MER cambió y el código sigue siendo el viejo.** Las fases `B1` y `B2` están marcadas como
cerradas contra el modelo antiguo. Al aplicar el nuevo hay que reabrirlas — anotado en
`retomar/PROGRESO.md` para que no parezca un olvido dentro de tres semanas.

No es un retroceso: **es lo que pasa cuando el papel se hace después del código**, que es justo
lo que este ejercicio viene a corregir.
