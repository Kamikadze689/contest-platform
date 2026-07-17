# Платформа для сбора работ на конкурс

## Описание
Веб-приложение для проведения конкурсов с тремя ролями: администратор, жюри и участник.

## Требования
- PHP 8.1+
- MySQL 5.7+
- Composer
- Node.js & NPM

## Установка
```bash
1. Клонировать репозиторий

git clone https://github.com/Kamikadze689/contest-platform.git
cd contest-platform
Установить зависимости

2. Установить зависимости
composer install
npm install
npm run build

3. Настройка окружения
bash
cp .env.example .env
php artisan key:generate

4. Настройка базы данных (в файле .env)
text
DB_CONNECTION=mysql
DB_HOST=MySQL-8.0
DB_PORT=3306
DB_DATABASE=contest_platform
DB_USERNAME=root
DB_PASSWORD=

5. Настройка S3 хранилища (в файле .env)
text
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_key
AWS_DEFAULT_REGION=ru-1
AWS_BUCKET=108441407d0b-college
AWS_ENDPOINT=https://s3.ru1.storage.beget.cloud
AWS_URL=https://108441407d0b-college.s3.ru1.storage.beget.cloud
AWS_USE_PATH_STYLE_ENDPOINT=true

6. Запустить миграции и сиды
bash
php artisan migrate
php artisan db:seed

7. Запустить очередь (в отдельном окне)
bash
php artisan queue:work

8. Запустить сервер
bash
php artisan serve

Тестовые пользователи
Роль	Email	Пароль
Администратор	admin@test.com	password
Член жюри	jury@test.com	password
Участник	participant@test.com	password
