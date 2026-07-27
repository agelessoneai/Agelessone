# Ageless Admin Panel - Laravel + MySQL

## MySQL Setup Option 1: Laravel Migration

```bash
cd ageless-admin-panel
composer install
cp .env.mysql.example .env
php artisan key:generate
```

Create MySQL database:

```sql
CREATE DATABASE ageless_admin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Edit `.env` if needed:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ageless_admin
DB_USERNAME=root
DB_PASSWORD=
```

Run database tables and default users:

```bash
php artisan migrate --seed
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## MySQL Setup Option 2: Direct SQL Import

Import this file in phpMyAdmin or MySQL:

```text
database/ageless_admin.sql
```

Then run:

```bash
composer install
cp .env.mysql.example .env
php artisan key:generate
php artisan serve
```

## Features

- Admin login
- User login
- User registration
- Admin dashboard
- User dashboard
- Admin can view registered users
- MySQL database ready

## Office Staff and Site Workers update (2026-07-21)

- Office staff are managed at **Admin > Office Staff** and stored in `users`.
- Office attendance remains the attendance shown in the HR & Staff menu.
- Site workers are managed only inside **Work Sites > View Site > Manage Site Workers**.
- Site worker roles: Worker, Helper, Supervisor, Security.
- Office staff roles: Administrator, Project Manager, Project Head, Site Supervisor, Supervisor, Security, Office Staff.

After replacing an existing installation, run:

```bash
php artisan migrate
php artisan optimize:clear
php artisan storage:link
```

For `php artisan view:cache`, PHP DOM/XML must be enabled (`php-xml`).
