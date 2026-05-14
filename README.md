<h1 align="center">🐾 Sistema de Gestión Veterinaria</h1>

<p align="center">
  Aplicación web desarrollada con <strong>Laravel 12</strong> para la gestión integral de una clínica veterinaria.<br>
  Incluye autenticación con separación de roles, panel de administración y dashboard para veterinarios.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.4-blue?style=for-the-badge&logo=php" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/MariaDB-11.8-teal?style=for-the-badge&logo=mariadb" alt="MariaDB">
  <img src="https://img.shields.io/badge/SB_Admin_2-template-orange?style=for-the-badge" alt="SB Admin 2">
</p>

---

## 📋 Tabla de Contenidos

- [Tecnologías](#-tecnologías)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Sistema de Roles](#-sistema-de-roles)
- [Usuarios de Prueba](#-usuarios-de-prueba)
- [Rutas Disponibles](#-rutas-disponibles)

---

## 🛠 Tecnologías

| Tecnología | Versión | Uso |
|---|---|---|
| Laravel | 12.x | Framework principal (backend, rutas, ORM) |
| PHP | 8.4 | Lenguaje del servidor |
| MariaDB | 11.8 | Base de datos relacional |
| SB Admin 2 | — | Plantilla de interfaz de usuario (Bootstrap 4) |
| Font Awesome | 5.x | Íconos |

---

## ✅ Requisitos

- PHP >= 8.2
- Composer
- MariaDB / MySQL
- Servidor web (Apache / Nginx) o `php artisan serve`
- Node.js (opcional, solo si se recompilan assets)

---

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone git@github.com:ramirosF4/veterinariaa.git
cd veterinariaa

# 2. Instalar dependencias PHP
composer install

# 3. Copiar el archivo de entorno
cp .env.example .env

# 4. Generar la clave de la aplicación
php artisan key:generate

# 5. Configurar la base de datos en .env
#    DB_DATABASE=veterinaria
#    DB_USERNAME=tu_usuario
#    DB_PASSWORD=tu_contraseña

# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. (Opcional) Solo ejecutar el seeder de usuarios
php artisan db:seed --class=AdminUserSeeder

# 8. Levantar el servidor de desarrollo
php artisan serve
```

---

## 📁 Estructura del Proyecto

```
resources/views/
│
├── layouts/
│   ├── main.blade.php              # Layout principal (veterinario)
│   ├── admin.blade.php             # Layout exclusivo del administrador
│   ├── auth.blade.php              # Layout para páginas de autenticación
│   └── partials/
│       ├── sidebar.blade.php       # Sidebar del veterinario (azul)
│       ├── topbar.blade.php        # Topbar del veterinario
│       ├── footer.blade.php        # Footer compartido
│       ├── logout-modal.blade.php  # Modal de confirmación de logout
│       └── admin/
│           ├── sidebar.blade.php   # Sidebar del administrador (teal)
│           └── topbar.blade.php    # Topbar del administrador
│
└── modules/
    ├── auth/
    │   └── login.blade.php         # Vista de inicio de sesión
    ├── dashboard/
    │   └── home.blade.php          # Dashboard del veterinario
    └── admin/
        └── dashboard.blade.php     # Dashboard del administrador
```

```
app/Http/Controllers/
└── AuthController.php   # Login, logout, redirección por rol, dashboards
```

```
database/
├── migrations/
│   └── 0001_01_01_000000_create_users_table.php   # Tabla users con campo role (enum)
└── seeders/
    └── AdminUserSeeder.php   # Usuarios de prueba: admin y veterinario
```

---

## 👥 Sistema de Roles

El sistema gestiona dos roles mediante un campo `role` de tipo `enum` en la tabla `users`:

| Rol | Valor en BD | Acceso tras login |
|---|---|---|
| Administrador | `administrador` | `/admin/home` — Panel de administración (teal) |
| Veterinario | `veterinario` | `/home` — Dashboard veterinario (azul) |

La redirección se realiza automáticamente en `AuthController::logear()` al verificar `Auth::user()->role` tras una autenticación exitosa.

---

## 🔑 Usuarios de Prueba

Generados por `AdminUserSeeder`. Se pueden recrear con:

```bash
php artisan db:seed --class=AdminUserSeeder
```

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | `admin@gmail.com` | `admin` |
| Veterinario | `veterinario@gmail.com` | `veterinario` |

> **Nota:** Los seeders usan `updateOrCreate`, por lo que son idempotentes (se pueden ejecutar múltiples veces sin duplicar registros).

---

## 🗺 Rutas Disponibles

### Públicas (solo para invitados)

| Método | URI | Nombre | Descripción |
|---|---|---|---|
| `GET` | `/` | `login` | Formulario de inicio de sesión |
| `POST` | `/logear` | `logear` | Procesar el login y redirigir por rol |

### Protegidas (requieren autenticación)

| Método | URI | Nombre | Acceso |
|---|---|---|---|
| `GET` | `/home` | `home` | Dashboard del veterinario |
| `GET` | `/admin/home` | `admin.home` | Dashboard del administrador |
| `GET` | `/logout` | `logout` | Cerrar sesión |

---

## 🎨 Plantilla UI

La interfaz utiliza **SB Admin 2** (Bootstrap 4), cuyos archivos estáticos se encuentran en `public/startbootstrap/`.

Los assets compilados (CSS y JS) están disponibles en:
- `public/css/sb-admin-2.min.css`
- `public/js/sb-admin-2.min.js`
- `public/vendor/` — jQuery, Bootstrap, FontAwesome, jQuery Easing

---

## 📄 Licencia

Proyecto académico — Ingeniería de Software.
