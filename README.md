File Manager Engine (PHP/Laravel/PostgreSQL) Выполнил Александр Аблин

Система управления файлами с разграничением прав доступа (RBAC), построенная на базе современных стандартов PHP (PSR-12) и контейнеризации Docker.

1. Постановка задачи (ТЗ)

Цель проекта: Разработать веб-приложение для безопасного хранения и управления файлами в реляционной базе данных.
Ключевые функции:

    Безопасность: Аутентификация пользователей и защита маршрутов через Middleware.
    Хранение: Использование типа данных BYTEA (PostgreSQL) для хранения файлов напрямую в БД (исключает зависимость от локальной файловой системы контейнера).
    RBAC (Role-Based Access Control): * User: Загрузка, просмотр и скачивание только своих файлов.
    Admin: Полный аудит системы (просмотр и скачивание файлов всех пользователей), запрет на личную загрузку.
    Интерфейс: SPA-подобный UI с использованием компонентов Ant Design.

2. Структура данных (ER-схема)

    Таблица users
    Поле	Тип	Описание
    id	BigInt	Первичный ключ
    name	String	Имя пользователя
    email	String	Уникальный Email (логин)
    password	String	Хеш пароля (Bcrypt)
    role	String	Роль (admin или user)

    Таблица files
    Поле	Тип	Описание
    id	BigInt	Первичный ключ
    user_id	Foreign Key	Связь с users.id (Cascade delete)
    name	String	Оригинальное имя файла
    content	Binary (BYTEA)	Содержимое файла в бинарном виде
    mime_type	String	Тип файла (image/png, application/pdf и т.д.)
    size	BigInt	Размер в байтах

3. Схема бизнес-логики (Workflow)

    Аутентификация: Пользователь вводит данные -> Middleware проверяет сессию -> Доступ к /home.

    Загрузка (User): Файл валидируется (max 16MB) -> Читается в поток (stream) -> Записывается в PostgreSQL.

    Доступ (Admin): Контроллер проверяет Auth::user()->role. Если admin, запрос File::all() подтягивает данные всех владельцев через Eager Loading (with('user')).

    Скачивание: Система проверяет права -> Преобразует бинарный ресурс PHP в HTTP-ответ с соответствующими заголовками Content-Type.

4. Технологический стек

    Backend: PHP 8.4 (Laravel 13)

    Database: PostgreSQL 15

    Frontend: Blade + Ant Design (CDN)

    Environment: Docker / Docker-compose

    Standards: PSR-1/4/12 (Автозагрузка через Composer)

5. Установка и запуск

    Клонирование репозитория:
    git clone -b dev https://github.com/Pro100sashaHD/PHP_File_manager
   
    cd file-manager

    cd src

    cp .env.example .env

    cd ..

    Запуск контейнеров:
   
    docker-compose up -d --build

    Настройка приложения:
   
    docker exec -it file-manager-app composer install

   docker exec -it file-manager-app php artisan key:generate
   
    docker exec -it file-manager-app php artisan migrate

   если нужны готовые пользователи
   
    docker exec -it file-manager-app php artisan db:seed --class=DatabaseSeeder

    Доступ:

        URL: http://localhost:8080

        Admin: admin@example.com / password

        User1: user1@example.com / password

        User2: user2@example.com / password
