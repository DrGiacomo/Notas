# 📇 Índice de la documentación — Notas

> **Qué es este documento.** Qué documento responde qué pregunta, y cuándo se toca.
> Existe para que nadie escriba el cuarto documento de contexto porque no encontró los tres
> que ya hay.
>
> **Fecha:** `2026-08-31`

---

## Los documentos

| Documento | Responde | Se toca cuando |
|---|---|---|
| `BIBLIA_PROYECTO.md` ⬜ | ¿Por qué existe esto y qué **no** va a ser? | Cambia qué es el proyecto o para quién. **No** si cambia una librería |
| [`MODELO_DE_DATOS.md`](MODELO_DE_DATOS.md) | ¿Qué existe, qué valores caben, quién puede tocar qué y qué pasa al borrar? | Cambia una regla de negocio, una entidad o un permiso |
| [`../../retomar/PLAN_PASO_A_PASO.md`](../../retomar/PLAN_PASO_A_PASO.md) | ¿Qué hago ahora y por qué esto antes que aquello? **Vive en `retomar/`: es común a los cuatro frameworks** | Al cerrar cada paso |
| `FEATURES.md` ⬜ | ¿Qué hay que hacer y en qué estado está? | Al cerrar una funcionalidad |
| `CONTEXTO_TECNICO.md` ⬜ | ¿Cómo arranco esto en una máquina limpia? | Cambia el stack o un comando |
| [`auditorias/`](auditorias/) | ¿Qué estaba mal, y cuándo se midió? | Tras cada `/audit`, `/perfeccionar` o revisión |
| `recorrido/` | ¿Cómo se resolvió cada bloque, con qué evidencia? | **Al cerrar un bloque. Sin su archivo, el bloque no está terminado** |
| `propuestas/` | Lo que aún no se decide | — · **Ninguna autoridad** hasta que se aprueba |
| [`../curva/`](../curva/) | El registro **humano** del día | Al cerrar la jornada |

⬜ = todavía no existe. `BIBLIA_PROYECTO.md` la genera la skill `biblia`; `FEATURES.md` y
`CONTEXTO_TECNICO.md`, la skill `arrancar-proyecto`.

---

## Fuera del proyecto, pero manda igual

| Documento | Qué aporta |
|---|---|
| [`Docs/ESTANDAR_DE_PROYECTO.md`](../../Docs/ESTANDAR_DE_PROYECTO.md) | Cómo se organiza, se escribe y se registra el trabajo — **el proceso** |
| [`retomar/CHECKLIST_APP_WEB.md`](../../retomar/CHECKLIST_APP_WEB.md) | Qué hay que resolver para que una app web funcione de verdad |
| [`retomar/PROGRESO.md`](../../retomar/PROGRESO.md) | Por dónde va este proyecto y los otros tres frameworks |
| [`LECCIONES.md`](../../LECCIONES.md) | Las reglas que rigen todo el trabajo de la casa |

---

## Cadena de autoridad

Cuando dos documentos se contradicen, gana el de más arriba:

```
BIBLIA_PROYECTO.md
      ▼
MODELO_DE_DATOS.md  ·  PLAN_PASO_A_PASO.md  ·  FEATURES.md
      ▼
recorrido/  ·  CONTEXTO_TECNICO.md  ·  auditorias/
      ▼
propuestas/          ← ninguna autoridad: son ideas hasta que se deciden
```

Y la excepción: **entre un documento y el código gana el código** — salvo que el documento sea la
biblia, en cuyo caso el que está mal es el código. Eso lo comprueba la skill `converger`.

---

## Por dónde empezar si llegas hoy

1. **[`auditorias/revision-2026-08-31.md`](auditorias/revision-2026-08-31.md)** — qué estaba roto
   y qué se arregló. Tiene un apéndice que separa **lo que se leyó de lo que se midió**.
2. **[`MODELO_DE_DATOS.md`](MODELO_DE_DATOS.md)** — el dominio, y las cinco decisiones abiertas.
3. **[`retomar/PROGRESO.md`](../../retomar/PROGRESO.md)** — dónde va el proyecto.
   El siguiente paso es el `A6`.
