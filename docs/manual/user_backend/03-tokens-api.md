# Manual del Panel de Usuario — Tokens API

## Objetivo

La página de **Tokens API** permite crear, visualizar y eliminar tokens de acceso personal para la API REST de la plataforma. Los tokens API son necesarios para que aplicaciones externas, scripts o integraciones puedan comunicarse con la plataforma en tu nombre de forma segura y autenticada.

---

## Acceder a Tokens API

1. En el menú lateral del Panel de Usuario, haz clic en **Tokens API**.
2. Se cargará la página con el listado de tus tokens activos y el formulario para crear nuevos.

---

## ¿Qué es un Token API?

Un **Token API** es una cadena de texto única y secreta que actúa como «contraseña» para que aplicaciones externas accedan a la API de la plataforma en tu nombre. Cada token está asociado a tu cuenta de usuario.

Ejemplo de uso: si quieres que una aplicación móvil o un script automatizado acceda a los datos de la plataforma, necesitará un token API para autenticarse.

---

## Listado de tokens

La tabla muestra todos los tokens que has creado:

| Columna                | Descripción                                                                     |
|------------------------|---------------------------------------------------------------------------------|
| **Nombre**             | Nombre descriptivo que le asignaste al token al crearlo (ej: «Mi app móvil»).   |
| **Última vez usado**   | Fecha y hora de la última vez que se usó este token para hacer una petición a la API. Si nunca se ha usado, puede aparecer vacío. |
| **Fecha de creación**  | Fecha y hora en que creaste el token.                                           |

Los tokens se muestran ordenados del más reciente al más antiguo.

### Acciones por token

- **Eliminar**: Botón para revocar (eliminar) el token. Una vez eliminado, ya no se puede usar para autenticarse.

---

## Crear un nuevo token

1. En el campo **Nombre del token**, escribe un nombre descriptivo que te permita identificar para qué usarás este token (ej: «Integración web», «App móvil», «Script de backup»).
2. Haz clic en el botón **Crear token**.
3. Se mostrará el token generado en pantalla junto con una notificación de éxito.

### ⚠️ MUY IMPORTANTE: Copia el token inmediatamente

El token generado **solo se muestra UNA VEZ**, en el momento de su creación. Después de cerrar o recargar la página, **no podrás volver a verlo nunca más**.

**Debes copiarlo y guardarlo en un lugar seguro** antes de realizar cualquier otra acción.

Si perdiste el token sin copiarlo:
1. Elimina el token desde el listado.
2. Crea uno nuevo.

---

## Eliminar un token

1. En el listado de tokens, haz clic en el botón **Eliminar** junto al token que deseas revocar.
2. Confirma la eliminación.
3. Aparecerá una notificación: **«Token eliminado correctamente.»**

### ¿Qué ocurre al eliminar un token?

- El token queda **revocado inmediatamente**.
- Cualquier aplicación o servicio que estuviera usando ese token dejará de funcionar al instante.
- La acción es **irreversible**: no se puede recuperar un token eliminado.

---

## Cómo usar un token API

Una vez que tengas un token, puedes usarlo para autenticarte en las peticiones a la API REST de la plataforma. El token se envía en la cabecera `Authorization` de cada petición:

```
Authorization: Bearer tu-token-aqui
```

### Ejemplo práctico

Para obtener los datos de tu perfil de usuario:

```
GET https://tu-dominio.com/api/v1/auth/user
Authorization: Bearer 1|abcdef123456789...
```

### Endpoints disponibles con autenticación

| Método  | Endpoint                        | Descripción                              |
|---------|---------------------------------|------------------------------------------|
| GET     | `/api/v1/auth/user`             | Obtener tus datos de usuario.            |
| POST    | `/api/v1/auth/logout`           | Cerrar sesión (revocar token actual).    |
| GET     | `/api/v1/user/tokens`           | Listar tus tokens API.                   |
| POST    | `/api/v1/user/tokens`           | Crear un nuevo token desde la API.       |
| DELETE  | `/api/v1/user/tokens/{id}`      | Eliminar un token por su ID.             |

> Los endpoints públicos (posts, páginas, categorías) no requieren token.

---

## Buenas prácticas de seguridad

1. **No compartas tus tokens** con personas no autorizadas.
2. **Usa nombres descriptivos** para cada token, de modo que puedas identificar fácilmente qué servicio o aplicación lo usa.
3. **Elimina tokens que ya no uses**. Si dejaste de usar una integración, revoca su token.
4. **Crea tokens separados** para cada aplicación o servicio. De esta forma, si una integración se ve comprometida, puedes revocar solo ese token sin afectar al resto.
5. **Nunca incluyas tokens en código fuente público** (repositorios Git, foros, etc.).
6. **Almacena los tokens en variables de entorno** o gestores de secretos en tus aplicaciones.

---

## Preguntas frecuentes

**¿Cuántos tokens puedo crear?**
No hay un límite establecido. Puedes crear tantos tokens como necesites.

**¿Los tokens caducan?**
No, los tokens no caducan automáticamente. Se mantienen activos hasta que los elimines manualmente.

**¿Puedo ver el valor de un token después de crearlo?**
No. Por seguridad, el valor del token solo se muestra una vez, en el momento de su creación. Si lo pierdes, debes crear uno nuevo.

**¿Qué pasa con mis tokens si un administrador desactiva mi cuenta?**
Todos tus tokens dejarán de funcionar mientras tu cuenta esté desactivada, ya que cada petición a la API verifica que tu cuenta está activa.

**¿Puedo renombrar un token existente?**
No, los tokens no se pueden editar. Si necesitas cambiar el nombre, elimina el token y crea uno nuevo con el nombre deseado.

**¿Un token me da acceso al panel de administración?**
No. Los tokens API solo sirven para acceder a la API REST de la plataforma. El acceso al panel de administración o al panel de usuario se realiza mediante el inicio de sesión web con email y contraseña.
