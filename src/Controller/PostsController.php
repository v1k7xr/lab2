<?php
include_once("../src/Model/Posts.php");


class PostsController {

    public function actionIndex () {
        $newPostsList = [];
        $newPostsList = Posts::getAllPosts();

        echo "<pre>";
        print_r($newPostsList);
        echo "<pre>";

        return true;
    }

    public function actionView ($id) {
        if ($id) {
            $postItem = Posts::getPostById($id);

            echo "<pre>";
            print_r($postItem);
            echo "<pre>";
        }
        return true;
    }
}

?>