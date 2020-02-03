<?php

include "access/db.php";

function dbConnect(){
	static  $connection = null;
	
	$host = "127.0.0.1";
	$name = "m152";
	$user= USERNAME;
	$pass= PASSWORD;
	
	if($connection == null){
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


function addMedia($type, $name, $path, $idPost){
    static $querry = null;
    
    $now = date("Y/m/d H:i:s");
    
    $querry = dbConnect()->prepare("INSERT INTO `medias` (typeMedia, nameMedia, creationDate, modificationDate, mediaPath, idPost) VALUES (:type, :name, :creatioD, :modificationD, :path, :idPost)");
    $querry -> bindParam("type", $type, PDO::PARAM_STR);
    $querry -> bindParam("name", $name, PDO::PARAM_STR);
    $querry -> bindParam("creatioD", $now, PDO::PARAM_STR);
    $querry -> bindParam("modificationD", $now, PDO::PARAM_STR);
    $querry -> bindParam("path", $path, PDO::PARAM_STR);
    $querry -> bindParam("idPost", $idPost, PDO::PARAM_STR);
    $result = $querry->execute();
    
    return $result;
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
    
    return $result;    
}

function getLastId(){
    $querry = dbConnect()->prepare("SELECT idPost from posts ORDER BY idPOst DESC LIMIT 1");
    $result = $querry->execute();
    return $querry->fetchAll(PDO::FETCH_ASSOC)[0]['idPost'];
}

function deletePost($id){
    static $querry = null;
    
    $querry = dbConnect()->prepare("DELETE FROM `posts` WHERE idPost = :id");
    $querry -> bindParam("id", $id, PDO::PARAM_INT);
    $result = $querry->execute();
    return $result;
}

function getPosts(){
    static $querry = null;
    $querry = dbConnect()->prepare("SELECT * FROM posts ORDER BY creationDate DESC");
    $result = $querry->execute();
    return $querry->fetchAll(PDO::FETCH_ASSOC);
}

function getMedia($idPost){
    static $querry = null;
    $querry = dbConnect()->prepare("SELECT * FROM medias WHERE idPost = :id");
    $querry -> bindParam("id", $idPost, PDO::PARAM_INT);
    $result = $querry->execute();
    return $querry->fetchAll(PDO::FETCH_ASSOC);

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
                    array_push($aMedia, ['mediaName'=>$m['nameMedia'], 'mediaPath'=>$m['mediaPath'], 'typeMedia'=>$m['typeMedia']]);
                }
            }
            array_push($arrangedPosts, [$p['idPost'], $p['comment'], $aMedia]);
        }
    }
    return $arrangedPosts;
}