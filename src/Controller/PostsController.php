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
}

?>