# Acciones del sistema

## Objetivo

La sección **Acciones** del panel de administración proporciona herramientas de mantenimiento del sistema. Permite regenerar el sitemap, limpiar la caché y consultar los logs del servidor.

Se accede desde el menú lateral, en el grupo **Acciones**.

---

## Regenerar Sitemap

### Descripción
Regenera el archivo `sitemap.xml` que indica a los motores de búsqueda (Google, Bing, etc.) las páginas disponibles en el sitio web.

### Cómo usar
1. Acceder a **Acciones → Regenerar Sitemap**
2. Pulsar el botón **Regenerar Sitemap** en la cabecera
3. Confirmar en el modal que aparece
4. Esperar la notificación de éxito

### Cuándo usarlo
- Después de publicar o despublicar posts/páginas
- Después de cambios importantes en la estructura del sitio
- Periódicamente para mantener actualizado el sitemap

---

## Limpiar Caché

### Descripción
Limpia toda la caché del sistema: configuración, rutas, vistas, eventos y caché general.

### Cómo usar
1. Acceder a **Acciones → Limpiar Caché**
2. Leer las advertencias mostradas en la página
3. Pulsar el botón **Limpiar Caché** en la cabecera
4. Confirmar en el modal

### ⚠️ Consecuencias
- Se cerrarán todas las sesiones activas de usuarios
- Se vaciarán los datos en caché (settings, consultas, etc.)
- Las colas de eventos pendientes pueden interrumpirse
- La primera carga tras limpiar será más lenta hasta que se regenere la caché

### Cuándo usarlo
- Después de cambiar configuraciones del sistema
- Cuando las páginas no muestran datos actualizados
- Tras una actualización del código de la plataforma

---

## Ver Logs

### Descripción
Muestra un listado de todos los archivos de log de Laravel, ordenados por fecha de modificación descendente.

### Columnas del listado
| Columna | Descripción |
|---------|-------------|
| Archivo | Nombre del archivo de log |
| Tamaño | Tamaño del archivo en KB |
| Última modificación | Fecha y hora de la última escritura |
| Acciones | Botones para ver y descargar |

### Cómo usar
1. Acceder a **Acciones → Ver Logs**
2. Se muestra la tabla con todos los archivos `.log` disponibles
3. Pulsar **Ver** para abrir un modal con el contenido del log (últimas 500 líneas)
4. Pulsar **Descargar** para descargar el archivo completo
5. En el modal, se puede descargar o cerrar

### Utilidad
- Depuración de errores del sistema
- Revisión de actividad del servidor
- Descarga de logs para análisis externo

---

## Widget en el Dashboard

En el dashboard principal del panel admin aparece un widget de **Log de errores** que muestra:
- Nombre del último archivo de log
- Su tamaño y fecha de modificación
- Botón para descargar directamente
- Enlace para ir a la página de Ver Logs

---

## Preguntas frecuentes

**¿Puedo regenerar el sitemap sin consecuencias?**
Sí, regenerar el sitemap es completamente seguro y no afecta al funcionamiento del sitio.

**¿Qué pasa si limpio la caché estando otros usuarios conectados?**
Se cerrarán sus sesiones y deberán volver a iniciar sesión.

**¿Los logs se borran al limpiar la caché?**
No, los archivos de log no se ven afectados por la limpieza de caché.
