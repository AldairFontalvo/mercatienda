# Proyecto MERCATIENDA Laravel con MySQL

Este proyecto está desarrollado utilizando el framework Laravel y una base de datos MySQL. En este archivo se explican los pasos para instalar y ejecutar el proyecto localmente.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instaladas las siguientes herramientas:

- [PHP](https://www.php.net/downloads) (>= 7.4)
- [Composer](https://getcomposer.org/)
- [MySQL](https://dev.mysql.com/downloads/mysql/)
- [Git](https://git-scm.com/) (opcional, para clonar el repositorio)

## Instalación

### 1. Clonar el repositorio

### 2. Configurar las variables de entorno

- cp .env.example .env
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=nombre_de_tu_base_de_datos
- DB_USERNAME=tu_usuario
- DB_PASSWORD=tu_contraseña

### 3. Instalar dependencias de PHP
composer install

### 4. Ejecuta las migraciones
php artisan migrate

### 5. Ejecuta el servidor de desarrollo
php artisan serve

## Usabilidad

### 1. Inicia sesión
- email: admin@mercatienda.com
- password: 123456