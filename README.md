# Лабораторная работа №2
Проект тестился на [встроенном php сервере](https://www.php.net/manual/en/features.commandline.webserver.php).

Запуск сервера командой **php -S localhost:[port]** (port - по идее – любой свободный порт на машине, например : php -S localhost:9000 ) из папки public .

Перед запуском сервера нужно изменить файл dbConf(example).json, записав данные для подлкючения к BD, и поменять имя файла на dbConf.json (Или можно назвать другим именем, но тогда нужно будет менять имя файла конфига в файле DataBaseWorker.php (11 строка))

База данных, используемая в проекте - Postgresql.
[Скрипт создания бд](https://github.com/v1k7xr/lab2/blob/master/dumpSchema.sql)
Для работы проекта нужно дать [права на всё](https://www.postgresql.org/docs/9.0/sql-grant.html) в таблице тому юзeру, который записан в dbConf.json 
Пример:
- GRANT ALL PRIVILEGES ON {database name} TO username;
- GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public to username;
Сама структура БД -> [imgur](https://imgur.com/a/QMENf2o)


Изменения в файле php.ini:
- file_uploads = On
- upload_max_filesize = 15M
- max_file_uploads = 10
- short_open_tag = On
