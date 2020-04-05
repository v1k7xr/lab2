<?php 

require_once("../src/Controller/UserController.php");
#header here
?>

<section>
        <? if (isset($errors) && is_array($errors)): ?>
            <ul>
                <? foreach ($errors as $error): ?>
                    <li> - <? echo $error; ?> </li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
    <div class="login-form"><!--login form-->
        <h2>Авторизация на сайте</h2>
            <form action="#" method="post">
                <input type="email" name="email" placeholder="E-mail" value="<? echo $email ?>"/>
                <input type="password" name="password" placeholder="Пароль" value=""/>
                <input type="submit" name="submit" class="btn btn-default" value="Авторизация" />                
             </form>
    </div><!--/login form-->
</section>