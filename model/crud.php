<?php

include "access/db.php";

function dbConnect(){
	static $db = null;
	
	$host = "127.0.0.1";
	$name = "m152";
	$user = USERNAME;
	$pass = PASSWORD;
	
	if($db == null){
		try {
            $connexionString = 'mysql:host=' . $host . ';dbname=' . $name . '';
            $db = new PDO($connexionString, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    return $db;
}


function addMedia($type, $fullType, $name, $path, $idPost){
    static $querry = null;
        
    $now = date("Y/m/d H:i:s");
    
    $querry = dbConnect()->prepare("INSERT INTO `medias` (typeMedia, fullMediaType, nameMedia, creationDate, modificationDate, mediaPath, idPost) VALUES (:typeM, :fullType, :nameM, :creatioD, :modificationD, :pathM, :idPost)");
    $querry -> bindParam("typeM", $type, PDO::PARAM_STR);
    $querry -> bindParam("fullType", $fullType, PDO::PARAM_STR);
    $querry -> bindParam("nameM", $name, PDO::PARAM_STR);
    $querry -> bindParam("creatioD", $now, PDO::PARAM_STR);
    $querry -> bindParam("modificationD", $now, PDO::PARAM_STR);
    $querry -> bindParam("pathM", $path, PDO::PARAM_STR);
    $querry -> bindParam("idPost", $idPost, PDO::PARAM_STR);
    return $querry->execute();
}

//return id of the post
function addPost($comment){
    static $querry = null;
    
    $now = date("Y/m/d H:i:s");
    
    $querry = dbConnect()->prepare("INSERT INTO `posts` (comment, creationDate, modificationDate) VALUES (:comment, :creationD, :modificationD)");
    $querry -> bindParam("comment", $comment, PDO::PARAM_STR);
    $querry -> bindParam("creationD", $now, PDO::PARAM_STR);
    $querry -> bindParam("modificationD", $now, PDO::PARAM_STR);
    $result = $querry->execute();
    
    return dbConnect()->lastInsertId();    
}

function deletePost($id){
    static $querry = null;
    
    $querry = dbConnect()->prepare("DELETE FROM `posts` WHERE idPost = :id");
    $querry -> bindParam("id", $id, PDO::PARAM_INT);
    return $querry->execute();
}

function deletePostMedias($id){
    static $querry = null;
    
    $querry = dbConnect()->prepare("DELETE FROM `medias` WHERE idPost = :id");
    $querry -> bindParam("id", $id, PDO::PARAM_INT);
    $result = $querry->execute();
    return $result;
}

function getPosts(){
    static $querry = null;
    $querry = dbConnect()->prepare("SELECT * FROM posts ORDER BY creationDate DESC");
    $querry->execute();
    return $querry->fetchAll(PDO::FETCH_ASSOC);
}

function getMedia($idPost){
    static $querry = null;
    $querry = dbConnect()->prepare("SELECT * FROM medias WHERE idPost = :id");
    $querry -> bindParam("id", $idPost, PDO::PARAM_INT);
    $querry->execute();
    return $querry->fetchAll(PDO::FETCH_ASSOC);

}

function deleteMedia($idMedia){
    static $querry = null;
    $querry = dbConnect()->prepare("DELETE FROM medias WHERE idMedia = :id");
    $querry -> bindParam("id", $idMedia, PDO::PARAM_INT);
    return $querry->execute();
}

function editComment($comment, $idPost){
    static $querry = null;
    $dateN = date('Y-m-d');
    $querry = dbConnect()->prepare("UPDATE `posts` SET `comment`=:comment,`modificationDate`=:dateN WHERE :id");
    $querry -> bindParam("id", $idPost, PDO::PARAM_INT);
    $querry -> bindParam("dateN", $dateN, PDO::PARAM_STR);
    $querry -> bindParam("comment", $comment, PDO::PARAM_STR);
    return $querry->execute();
}

function startTransaction(){
    dbConnect()->beginTransaction();
}

function rollback(){
    dbConnect()->rollback();
}

function commit(){
    dbConnect()->commit();
}

function getArrangedPosts(){
    $posts = getPosts();
    $arrangedPosts = array();
    if(count($posts)>0){
        foreach ($posts as $p){
            $aMedia = array();
            $medias = getMedia($p['idPost']);
            if(count($medias)>0){
                foreach ($medias as $m){
                    array_push($aMedia, ['nameMedia'=>$m['nameMedia'], 'mediaPath'=>$m['mediaPath'], 'typeMedia'=>$m['typeMedia'], 'fullMediaType'=>$m['fullMediaType']]);
                }
            }
            array_push($arrangedPosts, [$p['idPost'], $p['comment'], $aMedia]);
        }
    }
    return $arrangedPosts;
}