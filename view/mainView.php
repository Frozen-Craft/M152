<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Accueil</title>
</head>
<body>
<?php require("view/includes/nav.php") ?>
<main class="container">
    <?= $info ?>
    <div class="row mt-2 mb-2 mx-auto">
        <div class="col-md-4 mx-auto">
            <div class="card mx-auto" >
                <img src="images/profilepicture.jpg" style="width: 90%;" class="card-img-top mt-2 mx-auto" alt="profilePicture">
                <div class="card-body">
                    <p class="card-text">Ceci est ma photo de profile</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <div class="card mx-auto">
                <div class="card-body">
                    <h2 class="card-title">Welcome</h2>
                </div>
            </div>
            <!-- TEST -->
            <div class="posts">

            </div>
        </div>
    </div>
</main>
</body>
</html>