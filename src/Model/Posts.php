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

    /**
     * Returns new files array (added convenient designation types) if all ok with files and false if isn't
     * @return array $files (ok)
     * @return bool false (not ok)
     * Kinda security code
     */
    public static function checkAddFileTypes(array $files) {
        $allowedTypes = ['.zip', '.doc', '.docx', '.xls', '.xlsx', '.pdf', '.jpg', '.png']; // allowed file types
        $re = '/\.[a-z]{3,4}$/m';
        $fileType = "";
        $i = 0;
        foreach ($files as $file) {
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
            $files[$i]['filetype'] = $fileType[0];
            $i++;
        }
        return $files; // kind of okay
    }

    /**
     * Returns true if there are no errors
     * @return bool
     */
    public static function uploadErrorsCheck(array $loadErrors) : bool {
        $errors = [1, 2, 3, 4, 5, 6, 7, 8]; // https://www.php.net/manual/en/features.file-upload.errors.php
        $uploadError = array_intersect($errors, $loadErrors);
        if ($uploadError) {
            return false;
        }
        return true;
    }

    /**
     * Returns array like ['file name on server', 'file name from user'] if all ok, false if isn't
     * @return array $files (ok)
     * @return bool false (not ok)
     */
    public static function saveRenamedFilesOnServer(array $files) {
        $dirToSave = "../storagedir/";
        $md5hashsum = "";
        $fulldir = "";
        $stdir = ""; # 1'st
        $nddir = ""; # 2'nd
        $insertInfo = [];
        $uploaded = true;
        foreach ($files as $file) {
            $md5hashsum = md5_file($file['tmpname']);
            $stdir = substr($md5hashsum, 0, 2);
            $nddir = substr($md5hashsum, 0, 5);
            // check of dir existence, create if false
            if (!is_dir($dirToSave . $stdir)) {
                mkdir($dirToSave . $stdir . "/" . $nddir, 0777, true);
            } else {
                if(!is_dir($dirToSave . $stdir . "/" . $nddir)) {
                    mkdir($dirToSave . $stdir . "/" . $nddir, 0777, false);
                }
            }

            // fulldir - full path to uploaded file on server (now file has the name somthing like md5hashsum(32).filetype)
            $fulldir = $dirToSave . $stdir . "/" . $nddir . "/" . $md5hashsum . $file['filetype'];

            //move file to dir
            if (move_uploaded_file($file['tmpname'], $fulldir)) {
                $insertInfo[] = [
                    "filenameuser" => $file['filename'],
                    "filenamehashsum" => $md5hashsum,
                ];
            } else {
                $message = date("[Y-m-d H:i:s]") . " / File with : name from user - " . $file['filename'] . ", hashsum - " . $md5hashsum . " was not loaded\n";
                error_log($message, 3, "../logs/lgs.log");
                $uploaded = false;
            }

        }
        if ($uploaded) {
            return $insertInfo;
        } else {
            return false;
        }
    }

    public static function saveNewPostDataBase(array $postInfo) {
        $dbwPsts = new DBWPosts();
        $id = $dbwPsts->addNewPost($postInfo);
        $dbwPsts->closeConnection();
        return $id;
    }

    public static function saveFilesInfo(array $filesOnServer, int $postId) {
        $dbwPsts = new DBWPosts();
        $dbwPsts->addNewFiles($filesOnServer, $postId);
        $dbwPsts->closeConnection();
    }
}

?>