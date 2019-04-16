window.onload = function() {
	var i = 0;
  var sw = 0;
  var id_obj = 'x';
  var object_in = "k";
  setTimeout(function(){
   var elements = document.querySelectorAll('.drag');
   while(i < elements.length) {
    elements[i].addEventListener('contextmenu', function(event){
      event.preventDefault();
      if (sw == 0)
        sw = 1;
      else
        sw = 0;
    });
    elements[i].addEventListener("mousedown", function(){all(this.id, sw)});
    i++;
  }
}, 500);
  function all(id, sw) {
    if (sw == 0)
      drag_and_drop(id, id_obj);
    else {
      resize(id);
      id_obj = id_obj+' '+id;
    }
  }

  function resize(id) {
    var box = document.getElementById(id);
    box.style.cursor = 'pointer';
    box.addEventListener('mousedown', initialiseResize, false);

    function initialiseResize(e) {
      if (sw == 1) {
        window.addEventListener('mousemove', startResizing, false);
        window.addEventListener('mouseup', stopResizing, false);
      }
    }

    function startResizing(e) {
     box.style.width = (e.clientX - box.offsetLeft) + 'px';
     box.style.height = (e.clientY - box.offsetTop) + 'px';
   }
   function stopResizing(e) {
    window.removeEventListener('mousemove', startResizing, false);
    window.removeEventListener('mouseup', stopResizing, false);
  }
}

function drag_and_drop(id, id_obj) {
  var edc = document.getElementById(id);
  edc.style.cursor = 'grab';
    var top = event.clientY - document.documentElement.scrollTop - edc.offsetHeight / 2; // a pofiner
    var left = edc.offsetLeft;
    edc.style.zIndex = 1000;

    match = id_obj.match(id);
    if (match == null) {
      edc.style.width = '10%';
      edc.style.height = '15%';
    } else {
      edc.style.width = document.getElementById(match[0]).style.width;
      edc.style.height = document.getElementById(match[0]).style.height;
    }
    edc.style.transform = "none";
    edc.style.position = 'fixed';
    edc.style.top = top+'px';
    edc.style.left = left+'px';

    var currentDroppable = null;
    var shiftX = event.clientX - edc.getBoundingClientRect().left;
    var shiftY = event.clientY - edc.getBoundingClientRect().top;

    document.body.append();

    moveAt(event.pageX, event.pageY);

    function moveAt(pageX, pageY) {
      edc.style.left = pageX - shiftX + 'px';
      edc.style.top = pageY - shiftY + 'px';
    }

    function onMouseMove(event) {
      moveAt(event.pageX, event.pageY);

      edc.hidden = true;
      var elemBelow = document.elementFromPoint(event.clientX, event.clientY);
      edc.hidden = false;

      if (!elemBelow) return;
      var droppableBelow = elemBelow.closest('.droppable');
      if (currentDroppable != droppableBelow) {
        currentDroppable = droppableBelow;
      } else {
        edc.onmouseup = function() {
          if (currentDroppable == null) {
            edc.style.zIndex = 1000;
            edc.style.width = '60%';
            edc.style.height = '100%';
            edc.style.left = 0+'px';
            edc.style.top = 0+'px';
            edc.style.position = 'relative';
            var src = edc.src;
            object_in = object_in.replace(new RegExp(src, 'g'), 'k');
          } else if (currentDroppable.id == "draw") {
            edc.onmouseup = null;
            edc.style.zIndex = 10;
            var t = edc.style.top.replace('px', '');
            var t1 = document.getElementById('draw').offsetTop;
            var l = edc.style.left.replace('px', '');
            var l1 = document.getElementById('draw').offsetLeft;
            var top = t - t1;
            var left = l - l1;
            var height = edc.offsetHeight;
            var width = edc.offsetWidth;
            var src = edc.src;
            object_in = object_in+' '+src+':'+width+':'+height+':'+top+':'+left;
          }
          document.removeEventListener('mousemove', onMouseMove);
          edc.onmouseup = null;
          edc.style.zIndex = 10;
        }
      }
    }

    document.addEventListener('mousemove', onMouseMove);

    edc.onmouseup = function() {
      document.removeEventListener('mousemove', onMouseMove);
      edc.onmouseup = null;
      edc.style.zIndex = 10;
    };

    edc.ondragstart = function() {
      return false;
    };
  }
  document.getElementById("pub").addEventListener("click", function() {
    if (object_in == "k") {
      alert('aucun stickers selectionné');
    } else {
      var canvas = document.getElementById('draw');
      var dataurl = canvas.toDataURL();
      var inf = new Array();
      inf[0] = 'photo='+encodeURIComponent(object_in)+'&';
      inf[1] = 'id='+2+'&';
      inf[2] = 'ar_p='+encodeURIComponent(dataurl)+'&';
      inf[3] = 'canvas_w='+canvas.scrollWidth+'&';
      inf[4] = 'canvas_h='+canvas.scrollHeight;
      post_page('save_p.php', inf, function(data) {
        window.location = 'index.php';
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
}