var input = document.getElementById('img_insert');
var out_pout = document.getElementById('img_insert_btn');

function load(url, element)
{
    req = new XMLHttpRequest();
    req.open("POST", url, false);
    req.send(null);

    element.innerHTML = req.responseText; 
}

out_pout.onclick = function() {
    
    input.click();
}

input.onchange = function() {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var dat = e.target.result.split('/');
            var base = dat[1].split(';');
            if (dat[0] == "data:image") {
                var inf = new Array();
                inf[0] = 'base64='+encodeURIComponent(e.target.result)+'&';
                inf[1] = 'type='+base[0];
                post_page('insert_img_user.php', inf, function(data) {
                    load("show_img.php", document.getElementById("img_show"));
                });
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

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