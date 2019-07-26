var player = videojs('video');
var viewLogged = false;

// Chi bat dau chay khi ngta play video
player.on('timeupdate', function () {
    //console.log(player.currentTime(), player.duration());

    var percentagePlayed = Math.ceil(player.currentTime() / player.duration() * 100);

    //console.log(percentagePlayed);

    if (percentagePlayed > 10 && !viewLogged) {
        viewLogged = true; // Để việc increment lượt views 1 lần thôi
        axios.put('/videos/' + window.CURRENT_VIDEO_ID)
            .then(res => console.log(res.data))
            .catch(err => console.log(err.response.data));
    }
});
