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


function addMedia($type, $name, $path){
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
    
    return dbConnect()->lastInsertId("idPost");    
}

function getLastId(){
    $querry = dbConnect()->prepare("SELECT LAST_INSERT_ID() FROM posts;");
    $result = $querry->execute();
    return $querry->fetchAll();
    // return dbConnect()->lastInsertId('idPost');    
}

function startTransaction(){
    dbConnect()->beginTransaction();
}

function commit(){
    dbConnect()->commit();
}

function rollback(){
    dbConnect()->rollback();
}