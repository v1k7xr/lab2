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
                $message = date("[Y-m-d H:i:s]") . " / File with : name from user - " . $file['filename'] . ", hashsum - " . $md5hashsum . " was not loaded on server\n";
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


    /**
     * Returns id of newly created post
     * @param array $postInfo
     * @return int $id
     */
    public static function saveNewPostDataBase(array $postInfo) {
        $dbwPsts = new DBWPosts();
        $id = $dbwPsts->addNewPost($postInfo);
        $dbwPsts->closeConnection();
        return $id;
    }

    /**
     * Writes information about files in the database
     * @param array $filesOnServer
     * @param int $postId
     */
    public static function saveFilesInfo(array $filesOnServer, int $postId) {
        $dbwPsts = new DBWPosts();
        $dbwPsts->addNewFiles($filesOnServer, $postId);
        $dbwPsts->closeConnection();
    }

    /**
     * Returns true if all alright with name of the post
     * @param string $postName
     * @return bool
     */
    public static function checkPostName(string $postName) : bool {
        if (strlen($postName) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if all alright with description of the post
     * @param string $postDescription
     * @return bool
     */
    public static function checkPostDescription(string $postDescription) : bool {
        if (strlen($postDescription) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if all alright with count of the uploadpost
     * @param int $fileCount
     * @return bool
     */
    public static function checkFilesCount($fileCount) {
        if ($fileCount > 0 && $fileCount < 10) { // 10 - max upload files in php.ini
            return true;
        } 
        return false;
    }

    /**
     * Returns information about files in server
     * @param $id (post id)
     * @return array $filesInfo
     */
    public static function getFiles(int $id) : array {
        $dbwPsts = new DBWPosts();
        $filesInfo = $dbwPsts->getAllFilesInfo($id);
        $dbwPsts->closeConnection();
        return $filesInfo;
    }

    /**
     * Upload single file to user
     * @param string $fileNameUser
     * @param string $fileNameServer
     */
    public static function uploadFile(string $fileNameUser, string $fileNameServer) {
        $fullDir = Posts::getDir($fileNameUser, $fileNameServer);

        Posts::upload($fileNameUser, $fullDir);
    }

    /**
     * Upload all files in post to user
     * @param string $postName
     * @param array $files
     */
    public static function uploadAllFilesZip(array $files, string $postName) {
        $tempFilePath = "tempzip/" . time() . ".zip";
        $pathToFile = "";

        $zip = new ZipArchive();
 
        if ($zip->open($tempFilePath, ZipArchive::CREATE)!==TRUE) {
            exit("Невозможно открыть <$tempFilePath>\n");
        }

        foreach ($files as $file) {
            $pathToFile = Posts::getDir($file['filenameuser'], $file['filenamehashsum']);
            $zip->addFile($pathToFile, $file['filenameuser']);
        }

        $zip->close();

        Posts::upload($postName, $tempFilePath);

        unlink(realpath($tempFilePath));
    }

    /**
     * Work with client browser
     */
    public static function upload($fileNameUser, $fileNameOnServer) {
        if (file_exists($fileNameOnServer)) {
            // buff staff clean
            if (ob_get_level()) {
              ob_end_clean();
            }
            // open save window in browser
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileNameUser . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileNameOnServer));

            readfile($fileNameOnServer);
            
          }
    }

    /**
     * Returns the path to the client file with its extension
     * @param string $fileNameUser
     * @param string $fileNameOnServer
     * @return string @mainDir
     */
    public static function getDir(string $fileNameUser, string $fileNameOnServer) {
        $maindir = "../storagedir/";
        $re = '/\.[a-z]{3,4}$/m';

        $fileType = "";

        preg_match($re, $fileNameUser, $fileType);

        $stdir = substr($fileNameOnServer, 0, 2); //1st dir
        $nddir = substr($fileNameOnServer, 0, 5); //2nd dir

        return $maindir . $stdir . "/" . $nddir . "/" . $fileNameOnServer . $fileType[0];
    }

}

?>