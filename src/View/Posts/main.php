<?php 
require_once("../src/Controller/PostsController.php");
require_once("../src/View/templates/whoiswho.php");

?>
<!DOCTYPE html>
<html>
<head>
    <title> posts page </title>
</head>
<body>
<? if (isset($newPostsList)) : ?>
    <ul>
        <? foreach ($newPostsList as $post): ?>
        <li> <? print_r($post); ?> </li>
        <? endforeach; ?>
    </ul>
<? else : ?>
    <h1> Oops, looks like something unplanned </h1>
<? endif; ?>
</body>
</html>