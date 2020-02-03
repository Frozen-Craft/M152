//make an image bigger on clicking on it (for the preview images)
function biggerImg(image){
    var parent = document.getElementById("bigSizeViewBack");
    parent.style.visibility = "visible";
    var imgPrev = document.getElementById("bigSizeViewImg");
    imgPrev.src = image.src;
    imgPrev.alt = image.alt;
}

//make the big image smaller on clicking anywhere
function closeBigView(){
    document.getElementById("bigSizeViewBack").style.visibility = "hidden";
}

//make the big image smaller by hitting any key
document.addEventListener('keyup', (e) => {
    closeBigView();
});