function WebCam() {
	var streaming = false,
		video = document.getElementById('video'),
		canvas = document.getElementById('canvas'),
		width = 404,
		height = false,
		photo = false;

	navigator.getMedia = (navigator.getUserMedia ||
			navigator.webkitGetUserMedia ||
			navigator.mozGetUserMedia ||
			navigator.msGetUserMedia);
	navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				}
				else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
	video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
			);

	video.addEventListener('canplay', function() {
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	function takepicture() {
		if (streaming || canvas.style.backgroundImage)
		{
			canvas.width = width;
			canvas.height = height;
			canvas.style.border="2px solid #f3558e";
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
			photo = canvas.toDataURL('image/png');
			document.getElementById("publishbutton").disabled = false;
			document.getElementById("deletebutton").disabled = false;
		}
	}

	function deletepicture() {
		var ctx = canvas.getContext("2d");
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		canvas.style.backgroundImage = "";
		canvas.style.border = "0px";
		document.getElementById("publishbutton").disabled = true;
		document.getElementById("deletebutton").disabled = true;
		photo = false;
	}

	function publishphoto() {
		if (photo)
		{
			var filter = document.getElementById('filter');
			var data = new FormData();
			data.append("img", photo);
			if (filter) {
				data.append("filter", filter.alt);
				data.append("size-left", filter.style.left);
				data.append("size-top", filter.style.top);
			}
			var myInit = { method: 'POST', body: data, credentials: 'same-origin' };
			fetch("home/add_photo", myInit)
				.then(function(response) {
					return response.json()
				}).then(function(json) {
					ul = document.getElementById('ul-photos');
					li = document.createElement('li');
					a = document.createElement('a');
					img = document.createElement('img');
					spanlike = document.createElement('span');
					spancomment = document.createElement('span');
					spanlike.style.color = '#4BB5C1';
					spancomment.style.color = '#4BB5C1';
					img.setAttribute('src', json.src);
					img.setAttribute('id', 'all');
					a.href = json.href;
					spanlike.innerHTML = json.like;
					spancomment.innerHTML = json.comment;
					li.appendChild(img);
					a.appendChild(li);
					a.appendChild(spanlike);
					a.appendChild(spancomment);
					ul.insertBefore(a, ul.firstChild);
				});
		}
	}

	startbutton.addEventListener('click', function(ev) {
		takepicture();
		ev.preventDefault();
	}, false);

	deletebutton.addEventListener('click', function(ev) {
		deletepicture();
		ev.preventDefault();
	}, false);

	publishbutton.addEventListener('click', function(ev) {
		publishphoto();
		ev.preventDefault();
	}, false);

	add_file.addEventListener('change', function() {
		var file = document.getElementById("add_file").files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			var ext = file.name.match(/\.([^\.]+)$/)[1];
			switch (ext) {
				case 'png':
				case 'jpeg':
				case 'gif':
					break;
				default:
					return;
			}
			photo = reader.result;
			photo.width = "404px";
			photo.height = "304px";
			canvas.style.backgroundImage = "url(" + photo + ")";
			canvas.style.backgroundRepeat = "no-repeat";
			canvas.style.backgroundSize = "404px 304px";
			canvas.style.border = "2px solid #f3558e";
			if (document.getElementById('filter'))
				document.getElementById("publishbutton").disabled = false;
			document.getElementById("deletebutton").disabled = false;
		}
			if (file)
				reader.readAsDataURL(file);
	}, true);
}

function add_filter(filter) {
	var img;
	if (img = document.getElementById('filter'))
	{
		if (img.src == filter.src)
		{
			img.parentNode.removeChild(img);
			img = false;
			document.getElementById("startbutton").disabled = true;
			document.getElementById("publishbutton").disabled = true;
			return;
		}
		else
		{
			img.parentNode.removeChild(img);
			img = false;
		}
	}
	img = document.createElement('img');
	img.setAttribute('src', filter.src);
	img.setAttribute('alt', filter.title);
	img.setAttribute('draggable', 'true');
	img.setAttribute('onclick', "move_filter(this)");
	img.id='filter';
	img.style.position = "absolute";
	img.style.top = '0px';
	img.style.left = '0px';
	if (document.getElementById('canvas').style.backgroundImage)
		document.getElementById("publishbutton").disabled = false;
	if (document.getElementById('video').getAttribute('width'))
		document.getElementById("startbutton").disabled = false;
	document.getElementById('camera').appendChild(img);
}

function mouseDown(e) {
	var filter = document.getElementById('filter');
	var cam = document.getElementById('camera');
	var left = cam.offsetLeft;
	var top = cam.offsetTop;
	filter.style.left = e.clientX - left - 202 + 'px';
	filter.style.top = e.clientY - top - 152 + 'px';
	filter.setAttribute('onclick', "mouseUp()");
}

function move_filter(filter) {
	filter.addEventListener('mousemove', mouseDown, true);
}

function mouseUp() {
	var filter = document.getElementById('filter');
	filter.removeEventListener('mousemove', mouseDown, true);
	filter.setAttribute('onclick', "move_filter(this)");
}

var incrementer = (function() {
		var i = 0;
		return function(j) {
			i++;
			return i + j;
		};
})();

var decrementer = (function() {
		var i = 0;
		return function(j) {
			i--;
			return i + j;
		};
})();

function load_next(i) {
	var data = new FormData();
	i = incrementer(i);
	data.append('i', i);
	var myInit = { method: 'POST', body: data, credentials: 'same-origin' };
	fetch("galery/load_next", myInit)
	.then(function(response) {
		return response.json()
	}).then(function(json) {
		if (json.nb_photos - json.nb_photos_page >= json.i) {
			for (i = 0; i < json.nb_photos_page; i++) {
				ul = document.getElementById('ul-all');
				if (ul.children.length > 2 && ul.children[1].tagName == 'LI')
					ul.removeChild(ul.children[1]);
			}
			for (i = json.i; i < json.i + json.nb_photos_page; i++) {
				if (photo = json.photos[i]) {
					ul = document.getElementById('ul-all');
					li = document.createElement('li');
					a = document.createElement('a');
					br = document.createElement('br');
					img = document.createElement('img');
					spanlike = document.createElement('span');
					spancomment = document.createElement('span');
					spanlike.style.color = '#4BB5C1';
					spancomment.style.color = '#4BB5C1';
					img.setAttribute('src', 'ressources/photos/' + photo.name + '.' + photo.extension);
					img.setAttribute('id', 'all');
					a.href = json.href + photo.id;
					spanlike.innerHTML = photo.like;
					spancomment.innerHTML = photo.comment;
					a.appendChild(img);
					a.appendChild(br);
					a.appendChild(spanlike);
					a.appendChild(spancomment);
					li.appendChild(a);
					x = ul.children.length;
					ul.insertBefore(li, ul.children[x - 1]);
					stop = json.i + json.nb_photos_page - 1;
				}
			}
			if (json.nb_photos - json.nb_photos_page == json.i)
				document.getElementById('next').style.color ="#f3558e";
		}
		else
			document.location.href="galery";
	});
}

function load_next_user(i) {
	var data = new FormData();
	i = incrementer(i);
	data.append('i', i);
	var myInit = { method: 'POST', body: data, credentials: 'same-origin' };
	fetch("galery/load_next_user", myInit)
	.then(function(response) {
		return response.json()
	}).then(function(json) {
		if (json.nb_photos - json.nb_photos_page >= json.i) {
			for (i = 0; i < json.nb_photos_page; i++) {
				ul = document.getElementById('ul-perso');
				if (ul.children.length > 2 && ul.children[1].tagName == 'LI')
					ul.removeChild(ul.children[1]);
			}
			for (i = json.i; i < json.i + json.nb_photos_page; i++) {
				if (photo = json.photos[i]) {
					ul = document.getElementById('ul-perso');
					li = document.createElement('li');
					a = document.createElement('a');
					br = document.createElement('br');
					img = document.createElement('img');
					spanlike = document.createElement('span');
					spancomment = document.createElement('span');
					spanlike.style.color = '#4BB5C1';
					spancomment.style.color = '#4BB5C1';
					img.setAttribute('src', 'ressources/photos/' + photo.name + '.' + photo.extension);
					img.setAttribute('id', 'all');
					a.href = json.href + photo.id;
					spanlike.innerHTML = photo.like;
					spancomment.innerHTML = photo.comment;
					a.appendChild(img);
					a.appendChild(br);
					a.appendChild(spanlike);
					a.appendChild(spancomment);
					li.appendChild(a);
					x = ul.children.length;
					ul.insertBefore(li, ul.children[x - 1]);
					stop = json.i + json.nb_photos_page - 1;
				}
			}
			if (json.nb_photos - json.nb_photos_page == json.i)
				document.getElementById('next_user').style.color ="#f3558e";
		}
		else
			document.location.href="galery";
	});
}

function load_back(i) {
	document.location.href="galery";
	/*var data = new FormData();
	document.getElementById('next').style.color ="#333c4a";
	i = decrementer(i);
	data.append('i', i);
	var myInit = { method: 'POST', body: data, credentials: 'same-origin' };
	fetch("galery/load_back", myInit)
	.then(function(response) {
		return response.json()
	}).then(function(json) {
		console.log('i==', i);
		console.log('json.i==', json.i);
		if (json.i >= 0) {
			for (y = 0; y < json.nb_photos_page; y++) {
				ul = document.getElementById('ul-all');
				if (ul.children.length > 2 && ul.children[1].tagName == 'LI')
					ul.removeChild(ul.children[1]);
			}
			for (i = json.i; i < json.i + json.nb_photos_page; i++) {
				if (photo = json.photos[i]) {
					ul = document.getElementById('ul-all');
					li = document.createElement('li');
					a = document.createElement('a');
					br = document.createElement('br');
					img = document.createElement('img');
					spanlike = document.createElement('span');
					spancomment = document.createElement('span');
					spanlike.style.color = '#4BB5C1';
					spancomment.style.color = '#4BB5C1';
					img.setAttribute('src', 'ressources/photos/' + photo.name + '.' + photo.extension);
					img.setAttribute('id', 'all');
					a.href = json.href + photo.id;
					spanlike.innerHTML = photo.like;
					spancomment.innerHTML = photo.comment;
					a.appendChild(img);
					a.appendChild(br);
					a.appendChild(spanlike);
					a.appendChild(spancomment);
					li.appendChild(a);
					x = ul.children.length;
					ul.insertBefore(li, ul.children[x - 1]);
				}
			}
		}
	});*/
}
