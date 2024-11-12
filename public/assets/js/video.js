const videoModal = document.querySelector('.video-modal');
const video = document.getElementById('video');
const playPauseBtn = document.getElementById('play-pause');
const volumeInput = document.getElementById('volume');
const volumeButton = document.getElementById('volume-icon');
const resizeButton = document.getElementById('resize');


video.addEventListener('dblclick', toggleFullscreen);
video.addEventListener('touchstart', toggleFullscreen);

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        video.requestFullscreen();
        resizeButton.innerHTML = '<i class="ph ph-corners-in"></i>';
    } else {
        document.exitFullscreen();
        resizeButton.innerHTML = '<i class="ph ph-corners-out"></i>';
    }
}


function openVideoModal(element) {
    const videoUrl = element.getAttribute('data-video-url');

    video.src = videoUrl;
    video.type = "video/mp4";
    videoModal.classList.add('active');
}



playPauseBtn.addEventListener('click', () => {
    if (video.paused) {
        video.play();
        playPauseBtn.innerHTML = '<i class="ph ph-pause"></i>';
    } else {
        video.pause();
        playPauseBtn.innerHTML = '<i class="ph ph-play"></i>';
    }
});

volumeButton.addEventListener('click', () => {
    if (video.volume > 0) {
        video.volume = 0;
        volumeInput.value = 0;
        volumeButton.innerHTML = '<i class="ph ph-speaker-simple-x"></i>';
    } else {
        video.volume = 1;
        volumeInput.value = 1;
        volumeButton.innerHTML = '<i class="ph ph-speaker-high"></i>';
    }
});

volumeInput.addEventListener('input', () => {
    video.volume = volumeInput.value;
    if (video.volume == 0) {
        volumeButton.innerHTML = '<i class="ph ph-speaker-simple-x"></i>';
    } else {
        volumeButton.innerHTML = '<i class="ph ph-speaker-high"></i>';
    }
});

resizeButton.addEventListener('click', () => {
    if (!document.fullscreenElement) {
        videoModal.requestFullscreen();
        resizeButton.innerHTML = '<i class="ph ph-corners-in"></i>'
    } else {
        document.exitFullscreen();
        resizeButton.innerHTML = '<i class="ph ph-corners-out"></i>';
    }
});

document.addEventListener('fullscreenchange', () => {
    if (!document.fullscreenElement) {
        resizeButton.innerHTML = '<i class="ph ph-corners-out"></i>';
    }
});





const currentTimeDisplay = document.getElementById('current-time');
const totalDurationDisplay = document.getElementById('total-duration');

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
}

video.addEventListener('loadedmetadata', () => {
    totalDurationDisplay.textContent = formatTime(video.duration);
});

video.addEventListener('timeupdate', () => {
    currentTimeDisplay.textContent = formatTime(video.currentTime);
});

const modalCloseButton = document.querySelector('.modal-close');

modalCloseButton.addEventListener('click', () => {
    videoModal.classList.remove('active');
    video.pause();
    video.src = '';
    video.load();
});
