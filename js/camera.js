var canvas, context;
var star_img = new Image();
var img = new Image();
var isDraggable = false;
var isVideo = false;

var currentX = 0;
var currentY = 0;

window.onload = function() {
    document.getElementById('biba').addEventListener('click', start_camera);
    document.getElementById('file_up')
        .addEventListener('change', (e) => edit_photo(e.target.files));
    canvas = document.getElementById("canvas");
    context = canvas.getContext("2d");

    currentX = canvas.width/2;
    currentY = canvas.height/2;

    star_img.src = '/images/ricardo.png';
};

function start_camera() {
    var video = document.getElementById('video');
    if (navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream) {
        video.srcObject = stream;
        video.play();
    }))
    {
        isVideo = true;
    }
    _Go();
}

function edit_photo(img) {
    _Go();
}

function _Go() {
    _MouseEvents();
    if (isVideo) {
        setInterval(function () {
            _ResetCanvas();
            _DrawImage();
        }, 1000 / 60);
    }
    else
    {
        setInterval(function () {
            _ResetCanvas();
            context.fillRect(0, 0, 640, 480);
            context.drawImage(img, 0, 0, 640, 480);
            _DrawImage();
        }, 1000 / 60);
    }
}


function _ResetCanvas() {
    context.clearRect(0,0, canvas.width, canvas.height);
}
function _MouseEvents() {
    canvas.onmousedown = function(e) {

        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;


        if (mouseX >= (currentX - star_img.width/2) &&
            mouseX <= (currentX + star_img.width/2) &&
            mouseY >= (currentY - star_img.height/2) &&
            mouseY <= (currentY + star_img.height/2)) {
            isDraggable = true;
            currentX = mouseX;
            currentY = mouseY;
        }
    };
    canvas.onmousemove = function(e) {

        if (isDraggable) {
            currentX = e.pageX - this.offsetLeft;
            currentY = e.pageY - this.offsetTop;
        }
    };
    canvas.onmouseup = function(e) {
        isDraggable = false;
    };
    canvas.onmouseout = function(e) {
        isDraggable = false;
    };
}
function _DrawImage() {
    context.drawImage(star_img, currentX-(star_img.width/2), currentY-(star_img.height/2));
}

function readURL(input) {
    img = new Image;
    let file = document.querySelector('input[type=file]').files[0];
    let reader = new FileReader();
    reader.addEventListener('load', function () {
        img.src = reader.result;
    });
    if (file)
        reader.readAsDataURL(file);
}

function submit() {
    var form = document.getElementById('upload_form');
    var data = new FormData(form);
    var request = new XMLHttpRequest();
    request.open('POST', 'add/create');
    request.send();
    alert('BIBA');
}