var loadFile = function(event) {
    var parent = document.getElementById("uploadedImg");
    parent.innerHTML="";
    for(var i = 0; i<event.target.files.length; i++){
        var imgPrev = document.createElement("img");
        imgPrev.src = URL.createObjectURL(event.target.files[i]);
        imgPrev.classList.add("imgPreview");
        imgPrev.classList.add("mr-1");
        imgPrev.classList.add("mb-1");
        imgPrev.style.cursor = "pointer";
        imgPrev.onclick = function() {showBig(this.src)};
        parent.append(imgPrev);
    }
};


function showBig(image){
    var parent = document.getElementById("bigSizeViewBack");
    parent.style.visibility = "visible";
    var imgPrev = document.getElementById("bigSizeViewImg");
    imgPrev.src = image;
}

function closeBigView(){
    document.getElementById("bigSizeViewBack").style.visibility = "hidden";
}

document.addEventListener('keyup', (e) => {
    closeBigView();
});