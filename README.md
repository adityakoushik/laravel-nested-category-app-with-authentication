# Laravel Nested Category App — Authentication & Roles

## Features Implemented

- Basic authentication using Laravel 12 Breeze (Blade stack)
- Role system: Added `role` column to `users` table (default: `user`)
- Registration: UI registration always assigns `role = 'user'` (role cannot be set by client)
- Admin seeder: Seeder creates/updates one admin user only (cannot be created via UI)

## Migration & Seeder Details

- Migration file: `database/migrations/2025_11_21_000001_add_role_to_users_table.php`
  - Adds `role` column to `users` table, default value `user`
- Seeder file: `database/seeders/AdminUserSeeder.php`
  - Creates/updates admin user:
    - Email: `admin@example.com`
    - Password: `password123`
    - Role: `admin`
- `DatabaseSeeder` calls `AdminUserSeeder` and creates a test user (`test@example.com`)

## How Registration Works

- Registration form and controller do not accept or process a `role` field
- All users registered via UI are assigned `role = 'user'`
- Only the seeder can create an admin user

## Admin Credentials
- Email: `admin@example.com`
- Password: `password123`
- Role: `admin` (set only by seeder)
