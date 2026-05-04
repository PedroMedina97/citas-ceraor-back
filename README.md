# API CERAOR 3D

Sistema de API REST para gestión de citas, servicios, órdenes de trabajo, pagos y más para CERAOR 3D. Desarrollado en PHP 8.2 con arquitectura RESTful.

## 📋 Requisitos Previos

- **Docker** (recomendado) y Docker Compose
- **PHP 8.2+** (si instalas sin Docker)
- **MySQL 8.0+**
- **Composer**
- **Git**

## 🚀 Instalación

### Opción 1: Con Docker (Recomendado)

#### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd citas-ceraor-back
```

#### 2. Construir y levantar los contenedores

```bash
docker-compose up -d
```

Este comando:
- Construirá la imagen PHP con Apache
- Levantará el contenedor de PHP en el puerto `8080`
- Levantará MySQL en el puerto `3306`
- Creará un volumen para persistencia de datos

#### 3. Esperar a que MySQL esté listo

```bash
# Esperar a que el contenedor de MySQL esté completamente inicializado (puede tardar ~30 segundos)
docker-compose logs db | grep "ready for connections"
```

#### 4. Ejecutar migraciones

```bash
docker exec php_ceraor_api vendor/bin/phinx migrate -e development
```

#### 5. Verificar la instalación

```bash
# Acceder a la API
curl http://localhost:8080/

# Verificar que las extensiones PHP están disponibles
docker exec php_ceraor_api php -m | grep -E "mysqli|pdo|zip"
```

### Opción 2: Instalación Local (Sin Docker)

#### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd citas-ceraor-back
```

#### 2. Instalar dependencias con Composer

```bash
composer install
```

#### 3. Configurar variables de entorno

Crear o editar el archivo `config/Utils/.env`:

```env
APP_ENV=local
APP_DEBUG=false
DB_HOST=localhost
DB_PORT=3306
DB_NAME=ceraor3d
DB_USER=root
DB_PASSWORD=root
API_JWT=Pk96?T5ju%LXmt!HJ
```

#### 4. Crear la base de datos

```bash
mysql -u root -p -e "CREATE DATABASE ceraor3d CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### 5. Ejecutar migraciones

```bash
vendor/bin/phinx migrate -e development
```

#### 6. Configurar Apache

Asegúrate de tener habilitado `mod_rewrite`:

```bash
a2enmod rewrite
```

Reinicia Apache:

```bash
sudo systemctl restart apache2
```

#### 7. Verificar la instalación

```bash
# Verificar que todas las extensiones PHP requeridas están disponibles
php -m | grep -E "mysqli|pdo|zip"
```

## ⚙️ Configuración

### Variables de Entorno

El archivo `config/Utils/.env` contiene las variables de entorno necesarias:

| Variable | Descripción | Ejemplo |
|----------|-------------|---------|
| `APP_ENV` | Ambiente de ejecución | `local`, `production` |
| `APP_DEBUG` | Modo debug | `true`, `false` |
| `DB_HOST` | Host del servidor MySQL | `db` (Docker) o `localhost` |
| `DB_PORT` | Puerto MySQL | `3306` |
| `DB_NAME` | Nombre de la base de datos | `ceraor3d` |
| `DB_USER` | Usuario MySQL | `root` |
| `DB_PASSWORD` | Contraseña MySQL | Tu contraseña |
| `API_JWT` | Clave secreta para JWT | Una cadena aleatoria segura |

### Configuración de Base de Datos

La configuración de Phinx está en `phinx.php` y carga automáticamente las variables de entorno desde `.env`.

## 🗄️ Migraciones

Las migraciones se encuentran en la carpeta `migrations/` y se ejecutan con Phinx.

### Ejecutar todas las migraciones

```bash
# Con Docker
docker exec php_ceraor_api vendor/bin/phinx migrate -e development

# Sin Docker
vendor/bin/phinx migrate -e development
```

### Ver estado de las migraciones

```bash
# Con Docker
docker exec php_ceraor_api vendor/bin/phinx status -e development

# Sin Docker
vendor/bin/phinx status -e development
```

### Revertir última migración

```bash
# Con Docker
docker exec php_ceraor_api vendor/bin/phinx rollback -e development -t 0

# Sin Docker
vendor/bin/phinx rollback -e development -t 0
```

### Crear una nueva migración

```bash
# Con Docker
docker exec php_ceraor_api vendor/bin/phinx create MigracionNombre

# Sin Docker
vendor/bin/phinx create MigracionNombre
```

## 📦 Estructura del Proyecto

```
citas-ceraor-back/
├── migrations/           # Migraciones de base de datos (Phinx)
├── models/
│   ├── abstract/        # Clases abstractas base
│   └── classes/         # Modelos y clases de negocio
├── controllers/         # Controladores REST
├── config/
│   ├── Utils/          # Utilidades y configuración
│   │   ├── .env        # Variables de entorno
│   │   ├── db.php      # Configuración de BD
│   │   ├── Env.php     # Clase para variables de entorno
│   │   └── Helpers.php # Funciones auxiliares
├── includes/           # Archivos compartidos (headers CORS, etc)
├── vendor/             # Dependencias Composer
├── docker-compose.yml  # Configuración Docker Compose
├── Dockerfile          # Configuración Docker
├── phinx.php          # Configuración Phinx para migraciones
├── composer.json      # Dependencias del proyecto
├── composer.lock      # Lock file de dependencias
└── index.php          # Punto de entrada de la API
```

## 🛠️ Comandos Útiles

### Contenedores Docker

```bash
# Levantar contenedores
docker-compose up -d

# Detener contenedores
docker-compose down

# Ver logs
docker-compose logs -f

# Ver logs de un servicio específico
docker-compose logs -f app     # PHP/Apache
docker-compose logs -f db      # MySQL

# Acceder a la terminal del contenedor PHP
docker exec -it php_ceraor_api bash

# Acceder a MySQL
docker exec -it mysql_db mysql -u root -p ceraor3d
```

### Composer

```bash
# Instalar dependencias
composer install

# Actualizar dependencias
composer update

# Autoload de clases (PSR-4)
composer dump-autoload
```

### Phinx (Migraciones)

```bash
# Listar todas las migraciones y su estado
vendor/bin/phinx status -e development

# Ejecutar las migraciones pendientes
vendor/bin/phinx migrate -e development

# Revertir las últimas migraciones
vendor/bin/phinx rollback -e development -t <numero>

# Crear una nueva migración
vendor/bin/phinx create NombreMigracion
```

## 📚 Dependencias Principales

| Dependencia | Versión | Descripción |
|-------------|---------|-------------|
| `robmorgan/phinx` | ^0.16.10 | Gestor de migraciones de BD |
| `firebase/php-jwt` | ^6.10 | Autenticación con JWT |
| `vlucas/phpdotenv` | ^5.6 | Carga de variables de entorno |
| `dompdf/dompdf` | ^2.0 | Generación de PDFs |
| `phpoffice/phpspreadsheet` | ^4.3 | Manejo de archivos Excel |
| `picqer/php-barcode-generator` | ^2.4 | Generación de códigos de barras |
| `twbs/bootstrap` | ^5.3 | Framework CSS |

## 🔧 Desarrollo

### Cargar variables de entorno en PHP

```php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/config/Utils');
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$apiJwt = $_ENV['API_JWT'];
```

### Autoload PSR-4

El proyecto está configurado con PSR-4 para autoloading automático de clases:

```php
// config/Utils se mapea a Utils\
// models/classes se mapea a Classes\
// models/abstract se mapea a Abstracts\

require 'vendor/autoload.php';
use Classes\Router;
use Abstracts\BaseModel;
```

## 🐛 Troubleshooting

### MySQL no está listo

Si obtienes errores de conexión a MySQL al iniciar, espera a que esté completamente inicializado:

```bash
docker-compose logs db | grep "ready for connections"
```

### Permisos de archivos en Docker

Si hay problemas de permisos, reinicia los contenedores:

```bash
docker-compose down
docker-compose up -d
```

### Limpiar todo y empezar de nuevo

```bash
# Detener y eliminar contenedores y volúmenes
docker-compose down -v

# Reconstruir imágenes
docker-compose build --no-cache

# Levantar nuevamente
docker-compose up -d

# Ejecutar migraciones
docker exec php_ceraor_api vendor/bin/phinx migrate -e development
```

### Verificar extensiones PHP

```bash
# Con Docker
docker exec php_ceraor_api php -m

# Sin Docker
php -m
```

Debe incluir: `mysqli`, `pdo`, `pdo_mysql`, `zip`, `mbstring`, `xml`, `fileinfo`, `gd`

## 📖 Documentación Adicional

- [API_DOCUMENTATION.md](API_DOCUMENTATION.md) - Documentación completa de endpoints
- [endpoints.md](endpoints.md) - Listado de endpoints disponibles
- [DOCUMENTACION_API_COMPLETA.md](DOCUMENTACION_API_COMPLETA.md) - Documentación detallada

## 🤝 Contribuir

1. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
2. Haz commit de tus cambios (`git commit -m 'Add some AmazingFeature'`)
3. Push a la rama (`git push origin feature/AmazingFeature`)
4. Abre un Pull Request

## 📝 Licencia

Este proyecto está bajo licencia privada.

## 👨‍💻 Autor

Desarrollado para CERAOR 3D

---

**Última actualización:** Mayo 4, 2026
