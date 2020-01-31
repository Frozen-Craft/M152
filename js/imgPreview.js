//Add small image under the textbox to show a preview of the selected images
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

//make an image bigger on clicking on it (for the preview images)
function showBig(image){
    var parent = document.getElementById("bigSizeViewBack");
    parent.style.visibility = "visible";
    var imgPrev = document.getElementById("bigSizeViewImg");
    imgPrev.src = image;
}

//make the big image smaller on clicking anywhere
function closeBigView(){
    document.getElementById("bigSizeViewBack").style.visibility = "hidden";
}

//make the big image smaller by hitting any key
document.addEventListener('keyup', (e) => {
    closeBigView();
    var key = e.key;
    if(key != "Enter" && key != "Escape"){
        document.getElementById("comment").focus();
    }
});