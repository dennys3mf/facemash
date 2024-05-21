let watchTime = 0;
let video = document.getElementById('video'); // Suponiendo que el elemento video tiene este id

if (video) {
    video.addEventListener('timeupdate', function() {
        watchTime = Math.floor(video.currentTime);
    });

    window.addEventListener('beforeunload', function() {
        // Enviar el tiempo de visualización al servidor antes de que la página se cierre
        fetch('/save_watch_time.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: USER_ID, content_id: CONTENT_ID, watch_time: watchTime })
        });
    });
} else {
    // Para fotos, el tiempo de visualización es 0
    window.addEventListener('beforeunload', function() {
        fetch('/save_watch_time.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: USER_ID, content_id: CONTENT_ID, watch_time: 0 })
        });
    });
}
