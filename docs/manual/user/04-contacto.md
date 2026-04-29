# Manual del Usuario — Contacto

## Descripción

La página de **Contacto** te permite enviar un mensaje directamente a la empresa o a los responsables de la plataforma a través de un formulario web. No necesitas estar registrado ni haber iniciado sesión para enviar un mensaje.

**URL:** `https://tu-dominio.com/contact`

---

## Acceder a la página de contacto

Puedes acceder de varias formas:

- Haciendo clic en **Contacto** en la barra de navegación superior.
- Haciendo clic en **Contacto** en el pie de página.

---

## Formulario de contacto

El formulario de contacto incluye los siguientes campos:

| Campo         | Obligatorio | Descripción                                                                                       |
|---------------|-------------|---------------------------------------------------------------------------------------------------|
| **Nombre**    | ✅ Sí       | Tu nombre completo. Se usa para identificar quién envía el mensaje.                               |
| **Email**     | ✅ Sí       | Tu dirección de correo electrónico. Debe ser un email válido. Se usará para responder a tu mensaje. |
| **Asunto**    | ✅ Sí       | Tema o motivo de tu mensaje. Sé breve y descriptivo (ej: «Pregunta sobre servicios»).             |
| **Mensaje**   | ✅ Sí       | El contenido de tu mensaje. Describe detalladamente tu consulta, sugerencia o solicitud.           |

---

## Enviar el mensaje

1. Rellena todos los campos del formulario.
2. Haz clic en el botón **Enviar** (o similar).
3. Si todo es correcto, verás un mensaje de éxito: **«Mensaje enviado correctamente.»**
4. La empresa recibirá tu mensaje por email y podrá responderte a la dirección que indicaste.

---

## Errores de validación

Si algún campo no se ha rellenado correctamente, verás mensajes de error debajo de los campos correspondientes:

| Error                                | Causa                                                   |
|--------------------------------------|---------------------------------------------------------|
| «El campo nombre es obligatorio.»   | No has escrito tu nombre.                               |
| «El campo email es obligatorio.»    | No has escrito tu email.                                |
| «El campo email debe ser un email válido.» | El formato del email no es correcto (ej: falta la @). |
| «El campo asunto es obligatorio.»   | No has escrito el asunto del mensaje.                   |
| «El campo mensaje es obligatorio.»  | No has escrito el contenido del mensaje.                |

Corrige los errores indicados y vuelve a enviar el formulario.

---

## Información adicional de contacto

Junto al formulario, es posible que se muestre información adicional dependiendo de la configuración del sitio:

- **Dirección postal** de la empresa.
- **Teléfono** de contacto.
- **Email** de contacto directo.
- **Horario de atención**.
- **Mapa** de ubicación (si está configurado).

Esta información proviene de las secciones dinámicas de la zona `contact` y de la configuración del sistema.

---

## Preguntas frecuentes

**¿Necesito crear una cuenta para contactar?**
No, el formulario de contacto es público y no requiere registro ni inicio de sesión.

**¿Recibiré confirmación de que mi mensaje fue enviado?**
Verás un mensaje de éxito en pantalla inmediatamente después de enviar. Dependiendo de la configuración, también podrías recibir un email de confirmación.

**¿Cuánto tardan en responder?**
El tiempo de respuesta depende de la empresa. El sistema envía tu mensaje inmediatamente, pero la respuesta depende de los responsables.

**¿Puedo enviar archivos adjuntos?**
No, el formulario de contacto estándar no admite archivos adjuntos. Si necesitas enviar documentos, indícalo en el mensaje y te indicarán cómo hacerlo.
