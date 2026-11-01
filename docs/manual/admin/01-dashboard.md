# Manual del Administrador — Dashboard

*Última actualización: 2026-08-26*

## Objetivo

El **Dashboard** es la primera pantalla que verás al acceder al panel de administración. Proporciona una visión general rápida del estado de la plataforma mediante tarjetas de estadísticas, gráficos y tablas resumidas. Su propósito es que, de un solo vistazo, puedas conocer la actividad reciente y los datos más relevantes del sistema.

---

## Widgets del Dashboard

### 1. Resumen de estadísticas (Stats Overview)

En la parte superior del Dashboard se muestran **tarjetas de resumen** con las métricas principales:

| Tarjeta                     | Descripción                                                                 |
|-----------------------------|-----------------------------------------------------------------------------|
| **Usuarios activos**        | Número total de usuarios registrados que tienen la cuenta activa.           |
| **Posts publicados**        | Número total de posts con estado «Publicado» visibles en el blog.           |
| **Páginas publicadas**      | Número total de páginas con estado «Publicado» visibles en la web.          |
| **Emails enviados**         | Número total de emails enviados a través de la plataforma.                  |

Estas cifras se actualizan automáticamente cada vez que accedes al Dashboard o recargas la página.

---

### 2. Últimos emails enviados (Latest Emails)

Debajo de las estadísticas encontrarás una **tabla resumida** con los últimos 5 emails enviados desde la plataforma. Las columnas son:

| Columna        | Descripción                                                          |
|----------------|----------------------------------------------------------------------|
| **Para (To)**  | Dirección de email del destinatario.                                 |
| **Asunto**     | Asunto del email enviado.                                            |
| **Estado**     | Indica si el email fue enviado correctamente (`sent`) o si falló (`failed`). Se muestra como una etiqueta de color. |
| **Fecha**      | Fecha y hora en que se procesó el envío.                             |

Esta tabla te permite detectar rápidamente si hay problemas con el envío de emails (por ejemplo, si ves muchos emails con estado «failed»).

> **Consejo:** Para ver el historial completo de emails, accede al módulo [Emails Enviados](09-emails-enviados.md) desde el menú lateral.

---

### 3. Gráfico de Posts por mes (Posts Chart)

Un **gráfico de barras** que muestra la cantidad de posts creados por mes durante los **últimos 6 meses**. Esto te permite:

- Visualizar la tendencia de publicación de contenido.
- Identificar meses con baja actividad editorial.
- Planificar la estrategia de contenido basándote en datos reales.

El eje horizontal muestra los meses y el eje vertical la cantidad de posts creados en cada uno.

---

## Navegación desde el Dashboard

Desde el Dashboard puedes acceder a cualquier módulo del panel mediante el **menú lateral izquierdo**. Los grupos de navegación disponibles son:

- **Contenido** → Páginas, Posts, Categorías
- **Media** → Slides
- **Frontend** → Secciones
- **Sistema** → Usuarios, Configuración, Emails Enviados

Cada enlace del menú te llevará al listado correspondiente del módulo seleccionado.

---

## Preguntas frecuentes

**¿Las estadísticas se actualizan en tiempo real?**
Las estadísticas se calculan cada vez que cargas o recargas el Dashboard. No se actualizan en tiempo real sin recargar la página.

**¿Puedo personalizar los widgets del Dashboard?**
Los widgets mostrados están predefinidos por el sistema. Si necesitas widgets adicionales, contacta con el equipo de desarrollo.
