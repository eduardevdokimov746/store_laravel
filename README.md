# Интернет - магазин на фрейморке PHP Laravel
## Описание
Проект разрабатывался с целью обучения. В нем используется готовый шаблон сайта (верстка написана не мной, только изменена под мои нужды). В проекте есть панель администратора. А также чат в реальном времени, написанный с использованием Laravel echo и pusher-js. Бизнес логика основана на моем предыдущем проекте, а именно интернет магазин, только на чистом PHP.
[Ссылка на предыдущий проект](<https://github.com/eduardEvdokimov/store>)
## Установка
### Загрузка проекта на машину
1. Перейти в каталог, где будет храниться проект.
2. Если **не** установлен git. Загрузить zip архив со страницы репозитория. И скопировать содержимое в папку.
3. Если **установлен** git. Выполнить следующую команду:

        git clone "https://github.com/eduardEvdokimov/store_laravel.git"
    
### Подготовка к запуску
##### Добавление изображений товаров
Я не стал добавлять в данный репозиторий все изображения, так как они много весят. Поэтому необходимо их скачать из предыдущего проекта:
[Ссылка на предыдущий проект](<https://github.com/eduardEvdokimov/store>)
Проще всего будет скачать проект в zip архиве, и после загрузки вырезать все содержимое папки: *store/www/images* в папку этого проекта *store_laravel/storage/app/public/images*.
### Подгрузка движка фреймворка
Для загрузки всех файлов фрейморка необходим composer. Если нет, устанавливаем.
[Ссылка на загрузку composer](https://getcomposer.org/Composer-Setup.exe)
Из командной строки, находясь в папке проекта выполняем следующую команду:

    composer install
    
##### Установка конфигурации
Необходимо создать файл конфигурации с именемем *.env* в корне проекта. Потом из корня проекта открыть файл *.env.example*, скопировать содержимое в созданный файл и написать свои значения ключей для ключей.
Далее выполнить команду для генерации ключа приложения:

    php artisan key:generate
    
Также для правильной работы хранилища необходимо сделать ссылку на католог *storage/app/public* в *public/storage*. Для этого выполняем следующую команду:

    php artisan storage:link
    
##### Подключение к базе данных
Перед тем как подключиться к базе данных необходимо указать в файле конфигурации *.env* настройки подключения к БД. После этого необходимо выполнеить следующую команду:
    
    php artisan migrate --seed
    
#### Запуск процессов для работы чата и очередей отправки эл. почты
Для запуска процесса websockets необходимо ввести команду:

    php artisan websockets:serve --port=6001
    
Для запуска воркера очередей для отправки эл. почты введите команду:

    php artisan queue:work --queue=emails --sleep=3 --tries=3 --timeout=60
    
В конце рекомендую выполнить сброс кеша конфигурации командой:

    php artisan config:cache
