var a = 0;

function load(url, element)
{
    req = new XMLHttpRequest();
    req.open("POST", url, false);
    req.send(null);

    element.innerHTML = req.responseText; 
}

load("show_img.php", document.getElementById("img_show"));
load("get_sticker.php", document.getElementById("img_sup"));

var video = document.getElementById('video');
var ess = document.getElementById('fond_v');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

// pour avoir le rendu de la webcam et direct
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    var constraints = { video: true};
    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
        video.srcObject = stream;
        video.play();
        ess.srcObject = stream;
        ess.play();
    }).catch(
    e => a = 1
    );
}

// Pour prendre une photo
document.getElementById("snap").addEventListener("click", function() {
    if (a == 0) {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        var dataurl = canvas.toDataURL();
        var inf = new Array();
        inf[0] = 'id='+1+'&';
        inf[1] = "photo="+encodeURIComponent(dataurl);
        post_page('save_p.php', inf, function(data) {
            load("show_img.php", document.getElementById("img_show"));
        });
    }
});

function post_page(url, infos, callback) {
    var http_req = new XMLHttpRequest();

    http_req.onreadystatechange = function () {
        if (http_req.readyState === 4) {
            callback(http_req.responseText);
        }
    }
    http_req.open('POST', url, true);
    http_req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var i = 0;
    var variables = "";
    while (i < infos.length) {
        variables = variables+infos[i];
        i++;
    }
    http_req.send(variables);
}