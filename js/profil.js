window.onload = function() {
	if (document.getElementById('form_inscription') != null) {
		document.getElementById('form_inscription').onclick = function(e) {
			e.preventDefault();
			var form_inscription_mdp = document.getElementById('form_inscription_mdp').value;
			var form_inscription_pseudo = document.getElementById('form_inscription_pseudo').value;
			var form_inscription_mail = document.getElementById('form_inscription_mail').value;
			var form_inscription_mdp2 = document.getElementById('form_inscription_mdp2').value;


			var inf = new Array();
			inf[0] = 'form_inscription_mdp='+encodeURIComponent(form_inscription_mdp)+'&';
			inf[1] = 'form_inscription_pseudo='+encodeURIComponent(form_inscription_pseudo)+'&';
			inf[2] = 'form_inscription_mail='+encodeURIComponent(form_inscription_mail)+'&';
			inf[3] = 'form_inscription_mdp2='+encodeURIComponent(form_inscription_mdp2);
			post_page('traitement_profil.php', inf, function(data) {
				console.log(data);
		    	var p_f = document.getElementById('ins_f');
		    	if (data == "bravo inscription reussi")
		    		p_f.style.color = 'green';
		    	else {
		    		p_f.style.color = 'red';
		    	}
		    	p_f.style.position = 'absolute';
				p_f.style.top = '2%';
				p_f.style.width = '100%';
				p_f.style.fontSize = '1.5vh';
				p_f.style.textAlign = 'center';
		    	p_f.innerHTML = data;
		    });
		}
	}
	if (document.getElementById('form_connection') != null) {
		document.getElementById('form_connection').onclick = function(e) {
			e.preventDefault();
			var form_connection_mdp = document.getElementById('form_connection_mdp').value;
			var form_connection_pseudo = document.getElementById('form_connection_pseudo').value;

			var inf = new Array();
			inf[0] = 'form_connection_mdp='+encodeURIComponent(form_connection_mdp)+'&';
			inf[1] = 'form_connection_pseudo='+encodeURIComponent(form_connection_pseudo);
			post_page('traitement_co.php', inf, function(data) {
		    	var p_f = document.getElementById('co_f');
		    	if (data == "connection ...") {
		    		p_f.style.color = 'green';
		    		location.reload();
		    	}
		    	else {
		    		p_f.style.color = 'red';
		    		p_f.style.position = 'absolute';
					p_f.style.top = '58%';
					p_f.style.width = '100%';
					p_f.style.fontSize = '1.5vh';
					p_f.style.textAlign = 'center';
		    	}
		    	p_f.innerHTML = data;	
		    });
		}
	}
	
	document.getElementById('btn-mid').onclick = function() {
	    slideToggle();
	}

	var open = false;
	var initHeight = 100;
	var intval = null;

	function slideToggle() {
		window.clearInterval(intval);
		var mdiv = document.getElementById('go_pro');
		if(open) {
			var h = initHeight;
			open = false;
			intval = setInterval(function(){
				h--;
				mdiv.style.height = h + '%';
				if(h <= 0) {
					mdiv.style.display = 'none';
					window.clearInterval(intval);
				}
			}, 5
			);
		}
		else {
			var h = 0;
			open = true;
			mdiv.style.display = 'block';
			intval = setInterval(function(){
				h++;
				mdiv.style.height = h + '%';
				if(h >= initHeight) {
					window.clearInterval(intval);
				}
			}, 5
			);
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
};