<?php

//get files
$files = $_FILES["uploadedFile"];
$textComment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);

$totalSize = 0;
foreach($_FILES["uploadedFile"]["size"] as $s) $totalSize += $s;

//if total file size >70mo return post page
if($totalSize>70000000){
	header("Location: ?action=post");
	exit();
}

//if a file size is > 3mo return post page
foreach($_FILES["uploadedFile"]["size"] as $s) $s>3000000?header("Location: ?action=post&error=File%20too%20big").exit():"";

//if form empty return post page
if($totalSize == 0 && empty($textComment)){
	header("Location: ?action=post");
	exit();
}

startTransaction();
$idPost = addPost($textComment);

$addedFiles = array();
//get file type and move files
if($totalSize>0){
	for($i = 0; $i < count($files["tmp_name"]); $i++){
		//get file type
		$fullType = mime_content_type($files["tmp_name"][$i]);
		//get file ext
		$ext = explode('/', $fullType)[1];
		//get global type
		$type = explode('/', $fullType)[0];
		//if file is other than image deleting the post and go back to post page
		if($type != "image" && $ext != "mp3" && $ext!= "wav" && $type != "audio"){
			cancelPosting("Wrong type");
		}
		//move file
		$newFileName = md5($files["name"][$i].date("d m Y H:i:s:u").uniqid()).'.'.$ext;
		$result = move_uploaded_file($files['tmp_name'][$i], "media/".$type."/".$newFileName);
		//add to db
		if($result == 1)
		{
			$result = addMedia($type, $fullType, $files["name"][$i], 'media/'.$type.'/'.$newFileName, $idPost);
			if($result == 1)
				array_push($addedFiles, $newFileName);
			else
				cancelPosting("Failed to add to db");
		}else{
			cancelPosting("Failed to move file");
		}
	}
	
}
commit();
header("Location: ?action=index&successPost=true");
exit();

function cancelPosting($error){
	global $addedFiles;
	rollback();
	//remove all just added files from image folder
	foreach($addedFiles as $f){
		unlink('media/images/'.$f);
	}
	header("Location: ?action=postComment&error=".$error);
	exit();
}


/*

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
