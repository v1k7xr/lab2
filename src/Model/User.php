<?php 
include_once("../lib/DataBaseWorker/DBWUser.php");


class User {

    public static function userRegistration() {

    }

    public static function checkName(string $name) : bool {
        $pattern = "/[!@$#%^&*()_;:0-9a-zA-Z]/";
        if (!preg_match($pattern, $name) && strlen($name) > 0) {
            return true;
        }
        return false;
    }

    public static function checkEmail(string $email) : bool {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function checkPassword(string $password, string $repeatedPassword) : bool {
        $pattern = "/[a-zA-Z]/";
        if (strlen($password) >= 6) {
            if (strcmp($password, $repeatedPassword) == 0) {
                if (preg_match($pattern, $password)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check for the existence of a record in the database with this email
     * @param string $email
     * @return bool 
     */
    public static function checkEmailNovelty(string $email) : bool {
        $user = new DBWUser();

        if ($user->checkEmailNovelty($email)) {
            $user->closeConnection();
            return false;
        }
        $user->closeConnection();
        return true;
    }

    public static function saveUser(string $name, string $email, string $password) : bool {
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $user = new DBWUser();
        $result = $user->addNewUser($name, $email, $passHash);
        $user->closeConnection();
        return $result;
    }

    public static function checkUserData(string $email, string $password) {
        $user = new DBWUser();
        $userInfo = $user->checkUser($email, $password);
        $user->closeConnection();
        return $userInfo;
    }

    public static function userAuth(array $userInfo) {
        session_start();
        $_SESSION['userid'] = $userInfo['userId'];
        $_SESSION['username'] = $userInfo['userName'];
    }

    public static function userLogout() {
        session_start();
        unset($_SESSION['userid']);
        unset($_SESSION['username']);
    }
}

?>