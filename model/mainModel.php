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
$posts = getArrangedPosts();

$allCards='';

foreach ($posts as $p){
    if(count($p[2])>1){
        $c = new PostWithMultipleImage($p[0], $p[1], $p[2]);
        $c->makeCarousel();
        $allCards.=$c->getCarousel();
    }elseif(count($p[2])==1){
        $c = new PostWithSingleImage($p[0], $p[1], $p[2][0]);
        $c->makeCard();
        $allCards.=$c->getCard();
    }else{
        $c = new Post($p[0], $p[1]);
        $c->makeCard();
        $allCards.=$c->getCard();
    }
}
