<?php
require_once("../src/Controller/PostsController.php");
//require_once("../src/View/templates/whoiswho.php");
require_once("../src/View/templates/header.php");
require_once("../src/View/templates/whoiswho.php");
?>

<? foreach ($files as $file): ?>
    <li> - <? echo ""; ?> </li>
    <a href="http://localhost:9000/upload?fnu=<? echo $file['filenameuser']; ?>&fns=<? echo $file['filenamehashsum']; ?>"><? echo $file['filenameuser']; ?></a>
<? endforeach; ?>

<form action="#" method="post">
<input type="submit" name="submit" class="" value="Скачать все файлы" />             
</form>