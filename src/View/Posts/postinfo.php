<?php
require_once("../src/Controller/PostsController.php");
//require_once("../src/View/templates/whoiswho.php");
require_once("../src/View/templates/header.php");
require_once("../src/View/templates/whoiswho.php");
?>

<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
            <p> Название:  <? echo $postItem['postname'];  ?> </p>
		</div>
		<div class="col-md-4">
		</div>
</div>

<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
            <p> Дата добавления:  <? echo $postItem['date'];  ?> </p>
		</div>
		<div class="col-md-4">
		</div>
</div>

<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
            <p> Описание:  <? echo $postItem['description'];  ?> </p>
		</div>
		<div class="col-md-4">
		</div>
</div>

<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
            <p> Автор:  <? echo $postItem['username'];  ?> </p>
		</div>
		<div class="col-md-4">
		</div>
</div>

<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
        <p> Файлы:  </p>
		</div>
		<div class="col-md-4">
		</div>
</div>
<ul>
<? foreach ($files as $file): ?>
    <div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4 file">
        <a href="http://localhost:9000/upload?fnu=<? echo $file['filenameuser']; ?>&fns=<? echo $file['filenamehashsum']; ?>"><? echo $file['filenameuser']; ?></a>
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>
<? endforeach; ?>
</ul>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
        <form action="#" method="post">
        <input type="submit" name="submit" class="btnDownload" value="Скачать все файлы" />             
        </form>
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>

