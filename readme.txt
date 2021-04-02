git clone https://user_name/codedistrict/php-template.git
cd php-template
composer install
cp .env.example .env
php artisan key:generate
create a database
configure the database in the .env file
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=user_name
    DB_PASSWORD=database_password
php artisan migrate
php artisan db:seed