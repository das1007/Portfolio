# Darshan Patel — Portfolio CMS v3
## MySQL Setup (XAMPP / WAMP / Live Server)

### Requirements
- PHP 8.2+ with pdo_mysql enabled
- Composer
- MySQL 5.7+

---

## 5-Step Setup

### 1. Create MySQL Database
In phpMyAdmin → New → name: `portfolio_cms` → Collation: `utf8mb4_unicode_ci` → Create

Or via CLI:
```sql
mysql -u root -p
CREATE DATABASE portfolio_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Install Laravel & Copy Files
```bash
composer create-project laravel/laravel portfolio-cms
cd portfolio-cms
# Copy all files from this zip into portfolio-cms folder (overwrite existing)
```

### 3. Configure .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio_cms
DB_USERNAME=root
DB_PASSWORD=          # blank if XAMPP has no password

SESSION_DRIVER=file
CACHE_STORE=file

ADMIN_EMAIL=darshan.p1792@gmail.com
ADMIN_PASSWORD=Admin@2024
```

### 4. Register Middleware (Laravel 11 — bootstrap/app.php)
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin.auth' => \App\Http\Middleware\AdminAuthMiddleware::class,
    ]);
})
```

### 5. Run Commands
```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Open: http://localhost:8000
Admin: http://localhost:8000/admin/login → Admin@2024

---

## New Features in v3

| Feature | Details |
|---------|---------|
| 👤 Profile Image | Upload photo in Admin → Settings |
| 🌐 Social Media Links | 11 platforms — LinkedIn, GitHub, Twitter/X, Instagram, YouTube, Dribbble, Behance, Dev.to, Medium, Website |
| ⬆️ Latest First | New Experience, Education, Skills, Reviews all show newest at top |
| 🎨 Background Color | Admin → Settings → Theme — pick any bg color + live preview |
| 🎨 Accent Color | Same section — changes all buttons, links, glows |
| 🚀 Projects Section | Full project showcase with title, company name, logo, description, tags, live URL, GitHub URL, Featured badge |

## Troubleshooting
| Error | Fix |
|-------|-----|
| Access denied | Wrong DB_PASSWORD in .env |
| Unknown database | Create the DB first (Step 1) |
| Connection refused | Start MySQL in XAMPP Control Panel |
| could not find driver | Enable extension=pdo_mysql in php.ini |
