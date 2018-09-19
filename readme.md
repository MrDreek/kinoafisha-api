## Порядок деплоя

**_git clone git@github.com:MrDreek/kinoafisha-api.git_**

**_composer install --no-dev_** установка зависимостей без require-dev

**_php -r "file_exists('.env') || copy('.env.example', '.env');"_**

**_php artisan key:generate_**

Указать необходимые данные в файле .env (Подключение к базе, настройки прокси, ключ кинохода)

_**php artisan config:cache**_  // команда для кеширования настроек окружения


## Endpoint

[Документация по апи Kinoafisha](https://api.kinoafisha.info/docs/export/index.html)


GET http://kinoafisha.loc/api/get-city-list

POST http://kinoafisha.loc/api/get-code

POST http://kinoafisha.loc/api/get-seances

POST http://kinoafisha.loc/api/get-movie-detail
