<?php

class Post
{

    protected $idPost;
    protected $comment;

    protected $card;

    function __construct($idPost, $comment)
    {
        $this->$idPost = $idPost;
        $this->$comment = $comment;
    }

    function makeCard()
    {
        $card = '<div class="card mt-2 mb-2">';
        $card .= $this->comment;
        $card = '</div>';
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
        $this->$picture = $picture;
    }

    function makeCard()
    {
        $card = '<div class="card mt-2 mb-2">';
        $card .= sprintf('<img src="%s" alt="%s"', $this->picture['path'], $this->picture['name']);
        $card .= $this->comment;
        $card .= '</div>';
        $this->card = $card;
    }

    function getCard()
    {
        parent::getCard();
    }
}

class PostWithMultipleImage extends Post
{

    private $pictures;

    private $carousel;

    function __construct($idPost, $comment, $pictures)
    {
        parent::__construct($idPost, $comment);
        $this->$pictures = $pictures;
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
            $carousel .= '<li data-target="#carouselIndicators" data-slide-to="' . $i . '" class="active"></li>';
        }

        $carousel .= '</ol>
                      <div class="carousel-inner">';

        foreach ($this->pictures as $p) {
            $carousel .= '<div class="carousel-item">';
            $carousel .= sprintf('<img src="%s" class="d-block w-100" alt="%s" />', $p['path'], $p['name']);
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
                      </div>
                      </div>';

        $this->carousel = $carousel;
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