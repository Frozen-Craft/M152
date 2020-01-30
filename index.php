<?php
/**
 * @author Alexandre Benzonana
 * @version 1.0
 * @mainpage 
 * Description: web app router
 */

session_start();

$dest = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
$role="default";

$permissions=[
    "default"=>[
        "index"=> "mainController",
        "post"=> "postController"
    ]
];

if(array_key_exists($dest, $permissions[$role])){
    require_once("controller/".$permissions[$role][$dest].".php");
}
else{
    require_once("controller/".$permissions["default"]["index"].".php");
}