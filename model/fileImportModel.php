<?php

//get files
$files = $_FILES["uploadedFile"];
$textComment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);

$totalSize = 0;
foreach($_FILES["uploadedFile"]["size"] as $s) $totalSize+=$s;
echo $totalSize;
echo"<pre>";
var_dump($files);

//if total file size >70mo return post page
if($totalSize>70000000){
	header("Location: ?action=post");
	exit();
}

//if a file size is > 3mo return post page
foreach($_FILES["uploadedFile"]["size"] as $s) $s>3000000?header("Location: ?action=post").exit():"";

//if form empty return post page
if($totalSize == 0 && empty($textComment)){
	header("Location: ?action=post");
	exit();
}

addPost($textComment);
$idPost = getLastId();

//get file type and move files
if($totalSize>0){
	for($i = 0; $i < count($files["tmp_name"]); $i++){
		//get file type
		$type = mime_content_type($files["tmp_name"][$i]);
		//get file ext
		$ext = explode('/', $type)[1];
		//get global type
		$type = explode('/', $type)[0];
		//if file is other than image deleting the post and go back to post page
		if($type != "image"){
			deletePost($idPost);
			header("Location: ?action=postComment");
			exit();
		}
		//move file
		$newFileName = md5($files["name"][$i].date("d m Y H:i:s:u").uniqid()).'.'.$ext;
		move_uploaded_file($files['tmp_name'][$i], "images/".$newFileName);
		//add to db
		addMedia($type, $files["name"][$i], 'images/'.$newFileName, $idPost);
	}
	
}

/*

//get extension


// unique name --> md5($file.date("d m Y H:i:s:u").uniqid())

//Move
$success = move_uploaded_file($_FILES["photo"]['tmp_name'], $dest);




//Resize
$img = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
	$size = getimagesize($dest);
	$w = $maxWidth;
	$h = $w * ($size[1] / $size[0]);
	$img_dst = ImageCreateTrueColor($w, $h);
	$img_src = imagecreatefromjpeg($dest);
	ImageCopyResampled($img_dst, $img_src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
	ImageJpeg($img_dst, $dest, 90);

	$success = addPhoto($name, $desc, $cat, $path);

*/