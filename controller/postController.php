<?php

$postingComment = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);

if(is_null($postingComment))
    require("view/postView.php");
else{
    require("model/crud.php");
    require("model/fileImportModel.php"); 
   
}