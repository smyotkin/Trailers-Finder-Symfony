# Тестовое задание

## Технические требования
 - PHP 7.2
 - MySQL 5.7

## Установка (`без docker`):
- 1. Добавить `.env` где указать стадию разработки приложения и подключение к БД (создать необходимую базу), например:

```bash
APP_ENV=dev
DATABASE="mysql://user:pass@127.0.0.1:3306/dbname"
```

- 2. Запустить `composer update` для установки всех необходимых зависимостей
- 3. Добавить `.htaccess` с данными параметрами:

```bash
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

и добавить точку входа:

```bash
DirectoryIndex public/index.php
```

- 4. В консоли выполнить команды:
```bash
php bin/console orm:schema-tool:create
```
```bash
php bin/console fetch:trailers
```

Всё готово)


