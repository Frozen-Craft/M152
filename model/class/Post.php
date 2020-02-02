<?php

class Post {

    private int $idPost;
    private string $comment;

    private string $card;

    function __construct($idPost, $comment){
        
    }

    function makeCard(){

    }

    function getCard(){

    }
    
}

class PostWithSingleImage extends Post{

    private array $pictures;

    function __construct(){
        parent::__construct();
    }

    function makeCard(){

    }    
}

class PostWithMultipleImage extends Post{

    private array $pictures;

    function __construct(){
        parent::__construct();
    }

    function makeCard(){

    }

    function makeCarousel(){
        
    }
}