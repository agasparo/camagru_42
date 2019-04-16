var page = document.querySelectorAll('.page');
var i = 0;
var inf = new Array();
inf[0] = 'commence='+0;
post_page('galeri.php', inf, function(data) {
	document.getElementById('galerie').innerHTML = "";
	document.getElementById('galerie').innerHTML = data;
	var a = 0;
	while (a < page.length) {
		var b = a + 1;
		document.getElementById(b+'page').style.color = 'grey';
		document.getElementById(b+'pagination').style.backgroundColor = 'transparent';
		var elem = document.getElementById(b+'pagination').querySelectorAll('img');
		var i = 0;
		while (i < elem.length) {
			elem[i].removeEventListener('click', ancre);
			elem[i].style.cursor = 'auto';
			i++;
		}
		a++;
	}
	if (document.getElementById('1page'))
		document.getElementById('1page').style.color = '#fa7e1e';
	if (document.getElementById('1pagination')) {
		document.getElementById('1pagination').style.backgroundColor = '#9E9E9E';
		var elem = document.getElementById('1pagination').querySelectorAll('img');
		var i = 0;
		while (i < elem.length) {
			elem[i].addEventListener('click', ancre);
			elem[i].style.cursor = 'pointer';
			i++;
		}
		partage();
		postis();
	}
});

while(i < page.length) {
	page[i].addEventListener("click", function(){autre(this.innerHTML, this.id, page.length)});
	i++;
}

function autre(content, id, len) {
	var ess = content.replace(' ', '');
	var inf = new Array();
	inf[0] = 'commence='+(parseInt(ess) - 1);
	post_page('galeri.php', inf, function(data) {
		document.getElementById('galerie').innerHTML = "";
		document.getElementById('galerie').innerHTML = data;
		var a = 0;
		while (a < len) {
			var b = a + 1;
			document.getElementById(b+'pagination').style.backgroundColor = 'transparent';
			document.getElementById(b+'page').style.color = 'grey';
			var elem = document.getElementById(b+'pagination').querySelectorAll('img');
			var i = 0;
			while (i < elem.length) {
				elem[i].removeEventListener('click', ancre);
				elem[i].style.cursor = 'auto';
				i++;
			}
			a++;
		}
		document.getElementById(id).style.color = '#fa7e1e';
		var e = id.split('page');
		document.getElementById(e[0]+'pagination').style.backgroundColor = '#9E9E9E';
		var a = document.createElement('a');
		a.href = "#"+e[0]+'pagination';
		document.getElementById('pagination').appendChild(a);
		a.click();
		document.getElementById('pagination').removeChild(a);
		var elem = document.getElementById(e[0]+'pagination').querySelectorAll('img');
		var i = 0;
		while (i < elem.length) {
			elem[i].addEventListener('click', ancre);
			elem[i].style.cursor = 'pointer';
			i++;
		}
		partage();
		postis();
	});
}

function ancre(e) {
	var a = document.createElement('a');
	a.href = "#"+e.target.id+'go_to';
	document.body.appendChild(a);
	a.click();
	document.body.removeChild(a);
}

function partage() {
	var aime = document.querySelectorAll('.aime');

	var i = 0;
	while(i < aime.length) {
		count(aime[i].id, 1);
		aime[i].addEventListener("click", function(){all(this.id, 1)});
		i++;
	}

	function count(id, type) {
		var inf = new Array();
		inf[0] = 'id='+id+'&';
		inf[1] = 'type='+1;
		post_page('get_jaime.php', inf, function(data) {
			document.getElementById(id).innerHTML = data;
		});
	}

	function all(id, type) {
		if (type == 1) {
			var inf = new Array();
			inf[0] = 'id='+id+'&';
			inf[1] = 'type='+2;
			post_page('get_jaime.php', inf, function(data) {
				count(id, 1);
			});
		}
	}
}

if (document.getElementById('pref')) {
	document.getElementById('pref').onclick = function() {
		if (document.getElementById('pref').innerText == '● Mes preferences (mail : oui)') {
			document.getElementById('pref').innerHTML = '&#9679; Mes preferences (mail : non)';
			var inf = new Array();
			inf[0] = 'id='+1;
			post_page('mail.php', inf, function(data) {
			});
		} else {
			document.getElementById('pref').innerHTML = '&#9679; Mes preferences (mail : oui)';
			var inf = new Array();
			inf[0] = 'id='+0;
			post_page('mail.php', inf, function(data) {
			});
		}
	}
}

if (document.getElementById('montages')) {
	document.getElementById('montages').onclick = function() {
		var newDiv = document.createElement("div");
		newDiv.id = 'suppr_img_all';
		newDiv.style.position = 'fixed';
		newDiv.style.backgroundColor = 'white';
		newDiv.style.zIndex = '200';
		newDiv.style.width = '50%';
		newDiv.style.height = '50%';
		newDiv.style.top = '25%';
		newDiv.style.left = '25%';
		newDiv.style.boxShadow = '1px 1px 12px #555';
		newDiv.style.overflow = 'auto';
		var inf = new Array();
		post_page('get_montages.php', inf, function(data) {
			newDiv.innerHTML = data;
			var suppr = document.querySelectorAll('.img_suppr');
			var i = 0;
			while (i < suppr.length) {
				suppr[i].addEventListener('click', elem_suppr);
				i++;
			}
			if (document.getElementById('close_suppr')) {
				document.getElementById('close_suppr').onclick = function() {
					document.body.removeChild(newDiv);
					location.reload();
				}
			}
		});
		document.body.appendChild(newDiv);
	}

	function elem_suppr(e) {
		var inf = new Array();
		inf[0] = 'src='+encodeURIComponent(e.target.src);
		post_page('suppr_montages.php', inf, function(data) {
			var suppr = document.querySelectorAll('.img_suppr');
			var i = 0;
			while (i < suppr.length) {
				suppr[i].removeEventListener('click', elem_suppr);
				i++;
			}
			var inf = new Array();
			post_page('get_montages.php', inf, function(data) {

				document.getElementById('suppr_img_all').innerHTML = data;
				var suppr = document.querySelectorAll('.img_suppr');
				var i = 0;
				while (i < suppr.length) {
					suppr[i].addEventListener('click', elem_suppr);
					i++;
				}
				if (document.getElementById('close_suppr')) {
					document.getElementById('close_suppr').onclick = function() {
						document.body.removeChild(document.getElementById('suppr_img_all'));
						location.reload();
					}
				}
			});
		});
	}
}

function postis() {
	var post_msg = document.querySelectorAll('.comm_send');
	var i = 0;
	while (i < post_msg.length) {
		post_msg[i].addEventListener('click', post_comm);
		i++;
	}
	var post_msg = document.querySelectorAll('.comm_write');
	var i = 0;
	while (i < post_msg.length) {
		post_msg[i].addEventListener('keydown', auto_post);
		i++;
	}
}

function auto_post(event) {
	if (event.keyCode == 13) {
		var e = event.target.id.split('s');
		document.getElementById(e[0]).click();
	}
}

function post_comm(e) {
	var inf = new Array();
	inf[0] = 'msg='+encodeURIComponent(document.getElementById(e.target.id+'s').value)+'&';
	inf[1] = 'id='+e.target.id+'&';
	inf[2] = 'id_perso='+document.getElementById(e.target.id+'s').getAttribute('name');
	post_page('add_comm.php', inf, function(data) {
		var inf = new Array();
		inf[0] = 'id='+e.target.id;
		post_page('get_comm.php', inf, function(data) {
			document.getElementById(e.target.id+'s').value = "";
			document.getElementById(e.target.id+'_re').innerHTML = data;
		});
	});
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