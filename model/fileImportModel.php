<?php

//get files
$file = $_FILES["uploadedFile"];


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