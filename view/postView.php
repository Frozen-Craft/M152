<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" /> 
    <link rel="stylesheet" href="css/style.css" /> 
    <title>Post</title>
</head>
<body>
    <?php require("view/includes/nav.php") ?>
    <main class="container">
        <form method="post" action="?action=postComment" class="mt-2" enctype="multipart/form-data">
            <div class="form-group">
                <textarea class="form-control" name="comment" id="comment" placeholder="Écrivez votre message" style="resize:none;" rows="6"></textarea>
            </div>
            <label for="fileUpload" class="lblFileUpload"><img src="css/icons/camera-solid.svg" height="20em" /></label>
            <input type="file" style="display: none;" id="fileUpload" name="uploadedFile[]" accept="image/*,video/*, .mp3, .wav" multiple class="form-control-file">
            <input type="submit" name="submit" class="btn btn-dark btnSubmit colorBlue float-right"/>
        </form>
        <div id="uploadedImg">
        </div>
    </main>
    <div id="bigSizeViewBack"">
        <img src="" alt="" id="bigSizeViewImg" ">
    </div>
    <!-- <script type="text/javascript" src="js/imgPreview.js"></script>  -->
</body>
</html>