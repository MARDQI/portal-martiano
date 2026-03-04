# Guía de Despliegue y Configuración — Portal Martiano

Esta guía está diseñada para que **cualquier persona**, incluso sin experiencia técnica, pueda instalar y poner en funcionamiento el Portal Martiano en una computadora. Sigue los pasos en orden y no omitas ninguno.

---

## Tabla de Contenidos

1. [¿Qué necesito antes de empezar?](#1-qué-necesito-antes-de-empezar)
2. [Paso 1: Instalar Docker](#2-paso-1-instalar-docker)
3. [Paso 2: Descargar el proyecto](#3-paso-2-descargar-el-proyecto)
4. [Paso 3: Iniciar el portal](#4-paso-3-iniciar-el-portal)
5. [Paso 4: Configurar WordPress por primera vez](#5-paso-4-configurar-wordpress-por-primera-vez)
6. [Paso 5: Activar el tema del portal](#6-paso-5-activar-el-tema-del-portal)
7. [Paso 6: Configurar la página de inicio](#7-paso-6-configurar-la-página-de-inicio)
8. [Paso 7: Personalizar el portal](#8-paso-7-personalizar-el-portal)
9. [Cómo detener y reiniciar el portal](#9-cómo-detener-y-reiniciar-el-portal)
10. [Solución de problemas frecuentes](#10-solución-de-problemas-frecuentes)
11. [Glosario de términos](#11-glosario-de-términos)
12. [Restaurar desde respaldo (levantar el portal ya configurado)](#12-restaurar-desde-respaldo-levantar-el-portal-ya-configurado)

---

## 1. ¿Qué necesito antes de empezar?

### Requisitos de la computadora

- **Sistema operativo**: Windows 10/11, macOS 10.15+ o Linux (Ubuntu, Fedora, Arch, etc.)
- **Memoria RAM**: 4 GB mínimo (8 GB recomendado).
- **Espacio en disco**: Al menos 2 GB libres.
- **Conexión a Internet**: Necesaria solo durante la instalación inicial para descargar los componentes.

### Programas que necesitarás instalar

| Programa | ¿Para qué sirve? | ¿Dónde descargarlo? |
| -------- | ----------------- | ------------------- |
| **Docker Desktop** | Ejecuta el portal sin instalar otros programas | https://www.docker.com/products/docker-desktop/ |
| **Git** (opcional) | Para descargar el proyecto desde GitHub | https://git-scm.com/downloads |

> **Nota**: Si no deseas instalar Git, también puedes descargar el proyecto como archivo ZIP desde GitHub (se explica más adelante).

---

## 2. Paso 1: Instalar Docker

Docker es el programa que se encarga de ejecutar WordPress, la base de datos y todo lo necesario. Solo hay que instalarlo una vez.

### En Windows

1. Ir a https://www.docker.com/products/docker-desktop/
2. Hacer click en **"Download for Windows"**.
3. Ejecutar el archivo descargado (`Docker Desktop Installer.exe`).
4. Seguir el asistente de instalación con las opciones predeterminadas.
5. Cuando pida **reiniciar la computadora**, hacerlo.
6. Después de reiniciar, abrir **Docker Desktop** desde el menú Inicio.
7. Esperar a que en la esquina inferior izquierda diga **"Engine running"** (motor en ejecución) con un indicador verde.

> **Importante para Windows**: Si aparece un mensaje sobre "WSL 2", seguir las instrucciones que muestra Docker para instalar la actualización de WSL 2. Es un paso adicional que Windows necesita.

### En macOS

1. Ir a https://www.docker.com/products/docker-desktop/
2. Hacer click en **"Download for Mac"** (elegir la versión correcta: Apple Silicon para Mac con chip M1/M2/M3, o Intel).
3. Abrir el archivo `.dmg` descargado y arrastrar Docker al icono de Aplicaciones.
4. Abrir **Docker** desde la carpeta Aplicaciones.
5. Aceptar los permisos que solicite.
6. Esperar a que el icono de Docker en la barra de menú diga **"Docker Desktop is running"**.

### En Linux (Ubuntu/Debian)

Abrir una **Terminal** (Ctrl+Alt+T) y copiar estos comandos uno por uno:

```bash
# Actualizar paquetes
sudo apt update

# Instalar dependencias
sudo apt install -y ca-certificates curl gnupg

# Agregar repositorio oficial de Docker
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Instalar Docker
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

# Permitir usar Docker sin sudo
sudo usermod -aG docker $USER
```

**Cerrar la terminal y volver a abrirla** (o reiniciar) para que el último cambio surta efecto.

### En Linux (Fedora/Arch)

```bash
# Fedora
sudo dnf install -y docker docker-compose-plugin
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker $USER

# Arch Linux
sudo pacman -S docker docker-compose
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker $USER
```

### Verificar que Docker funciona

Después de instalar, abrir una terminal (o PowerShell en Windows) y escribir:

```bash
docker --version
```

Debe mostrar algo como: `Docker version 29.x.x`. Si muestra un error, Docker no se instaló correctamente o no está en ejecución.

---

## 3. Paso 2: Descargar el proyecto

### Opción A: Descargar desde GitHub como ZIP (más fácil)

1. Ir a la página del proyecto en GitHub.
2. Hacer click en el botón verde **"<> Code"**.
3. Seleccionar **"Download ZIP"**.
4. Descomprimir el archivo ZIP en la ubicación deseada (por ejemplo, el Escritorio o Documentos).
5. La carpeta resultante se llama `portal-martiano` (o `portal-martiano-main`). Si se llama con `-main`, renombrarla a `portal-martiano`.

### Opción B: Clonar con Git (para usuarios más avanzados)

Abrir una terminal y ejecutar:

```bash
git clone https://github.com/TU_USUARIO/portal-martiano.git
cd portal-martiano
```

(Reemplazar `TU_USUARIO` por el nombre de usuario o la organización de GitHub donde está alojado el proyecto.)

---

## 4. Paso 3: Iniciar el portal

1. **Abrir una terminal** (o PowerShell en Windows).

2. **Navegar hasta la carpeta del proyecto**. Ejemplo:

   ```bash
   # Si la carpeta está en el Escritorio:
   cd ~/Escritorio/portal-martiano

   # En Windows puede ser:
   cd C:\Users\TuUsuario\Desktop\portal-martiano
   ```

3. **Ejecutar el siguiente comando**:

   ```bash
   docker compose up -d
   ```

4. **Esperar** a que se descarguen los componentes. La primera vez puede tardar entre 2 y 10 minutos dependiendo de la velocidad de Internet. Verás mensajes de descarga en la terminal. Cuando termine, verás algo como:

   ```
   ✔ Container pm_mariadb     Started
   ✔ Container pm_wordpress   Started
   ✔ Container pm_phpmyadmin  Started
   ```

5. **Abrir el navegador** (Chrome, Firefox, etc.) e ir a:

   **http://localhost:8080**

   Si ves una página de WordPress, ¡el portal está funcionando!

> **Nota**: Si en lugar de la página del portal ves un mensaje de error del navegador como "No se puede acceder a este sitio", espera 30 segundos más y recarga la página. Los servicios necesitan un momento para iniciarse completamente.

---

## 5. Paso 4: Configurar WordPress por primera vez

Si es la **primera vez** que inicias el portal y ves el asistente de instalación de WordPress:

1. **Idioma**: Seleccionar **Español** y hacer click en "Continuar".
2. **Información del sitio**:
   - **Título del sitio**: `Portal Martiano`
   - **Nombre de usuario**: `admin` (o el que prefieras, ¡anótalo!)
   - **Contraseña**: Elegir una contraseña segura (¡anótala!)
   - **Correo electrónico**: Un correo válido del administrador.
3. Hacer click en **"Instalar WordPress"**.
4. Hacer click en **"Iniciar sesión"** e ingresar con el usuario y contraseña que acabas de crear.

> **Si el portal ya fue instalado previamente** (por ejemplo, con WP-CLI como se describe en el README), ve directamente a http://localhost:8080/wp-admin e inicia sesión con `admin` / `admin123`.

---

## 6. Paso 5: Activar el tema del portal

1. Una vez dentro del panel de administración (http://localhost:8080/wp-admin), ir al menú lateral: **Apariencia → Temas**.
2. Buscar el tema llamado **"Cátedra Marti"**.
3. Pasar el ratón sobre él y hacer click en **"Activar"**.
4. El sitio ahora tiene el diseño del Portal Martiano.

> Si el tema ya aparece como "Activo", este paso ya está hecho.

---

## 7. Paso 6: Configurar la página de inicio

Para que la portada del sitio muestre el diseño completo (banner, noticias, calendario, etc.):

1. Ir a **Ajustes → Lectura** (en el menú lateral del panel de admin).
2. En "Tu portada muestra", seleccionar **"Una página estática"**.
3. En el desplegable "Portada", seleccionar la página **"Inicio"**.
   - Si no existe la página "Inicio": ir a **Páginas → Añadir nueva**, poner de título "Inicio", hacer click en "Publicar" y volver al paso 2.
4. Hacer click en **"Guardar cambios"**.

### Crear la página de Galería

1. Ir a **Páginas → Añadir nueva**.
2. Poner de título: **Galería**.
3. En el panel derecho, buscar la sección **"Atributos de página"** (si no la ves, hacer click en el icono de engranaje arriba a la derecha).
4. En **"Plantilla"**, seleccionar **"Galería de Imágenes"**.
5. Hacer click en **"Publicar"**.

---

## 8. Paso 7: Personalizar el portal

### Configurar el banner, redes sociales y contacto

1. Ir a **Apariencia → Personalizar** (en el menú lateral).
2. Hacer click en **"Portal Martiano"**. Aquí encontrarás tres secciones:

**Página de Inicio:**
- Título y descripción del banner principal.
- Imagen de fondo del banner.
- Mensaje de bienvenida.
- URL y título del video destacado.

**Redes Sociales:**
- Pegar las URLs completas de: Facebook, Twitter/X, Instagram, YouTube, Telegram y correo.

**Info de Contacto:**
- Dirección postal, teléfono, correo institucional y horario.

3. Al terminar, hacer click en **"Publicar"** (botón azul arriba).

### Crear los menús de navegación

1. Ir a **Apariencia → Menús**.
2. Escribir un nombre para el menú (ejemplo: "Menú Principal") y hacer click en **"Crear menú"**.
3. En el panel izquierdo, marcar las páginas que deseas agregar y hacer click en **"Añadir al menú"**.
4. Reordenar los elementos arrastrándolos.
5. Debajo, en **"Ubicación del menú"**, marcar la casilla correspondiente:
   - ☑ **Menú principal (primary)** — para el menú de navegación superior.
6. Hacer click en **"Guardar menú"**.
7. Repetir para crear un menú del pie de página (ubicación: "Menú del footer").

---

## 9. Cómo detener y reiniciar el portal

### Detener el portal (sin perder datos)

```bash
cd portal-martiano
docker compose down
```

Esto apaga todos los servicios. Los datos (contenido, imágenes, usuarios) **se conservan**.

### Volver a iniciar el portal

```bash
cd portal-martiano
docker compose up -d
```

El portal volverá a estar disponible en http://localhost:8080 en unos segundos.

### Reiniciar el portal (si algo no funciona bien)

```bash
cd portal-martiano
docker compose restart
```

### Borrar TODO y empezar desde cero

> **⚠️ ATENCIÓN: Esto elimina toda la base de datos, usuarios, contenido e imágenes subidas. No se puede deshacer.**

```bash
cd portal-martiano
docker compose down -v
```

Después, volver a ejecutar `docker compose up -d` para una instalación limpia.

---

## 10. Solución de problemas frecuentes

### "No se puede acceder a este sitio" al abrir localhost:8080

**Causa**: Los servicios aún no terminaron de iniciarse, o Docker no está corriendo.

**Solución**:
1. Verificar que Docker está en ejecución (icono verde en Docker Desktop, o ejecutar `docker info` en terminal).
2. Esperar 30-60 segundos y recargar la página.
3. Si persiste, ejecutar:
   ```bash
   cd portal-martiano
   docker compose down
   docker compose up -d
   ```

### "Error establishing a database connection" en WordPress

**Causa**: La base de datos aún no terminó de iniciarse.

**Solución**:
1. Esperar 1-2 minutos y recargar.
2. Verificar que el contenedor de la base de datos está corriendo:
   ```bash
   docker compose ps
   ```
   Debe aparecer `pm_mariadb` con estado `Up (healthy)`.

### El portal se ve sin estilos (solo texto)

**Causa**: El tema no está activado.

**Solución**: Ir a http://localhost:8080/wp-admin → **Apariencia → Temas** → Activar **"Cátedra Marti"**.

### No aparecen las secciones de Noticias, Avisos, etc. en el menú del admin

**Causa**: El tema no está activado (los tipos de contenido personalizados los registra el tema).

**Solución**: Activar el tema **"Cátedra Marti"** como se indica arriba.

### La página de inicio se ve vacía o solo muestra texto

**Causa**: No se configuró la portada como página estática.

**Solución**: Ir a **Ajustes → Lectura** → Seleccionar "Una página estática" → Elegir "Inicio" como portada → Guardar.

### Los cambios no se reflejan en el sitio

**Causa**: Caché del navegador.

**Solución**: Presionar `Ctrl + Shift + R` (Windows/Linux) o `Cmd + Shift + R` (Mac) para recargar sin caché.

### Docker dice "permission denied" en Linux

**Causa**: El usuario actual no pertenece al grupo `docker`.

**Solución**:
```bash
sudo usermod -aG docker $USER
```
Luego **cerrar la sesión** del sistema operativo y volver a iniciar sesión.

### Docker dice "Cannot connect to the Docker daemon"

**Causa**: El servicio de Docker no está corriendo.

**Solución**:
- **Windows/Mac**: Abrir la aplicación **Docker Desktop** y esperar a que inicie.
- **Linux**: Ejecutar:
  ```bash
  sudo systemctl start docker
  ```

### No puedo subir archivos grandes (se queda cargando)

**Causa**: El límite de subida es de 64 MB por archivo.

**Solución**: Si necesitas subir archivos más grandes, editar el archivo `php/uploads.ini` y cambiar los valores:
```ini
upload_max_filesize = 128M
post_max_size = 128M
```
Luego reiniciar: `docker compose restart wordpress`

### ¿Cómo hago una copia de seguridad?

Para respaldar todo el contenido:

```bash
cd portal-martiano

# Respaldar la base de datos
docker compose exec db mysqldump -u pm_user -ppm_pass_2026 portal_martiano > respaldo_bd.sql

# La carpeta wp-content/uploads/ contiene las imágenes y archivos subidos.
# Copiarla a un lugar seguro.
```

Para restaurar una copia de seguridad:

```bash
# Restaurar base de datos
docker compose exec -T db mysql -u pm_user -ppm_pass_2026 portal_martiano < respaldo_bd.sql
```

---

## 11. Glosario de términos

| Término | Significado |
| ------- | ----------- |
| **Docker** | Programa que crea "contenedores" aislados donde se ejecuta el portal sin instalar otros programas en la computadora. |
| **Contenedor** | Un entorno aislado que ejecuta un servicio específico (WordPress, base de datos, etc.). |
| **Terminal** | Programa para escribir comandos de texto. En Windows se llama PowerShell o CMD, en Mac/Linux se llama Terminal. |
| **localhost** | Es la dirección de tu propia computadora. `localhost:8080` significa "esta computadora, puerto 8080". |
| **Puerto** | Un número que identifica un servicio. El 8080 es WordPress, el 8081 es phpMyAdmin. |
| **Base de datos** | Donde se almacena todo el contenido del portal (textos, usuarios, configuraciones). Las imágenes se guardan en archivos. |
| **phpMyAdmin** | Herramienta web para ver y gestionar la base de datos. Solo para uso técnico avanzado. |
| **Panel de admin / wp-admin** | La sección de administración de WordPress donde se gestiona todo el contenido. |
| **Tema** | El diseño visual del sitio. El tema "Cátedra Marti" es el diseño personalizado del portal. |
| **CPT (Custom Post Type)** | Tipo de contenido personalizado. En este portal hay 6: Noticias, Avisos, Actividades, Eventos, Curiosidades y Documentos. |
| **Plugin** | Extensión de WordPress que añade funcionalidades. Este portal no requiere plugins adicionales, todo está integrado en el tema. |
| **WP-CLI** | Herramienta de línea de comandos para administrar WordPress. Solo para uso técnico avanzado. |

---

## 12. Restaurar desde respaldo (levantar el portal ya configurado)

Si se te proporcionó el proyecto **con la carpeta `respaldo/`**, puedes levantar el portal con todo el contenido, usuarios y configuración ya incluidos, **sin necesidad de configurar nada manualmente**. Solo necesitas instalar Docker y seguir las instrucciones para tu sistema operativo.

### ¿Qué contiene la carpeta respaldo/?

```
respaldo/
├── respaldo_bd.sql          ← Base de datos (usuarios, contenido, configuración)
└── wordpress_data.tar.gz    ← WordPress completo (archivos, imágenes subidas, plugins)
```

> **Si no tienes esta carpeta**, sigue los pasos 1 al 8 de esta guía para una instalación desde cero.

---

### Restaurar en Windows

#### Requisitos previos
1. Tener **Docker Desktop** instalado y en ejecución (ver [Paso 1](#2-paso-1-instalar-docker)).
2. Tener la carpeta `portal-martiano` en algún lugar de tu disco (por ejemplo, el Escritorio).

#### Pasos

1. **Abrir PowerShell** (buscar "PowerShell" en el menú Inicio y hacer click derecho → "Ejecutar como administrador").

2. **Navegar hasta la carpeta del proyecto**:
   ```powershell
   cd C:\Users\TuUsuario\Desktop\portal-martiano
   ```
   (Cambiar `TuUsuario` por tu nombre de usuario real de Windows, y la ruta si la carpeta está en otro lugar.)

3. **Levantar los contenedores vacíos** (primera vez tarda 2-10 min porque descarga componentes):
   ```powershell
   docker compose up -d
   ```

4. **Esperar 30 segundos** a que la base de datos esté lista. Puedes verificar con:
   ```powershell
   docker compose ps
   ```
   `pm_mariadb` debe decir `Up (healthy)`.

5. **Restaurar los archivos de WordPress**:
   ```powershell
   docker compose exec -T wordpress tar xzf - -C /var/www/html < respaldo/wordpress_data.tar.gz
   ```

6. **Restaurar la base de datos**:
   ```powershell
   Get-Content respaldo\respaldo_bd.sql | docker compose exec -T db mysql -u pm_user -ppm_pass_2026 portal_martiano
   ```

   > **Nota Windows**: Si el comando anterior da error, intenta este formato alternativo:
   > ```powershell
   > cmd /c "docker compose exec -T db mysql -u pm_user -ppm_pass_2026 portal_martiano < respaldo\respaldo_bd.sql"
   > ```

7. **Reiniciar los contenedores** para aplicar todo:
   ```powershell
   docker compose restart
   ```

8. **Abrir el navegador** e ir a: **http://localhost:8080**

   ¡El portal debería aparecer completamente configurado con todo el contenido!

---

### Restaurar en macOS

#### Requisitos previos
1. Tener **Docker Desktop para Mac** instalado y en ejecución (ver [Paso 1](#2-paso-1-instalar-docker)).
2. Tener la carpeta `portal-martiano` descargada.

#### Pasos

1. **Abrir Terminal** (buscar "Terminal" en Spotlight con Cmd+Espacio, o ir a Aplicaciones → Utilidades → Terminal).

2. **Navegar hasta la carpeta del proyecto**:
   ```bash
   cd ~/Desktop/portal-martiano
   ```
   (Ajustar la ruta si la carpeta está en otra ubicación.)

3. **Levantar los contenedores vacíos**:
   ```bash
   docker compose up -d
   ```
   La primera vez descarga imágenes (2-10 min). Esperar a que termine.

4. **Esperar 30 segundos** y verificar que la base de datos esté lista:
   ```bash
   docker compose ps
   ```
   `pm_mariadb` debe decir `Up (healthy)`.

5. **Restaurar los archivos de WordPress**:
   ```bash
   docker compose exec -T wordpress tar xzf - -C /var/www/html < respaldo/wordpress_data.tar.gz
   ```

6. **Restaurar la base de datos**:
   ```bash
   docker compose exec -T db mysql -u pm_user -ppm_pass_2026 portal_martiano < respaldo/respaldo_bd.sql
   ```

7. **Reiniciar los contenedores**:
   ```bash
   docker compose restart
   ```

8. **Abrir el navegador** e ir a: **http://localhost:8080**

---

### Restaurar en Linux

#### Requisitos previos
1. Tener **Docker** y **Docker Compose** instalados (ver [Paso 1](#2-paso-1-instalar-docker)).
2. Tener la carpeta `portal-martiano` descargada.
3. Asegurarse de que Docker está corriendo:
   ```bash
   sudo systemctl start docker
   ```

#### Pasos

1. **Abrir una Terminal** (Ctrl+Alt+T en la mayoría de distribuciones).

2. **Navegar hasta la carpeta del proyecto**:
   ```bash
   cd ~/Escritorio/portal-martiano
   # O en inglés:
   # cd ~/Desktop/portal-martiano
   ```

3. **Levantar los contenedores vacíos**:
   ```bash
   docker compose up -d
   ```
   Primera vez: esperar 2-10 min para la descarga de imágenes.

4. **Esperar 30 segundos** y verificar:
   ```bash
   docker compose ps
   ```
   `pm_mariadb` debe decir `Up (healthy)`.

5. **Restaurar los archivos de WordPress**:
   ```bash
   docker compose exec -T wordpress tar xzf - -C /var/www/html < respaldo/wordpress_data.tar.gz
   ```

6. **Restaurar la base de datos**:
   ```bash
   docker compose exec -T db mysql -u pm_user -ppm_pass_2026 portal_martiano < respaldo/respaldo_bd.sql
   ```

7. **Reiniciar los contenedores**:
   ```bash
   docker compose restart
   ```

8. **Abrir el navegador** e ir a: **http://localhost:8080**

---

### Después de restaurar

Una vez que el portal cargue en el navegador:

- **Panel de administración**: http://localhost:8080/wp-admin
- **Usuario**: `admin`
- **Contraseña**: `admin123`
- **phpMyAdmin**: http://localhost:8081 (usuario: `root`, contraseña: `root_pm_2026`)

> **⚠️ Importante**: Si el portal se va a usar en una dirección diferente a `localhost:8080` (por ejemplo, un servidor con IP pública o un dominio), es necesario actualizar la URL ejecutando este comando desde la carpeta del proyecto:
>
> ```bash
> docker compose run --rm --user 33:33 wpcli search-replace 'http://localhost:8080' 'http://TU_NUEVA_URL' --all-tables
> ```
>
> Reemplazar `TU_NUEVA_URL` por la dirección real (ejemplo: `http://192.168.1.100:8080` o `http://portal.universidad.cu`).

### Hacer un nuevo respaldo

Si en el futuro necesitas hacer un respaldo actualizado del portal con contenido nuevo:

```bash
cd portal-martiano

# Respaldar base de datos
docker compose exec db mysqldump -u pm_user -ppm_pass_2026 portal_martiano > respaldo/respaldo_bd.sql

# Respaldar archivos de WordPress
docker compose exec wordpress tar czf - -C /var/www/html . > respaldo/wordpress_data.tar.gz
```

Luego copiar toda la carpeta `portal-martiano/` a donde se necesite.

---

### Resumen rápido de restauración (para usuarios con experiencia)

```bash
cd portal-martiano
docker compose up -d
# Esperar ~30s a que MariaDB sea healthy
docker compose exec -T wordpress tar xzf - -C /var/www/html < respaldo/wordpress_data.tar.gz
docker compose exec -T db mysql -u pm_user -ppm_pass_2026 portal_martiano < respaldo/respaldo_bd.sql
docker compose restart
# Abrir http://localhost:8080
```

---

## Resumen: Pasos mínimos para tener el portal funcionando

### Instalación desde cero

1. ✅ Instalar Docker Desktop
2. ✅ Descargar el proyecto (ZIP o Git)
3. ✅ Abrir terminal → `cd portal-martiano` → `docker compose up -d`
4. ✅ Abrir http://localhost:8080 → Completar instalación
5. ✅ Activar tema "Cátedra Marti"
6. ✅ Ajustes → Lectura → Página estática → "Inicio"
7. ✅ Apariencia → Personalizar → Configurar contenido
8. ✅ ¡Listo! Comenzar a publicar contenido

### Instalación desde respaldo (todo configurado)

1. ✅ Instalar Docker Desktop
2. ✅ Copiar la carpeta `portal-martiano` (con `respaldo/` incluido)
3. ✅ Abrir terminal → `cd portal-martiano` → `docker compose up -d`
4. ✅ Esperar 30 segundos
5. ✅ Restaurar WordPress: `docker compose exec -T wordpress tar xzf - -C /var/www/html < respaldo/wordpress_data.tar.gz`
6. ✅ Restaurar BD: `docker compose exec -T db mysql -u pm_user -ppm_pass_2026 portal_martiano < respaldo/respaldo_bd.sql`
7. ✅ Reiniciar: `docker compose restart`
8. ✅ Abrir http://localhost:8080 — ¡Listo!

---

*Documento elaborado para la Cátedra Honorífica de Estudios Martianos — Universidad de Las Tunas.*
