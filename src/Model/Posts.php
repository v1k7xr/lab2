<?php
include_once("../lib/DataBaseWorker/DBWPosts.php");

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

    public static function checkFileTypes(array $files) : bool {
        $allowedTypes = ['.zip', '.doc', '.docx', '.xls', '.xlsx', '.pdf', '.jpg', '.png']; // allowed file types
        $re = '/\.[a-z]{3,4}$/m';
        $fileType = "";
        echo "files from model posts: " . var_dump($files) . "\n<br>";
        foreach ($files as $file) {
            echo "foreach: " . var_dump($file) . "<br>";
            if (preg_match($re, $file['filename'], $fileType)) { // checking for compliance and taking the file type

                if (in_array($fileType[0], $allowedTypes)) { // checking for the entry of a file type (fileType) into an array of allowed types (allowedTypes)

                    if (strcmp($fileType[0], '.jpg') == 0 || strcmp($fileType[0], '.png') == 0) {// if pic
                        $fi = finfo_open(FILEINFO_MIME_TYPE);
                        $mime = (string) finfo_file($fi, $file['tmpname']);
                        
                        if (strpos($mime, 'image') === false) { // check on mime type
                            return false;
                        }
                    }

                } else {
                    return false;
                }

            } else {
                return false;
            }
        }

        return true; // kind of okay
    }

    public static function renameSaveFiles(array $files) {
        $dirToSave = "../storagedir/";

    }
}

?>