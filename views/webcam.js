function WebCam() {
	var streaming = false,
		video = document.querySelector('#video'),
		cover = document.querySelector('#cover'),
		canvas = document.querySelector('#canvas'),
		startbutton = document.querySelector('#startbutton'),
		width = 400,
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
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	function takepicture() {
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		photo = canvas.toDataURL('image/png');
	}

	function deletepicture() {
		var canvas = document.getElementById("canvas");
		var ctx = canvas.getContext("2d");
		photo = false;
		ctx.clearRect(0, 0, canvas.width, canvas.height);
	}

	function publishphoto() {
		var data = new FormData();
		data.append("img", photo);
		var myInit = {method: 'POST', body: data, credentials: 'same-origin'};
		fetch("home/add_photo", myInit);
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
}
