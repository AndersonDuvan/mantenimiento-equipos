# Prototipo: gestión de mantenimiento de equipos de cómputo — ENII Zipaquirá

Archivos para copiar sobre una instalación nueva de **Laravel 11** (PHP 8.2+, MySQL).


## Instalación

```bash
composer create-project laravel/laravel enii-mantenimiento
cd enii-mantenimiento
```

1. Copia el contenido de esta carpeta (`app`, `database`, `resources`, `routes`, `tests`) dentro del proyecto, aceptando reemplazar `User.php`, `web.php` y `DatabaseSeeder.php`.
2. Crea la base de datos en MySQL: `CREATE DATABASE enii_mantenimiento CHARACTER SET utf8mb4;`
3. En `.env` configura:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=enii_mantenimiento
DB_USERNAME=root
DB_PASSWORD=
APP_LOCALE=es
```
4. Ejecuta:
```bash
php artisan migrate --seed
php artisan serve
```
5. Abre http://127.0.0.1:8000

## Usuarios de prueba
| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | admin@enii.test | password |
| Técnico | tecnico@enii.test | password |

El administrador puede crear, editar y eliminar equipos (RF-08). El técnico reporta fallas y gestiona mantenimientos.

## Pruebas automatizadas
```bash
php artisan test
```
Usa la base SQLite en memoria que trae Laravel 11 (requiere la extensión `pdo_sqlite` de PHP).

## Correspondencia con los requerimientos
| Req. | Dónde |
|---|---|
| RF-01, RF-02 | `EquipoController`, vistas `equipos/` |
| RF-03 | `FallaController@store` |
| RF-04 | `FallaController@registrarAtencion` |
| RF-05 | `MantenimientoController@store` |
| RF-06 | `equipos/show.blade.php` (historial) |
| RF-07 | `ReporteController` (pantalla y CSV) |
| RF-08 | método `soloAdmin()` y rol en `users` |
| RNF-02 | validaciones en cada controlador |
| RNF-03 | middleware `auth` y control por rol |

## Subir a GitHub
```bash
git init && git add . && git commit -m "Prototipo funcional TRL5"
git branch -M main
git remote add origin https://github.com/TU_USUARIO/enii-mantenimiento.git
git push -u origin main
```
Luego en GitHub: Settings → Collaborators → agrega a tu tutor con permiso de lectura.
# mantenimiento-equipos
# mantenimiento-equipos
