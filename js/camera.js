var canvas, context;
var img = new Image();
var imgs;
var isDraggable = false;
var isVideo = false;
var stickers = [];

window.onload = function() {
    document.getElementById('biba').addEventListener('click', start_camera);
    canvas = document.getElementById("canvas");
    context = canvas.getContext("2d");
    imgs = document.getElementsByTagName('img');
    for (i = 1; i < imgs.length; i++)
    {
        imgs[i].onclick = img_list(imgs[i].currentSrc);
    }
    document.getElementById('file_up')
        .addEventListener('change', (e) => edit_photo(stickers));
};

function img_list(path) {
    return function() {
        sticker = Object.create(null);
        sticker.X = 320;
        sticker.Y = 240;
        sticker.star_img = new Image();
        sticker.star_img.src = path;
        stickers.push(sticker);
    }
}

function start_camera() {
    var video = document.getElementById('video');
    if (navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream) {
        video.srcObject = stream;
        video.play();
    }))
    {
        isVideo = true;
    }
    _Go(stickers);
}

function edit_photo(stickers) {
    _Go(stickers);
}

function _Go(stickers) {
    _MouseEvents(stickers);
    if (isVideo) {
        setInterval(function () {
            _ResetCanvas();
            _DrawImage(stickers);
        }, 1000 / 60);
    }
    else
    {
        setInterval(function () {
            _ResetCanvas();
            context.fillRect(0, 0, 640, 480);
            context.drawImage(img, 0, 0, 640, 480);
            _DrawImage(stickers);
        }, 1000 / 60);
    }
}


function _ResetCanvas() {
    context.clearRect(0,0, canvas.width, canvas.height);
}
function _MouseEvents(stickers) {
    sticker = stickers[stickers.length - 1];
    canvas.onmousedown = function(e) {

        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;


        if (mouseX >= (sticker.X - sticker.star_img.width/2) &&
            mouseX <= (sticker.X + sticker.star_img.width/2) &&
            mouseY >= (sticker.Y - sticker.star_img.height/2) &&
            mouseY <= (sticker.Y + sticker.star_img.height/2)) {
            isDraggable = true;
            sticker.X = mouseX;
            sticker.Y = mouseY;
        }
    };
    canvas.onmousemove = function(e) {

        if (isDraggable) {
            sticker.X = e.pageX - this.offsetLeft;
            sticker.Y = e.pageY - this.offsetTop;
        }
    };
    canvas.onmouseup = function(e) {
        isDraggable = false;
    };
    canvas.onmouseout = function(e) {
        isDraggable = false;
    };
}
function _DrawImage(stickers) {
    stickers.forEach(function (sticker) {
        context.drawImage(sticker.star_img, sticker.X-(sticker.star_img.width/2), sticker.Y-(sticker.star_img.height/2));
    });
}

function readURL(input) {
    let imgs = document.getElementsByTagName('img');
    for (i = 0; i < imgs.length; i++)
    {
        imgs[i].style.display = 'inline-flex';
    }
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
    // var form = document.getElementById('upload_form');
    // var data = new FormData(form);
    // data.append('description', 'bibo');
    document.getElementById('submit').click();
}

function delete_sticker() {
    stickers.pop();
    _MouseEvents(stickers);
}