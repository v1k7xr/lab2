<?php

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
    <div class="container"><!--login form-->
        <h2>Создание нового поста</h2>
            <form action="#" method="post" enctype='multipart/form-data'>
                <input type="text" name="postname" placeholder="Название поста" value="<? echo $postname ?>"/>
                <textarea rows="10" cols="45" name="postdescription" placeholder="Описание поста"><? echo $postdescription ?></textarea>
                <input type='file' name='file[]' multiple>
                <input class="submitbtn" type="submit" name="submit" class="btn btn-default" value="Сохранить данные" />               
             </form>
    </div><!--/login form-->
</section>