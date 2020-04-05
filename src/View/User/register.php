<?php 

require_once("../src/Controller/UserController.php");
#header here
?>

<section>
    <? if (isset($result) && $result): ?>
        <p> You have successfully registered! </p>
    <? else: ?>
        <? if (isset($errors) && is_array($errors)): ?>
            <ul>
                <? foreach ($errors as $error): ?>
                    <li> - <? echo $error; ?> </li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
    <? endif; ?>
    <div class="signup-form"><!--sign up form-->
        <h2>Регистрация на сайте</h2>
            <form action="#" method="post">
                <input type="text" name="name" placeholder="Имя" value="<? echo $name; ?>"/>
                <input type="email" name="email" placeholder="E-mail" value="<? echo $email ?>"/>
                <input type="password" name="password" placeholder="Пароль" value=""/>
                <input type="password" name="passwordRepeat" placeholder="Повторите пароль" value=""/>
                <input type="checkbox" id="confirmed" name="confirmed">
                    <label for="confirmed">Даю согласие на обработку персональных данных</label>
                <input type="submit" name="submit" class="btn btn-default" value="Регистрация" />                
             </form>
    </div><!--/sign up form-->
</section>