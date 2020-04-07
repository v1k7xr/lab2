<?php 

require_once("../src/View/templates/header.php");
require_once("../src/Controller/PostsController.php")

?>

<? if (isset($newPostsList)) : ?>
    <ul>
        <? foreach ($newPostsList as $post): ?>
        <li> <? print_r($post); ?> </li>
        <? endforeach; ?>
    </ul>
<? else : ?>
    <h1> Oops, looks like something unplanned </h1>
<? endif; ?>