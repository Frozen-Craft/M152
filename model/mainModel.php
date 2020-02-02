<?php

$successPost = filter_input(INPUT_GET, "successPost", FILTER_SANITIZE_STRING);

$info = "";

if($successPost){
    $info.="<div class='mt-2 alert alert-success alert-dismissible fade show' role='alert' >
    Contenu posté avec succès
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;
    </span></button></div>";
}