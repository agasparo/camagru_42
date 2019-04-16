window.onload = function() {
	let btn_btn = document.getElementById('valid');
	var id = 0;
	var name = "";
	var email = "";
	var insr = document.getElementById('get_username');
	insr.focus();
	var fade;
	var opa = 0.1;

	insr.onkeypress = function(e) {
		if (e.keyCode == 13)
			btn_btn.click();
	}

	btn_btn.onclick = function() {
		var input = document.getElementById('get_username').value;
		var ins = document.getElementById('get_username');
		id++;
		var inf = new Array();
		inf[0] = 'in='+encodeURIComponent(input)+'&';
		inf[1] = 'type='+id+'&';
		inf[2] = 'name='+name+'&';
		inf[3] = 'email='+email;
		post_page('check_infos.php', inf, function(data) {
			if (data !== "no") {
				if (id == 1) {
					var myVar = setInterval(fadeout, 50);
					setTimeout(function() {
						clearInterval(myVar);
						ins.type = 'email';
						ins.value = "";
						ins.placeholder = "Votre mail";
						name = data;
						fade = setInterval(fadein, 50);
						insr.focus();
					}, 500);
				} else if (id == 2){
					var myVar = setInterval(fadeout, 50);
					setTimeout(function() {
						clearInterval(myVar);
						ins.type = 'password';
						ins.value = "";
						ins.placeholder = "Votre nouveau mot de passe";
						email = data;
						fade = setInterval(fadein, 50);
						insr.focus();
					}, 500);
				} else {
					var i = 5;
					document.getElementById('retour').style.color = 'green';
					document.getElementById('retour').innerText = "Un mail vous a été envoyé, redirection dans "+i+" secondes ...";
					var time = setInterval(change_time, 1000);
					setTimeout(function(){
						clearInterval(time);
						window.location = "../index.php";
					}, 5000);

					function change_time () {
						i--;
						document.getElementById('retour').innerText = "Un mail vous a été envoyé, redirection dans "+i+" secondes ...";
					}
				}
			} else {
				document.getElementById('retour').style.color = 'red';
				document.getElementById('retour').innerText = "La requette a échouée ...";
				insr.focus();
				setTimeout(function(){
					document.getElementById('retour').innerText = "";
				}, 3000);
				ins.type = 'text';
				ins.value = "";
				ins.placeholder = "Votre nom d'utilisateur";
				id = 0;
			}
		});
	}

	function fadeout() {
		document.getElementById('get_username').style.opacity = document.getElementById('get_username').style.opacity - 0.1;
	}

	function fadein() {
		if (document.getElementById('get_username').style.opacity >= 1.1)
			clearInterval(fade);
		document.getElementById('get_username').style.opacity = opa;
		opa = opa + 0.1;
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
};