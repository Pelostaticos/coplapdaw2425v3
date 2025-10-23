# 🌟 Plataforma Correplayas

Este proyecto representa el desarrollo integral de una aplicación web para la gestión centralizada de datos de ciencia ciudadana relacionados con censos ornitológicos. El objetivo fue crear una herramienta robusta y escalable que permitiera al equipo del proyecto administrar información capturada por voluntarios en observatorios costeros.

Mi rol en el proyecto fue de Desarrollador Web PHP Full-Stack, en calidad de alumno del ciclo formativo de grado superior en Desarrollo de Aplicaciones Web, ofreciendo esta solución como propuesta a mi proyecto final de ciclo.

La Plataforma Correplayas es una adaptación al contexto de un proyecto de ciencia ciudadana real, como es el [Proyecto Limes Platalea](https://limesplatalea.blogspot.com/), el cuál proporciona una solución interna robusta para la lógica, el tratamiento y almacenamiento de su información científica, que tras años de voluntariado he detectado como carencias en el mismo.

Mi contribución directa fue clave para  digitalizar el proceso de recolección de datos, gestión de voluntariado y jornadas de participación, garantizando la fiabilidad y trazabilidad de los registros, sentando las bases tecnológicas para la futura expansión  que permita la gestión de Proyectos de ciencia ciudadana de una misma entidad y sus censos con fichas dinámicas adaptables a cada proyecto. Ademas de su integración con una interfaz pública más amplia, como podría ser WordPress.

Dado los requisitos del proyectos y su contexto, no tuve la ocasión de implementar esta solución, bajo un framework PHP como podría ser Laravel, algo que se convierte en un nuevo reto personal en mi inquietud de aprendizaje continuo, su migración.

## 📖 Tabla de Contenidos
- [🌟 Plataforma Correplayas](#-plataforma-correplayas)
  - [📖 Tabla de Contenidos](#-tabla-de-contenidos)
  - [✨ Características Principales](#-características-principales)
  - [📸 Demostración Visual](#-demostración-visual)
  - [💻 Tecnologías Utilizadas](#-tecnologías-utilizadas)
  - [⬇️ Instalación](#️-instalación)
  - [⚙️ Uso](#️-uso)
  - [⚠️ Bugs de la Plataforma](#️-bugs-de-la-plataforma)
  - [⚖️ Licencia](#️-licencia)
    - [Atribución](#atribución)
  
## ✨ Características Principales
Me centré en construir el motor de la aplicación, destacando las siguientes áreas de desarrollo:

1. Núcleo de la plataforma: Desarrollo completo del micro framework con las funciones esenciales de la plataforma como el registros e inicio de sesión de usuarios, acceso a la base de datos, envío de formularios de contacto, intercambio asíncrono de información, enrutamiento de peticiones, gestión de vistas y de excepciones junto a errores. 
2. Módulo de Gestión de Usuario. Desarrollo completo de las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para el registro y gestión de usuarios, incluyendo validación de datos en servidor y asegurando la integridad referencial con las tablas de personas y roles.
3. Modulo de Gestión de Jornada: Desarrollo completo de las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para el registro y gestión de jornadas censales, incluyendo validación de datos en servidor y asegurando la integridad referencial con las tablas de observatorios donde se realizaban dichas jornadas censales.
3. Modulo de Gestión de Participantes: Desarrollo completo de las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para el registro y gestión de censos, incluyendo validación de datos en servidor y asegurando la integridad referencial con las tablas de personas y roles.
4.​ Módulo de Gestión de Censos: Desarrollo completo de las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para el registro de censos, incluyendo validación de
datos en servidor y asegurando la integridad referencial con las tablas de jornadas y
aves. Ademas de consultas entre varias tablas como a observatorios, participantes, familias u ordenes.
5. Modulo de Gestión de Observatorios:  Desarrollo completo de las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para el registro de observatorios, incluyendo validación de datos en servidor y asegurando la integridad referencial con las tablas de jornadas y aves. Ademas de consultas entre varias tablas como a observatorios, participantes, familias u ordenes.
6. Modulo de Gestión de Aves:  Desarrollo completo de las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para el registro de aves, incluyendo validación de
datos en servidor y asegurando la integridad referencial con las tablas de jornadas y aves. Ademas de consultas entre varias tablas como a observatorios, participantes, familias u ordenes.
7. Sistema de Roles y Usuarios: Implementación de un control de acceso basado en roles, diferenciando entre:

   - **Administradores**: Acceso total a la administración de usuarios,observatorios y generación de reportes.
   - **Coordinadores**: Un voluntario con permisos para registrar los censos.
   - **Voluntarios**: Acceso limitado a la inserción de nuevos censos.

8. Diseño de la Base de Datos: Optimización del esquema para soportar el almacenamiento escalable de datos de múltiples observatorios y campañas a lo largo del tiempo.
9.  Desarrollo del Dashboard: Construcción del panel principal de acceso básico a todas las funciones disponibles en el backoffice de la plataforma.

Además me encargue de poner en marcha un entorno de desarrollo local basado en la pila LAMP (Linux, Apache, MySQL/MariaDB y PHP) bajo una máquina virtual y posteriormente el despliegue  en un [**hosting web real**](https://correplayas.bitgarcia.es) como entorno de producción final.

## 📸 Demostración Visual

![Plataforma Correplayas](assets/demostracion.gif)

## 💻 Tecnologías Utilizadas
- HTML5
- CSS3
- JavaScript
- PHP
- PHPMailer
- Motor de plantillas Smarty
- MySQL/MariaDB

## ⬇️ Instalación

Poner en marcha la Plataforma Correplayas requiere un entorno de servidor
web LAMP/XAMPP.

### Requisitos del Sistema:
Para una ejecución correcta, su entorno local debe cumplir con:

- **Servidor Web**: Apache (o Nginx).
- **PHP**: Versión 8.4.12 o superior.
- **Extensiones PHP**: Openssl, mbstring, sockets, iconv, Mbstring, ctype, tokenizer,
Pdo, json, session, filter, gd, curl, fileinfo, hash.
- **Base de Datos**: MySQL o MariaDB.
- **Cliente SQL**: Acceso a línea de comandos (mysql) o herramienta gráfica (MySQL Workbench).
- **Protocolo de Conexión (CRÍTICO)**: HTTPS con un certificado SSL/TLS. La aplicación utiliza cookies seguras, por lo que no funcionará
correctamente sobre HTTP.
- **Entorno Local**: Se requiere y es suficiente un certificado SSL auto-firmado, configurado en su VirtualHost XAMPP.

### Pasos de Configuración:

Siga los siguientes pasos para poner en funcionamiento el entorno local:

1. <u>Configuración del Repositorio</u>.

   1. Clone el repositorio del proyecto en el directorio raíz de su servidor web
(ej: /opt/lampp/htdocs/).

    ```Bash
    git clone https://github.com/Pelostaticos/coplapdaw2425v3.git
    ```

2. <u>Configuración del Servidor Virtual (VirtualHost)</u>

   1. Cree un VirtualHost de Apache y apunte el DocumentRoot al directorio
   /publico del proyecto.
   2. Asegúrese de habilitar SSL/HTTPS para el entorno local, ya que la
   aplicación se desarrolló para operar bajo este protocolo.

3. <u>Configuración de la Aplicación</u>

   1. Localice el fichero de configuración de la base de datos:
   plataforma/config/config-inc.php.
   2. Edite este fichero con sus credenciales locales de base de datos (usuario,
   contraseña y nombre de la BD).

4. <u>Carga de la Base de Datos</u>

   1. Cree una nueva base de datos vacía (ej: correplayas_db) en su servidor
   MySQL/MariaDB.
   2. Cargue el dump SQL inicial utilizando el cliente de línea de comandos o
   su herramienta gráfica preferida:

   ```Bash
   mysql -u [su_usuario] -p [nombre_bd] < [ruta_al_archivo_dump.sql]
   ```
   <u>**NOTA**</u>: El archivo dump.sql se encuentra en la raíz del proyecto. Además recuerde que el usuario debe tener permisos de CREATE y ALTER.

Como **verificación Final**, acceda a la URL configurada en su navegador (ej: https://correplayas.local). Si todo es correcto, la página de inicio debería cargarse.

<u>**OBSERVACIONES**</u>: Las dependencias de las librería PHPMailer y Smarty ya se encuentra integradas en el código de la plataforma.

## ⚙️ Uso

Para iniciar la aplicación, ejecuta la máquina virtual que has creado con el entorno de desarrollo local desde el manual PDF indicado. Luego, abre tu navegador web y escribe:

```bash
https://correplayas.xampp.local
```

Como instrucciones para aprender el manejo de la propia plataforma puede consulta la [**presentacion**](https://drive.google.com/file/d/1ZAecZJQvRRfOBocYVzHHAHCaXb80W9co/view?usp=sharing) de defensa del proyecto. Además la ventana de inicio del Backoffice de la plataforma dispone de ayuda online.

## ⚠️ Bugs de la Plataforma

Si quieres saber más sobre mi toma de decisión acerca de **Bugs de la Plataforma Correplayas** heredada del Proyecto DAW, puedes leerlo [**en este documento**](https://drive.google.com/file/d/17A44amIhN0s93Fmy5pZiacRxP8UvAv6t/view?usp=sharing).

## ⚖️ Licencia

La Plataforma Correplayas, en esta versión de demostración en PHP Puro, se distribuye bajo la **Licencia MIT**.

Esto significa que eres libre de usar, modificar, y distribuir este código, siempre y cuando se incluya el aviso de copyright y los términos completos de la licencia.

Puedes encontrar el texto completo de la licencia en el archivo `LICENSE` incluido en este repositorio.

### Atribución

* **Copyright (c) 2025 - Sergio García Butrón**
