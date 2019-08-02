var canvas, context;
var img = new Image();
var imgs;
var isDraggable = false;
var isVideo = false;
var stickers = [];
var source = 0;

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
    let imgs = document.getElementsByTagName('img');
    for (i = 0; i < imgs.length; i++)
    {
        imgs[i].style.display = 'inline-flex';
    }
    document.getElementById('file_up').style.display = 'none';
    _Go(stickers);
    document.getElementById('bsubmit').style.display = 'block';
    document.getElementById('biba').style.display = 'none';
    document.getElementById('del_stick').style.display = 'block';
    source = 1;
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
    document.getElementById('biba').style.display = 'none';
    document.getElementById('bsubmit').style.display = 'block';
    document.getElementById('file_up').style.display = 'none';
    document.getElementById('del_stick').style.display = 'block';
    source = 2;
}

function submit() {
    let form = document.getElementById('description');
    for (i = 0; i < stickers.length; i++)
    {
        let input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('form', 'upload_form');
        input.setAttribute('name', 'sticker' + i);
        input.style.display = 'none';
        let str = stickers[i].star_img.src.split('/')
        input.setAttribute('value', str[4] + ';' + stickers[i].X + ';' + stickers[i].Y);
        form.appendChild(input);
    }
    if (source === 2)
        document.getElementById('submit').click();
    else if (source === 1)
    {
        document.getElementById('upload_form').setAttribute('action', '/add/create_base/')
        base = video_to_base64();
        let binput = document.createElement('input');
        binput.setAttribute('type', 'text');
        binput.setAttribute('form', 'upload_form');
        binput.setAttribute('name', 'base_img');
        binput.style.display = 'none';
        binput.setAttribute('value', base);
        form.appendChild(binput);
        document.getElementById('submit').click();
    }
    else alert('Please, create post');
}

function delete_sticker() {
    stickers.pop();
    _MouseEvents(stickers);
}

function video_to_base64()
{
    hcanvas = document.getElementById('hide_canv');
    hcanvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
    base = hcanvas.toDataURL();
    console.log(base);
    return base;
}