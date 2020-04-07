<?php 

require_once("DataBaseWorker.php");

class DBWUser extends DataBaseWorker {

    public function checkEmailNovelty(string $email) : bool {
        $this->startConnection();

        $stmt = $this->connection->prepare('SELECT COUNT(*) FROM "User" WHERE "User".useremail = :email ;');

        $stmt->bindValue(':email', $email);

        $stmt->execute();

        if($stmt->fetchColumn() > 0) {
            return true;
        }
        return false;
    }

    public function addNewUser(string $name, string $email, string $hashPassword) : bool {
        $this->startConnection();

        $stmt = $this->connection->prepare('INSERT INTO "User" (username, useremail, userpsswrd) VALUES ( :username , :useremail , :hashPassword );');

        $stmt->bindParam(':username', $name, PDO::PARAM_STR);
        $stmt->bindParam(':useremail', $email, PDO::PARAM_STR);
        $stmt->bindParam(':hashPassword', $hashPassword, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function checkUser(string $email, string $password) {
        $this->startConnection();

        $stmt = $this->connection->prepare('SELECT userid, userpsswrd, username FROM "User" WHERE "User".useremail = :email ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        $userInfo = $stmt->fetch();

        if (password_verify($password, $userInfo['userpsswrd'])) {
            return [
                "userId" => $userInfo['userid'],
                "userName" => $userInfo['username'],
            ];
        }
        return false;
    }
}

?>