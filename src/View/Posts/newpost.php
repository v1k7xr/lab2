<?php

?>
<section>
        <? if (!isset($_SESSION['userid'])): ?>
            <h1>Данная страница доступна только авторизованным пользователям.</h1>
            <p>Вы будете автоматически перенаправленны на главную страницу через 5 секунд. </p>
            <? sleep(5); ?>
            <? header("Location: /posts/") ?>
        <? endif; ?>
    <div class="container"><!--login form-->
        <h2>Создание нового поста</h2>
            <form action="#" method="post" enctype='multipart/form-data'>
                <input type="text" name="postname" placeholder="Название поста" value="<? echo $postname ?>"/>
                <textarea rows="10" cols="45" name="postdescription" placeholder="Описание поста"><? echo $postdescription ?></textarea>
                <input type='file' name='file[]' value="Выбрать файлы для сохранения" multiple>
                <input class="submitbtn" type="submit" name="submit" class="btn btn-default" value="Сохранить данные" />
                <? echo "files from _files in view: " . var_dump($_FILES['file']) . "\n";?>                
             </form>
    </div><!--/login form-->
</section>