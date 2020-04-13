<?php 

require_once("../src/Controller/UserController.php");
require_once("../src/View/templates/header.php");
#header here
?>
<section>
    <? if (isset($result) && $result): ?>
        <? header("Location : /user/login") ?>
    <? else: ?>
        <? if (isset($errors) && is_array($errors)): ?>
            <ul>
                <? foreach ($errors as $error): ?>
                    <li> - <? echo $error; ?> </li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
    <? endif; ?>
    <div class="container"><!--sign up form-->
        <h1>Регистрация</h1>
        <p>Пожалуйста заполните поля в этой форме для создания аккаунта. </p>
            <form action="#" method="post">
                <label for="name"><b>Имя</b></label>
                <input type="text" name="name" placeholder="Имя" value="<? echo $name; ?>"/>
                <label for="email"><b>E-mail</b></label>
                <input type="email" name="email" placeholder="E-mail" value="<? echo $email ?>"/>
                <label for="password"><b>Пароль</b></label>
                <input type="password" name="password" placeholder="Пароль" value=""/>
                <label for="passwordRepeat"><b>Повторите пароль</b></label>
                <input type="password" name="passwordRepeat" placeholder="Повторите пароль" value=""/>
                <input type="checkbox" checked id="confirmed" name="confirmed">
                    <label for="confirmed">Согласен с <a href = "#">условиями и политикой конфиденциальности</a>.</label>
                <input type="submit" id="regButton" name="submit" class="submitbtn" value="Регистрация" />
                <div class="container signin">
                    <p>Уже есть аккаунт? <a href="http://localhost:9000/user/login">Войти</a>.</p>
                </div>                
             </form>
    </div>
</section>

<script>

var checker = document.getElementById('confirmed');
var sendbtn = document.getElementById('regButton');
checker.onchange = function(){
if(this.checked && sendbtn.disabled == true){
    sendbtn.disabled = false;
} else {
    sendbtn.disabled = true;
    }
}

</script>