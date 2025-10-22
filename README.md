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

Además me encargue de poner en marcha un entorno de desarrollo local basado en la pila LAMP (Linux, Apache, MySQL/MariaDB y PHP) bajo una máquina virtual y posteriormente el despliegue de mi aplicación web en un hosting web real como entorno de producción final.

## 📸 Demostración Visual
- ...

## 💻 Tecnologías Utilizadas
- HTML5
- CSS3
- JavaScript
- PHP
- PHPMailer
- Motor de plantillas Smarty
- MySQL/MariaDB

## ⬇️ Instalación
...

## ⚙️ Uso

Para iniciar la aplicación, ejecuta la máquina virtual que has creado con el entorno de desarrollo local desde el manual PDF indicado. Luego, abre tu navegador web y escribe:
```bash
https://correplayas.xampp.ocal
```

## ⚖️ Licencia

La Plataforma Correplayas, en esta versión de demostración en PHP Puro, se distribuye bajo la **Licencia MIT**.

Esto significa que eres libre de usar, modificar, y distribuir este código, siempre y cuando se incluya el aviso de copyright y los términos completos de la licencia.

Puedes encontrar el texto completo de la licencia en el archivo `LICENSE` incluido en este repositorio.

### Atribución

* **Copyright (c) 2025 - Sergio García Butrón**
