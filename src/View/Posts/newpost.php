<?php
require_once("../src/View/templates/header.php");
?>
<section>
        <? if (!isset($_SESSION['userid'])): ?>
            <? header("Location: /posts/") ?>
        <? endif; ?>
        <? if (isset($errors) && is_array($errors)): ?>
            <ul>
                <? foreach ($errors as $error): ?>
                    <li> - <? echo $error; ?> </li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
<div class="container-fluid"><!--new post add form-->
    <div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
            <h1>Создание нового поста</h1>
            <form action="#" method="post" enctype='multipart/form-data'>
                <input class="form-control" type="text" name="postname" placeholder="Название поста" value="<? echo $postname ?>"/>
                <textarea class="form-control" rows="10" name="postdescription" placeholder="Описание поста"><? echo $postdescription ?></textarea>
                <br>
                <label for="uploadFiles" class="custom-file-upload float-left">
                Выбрать файлы
                </label>    
                <input type='file' id='uploadFiles' name='file[]' multiple>
                <input class="submitbtn" type="submit" name="submit" class="btn btn-default" value="Сохранить данные" />               
             </form>
		</div> <div class="col-md-4"></div>
    </div>
</div>
</section>
