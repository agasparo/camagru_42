function do_fd(id) {
    var canvas = document.getElementById('draw');
    var context = canvas.getContext('2d');
    var img = document.getElementById(id);
    var imgs = new Image();
    imgs.src = img.src;
    if (id == "fond_v") {
        i = setInterval(function(){ 
            context.drawImage(img, 0, 0, canvas.width, canvas.height);
        }, 20);
    } else {
        if (typeof i != "undefined")
            clearInterval(i);
        imgs.onload = function () {
            context.drawImage(imgs, 0, 0, canvas.width, canvas.height);
        }
    }
}