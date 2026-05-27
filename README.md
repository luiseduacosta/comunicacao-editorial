# ANDES-SN Editorial Communication System (comunicacao-jornal)

Welcome to the **ANDES-SN Editorial Communication System**, a premium web application developed using **CakePHP 5.3**, **PHP 8.5+**, and **Bootstrap 5**. Designed specifically for planning editorial agendas (pautas) and drafting articles (matérias), this system features a stunning dark mode navigation bar, clean glassmorphic components, fluid transitions, and the elegant *Outfit* typography from Google Fonts.

The system is fully compatible with the database schema of its sibling application (`comunicacao-recursos`) but runs with a modern, independent authentication mechanism and an extremely robust, 100% green test suite.

---

## Key Features

1. **Stunning Dynamic Dashboard**:
   - Dynamic real-time statistics cards (Total Pautas, Matérias Produzidas, Categorias/Tags).
   - Quick Access grid for instant task navigation.
   - Activity feed highlighting the 5 most recent articles.
2. **Editorial Agendas (Pautas)**:
   - Complete CRUD operations.
   - Advanced filters (Archived vs Active, Newsletter vs Website publication targets).
   - Integrated live comments feed for collaborative planning.
3. **Article Drafting & Writing (Matérias)**:
   - Full-featured writing interface.
   - Multi-tag categorization with a clean Bootstrap badge indicator.
   - Observations thread linked to each article.
   - Secure multi-file upload facility mapping uploaded files under `webroot/files/` with auto-collision naming conventions.
   - Text search query filters across titles and body contents.
4. **Categories (Tags) Management**:
   - Full CRUD system to categorize articles efficiently.
5. **CSV Data Export**:
   - One-click CSV export of articles list with full metadata, matching search filters.
   - Encoded with UTF-8 BOM to ensure direct, effortless import into Microsoft Excel and LibreOffice Calc.
6. **State-of-the-Art Security**:
   - Modern PSR-15 Authentication Middleware with secure Password hashing.
   - Strict CSRF token protection enabled globally on all post forms.
   - Directory traversal protection.
7. **100% Green Test Suite**:
   - 47 comprehensive integration tests executing 119 assertions with 0 failures, 0 errors, and 0 incomplete tests.
   - Automatically migrates and executes on an in-memory SQLite database environment.

---

## Technical Stack & Architecture

- **Backend Framework**: CakePHP 5.3 (PHP 8.5+)
- **Frontend Framework**: Bootstrap 5.3 with FontAwesome 6 icons and Outfit Google Font
- **ORM & Database**: MySQL 8.0+ for development and production, SQLite in-memory for testing
- **Authentication**: `cakephp/authentication` plugin version 3.x, modified to pass identifiers directly to authenticators to avoid PHP deprecation warnings
- **Migrations**: CakePHP Migrations plugin (Phinx)

---

## Installation & Local Setup

### Prerequisites
Make sure you have the following installed on your machine:
- PHP 8.5 or higher
- Composer
- MySQL 8.0 or MariaDB

### Step 1: Clone the Repository & Install Dependencies
Navigate to the directory and run Composer to install framework dependencies:
```bash
composer install
```

### Step 2: Configure Database
1. Copy `config/app_local.example.php` to `config/app_local.php`.
2. Configure your database connection under the `default` key:
```php
'Datasources' => [
    'default' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root', // Replace with your MySQL password
        'database' => 'comunicacao_editorial',
    ],
],
```

### Step 3: Run Database Migrations
Create the editorial database and run the migrations to generate all the tables:
```bash
bin/cake migrations migrate
```

This generates all 8 core database tables:
- `users` (independent authenticable users)
- `pautas`
- `materias`
- `tags`
- `materias_tags` (many-to-many join)
- `comentapautas`
- `observacoes`
- `phinxlog` (migration history tracking)

### Step 4: Seed Database with Initial Admin
To seed your database with an initial administrator account, you can execute a migration seeder or insert it manually. Alternatively, start the local server and register an admin user if allowed, or use the database client to insert:
- **Username**: `admin`
- **Password**: `password` (Make sure it hashes correctly using the default CakePHP hasher or run `bin/cake` console commands)

### Step 5: Start Local Server
Run the CakePHP development server:
```bash
bin/cake server -p 8765
```
Access the application at `http://localhost:8765`.

---

## Running the Test Suite

The test suite is fully self-contained. It leverages an in-memory SQLite database to run migrations and execute tests fast without affecting your local development database.

To run the entire test suite:
```bash
vendor/bin/phpunit
```

You should see:
```text
OK
Tests: 47, Assertions: 119
```

---

## Security Practices & Polish

- **CSRF Protection**: Form submissions use token headers validated by `CsrfProtectionMiddleware`. Forms without valid tokens return a strict `403 Forbidden` response.
- **Path Traversal Protection**: The `PagesController` handles page routing securely, preventing traversal attacks like `/pages/../Layout/ajax` by throwing a `ForbiddenException`.
- **File Upload Protection**: Uploaded files are validated, and files are securely renamed to the format: `materia-{timestamp}-{index}.{ext}` under `webroot/files/` to ensure no path injection or script execution is possible in public directories.

---

## Deployment Guide

When moving to a production environment:

1. **Disable Debug Mode**:
   Ensure `'debug' => false` is configured inside `config/app_local.php`.
2. **Server Configuration (Apache)**:
   Ensure `mod_rewrite` is enabled. The following `.htaccess` rules in the root folder will map incoming requests to `webroot/index.php`:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine on
       RewriteRule    ^$    webroot/    [L]
       RewriteRule    (.*)  webroot/$1  [L]
   </IfModule>
   ```
3. **Database Setup**:
   Ensure you run the migrations in production to keep your database scheme up to date:
   ```bash
   bin/cake migrations migrate
   ```
4. **Environment Variables**:
   In a production setup, it is recommended to store your database credentials and security salt inside environment variables or directly inside `config/app_local.php` (which is git-ignored by default for maximum security).
