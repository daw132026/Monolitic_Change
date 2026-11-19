# Change.org – Monolitic_Change

Aplicación Laravel 12 (monolítica) tipo Change.org: peticiones, firmas, categorías y subida de imágenes, con autenticación Laravel Breeze y vistas adaptadas a mi diseño (Bootstrap 5).

## Despliegue con Docker

Requisitos: Docker Desktop (o Docker Engine + Docker Compose).

```bash
git clone https://github.com/daw132026/Monolitic_Change.git
cd Monolitic_Change
docker compose up -d --build
docker compose exec app php artisan db:seed --force   # categorías + usuario de prueba
```

| Servicio    | Contenedor  | URL / puerto                  |
|-------------|-------------|-------------------------------|
| Aplicación  | change_app  | http://localhost:8080         |
| phpMyAdmin  | change_pma  | http://localhost:8081         |
| MySQL 8     | change_db   | localhost:3307 (interno 3306) |

Credenciales de la BBDD (solo entorno de prácticas): usuario `change`, contraseña `change_pass`, base de datos `change_monol`.

### Ficheros de Docker

- `Dockerfile`: build multi-etapa. Node 20 compila los assets de Vite; la imagen final es `php:8.2-apache` con `pdo_mysql`, `mod_rewrite`, Composer y el DocumentRoot en `/public`.
- `docker/entrypoint.sh`: genera `APP_KEY` si falta, espera a MySQL, ejecuta las migraciones, crea `storage:link` y cachea la configuración.
- `docker-compose.yml`: servicios `app`, `db` y `phpmyadmin`, con los volúmenes `db_data` (datos de MySQL) y `uploads` (imágenes subidas).
- `.dockerignore`: excluye `vendor`, `node_modules`, `.env`, `.git`…

### Comandos útiles

```bash
docker compose ps                 # estado de los contenedores
docker compose logs -f app        # logs de Laravel/Apache
docker compose exec app bash      # entrar en el contenedor
docker compose down               # parar (los datos se conservan en los volúmenes)
docker compose down -v            # parar y borrar también los volúmenes
```
