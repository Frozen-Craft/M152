<?php

class Post
{

    protected $idPost;
    protected $comment;

    protected $card;

    function __construct($idPost, $comment)
    {
        $this->idPost = $idPost;
        $this->comment = $comment;
    }

    function makeCard()
    {
        $card = '<div class="card mt-2 mb-2"><p>';
        $card .= $this->comment;
        $card .= '</p></div>';
        $this->card = $card;
    }

    function getCard()
    {
        return $this->card;
    }

}

class PostWithSingleImage extends Post
{

    private $picture;

    function __construct($idPost, $comment, $picture)
    {
        parent::__construct($idPost, $comment);
        $this->picture = $picture;
    }

    function makeCard()
    {
        $card = '<div class="card mt-2 mb-2">';
        $card .= sprintf('<img src="%s" onclick="biggerImg(this)" alt="%s" /><p>', $this->picture['mediaPath'], $this->picture['mediaName']);
        $card .= $this->comment;
        $card .= '</p></div>';
        $this->card = $card;
    }

    function getCard()
    {
        return $this->card;
    }
}

class PostWithMultipleImage extends Post
{

    private $pictures;

    private $carousel;

    function __construct($idPost, $comment, $pictures)
    {
        parent::__construct($idPost, $comment);
        $this->pictures = $pictures;
    }

    function makeCard()
    {
        $this->makeCarousel();
    }

    function makeCarousel()
    {
        $carousel = '<div class="card mt-2 mb-2">
                     <div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
                     <ol class="carousel-indicators">';

        for ($i = 0; $i < count($this->pictures); $i++) {
            if($i==0){
                $carousel .= '<li data-target="#carouselIndicators" data-slide-to="' . $i . '" class="active"></li>';
            }else{
                $carousel .= '<li data-target="#carouselIndicators" data-slide-to="' . $i . '" class=""></li>';
            }
        }

        $carousel .= '</ol>
                      <div class="carousel-inner">';

        foreach ($this->pictures as $key => $p) {
            if($key==0){
                $carousel .= '<div class="carousel-item active">';
            }else {
                $carousel .= '<div class="carousel-item ">';
            }
            $carousel .= sprintf('<img src="%s" onclick="biggerImg(this)" class="d-block w-100" alt="%s" />', $p['mediaPath'], $p['nameMedia']);
            $carousel .= '</div>';
        }
        $carousel .= '</div>
                      <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                      </a>
                      </div><p>';
        $carousel .= $this->comment;
        $carousel .= '</p></div>';

        $this->carousel = $carousel;
    }

    function getComment()
    {
        return $this->pictures;
    }

    function getCard()
    {
        return $this->carousel;
    }

    function getCarousel()
    {
        return $this->carousel;
    }
}