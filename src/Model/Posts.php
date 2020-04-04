<?php
include_once("../lib/DataBaseWorker/dbwPosts.php");

class Posts {

    /**
     * Returns single post item with specified id
     * @param integer $id
     * @return array $fullPostInformation
     */
    public static function getPostById($id) : array {
        $id = intval($id);
        $dbwPsts = new DBWPosts();
        $postInfo = $dbwPsts->getAllInfoAboutPost($id);
        $dbwPsts->closeConnection();
        return $postInfo;
    }

    /**
     * Returns an array on posts
     * @return array $allPostsArray
     */
    public static function getAllPosts() : array {
        $dbwPsts = new DBWPosts();
        $psts = $dbwPsts->getAllPostsInfo();
        $dbwPsts->closeConnection();
        return $psts;
    }
}

?>