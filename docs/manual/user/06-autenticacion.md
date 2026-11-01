# Manual del Usuario — Registro e Inicio de Sesión

*Última actualización: 2026-08-26*

## Descripción

La plataforma permite crear una cuenta de usuario para acceder a funcionalidades adicionales como el Panel de Usuario, la gestión de perfil y la generación de tokens API.

---

## Registro de nueva cuenta

**URL:** `https://tu-dominio.com/register`

### Formulario de registro

| Campo                      | Obligatorio | Descripción                                                             |
|----------------------------|-------------|-------------------------------------------------------------------------|
| **Nombre**                 | ✅ Sí       | Tu nombre completo.                                                     |
| **Email**                  | ✅ Sí       | Dirección de email válida. Será tu identificador de usuario.            |
| **Contraseña**             | ✅ Sí       | Contraseña de al menos 8 caracteres.                                    |
| **Confirmar contraseña**   | ✅ Sí       | Repite la contraseña para confirmar que es correcta.                    |

### Pasos para registrarte

1. Haz clic en **Registrarse** en la barra de navegación.
2. Rellena todos los campos del formulario.
3. Haz clic en **Registrarse**.
4. Si todo es correcto, tu cuenta se creará automáticamente y serás redirigido a la plataforma.

> **Nota:** Es posible que recibas un email de bienvenida en la dirección que proporcionaste.

---

## Inicio de sesión

**URL:** `https://tu-dominio.com/login`

### Formulario de inicio de sesión

| Campo          | Obligatorio | Descripción                                    |
|----------------|-------------|------------------------------------------------|
| **Email**      | ✅ Sí       | El email con el que te registraste.            |
| **Contraseña** | ✅ Sí       | Tu contraseña de acceso.                       |
| **Recordarme** | ❌ No       | Si marcas esta casilla, la sesión se mantendrá activa durante más tiempo. |

### Pasos para iniciar sesión

1. Haz clic en **Iniciar sesión** en la barra de navegación.
2. Introduce tu email y contraseña.
3. Opcionalmente, marca la casilla «Recordarme».
4. Haz clic en **Iniciar sesión**.
5. Serás redirigido a la página principal con tu sesión activa.

---

## Recuperar contraseña olvidada

**URL:** `https://tu-dominio.com/forgot-password`

Si has olvidado tu contraseña:

1. En la pantalla de inicio de sesión, haz clic en **«¿Olvidaste tu contraseña?»**.
2. Introduce tu **dirección de email**.
3. Haz clic en **Enviar enlace de restablecimiento**.
4. Revisa tu bandeja de entrada (y la carpeta de spam) y haz clic en el enlace que recibirás.
5. Introduce tu **nueva contraseña** y confírmala.
6. Haz clic en **Restablecer contraseña**.
7. Ya puedes iniciar sesión con tu nueva contraseña.

---

## Cerrar sesión

Para cerrar tu sesión:

1. Haz clic en tu **nombre** o en el icono de perfil en la barra de navegación.
2. Selecciona **Cerrar sesión** (Logout).
3. Serás redirigido a la página principal sin sesión activa.

---

## Acceso a los paneles

Una vez que hayas iniciado sesión, puedes acceder a las siguientes áreas según tu rol:

| Rol               | Panel disponible                          | URL       |
|--------------------|-------------------------------------------|-----------|
| **User (usuario)** | Panel de Usuario                          | `/panel`  |
| **Admin**          | Panel de Administración + Panel de Usuario | `/admin` y `/panel` |
| **Superadmin**     | Panel de Administración + Panel de Usuario | `/admin` y `/panel` |

---

## Errores comunes

| Error                                               | Causa y solución                                                       |
|-----------------------------------------------------|------------------------------------------------------------------------|
| «Las credenciales no coinciden.»                    | Email o contraseña incorrectos. Verifica los datos e inténtalo de nuevo. |
| «Tu cuenta está desactivada.»                       | Un administrador ha desactivado tu cuenta. Contacta con soporte.        |
| «El campo email ya ha sido registrado.»             | Ya existe una cuenta con ese email. Usa otro email o recupera tu contraseña. |
| «La contraseña debe tener al menos 8 caracteres.»  | Tu contraseña es demasiado corta. Elige una más larga.                 |

---

## Seguridad de la cuenta

- **No compartas** tu contraseña con nadie.
- **Usa una contraseña segura** con letras, números y símbolos.
- **Cierra sesión** cuando uses un ordenador compartido o público.
- Si sospechas que alguien ha accedido a tu cuenta, **cambia tu contraseña** inmediatamente desde tu Panel de Usuario.
