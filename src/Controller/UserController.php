<?php
include_once("../src/Model/User.php");

class UserController {

    public function actionAutorisation() {
        return "Autorisation here";
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
            // if (isset($name)) {
            //     echo "<br>name: " . $name;
            // } 

            // if (isset($email)) {
            //     echo "<br>email: " . $email;
            // }

            // if (isset($password)) {
            //     echo "<br>password: " . $password;
            // }
        }
        require_once("../src/View/User/register.php");
        return true;
    }
}

?>