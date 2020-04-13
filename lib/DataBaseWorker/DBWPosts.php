<?php

require_once("DataBaseWorker.php");

function compareByTimeStamp($arr1, $arr2) // for sort posts by date
{ 
    if (strtotime($arr1['date']) < strtotime($arr2['date'])) 
        return 1; 
    else if (strtotime($arr1['date']) > strtotime($arr2['date']))  
        return -1; 
    else
        return 0; 
} 

class DBWPosts extends DataBaseWorker {

    public function getAllInfoAboutPost(int $id) : array {
        $this->startConnection();

        $stmt = $this->connection->prepare('SELECT postadddate, postdescription, postname, username FROM post
                                                LEFT JOIN "User"
                                                ON post.userid = "User".userid
                                                WHERE post.postid = :id');       

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $post = $stmt->fetch();

        $allInfoAboutPost = [
            'date' => $post['postadddate'],
            'description' => $post['postdescription'],
            'postname' => $post['postname'],
            'username' => $post['username'],
        ];

        return $allInfoAboutPost;
    }



    public function getAllPostsInfo() : array {
        
        $pstsList = [];
        
        $this->startConnection();

        $stmt = $this->connection->query('SELECT post.postid, "User".username, post.postadddate, post.postname FROM post
                                        LEFT JOIN "User"
                                        ON post.userid = "User".userid');
        
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        while ($row = $stmt->fetch()) {
            $pstsList[] = [
                'postid' => $row['postid'],
                'authorname' => $row['username'],
                'date' => $row['postadddate'],
                'postname' => $row['postname'],
            ];
        }

        usort($pstsList, "compareByTimeStamp");
        
        return $pstsList;
    }

    public function addNewPost(array $postInfo) : int {

        $this->startConnection();

        $sql = 'INSERT INTO post (userid, postadddate, postdescription, postname) VALUES ( :userid , :postadddate , :postdescription , :postname ) RETURNING postid;';

        $stmt = $this->connection->prepare($sql);

        $stmt->execute($postInfo);

        $newPostId = $stmt->fetchAll();

        $newPostId = $newPostId[0]['postid'];

        if (is_int($newPostId)) {
            return $newPostId;
        }

        return -1;
    }

    public function addNewFiles(array $filesInfo, int $postId) {
        
        $this->startConnection();

        $stmt = $this->connection->prepare('INSERT INTO "file" (postid, filenameuser, filenamehashsum) VALUES ( :postid , :filenameuser , :filenamehashsum )');

        foreach ($filesInfo as $fileInfo) {
            $stmt->bindValue(':postid', $postId);
            $stmt->bindValue(':filenameuser', $fileInfo['filenameuser']);
            $stmt->bindValue(':filenamehashsum', $fileInfo['filenamehashsum']);
            $stmt->execute();
        }

    }

    public function getAllFilesInfo(int $id) {
        $this->startConnection();

        $stmt = $this->connection->prepare('SELECT fileid, filenameuser, filenamehashsum FROM "file" WHERE postid = :postid ');

        $stmt->bindValue(':postid', $id);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}

?>