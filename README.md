# Portal Martiano — Cátedra Honorífica de Estudios Martianos

Portal web institucional de la **Cátedra Honorífica de Estudios Martianos** desarrollado con WordPress y un tema personalizado desde cero.

## Requisitos

- **Docker** ≥ 24.x
- **Docker Compose** ≥ 2.x
- 512 MB de RAM libres (mínimo)

> No necesitas PHP, MySQL ni Apache instalados localmente. Todo corre dentro de contenedores Docker.

## Inicio rápido

```bash
# 1. Clonar/entrar al proyecto
cd portal-martiano

# 2. Levantar los contenedores
docker compose up -d

# 3. Esperar ~30 segundos en el primer arranque y abrir:
#    WordPress:   http://localhost:8080
#    phpMyAdmin:  http://localhost:8081
```

### Detener los contenedores

```bash
docker compose down          # Detiene (preserva datos)
docker compose down -v       # Detiene y BORRA volúmenes (base de datos)
```

## Servicios

| Servicio    | URL                      | Credenciales                       |
| ----------- | ------------------------ | ---------------------------------- |
| WordPress   | http://localhost:8080    | Configurar en el asistente inicial |
| phpMyAdmin  | http://localhost:8081    | root / `root_pm_2026`             |
| MariaDB     | localhost:3306 (interno) | pm_user / `pm_pass_2026`          |

## Estructura del proyecto

```
portal-martiano/
├── docker-compose.yml
├── .env                          # Variables de entorno (no subir a git)
├── .gitignore
├── php/
│   └── uploads.ini               # Config PHP personalizada
├── wp-content/
│   └── themes/
│       └── catedra-marti/        # Tema personalizado
│           ├── style.css          # Metadata del tema
│           ├── functions.php      # Carga módulos
│           ├── inc/               # Módulos funcionales
│           │   ├── setup.php              # Soporte del tema
│           │   ├── enqueue.php            # Scripts y estilos
│           │   ├── custom-post-types.php  # 6 CPTs
│           │   ├── custom-fields.php      # Metaboxes
│           │   ├── ajax-handlers.php      # AJAX (scroll infinito, calendario)
│           │   ├── comments.php           # Config de comentarios
│           │   ├── social-share.php       # Botones compartir
│           │   ├── widgets.php            # Widget de contacto
│           │   ├── roles.php              # Permisos y roles
│           │   └── customizer.php         # Panel de personalización
│           ├── assets/
│           │   ├── css/
│           │   │   ├── main.css           # Estilos globales
│           │   │   └── front-page.css     # Estilos de inicio
│           │   └── js/
│           │       ├── main.js            # JS global
│           │       ├── infinite-scroll.js # Scroll infinito
│           │       └── calendar.js        # Calendario interactivo
│           ├── template-parts/            # Partes reutilizables
│           ├── header.php / footer.php
│           ├── front-page.php             # Página de inicio
│           ├── index.php / page.php / single.php / archive.php
│           ├── archive-{cpt}.php / single-{cpt}.php
│           ├── comments.php / search.php / 404.php
│           └── screenshot.png             # (pendiente)
└── README.md
```

## Custom Post Types

| CPT          | Slug            | Descripción                        |
| ------------ | --------------- | ---------------------------------- |
| Noticias     | `noticia`       | Noticias del portal                |
| Avisos       | `aviso`         | Avisos con prioridad y vigencia    |
| Actividades  | `actividad`     | Actividades con fechas y lugar     |
| Eventos      | `evento`        | Eventos con inscripción            |
| Curiosidades | `curiosidad`    | Datos curiosos con fuente          |
| Documentos   | `documento`     | Archivos descargables              |

## WP-CLI

Se incluye WP-CLI como servicio Docker (perfil `tools`):

```bash
# Ejecutar WP-CLI
docker compose run --rm wpcli option get siteurl

# Activar tema
docker compose run --rm wpcli theme activate catedra-marti

# Crear usuario admin (primera vez)
docker compose run --rm wpcli core install \
  --url="http://localhost:8080" \
  --title="Portal Martiano" \
  --admin_user=admin \
  --admin_password=admin123 \
  --admin_email=admin@portal.local

# Importar contenido de prueba
docker compose run --rm wpcli plugin install wordpress-importer --activate
```

## Configuración inicial en WordPress

1. Acceder a `http://localhost:8080` y completar el asistente de instalación.
2. Ir a **Apariencia → Temas** y activar **Cátedra Marti**.
3. Ir a **Ajustes → Lectura** y seleccionar "Una página estática" como página de inicio.
4. Ir a **Apariencia → Personalizar → Portal Martiano** para configurar:
   - Redes sociales
   - Información de contacto
   - Contenido del hero y bienvenida
5. Crear los menús en **Apariencia → Menús**:
   - **Menú Principal** (ubicación: primary)
   - **Menú Footer** (ubicación: footer)
   - **Redes Sociales** (ubicación: social)

## Roles y permisos

- **Administrador**: Control total del sitio.
- **Editor**: Gestiona todo el contenido (noticias, avisos, eventos, etc.). Puede editar opciones del tema (enlaces de interés).
- **Suscriptor**: Solo puede ver contenido y dejar comentarios. No accede al panel de administración.

---

## Guía de Administración del Portal

Esta sección está dirigida al **personal encargado de gestionar el contenido** del portal. No se requieren conocimientos de programación.

### Acceso al Panel de Administración

1. Abrir el navegador e ir a: **http://localhost:8080/wp-admin**
2. Introducir usuario y contraseña proporcionados por el administrador del sistema.
3. Una vez dentro, verás el **Escritorio** con acceso a todas las secciones.

### Publicar una Noticia

1. En el menú lateral, hacer click en **Noticias → Añadir nueva**.
2. Escribir el **título** de la noticia en el campo superior.
3. Redactar el contenido en el editor de texto (se puede dar formato con negritas, listas, imágenes, etc.).
4. En el panel derecho, hacer click en **"Imagen destacada" → Establecer imagen destacada** para subir o elegir una foto de portada.
5. Hacer click en el botón azul **"Publicar"**.

> Para **editar** una noticia existente: ir a **Noticias → Todas las noticias**, pasar el ratón sobre la noticia deseada y hacer click en "Editar". Para **eliminarla**, hacer click en "Papelera".

### Publicar un Aviso

1. Ir a **Avisos → Añadir nuevo**.
2. Escribir título y contenido del aviso.
3. Debajo del editor aparece un recuadro llamado **"Datos del Aviso"** con dos campos:
   - **Prioridad**: seleccionar entre `alta`, `media` o `baja`.
   - **Fecha de vigencia**: escribir la fecha límite del aviso en formato `AAAA-MM-DD` (ejemplo: `2026-06-30`). Los avisos vencidos dejarán de mostrarse automáticamente en la portada.
4. Hacer click en **"Publicar"**.

### Registrar una Actividad (aparece en el Calendario)

1. Ir a **Actividades → Añadir nueva**.
2. Escribir título y descripción de la actividad.
3. En el recuadro **"Datos de la Actividad"** completar:
   - **Fecha de inicio**: en formato `AAAA-MM-DD` (ejemplo: `2026-03-15`).
   - **Fecha de fin**: en formato `AAAA-MM-DD`.
   - **Lugar**: escribir la ubicación (ejemplo: "Aula Magna, Edificio 3").
4. Hacer click en **"Publicar"**.

> Las actividades aparecen automáticamente en el **calendario interactivo** de la página de inicio. Los días con actividades se resaltan en color y al hacer click muestran los detalles.

### Registrar un Evento

1. Ir a **Eventos → Añadir nuevo**.
2. Escribir título y descripción.
3. En el recuadro **"Datos del Evento"** completar:
   - **Fecha**: `AAAA-MM-DD` (ejemplo: `2026-04-10`).
   - **Hora**: `HH:MM` (ejemplo: `14:30`).
   - **Lugar**: ubicación del evento.
   - **URL de inscripción** (opcional): si existe un formulario de inscripción externo, pegar aquí el enlace. Se mostrará un botón "Inscribirse al Evento".
4. Subir una **imagen destacada** representativa.
5. Hacer click en **"Publicar"**.

> Los eventos próximos (con fecha futura) aparecen automáticamente en la portada.

### Subir Fotos a la Galería

1. En el menú lateral, ir a **Medios → Añadir nuevo archivo de medios**.
2. **Arrastrar y soltar** las imágenes desde la computadora al área indicada, o hacer click en **"Seleccionar archivos"** para buscarlas.
3. (Recomendado) Hacer click sobre cada imagen subida y rellenar:
   - **Título**: nombre descriptivo de la imagen.
   - **Texto alternativo**: descripción breve para accesibilidad.
   - **Leyenda**: texto que aparecerá como pie de foto en la galería.

> Las últimas 6 imágenes aparecen en la portada. Todas se muestran en la página **Galería** (accesible desde el enlace "Ver galería"). Al hacer click sobre una imagen se abre un visor a pantalla completa con navegación.

### Publicar una Curiosidad Martiana

1. Ir a **Curiosidades → Añadir nueva**.
2. Redactar el dato curioso.
3. En **"Datos de la Curiosidad"**, escribir la **Fuente** (libro, artículo o referencia de donde proviene).
4. Opcionalmente agregar imagen destacada.
5. Hacer click en **"Publicar"**.

### Subir un Documento Descargable

1. Ir a **Documentos → Añadir nuevo**.
2. Escribir título y una breve descripción del documento.
3. En el recuadro **"Archivo del Documento"**:
   - Hacer click en **"Seleccionar archivo"** y subir el archivo (PDF, DOC, DOCX, etc.).
   - Escribir la **categoría** del documento (ejemplo: "Obras", "Investigaciones", "Actas").
4. Hacer click en **"Publicar"**.

> Los visitantes podrán descargar el archivo directamente desde la tarjeta del documento.

### Configurar el Video Destacado

1. Ir a **Apariencia → Personalizar** (en el menú lateral).
2. Hacer click en **Portal Martiano → Página de Inicio**.
3. Rellenar los campos:
   - **URL del Video**: pegar el enlace de YouTube o Vimeo (ejemplo: `https://www.youtube.com/watch?v=XXXXX`).
   - **Título del Video**: texto que aparecerá como encabezado de la sección.
4. Hacer click en **"Publicar"** (botón azul arriba).

### Configurar Redes Sociales e Información de Contacto

1. Ir a **Apariencia → Personalizar → Portal Martiano**.
2. En la sección **"Redes Sociales"**: pegar las URLs de Facebook, Twitter/X, Instagram, YouTube, Telegram y correo electrónico.
3. En la sección **"Info de Contacto"**: escribir dirección física, teléfono, correo y horario de atención.
4. Hacer click en **"Publicar"**.

### Configurar el Banner Principal (Hero)

1. Ir a **Apariencia → Personalizar → Portal Martiano → Página de Inicio**.
2. Modificar:
   - **Título del Hero**: texto grande principal.
   - **Descripción del Hero**: subtítulo.
   - **Imagen del Hero**: imagen de fondo del banner.
   - **URL del Botón Principal**: a dónde lleva el botón del banner.
   - **Título de Bienvenida** y **Mensaje de Bienvenida**: sección introductoria debajo del banner.
3. Hacer click en **"Publicar"**.

### Administrar Menús de Navegación

1. Ir a **Apariencia → Menús**.
2. Crear o editar los siguientes menús:

| Nombre del menú     | Ubicación (en "Gestionar Ubicaciones") | Qué incluir                                 |
| -------------------- | --------------------------------------- | ------------------------------------------- |
| **Menú Principal**   | Menú principal (primary)               | Inicio, Noticias, Eventos, Actividades, Galería |
| **Menú Footer**      | Menú del footer (footer)               | Enlaces del pie de página                   |
| **Redes Sociales**   | Menú social (social)                   | URLs de las redes sociales                  |

3. Para agregar elementos: marcar las páginas/categorías en el panel izquierdo y hacer click en "Añadir al menú".
4. Arrastrar los elementos para reordenarlos.
5. Hacer click en **"Guardar menú"**.

### Moderar Comentarios

Los comentarios de los visitantes **requieren aprobación** antes de ser visibles:

1. Ir a **Comentarios** en el menú lateral.
2. Los comentarios pendientes aparecen resaltados.
3. Para cada comentario, se puede:
   - **Aprobar**: hace visible el comentario en el sitio.
   - **Rechazar** / **Spam**: oculta el comentario.
   - **Eliminar**: borra el comentario permanentemente.
   - **Responder**: escribir una respuesta como administrador.

> Los comentarios están habilitados únicamente en **Noticias** y **Eventos**.

### Gestionar Usuarios

1. Ir a **Usuarios → Añadir nuevo**.
2. Completar nombre de usuario, correo y contraseña.
3. Seleccionar el **rol** adecuado:

| Rol              | ¿Qué puede hacer?                                                |
| ---------------- | ----------------------------------------------------------------- |
| **Administrador** | Control total: configuración, temas, usuarios y contenido.       |
| **Editor**        | Crear, editar y eliminar todo el contenido. Gestionar menús.     |
| **Suscriptor**    | Solo leer contenido y dejar comentarios (no accede al panel de admin). |

4. Hacer click en **"Añadir nuevo usuario"**.

### Buscador del Portal

- El buscador se encuentra en la **barra superior** del sitio (visible para todos los visitantes).
- Busca en todos los tipos de contenido: noticias, avisos, actividades, eventos, curiosidades y documentos.
- No requiere configuración alguna.

### Tabla de Accesos Rápidos

| Operación                  | Ruta en el panel de administración            |
| -------------------------- | --------------------------------------------- |
| Publicar noticia           | Noticias → Añadir nueva                       |
| Publicar aviso             | Avisos → Añadir nuevo                         |
| Registrar actividad        | Actividades → Añadir nueva                    |
| Registrar evento           | Eventos → Añadir nuevo                        |
| Publicar curiosidad        | Curiosidades → Añadir nueva                   |
| Subir documento            | Documentos → Añadir nuevo                     |
| Subir fotos a la galería   | Medios → Añadir nuevo archivo de medios       |
| Configurar portada/redes   | Apariencia → Personalizar → Portal Martiano   |
| Moderar comentarios        | Comentarios                                   |
| Gestionar usuarios         | Usuarios → Añadir nuevo                       |
| Editar menús               | Apariencia → Menús                            |

---

## Requisitos funcionales cubiertos

El tema implementa los 45 requisitos funcionales (RF1–RF45) del documento de especificación, incluyendo:

- RF1–RF6: Autenticación y gestión de usuarios
- RF7–RF14: CRUD de noticias y avisos
- RF15–RF20: Gestión de actividades y calendario
- RF21–RF25: Comentarios con moderación previa
- RF26–RF31: Gestión de eventos
- RF32–RF37: Curiosidades y documentos
- RF38–RF41: Galería de imágenes y video
- RF42: Compartir en redes sociales
- RF43: Enlaces de interés
- RF44: Búsqueda global
- RF45: Información de contacto

## Tecnologías

- WordPress 6.x + PHP 8.2
- MariaDB 10.11 LTS
- Docker + Docker Compose
- CSS Custom Properties (sin preprocesador)
- JavaScript vanilla (ES6+)
- Intersection Observer API (scroll infinito)
- WP Customizer API
- WP REST API (CPTs habilitados)

## Documentación adicional

- **[GUIA-DESPLIEGUE.md](GUIA-DESPLIEGUE.md)** — Guía paso a paso para instalar y desplegar el portal desde cero (dirigida a personal sin conocimientos técnicos).

## Licencia

Uso educativo — Universidad de Las Tunas.
