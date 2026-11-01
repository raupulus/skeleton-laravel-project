# Manual del Panel de Usuario — Introducción

*Última actualización: 2026-08-26*

## ¿Qué es el Panel de Usuario?

El **Panel de Usuario** es una zona privada de la plataforma donde cualquier usuario registrado puede gestionar su perfil personal y sus tokens de acceso a la API. Se accede desde la ruta `/panel`.

A diferencia del Panel de Administración, el Panel de Usuario **no permite gestionar contenido del sitio web**. Está diseñado exclusivamente para que cada usuario administre su propia cuenta.

---

## ¿Quién puede acceder?

Cualquier usuario registrado con la cuenta activa (`is_active = true`) puede acceder al Panel de Usuario, independientemente de su rol (superadmin, admin o user).

- Los usuarios con rol `superadmin` o `admin` también pueden acceder al Panel de Administración (`/admin`).
- Los usuarios con rol `user` solo tienen acceso al Panel de Usuario (`/panel`).

---

## ¿Cómo acceder?

1. Abre tu navegador y dirígete a `https://tu-dominio.com/panel`.
2. Introduce tu **email** y **contraseña**.
3. Pulsa el botón **Iniciar sesión**.

Si tus credenciales son correctas y tu cuenta está activa, serás redirigido al **Dashboard** del panel de usuario.

> **Nota:** Si todavía no tienes cuenta, puedes registrarte desde la página de registro de la web (`https://tu-dominio.com/register`).

---

## Estructura del menú lateral

El menú lateral del Panel de Usuario contiene:

| Entrada          | Descripción                                                  |
|------------------|--------------------------------------------------------------|
| **Dashboard**    | Pantalla de bienvenida con resumen de tu cuenta.             |
| **Mi Perfil**    | Editar tu nombre, avatar y contraseña.                       |
| **Tokens API**   | Gestionar tus tokens de acceso a la API de la plataforma.    |

Cada funcionalidad se explica en detalle en su propio archivo de este manual.

---

## Índice de funcionalidades

1. [Dashboard](01-dashboard.md)
2. [Mi Perfil](02-mi-perfil.md)
3. [Tokens API](03-tokens-api.md)
