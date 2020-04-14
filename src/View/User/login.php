<?php 

require_once("../src/Controller/UserController.php");
require_once("../src/View/templates/header.php");
#header here
?>
<section>
        <? if (isset($errors) && is_array($errors)): ?>
            <ul>
                <? foreach ($errors as $error): ?>
                    <li> <p> <? echo $error; ?> </p> </li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
    <div class="container"><!--login form-->
        <h1>Авторизация на сайте</h1>
            <form action="#" method="post">
                <input type="email" name="email" placeholder="E-mail" value="<? echo $email ?>"/>
                <input type="password" name="password" placeholder="Пароль" value=""/>
                <input class="submitbtn" type="submit" name="submit" class="btn btn-default" value="Войти" />                
             </form>
    </div><!--/login form-->
</section>