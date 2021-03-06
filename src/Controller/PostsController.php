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
            $id = (int)$id;
            $postItem = Posts::getPostById($id);
            $files = Posts::getFiles($id);

            if(isset($_POST['submit'])) {
                Posts::uploadAllFilesZip($files, $postItem['postname'] . ".zip");
            }

            require_once("../src/View/Posts/postinfo.php");
        }
        return true;
    }

    public function actionAdd() {
        $postname = "";
        $postdescription = "";
        $files = false;
        $filesOnServer = []; // names and their types on server
        $uploadErrors = []; // upload errors
        $uploadWithoutErrors = true;
        $postData = [];
        session_start();
        if (isset($_POST['submit'])) {
            $postname = $_POST['postname'];
            $postdescription = $_POST['postdescription'];

            $errors = false;
            $result = false;

            $countfiles = count($_FILES['file']['name']);
            
            if (!Posts::checkPostName($postname)) {
                $errors[] = "Некорректное название поста";
            }

            if (!Posts::checkPostDescription($postdescription)) {
                $errors[] = "Некорректное описание поста";
            }

            if (!Posts::checkFilesCount($countfiles)) {
                $errors[] = "Минимальное количество файлов: 1";
                $errors[] = "Максимальное количество файлов: 10";
            }

            if ($errors == false) {
                for($i=0;$i<$countfiles;$i++){
                    $files[] = [
                        "filename" => $_FILES['file']['name'][$i],
                        "filemimetype" => $_FILES['file']['type'][$i],
                        "filesize" => $_FILES['file']['size'][$i],
                        "tmpname" => $_FILES['file']['tmp_name'][$i],
                        "error" => $_FILES['file']['error'][$i]
                    ];
                }
                
                $files = Posts::checkAddFileTypes($files); // check uploaded file types on allowed filetype
                $uploadErrors = array_column($files, 'error');
                $uploadWithoutErrors = Posts::uploadErrorsCheck($uploadErrors); // check that's all ok with uploads
                if ($files != false && $uploadWithoutErrors) {
                    $filesOnServer = Posts::saveRenamedFilesOnServer($files); // save file on server
    
                    //collect post (don't method) data from form
                    $postData = [
                        'userid' => $_SESSION['userid'],
                        'postadddate' => date("Y-m-d"),
                        'postname' => $postname,
                        'postdescription' => $postdescription,
                    ];
    
                    $newPostId = Posts::saveNewPostDataBase($postData); // save post data to DB and get id of new post
    
                    Posts::saveFilesInfo($filesOnServer, $newPostId);
    
                    header("Location: /posts/" . $newPostId);
                }
            }
        }

        require_once("../src/View/Posts/newpost.php");
        return true;
    }

    public function actionUpload() {
        $fileNameUser = $_GET['fnu'];
        $fileNameServer = $_GET['fns'];

        Posts::uploadFile($fileNameUser, $fileNameServer);
    }
}

?>