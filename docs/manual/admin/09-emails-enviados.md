# Manual del Administrador — Emails Enviados

## Objetivo

El módulo de **Emails Enviados** proporciona un registro completo de todos los correos electrónicos que la plataforma ha enviado. Funciona como un **log de auditoría** de emails que permite verificar qué se envió, a quién, cuándo y si el envío fue exitoso o falló. Este módulo se encuentra en el grupo **Sistema** del menú lateral.

Este módulo es de **solo lectura**: no se pueden crear, editar ni eliminar registros manualmente. Los registros se generan automáticamente cada vez que la plataforma envía un email (bienvenida a nuevos usuarios, formulario de contacto, emails genéricos, etc.).

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Sistema**.
2. Selecciona **Emails Enviados**.
3. Verás el listado de todos los emails enviados, ordenados del más reciente al más antiguo.

---

## Listado de emails enviados

| Columna               | Descripción                                                                                     |
|------------------------|-------------------------------------------------------------------------------------------------|
| **Para (To)**          | Dirección de email del destinatario. Buscable.                                                  |
| **Asunto (Subject)**   | Asunto del email enviado, truncado a 50 caracteres. Buscable.                                   |
| **Clase del Mailable** | Tipo técnico del email enviado (ej: `WelcomeMail`, `ContactMail`, `GenericMail`). Truncado a 30 caracteres. |
| **Estado (Status)**    | Estado del envío, mostrado como etiqueta de color: **verde** para «Enviado» (`sent`), **rojo** para «Fallido» (`failed`). |
| **Fecha de creación**  | Fecha y hora en que se procesó el envío, formato `dd/mm/aaaa HH:mm`. Ordenable.                |

> El listado está ordenado por defecto por **Fecha de creación** de más reciente a más antiguo.

### Búsqueda

Usa el campo de búsqueda para buscar emails por **dirección de destinatario** o por **asunto**.

---

## Ver detalle de un email

Para ver el contenido completo de un email enviado:

1. Haz clic en el botón **Ver** (icono de ojo) en la fila del email.
2. Se abrirá un modal o pantalla con el detalle completo:
   - **Destinatario (To)**: Email completo a donde se envió.
   - **Asunto (Subject)**: Asunto completo del email.
   - **Clase del Mailable**: Tipo de email que se envió (ej: WelcomeMail, ContactMail).
   - **Estado**: Si fue enviado correctamente o si falló.
   - **Cuerpo del email (Body)**: Contenido HTML completo del email tal como se envió. Puedes revisarlo para verificar que la información era correcta.
   - **Fecha**: Cuándo se intentó enviar.

---

## Tipos de emails que registra el sistema

| Tipo de email    | Clase             | Cuándo se envía                                                       |
|------------------|-------------------|-----------------------------------------------------------------------|
| **Bienvenida**   | `WelcomeMail`     | Cuando un nuevo usuario se registra en la plataforma.                 |
| **Contacto**     | `ContactMail`     | Cuando un visitante envía el formulario de contacto.                  |
| **Genérico**     | `GenericMail`     | Email personalizado enviado desde el sistema con contenido dinámico.  |

---

## Interpretación de estados

| Estado      | Color  | Significado                                                                    |
|-------------|--------|--------------------------------------------------------------------------------|
| **Sent**    | 🟢 Verde | El email se envió correctamente al servidor de correo.                        |
| **Failed**  | 🔴 Rojo  | El envío falló. Posibles causas: servidor de email caído, configuración incorrecta, dirección del destinatario inválida. |

### ¿Qué hacer si hay muchos emails con estado «Failed»?

1. **Verifica la configuración de email** del sistema (servidor SMTP, credenciales, puerto).
2. **Revisa los logs del servidor** para obtener más detalles del error.
3. **Contacta al equipo técnico** si el problema persiste, ya que puede ser un problema de infraestructura.

---

## Limitaciones del módulo

- **Solo lectura**: No puedes crear, editar ni eliminar registros de emails.
- **Sin reenvío**: No hay función para reenviar un email desde este módulo.
- **Sin adjuntos**: El registro del body del email es una representación del contenido enviado; no se almacenan archivos adjuntos si los hubiera.

---

## Preguntas frecuentes

**¿El estado «Sent» garantiza que el destinatario recibió el email?**
No. «Sent» significa que el email fue entregado correctamente al servidor de correo. La entrega final al buzón del destinatario depende de su servidor de email, filtros antispam, etc.

**¿Por cuánto tiempo se guardan los registros de emails?**
Los registros se almacenan indefinidamente en la base de datos. No hay un proceso automático de limpieza.

**¿Puedo exportar el listado de emails enviados?**
No hay una función de exportación integrada. Si necesitas exportar los datos, contacta al equipo técnico.

**¿Los emails de recuperación de contraseña aparecen aquí?**
Solo si se envían a través del `EmailService` del sistema. Los emails de recuperación nativos de Laravel pueden no aparecer en este registro si se envían directamente sin pasar por el servicio.
