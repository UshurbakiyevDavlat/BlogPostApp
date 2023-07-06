<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Blog Post project

### Requirements
~~~
Создать простую админ панель для CRUD-a постов блога на Laravel.

На выходе мы ожидаем следующие данные:
    Страница аутентификации/регистрации.
    Страницы доступные после аутентификации/регистрации для любого
    пользователя:
    страница списка постов:
    с кнопкой создать Создать;
    ID, наименование поста, кнопки редактировать и удалить;
    стандартная пагинация Laravel.
    страница создания поста;
    страница редактирования поста.

Страница создания/редактирования поста должна содержать поля:
title (required);
body (required);
author_name (required).
~~~
~~~
Требования к хранимым данным
    В базе данных вы должны хранить таблицы:
    users;
    posts. 

Таблица должна содержать следующие поля:
    id;
    author_name;
    created_at;
    updated_at;
    deleted_at.

прочие таблицы генерируемые самой Laravel.

Для хранения и чтения остальной информации необходимо использовать
https://dummyjson.com/. ID поста в таблице должно соответствовать ID
dummyjson.

Список постов должен запрашиваться не из БД, а из dummyjson по 30 штук на
страницу. Общее количество постов: 150.
При открытии на редактирование поста, у которого нет записи в БД, на
редактирование author_name посылать пустым.

~~~
~~~
Технические требования
Для запуска проекта необходимо использовать Laravel Sail, соответственно
проект должен легко подыматься через Docker.
В качестве БД использовать PostgreSQL.
~~~


### Installation
~~~
1. git clone
2. copy example.env to .env
3. bash ./vendor/bin/sail up -d
4. bash ./vendor/bin/sail composer install
5. bash ./vendor/bin/sail npm install
6. bash ./vendor/bin/sail artisan key:generate
7. bash ./vendor/bin/sail artisan migrate
8. bash ./vendor/bin/sail npm run build / or npm run dev
~~~

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
