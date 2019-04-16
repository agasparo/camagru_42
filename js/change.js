if (document.getElementById('form_changes')) {
    document.getElementById('form_changes').onclick = function(e) {
        e.preventDefault();
        var mail = document.getElementById('form_change_mail').value;
        var pseudo = document.getElementById('form_change_pseudo').value;
        var mdp = document.getElementById('form_change_mdp').value;
        var mdp1 = document.getElementById('form_change_mdp2').value;
        var inf = new Array();
        inf[0] = 'mail='+encodeURIComponent(mail)+'&';
        inf[1] = 'pseudo='+encodeURIComponent(pseudo)+'&';
        inf[2] = 'mdp='+encodeURIComponent(mdp)+'&';
        inf[3] = 'mpd1='+encodeURIComponent(mdp1);
        post_page('change.php', inf, function(data) {
            document.getElementById('result_change').innerText = data;
            if (data == "")
                window.location = "deco.php";
        });
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