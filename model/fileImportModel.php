<?php

//get files
$files = $_FILES["uploadedFile"];
$textComment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);

$totalSize = 0;
foreach($_FILES["uploadedFile"]["size"] as $s) $totalSize+=$s;
echo $totalSize;
echo"<pre>";
var_dump($files);

if($totalSize>70000000){
	header("Location: ?action=post");
	exit();
}

foreach($_FILES["uploadedFile"]["size"] as $s) $s>3000000?header("Location: ?action=post").exit():"";

if($totalSize == 0 && empty($textComment)){
	header("Location: ?action=post");
	exit();
}
// startTransaction();
$idPost = addPost($textComment);
echo $idPost;
var_dump(getLastId());
echo dbConnect()->lastInsertId("idPost");  
if($idPost==0){
	// rollback();
	echo "R";
}else{
	// commit();
	echo "C";
}


//get file type

//mime_content_type ( string $filename (path))

/*

//get extension
$ext = explode('.', $file);
$dest = '../img/' . md5($file.date("d m Y H:i:s:u").uniqid()) . '.' . $ext[count($ext)-1];
$path =  'img/' . md5($file.date("d m Y H:i:s:u").uniqid()) . '.' . $ext[count($ext)-1];


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