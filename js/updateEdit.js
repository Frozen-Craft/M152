var loadFile = function(event) {
    console.log(event.target.files.length);
    send();
};

function send() {
    document.getElementById("formEdit").submit();
}