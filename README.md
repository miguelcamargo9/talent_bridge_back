# Nombre del Proyecto

Descripción breve del proyecto. Por ejemplo, una API para gestionar la contratación de talento, permitiendo a los usuarios (talentos y reclutadores) registrarse, iniciar sesión, y gestionar oportunidades laborales.

## Configuración del Proyecto Localmente

Este proyecto utiliza Docker para facilitar el desarrollo y despliegue. Sigue estos pasos para configurar el proyecto localmente.

### Prerrequisitos

- Docker
- Docker Compose

### Pasos de Instalación

1. **Clonar el Repositorio**

    ```
    git clone https://github.com/miguelcamargo9/talent_bridge_back
    cd talent_bridge_back
    ```

2. **Configurar Variables de Entorno**

    Copia el archivo `env` a `.env` y ajusta las variables de entorno según sea necesario.
    
    ```
    cp env .env
    ```
3. **Construir y Levantar los Contenedores de Docker**
    ```
    docker-compose up -d
    ```

4. **Ejecutar Migraciones**

    Después de que los contenedores estén en funcionamiento, ejecuta las migraciones para crear las tablas en la base de datos.
    ```
    docker-compose exec app php spark migrate
    ```
5. **Ejecutar Seeders (Opcional)**

    Si necesitas datos de prueba en tu base de datos:
    ```
   docker-compose exec app php spark db:seed UserSeeder
   docker-compose exec app php spark db:seed OpportunitiesSeeder
   ```
6. **Acceder a la Aplicación**

    La API debería estar accesible en `http://localhost:puerto`, donde `puerto` es el que configuraste en tu `.env` o `docker-compose.yml`.
    
## Configuración de la Base de Datos Local
    
Para configurar la base de datos localmente, asegúrate de tener los detalles de conexión correctos en tu archivo `.env`. Por ejemplo:

 ```
database.default.hostname = db
database.default.database = talent_bridge
database.default.username = codeigniter_user
database.default.password = notsecret
database.default.DBDriver = MySQLi
 ```

Asegúrate de que estos valores coincidan con los de tu entorno Docker si estás usando contenedores para tu base de datos.

## Endpoints de la API

Aquí tienes una lista de los endpoints disponibles en la API:

### Usuarios

- **Registrar Usuario**
    - `POST /api/user/register`: registra un nuevo usuario.
- **Iniciar Sesión**
    - `POST /api/user/login`: inicia sesión con un usuario existente.
- **Ver Perfil de Usuario**
    - `GET /api/user/profile/{id}`: muestra el perfil del usuario por ID.
- **Actualizar Perfil de Usuario**
    - `PUT /api/user/update/{id}`: actualiza la información del usuario por ID.

### Oportunidades

- **Listar Oportunidades**
    - `GET /api/opportunities/`: lista todas las oportunidades disponibles.
- **Crear Oportunidad**
    - `POST /api/opportunity/create`: crea una nueva oportunidad laboral.

## Testing

El proyecto cuenta con una suite de pruebas, la cuales se pueden correr asi:

 ```
composer test
 ```