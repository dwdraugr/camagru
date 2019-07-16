window.onload = function () {
    var video = document.getElementById('video');
    if (navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream) {
        video.srcObject = stream;
        video.play();
    }));
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var video = document.getElementById('video');
    document.getElementById("snap").addEventListener('click', function () {
        context.drawImage(video, 0, 0, 640, 480);
    })
    document.getElementById('biba').addEventListener('click', function () {
        var dataURL = context.toDataURL;
        var formData = new FromData();
        formData.append('image_upload', dataURL);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/add/create', false);
        xhr.setRequestHeader('Content-Type', false)
        xhr.send(dataURL);
    })
};

