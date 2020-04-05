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
                $errors[] = 'Incorrect email!';
            }

            if (!User::checkPassword($password, $password)) {
                $errors[] = 'Incorrect password';
            }

            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Incorrect data for login!';
            } else {
                User::userAuth($userId);

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
                $errors[] = 'Incorrect name!';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Incorrect email!';
            }

            if (!User::checkPassword($password, $repeatedPassword)) {
                $errors[] = 'Incorrect password';
            }

            if (!User::checkEmailNovelty($email)) {
                $errors[] = 'User with this email already exsist!';
            }


            if ($errors == false) {
                $result = User::saveUser($name, $email, $password);
            }
        }
        require_once("../src/View/User/register.php");
        return true;
    }

}

?>