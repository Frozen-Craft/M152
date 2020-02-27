<?php

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

try {
    startTransaction();
    $medias = getMedia($id);
    if (deletePostMedias($id)) {
        if (deletePost($id)) {
            foreach ($medias as $m) {
                unlink($m['mediaPath']);
            }
        }
    }
    commit();
} catch (Exception $e) {
    rollback();
} finally {
    header("Location: ?action=index");
    exit;
}
