var loadFile = function(event) {
    var parent = document.getElementById("uploadedImg");
    parent.innerHTML="";
    for(var i = 0; i<event.target.files.length; i++){
        var imgPrev = document.createElement("img");
        imgPrev.width=100;
        imgPrev.src = URL.createObjectURL(event.target.files[i]);
        imgPrev.classList.add("mr-1");
        parent.append(imgPrev);
    }
};