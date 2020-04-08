<?php
include_once("../src/Model/User.php");

class UserController {

    public function actionLogin() {
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkEmail($email)) {
                $errors[] = 'Email введен некорректно';
            }

            if (!User::checkPassword($password, $password)) {
                $errors[] = 'Пароль введен некорректно';
            }

            $userInfo = User::checkUserData($email, $password);

            var_dump($userInfo);

            if ($userInfo == false) {
                $errors[] = 'Неверный логин или пароль!';
            } else {
                User::userAuth($userInfo);

                header("Location: /posts/");
            }
        }
        require_once("../src/View/User/login.php");
        return true;
    }

    public function actionRegistration() {
        $name = '';
        $email = '';
        $password = '';
        $repeatedPassword = '';

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeatedPassword = $_POST['passwordRepeat'];

            $errors = false;
            $result = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя введено некорректно (разрешена кириллица, пробелы и дефисы)';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Email введен некорректно';
            }

            if (!User::checkPassword($password, $repeatedPassword)) {
                $errors[] = 'Пароль введен некорректно (должен быть длиннее 6 символов)';
            }

            if (!User::checkEmailNovelty($email)) {
                $errors[] = 'Пользователь с таким email-ом уже существует';
            }


            if ($errors == false) {
                $result = User::saveUser($name, $email, $password);
            }
        }
        require_once("../src/View/User/register.php");
        return true;
    }

    public function actionLogout() {
        User::userLogout();
        header("Location: /posts/");
        return true;
    }

}

?>