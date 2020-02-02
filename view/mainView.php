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
        <div class="row mt-2 mx-auto">
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
    <div class="card mt-2 mb-2">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/0e622f554aa48766a1f9cecfcc496adf.jpeg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/0e622f554aa48766a1f9cecfcc496adf.jpeg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/0e622f554aa48766a1f9cecfcc496adf.jpeg"  class="d-block w-100" alt="...">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>
</div>
            </div>
        </div class="mb-2">
    </main>
</body>
</html>