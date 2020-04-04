<?php

require_once("DataBaseWorker.php");

function compareByTimeStamp($arr1, $arr2) 
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
                                                WHERE post.postid=:id');       

        $stmt->execute(['id' => $id]);

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
                'post_id' => $row['postid'],
                'author_name' => $row['username'],
                'date' => $row['postadddate'],
                'name' => $row['postname'],
            ];
        }

        usort($pstsList, "compareByTimeStamp");
        
        return $pstsList;
    }
}

?>