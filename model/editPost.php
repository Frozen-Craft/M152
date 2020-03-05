<?php
$idPost = filter_input(INPUT_GET, 'idPost', FILTER_SANITIZE_NUMBER_INT);

$message = getPosts($idPost)[0]['comment'];

startTransaction();

function showMedias($idPost){
    $m = getMedia($idPost);
    $strMedia = "";
    foreach($m as $me){
        $source = $me['mediaPath'];
        $id = $me['idMedia'];
        $strMedia .= <<<MEDIAS
        <div class="card col-md-3" width="20%">
            <img class="card-img-top mt-1" src="$source" />
            <div class="card-body">
                <a href="$id"><button class="btn btn-danger mt-1">Remove</button></a> 
            </div>
        </div>
        MEDIAS;
    }

    return $strMedia;
}