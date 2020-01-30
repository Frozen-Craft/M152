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
        <form method="post" action="" class="mt-2">
            <div class="form-group">
                <textarea class="form-control" name="comment" placeholder="Écrivez votre message" style="resize:none;" rows="6"></textarea>
            </div>
            <label for="fileUpload" class="lblFileUpload"><img src="icons/camera-solid.svg" height="20em" /></label>
            <input type="file" style="display: none;" id="fileUpload" onchange="loadFile(event)" name="uplodedFile[]" accept="image/*" multiple class="form-control-file">
            <input type="submit" class="btn btn-dark btnSubmit colorBlue float-right"/>
        </form>
        <div id="uploadedImg">
        </div>
    </main>
    <script type="text/javascript" src="js/imgPreview.js"></script> 
</body>
</html>