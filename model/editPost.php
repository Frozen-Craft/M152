<?php
$idPost = filter_input(INPUT_GET, 'idPost', FILTER_SANITIZE_NUMBER_INT);

$submited = filter_input(INPUT_POST, 'submitB', FILTER_SANITIZE_STRING);
$cancelled = filter_input(INPUT_POST, 'cancel', FILTER_SANITIZE_STRING);

$postMessage = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
$removedImg = filter_input(INPUT_POST, 'removeImg', FILTER_SANITIZE_NUMBER_INT);
$restoreImg = filter_input(INPUT_POST, 'restoreImg', FILTER_SANITIZE_NUMBER_INT);
$rmAddImg = filter_input(INPUT_POST, 'rmAddImg', FILTER_SANITIZE_STRING);

if (empty($cancelled) && empty($submited) && empty($removedImg) && empty($postMessage) && empty($restoreImg) && empty($_SESSION['EditPost']['Active']) && empty($rmAddImg)) {
    $_SESSION['EditPost'] = array();
    $_SESSION['EditPost']['RemovedImg'] = array();
    $_SESSION['EditPost']['AddedMedia'] = array();
    $_SESSION['EditPost']['Active'] = true;
    $postMessage = getPosts($idPost)[0]['comment'];
}

if (!empty($_FILES['uploadedFile']['name'][0])) {
    foreach ($_FILES['uploadedFile']['tmp_name'] as $key => $value) {
        $path = "media/tmp_media/" . uniqid() . $_FILES['uploadedFile']['name'][$key];
        $type = explode('/', mime_content_type($_FILES['uploadedFile']['tmp_name'][$key]));
        move_uploaded_file($_FILES['uploadedFile']['tmp_name'][$key], $path);
        array_push($_SESSION['EditPost']['AddedMedia'], ['name' => $_FILES['uploadedFile']['name'][$key], 'path' => $path, 'type' => $type[0], 'fullType' => $type[0] . "/" . $type[1]]);
    }
}

if (!empty($rmAddImg)) {
    foreach ($_SESSION['EditPost']['AddedMedia'] as $key => $m) {
        if ($m['name'] == $rmAddImg) {
            unlink($m['path']);
            unset($_SESSION['EditPost']['AddedMedia'][$key]);
        }
    }
}

if (!empty($removedImg)) {
    array_push($_SESSION['EditPost']['RemovedImg'], $removedImg);
}

if (!empty($restoreImg)) {
    unset($_SESSION['EditPost']['RemovedImg'][array_search($restoreImg, $_SESSION['EditPost']['RemovedImg'])]);
}


if ($cancelled == 'Annuler') {
    $_SESSION['EditPost'] = array();
    header('Location: ?action=index');
    exit();
}

if ($submited) {
    startTransaction();
    try {
        $medias = getMedia($idPost);
        foreach ($_SESSION['EditPost']['RemovedImg'] as $rmMedia) {
            echo 1;
            foreach ($medias as $m) {
                if ($m['idMedia'] == $rmMedia) {
                    $path = $m['mediaPath'];
                }
            }
            if (deleteMedia($rmMedia)) {
                unlink($path);
            }
        }
        foreach ($_SESSION['EditPost']['AddedMedia'] as $addMedia) {
            $ext = explode("/",$addMedia['fullType'])[1];
            $newPath = "media/" . $addMedia['type'] . "/" . md5($addMedia["name"] . date("d m Y H:i:s:u") . uniqid()) . '.' . $ext;
            if(rename($addMedia['path'], $newPath)){
                addMedia($addMedia['type'], $addMedia['fullType'], $addMedia['name'], $newPath, $idPost);
            }else{
                unlink($addMedia['path']);
            }
        }
        editComment($postMessage, $idPost);
        $_SESSION['EditPost'] = array();
        commit();
        header("Location: ?action=index");
        exit();
    } catch (Exception $e) {
        rollback();
    }
}

function showAddMedias()
{
    $strMedia = "";
    if (!empty($_SESSION['EditPost']['AddedMedia'])) {
        $m = $_SESSION['EditPost']['AddedMedia'];
        foreach ($m as $me) {
            $strMedia .= <<<MEDIAS
            <div class="card col-md-3" width="20%">
            MEDIAS;

            switch ($me['type']) {
                case "image":
                    $strMedia .= sprintf('<img src="%s" class="card-img-top mt-1" alt="%s" /><p>', $me['path'], $me['name']);
                    break;
                case "video":
                    $strMedia .= sprintf('<video width="224" height="126" class="mx-auto mt-1" controls><source src="%s" type="%s" /></video><p>', $me['path'], $me['fullType']);
                    break;
                case "audio":
                    $strMedia .= sprintf('<audio class="mt-1" controls><source src="%s" type="%s" /></audio><p>', $me['path'], $me['fullType']);
                    break;
            }

            $name = $me['name'];

            $strMedia .= <<<MEDIAS
            <div class="card-body">
            <button class="btn btn-danger mt-1" value="$name" name="rmAddImg">Supprimer</button>
            </div>
            </div>
            MEDIAS;
        }
    }
    return $strMedia;
}
function showMedias($idPost)
{
    $m = getMedia($idPost);
    $strMedia = "";
    foreach ($m as $me) {
        $source = $me['mediaPath'];
        $id = $me['idMedia'];
        if (!in_array($me['idMedia'], $_SESSION['EditPost']['RemovedImg'])) {
            $strMedia .= <<<MEDIAS
            <div class="card col-md-3" width="20%">
            MEDIAS;

            switch ($me['typeMedia']) {
                case "image":
                    $strMedia .= sprintf('<img src="%s" class="card-img-top mt-1" alt="%s" /><p>', $me['mediaPath'], $me['nameMedia']);
                    break;
                case "video":
                    $strMedia .= sprintf('<video width="224" height="126" class="mx-auto mt-1" controls><source src="%s" type="%s" /></video><p>', $me['mediaPath'], $me['fullMediaType']);
                    break;
                case "audio":
                    $strMedia .= sprintf('<audio class="mt-1" controls><source src="%s" type="%s" /></audio><p>', $me['mediaPath'], $me['fullMediaType']);
                    break;
            }
            $strMedia .= <<<MEDIAS
            <div class="card-body">
            <button class="btn btn-danger mt-1" value="$id" name="removeImg">Supprimer</button>
            </div>
            </div>
            MEDIAS;
        } else {

            $strMedia .= <<<MEDIAS
            <div class="card col-md-3 bg-dark" width="20%">
            MEDIAS;

            switch ($me['typeMedia']) {
                case "image":
                    $strMedia .= sprintf('<img src="%s" class="card-img-top mt-1" alt="%s" /><p>', $me['mediaPath'], $me['nameMedia']);
                    break;
                case "video":
                    $strMedia .= sprintf('<video width="224" height="126" class="mx-auto mt-1" controls><source src="%s" type="%s" /></video><p>', $me['mediaPath'], $me['fullMediaType']);
                    break;
                case "audio":
                    $strMedia .= sprintf('<audio class="mt-1" controls><source src="%s" type="%s" /></audio><p>', $me['mediaPath'], $me['fullMediaType']);
                    break;
            }
            $strMedia .= <<<MEDIAS
            <div class="card-body">
            <button class="btn btn-primary mt-1" value="$id" name="restoreImg">Restaurer</button>
            </div>
            </div>
            MEDIAS;
        }
    }

    return $strMedia;
}
