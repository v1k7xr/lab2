<?php 
require_once("../src/Controller/PostsController.php");
//require_once("../src/View/templates/whoiswho.php");
require_once("../src/View/templates/header.php");
require_once("../src/View/templates/whoiswho.php");
?>
<? if (isset($newPostsList)) : ?>
    <? foreach ($newPostsList as $post): ?>
        <div class="center"> 
            <span class="badge badge-success"><a href="http://localhost:9000/posts/<? echo $post['postid'] ?>"> Имя поста: <? echo $post['postname']; ?> </a></span> <br>
            <span class="badge badge-success">Автор: <? echo $post['authorname']; ?> </span> <br>
            <span class="badge badge-success">Дата создания: <? echo $post['date']; ?></span> <br>
        </div>
    <? endforeach; ?>
<? else : ?>
    <h1> Oops, looks like something unplanned </h1>
<? endif; ?>
</body>
</html>