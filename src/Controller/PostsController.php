<?php
include_once("../src/Model/Posts.php");


class PostsController {

    public function actionIndex () {
        $newPostsList = [];
        $newPostsList = Posts::getAllPosts();
        require_once("../src/View/Posts/main.php");
        return true;
    }

    public function actionView ($id) {
        if ($id) {
            $postItem = Posts::getPostById($id);

            print_r($postItem);
        }
        return true;
    }

    public function actionAdd() {
        $postname = "";
        $postdescription = "";
        $files = false;
        session_start();
        if (isset($_POST['submit'])) {
            $postname = $_POST['postname'];
            $postdescription = $_POST['postdescription'];

            $errors = false;
            $result = false;

            $countfiles = count($_FILES['file']['name']);
            
            for($i=0;$i<$countfiles;$i++){
                $files[] = [
                    "filename" => $_FILES['file']['name'][$i],
                    "filemimetype" => $_FILES['file']['type'][$i],
                    "filesize" => $_FILES['file']['size'][$i],
                    "tmpname" => $_FILES['file']['tmp_name'][$i],
                    "error" => $_FILES['file']['error'][$i]
                ];
            }
            
            $checkFiles = Posts::checkFileTypes($files);
            if ($checkFiles) {
                echo "files okay" . "<br>";
            }
        }

        require_once("../src/View/Posts/newpost.php");
        return true;
    }
}

?>