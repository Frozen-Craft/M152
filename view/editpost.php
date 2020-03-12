<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Edit Post</title>
</head>

<body>
    <?php require("view/includes/nav.php") ?>
    <main class="container">
        <form method="post" action="#" class="mt-2" id="formEdit" enctype="multipart/form-data">
            <div class="form-group">
                <textarea class="form-control" name="comment" id="comment" placeholder="Écrivez votre message" style="resize:none;" rows="6"><?= $postMessage ?></textarea>
            </div>
            <label for="fileUpload" class="lblFileUpload"><img src="css/icons/camera-solid.svg" height="20em" /></label>
            <input type="file" style="display: none;"  onchange="loadFile(event)" id="fileUpload" name="uploadedFile[]" accept="image/*,video/*, .mp3, .wav" multiple class="form-control-file">
            <input type="submit" name="submitB" class="ml-2 btn btn-dark btnSubmit colorBlue float-right" />
            <input type="submit" name="cancel" value="Annuler" class="btn btn-warning float-right" />
            <div id="uploadedImg" class="row">
                <?= showAddMedias() ?>
                <?= showMedias($idPost) ?>
            </div>
        </form>
    </main>
    <!-- <script type="text/javascript" src="js/imgPreview.js"></script>  -->
    <script type="text/javascript" src="js/updateEdit.js"></script> 
</body>

</html>