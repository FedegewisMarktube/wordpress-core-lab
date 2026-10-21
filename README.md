# WordPress Core Lab

Proyecto de aprendizaje y desarrollo de funcionalidades nativas de WordPress Core.

## Tecnologías

- WordPress
- PHP 8.3
- MySQL 8.0
- Docker Compose
- Git

## Requisitos

- Docker Desktop
- Docker Compose
- Git

## Instalación

1. Clonar el repositorio.
2. Crear un archivo `.env` utilizando `.env.example` como referencia.
3. Configurar las variables de entorno.
4. Ejecutar:

```bash
docker compose up -d
```

5. Acceder a WordPress desde el navegador:

`http://localhost:8080`

6. Completar la instalación inicial de WordPress.
7. Activar el plugin **WordPress Core Lab** desde el administrador.

## Estructura

- `docker-compose.yml`: configuración del entorno.
- `plugins/wordpress-core-lab/`: plugin personalizado.
- `docs/`: documentación técnica.

## Objetivos

Implementar y documentar:

- Custom Post Types.
- Taxonomías personalizadas.
- Roles y capacidades.
- Settings API.
- REST API.
- Transients API.
- WP-Cron.

## Consideraciones

El proyecto utiliza APIs nativas de WordPress y no modifica archivos del Core.