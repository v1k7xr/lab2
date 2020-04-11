<?php

return [
    "posts/([0-9]+)" => "posts/view/$1",
    "posts/add" => "posts/add",
    "posts" => "posts/index",
    "user/registration" => "user/registration",
    "user/login" => "user/login",
    "user/logout" => "user/logout",
    "^upload\?[a-zA-z0-9\=\.\&\%\-\_()\[\]\{\}\#\$\!\?а-яА-Я]+" => "posts/upload",
];

?>