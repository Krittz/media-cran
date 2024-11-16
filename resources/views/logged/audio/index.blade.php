@extends('logged.home')
@section('title', 'Audios')
@section('content')

@section('title-section', 'Audio')
@section('section-type', 'Audios')
@section('section-active', 'All')

@section('form_action')
{{ route('upload.audio') }}
@endsection

@section('input')
<input type="file" name="audio_upload" id="file" accept="audio/mpeg, audio/wav, audio/ogg, audio/x-wav, audio/x-mpeg, audio/x-mpeg-3, audio/x-mpeg-2, audio/x-mpeg-part, audio/x-pn-realaudio, audio/x-pn-realaudio-plugin, audio/x-pn-realaudio-sample, audio/x-scpls, audio/mp4, audio/x-m4a">
@endsection


@section('label_upload')
Upload audio
@endsection



<div class="wrapper">
    <div class="all-data">
        <div class="orders">
            <div class="header">
                <div class="header-left">
                    <i class="ph ph-vinyl-record"></i>
                    <h3>Audios</h3>
                </div>
                <div class="header-right">
                    <form action="{{route('audio')}}" method="GET">
                        <input type="search" name="search" id="search_audio" placeholder="Search audio">
                        <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
                    </form>
                    <i class="ph ph-funnel"></i>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th><i class="ph ph-funnel-simple"></i></th>
                        <th>Audio</th>
                        <th>
                            <a href="{{ route('audio', ['sort' => 'filename', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Name
                                @if($sortField === 'filename')
                                <i class="ph {{ $sortDirection === 'asc' ? 'ph-caret-up' : 'ph-caret-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('audio', ['sort' => 'created_at', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Uploaded
                                @if($sortField === 'created_at')
                                <i class="ph {{ $sortDirection === 'asc' ? 'ph-caret-up' : 'ph-caret-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('audio', ['sort' => 'file_size', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Size
                                @if($sortField === 'file_size')
                                <i class="ph {{ $sortDirection === 'asc' ? 'ph-caret-up' : 'ph-caret-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($audios as $audio)
                    <tr>
                        <td class="item-actions">
                            <i class="ph ph-dots-three-vertical"></i>
                            <div class="item-options">
                                <a href="#"><i class="ph ph-stack-plus"></i>Add Playlist</a>
                                <a href="#"><i class="ph ph-download-simple"></i> Download</a>
                                <a href="#"><i class="ph"></i> Delete</a>
                            </div>
                        </td>
                        <td class="media-view">
                            <i class="ph ph-music-notes-simple"></i>
                            <span data-audio-url="{{ route('audios.show', $audio->id) }}"
                                onclick="openAudioModal(this)"><i class="ph ph-play"></i></span>
                        </td>
                        <td>
                            <p>{{ $audio->filename }}</p>
                        </td>
                        <td>{{\Carbon\Carbon::parse($audio->created_at)->format('d-m-Y H:i') }}</td>
                        <td>
                            <p>
                                @php
                                $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                $bytes = $audio->file_size;
                                $unitIndex = 0;

                                while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
                                    $bytes /=1024;
                                    $unitIndex++;
                                    }

                                    echo round($bytes, 2) . ' ' . $units[$unitIndex];
                                    @endphp
                                    </p>
                        </td>
                        <td>
                            <p>{{ $audio->file_type }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        @if($audios->hasPages())
                        <div class="pagination">


                            {{-- Pagination Elements --}}

                            @foreach($audios->getUrlRange(1, $audios->lastPage()) as $page => $url)
                            @if($page == $audios->currentPage())
                            <span class="pagination-item active">{{ $page }}</span>
                            @else
                            <a href="{{ $audios->appends(request()->except('page'))->url($page) }}" class="pagination-item"> {{ $page }} </a>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<div class="audio-modal" id="audio-modal">
    <div class="audio-player">
        <span class="modal-close" onclick="closeAudioModal()"><i class="ph ph-x-square"></i></span>

        <div class="custom-player">
            <audio id="audio-player">
                <source src="" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>

            <div class="player-controls">
                <button id="prevBtn" class="control-btn"><i class="ph ph-rewind"></i></button>
                <button id="playBtn" class="control-btn"><i class="ph ph-play"></i></button>
                <button id="nextBtn" class="control-btn"><i class="ph ph-fast-forward"></i></button>
                <div class="volume-control">
                    <button id="muteBtn" class="control-btn"><i class="ph ph-speaker-high"></i></button>
                    <input type="range" class="volume-slider" min="0" max="100" value="100">
                </div>
            </div>

            <div class="progress-container">
                <div class="progress-bar" id="progressBar">
                    <div class="progress" id="progress"></div>
                </div>
                <div class="time-labels">
                    <span id="currentTime">0:00</span>
                    <span id="duration">0:00</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .audio-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 3001;
        backdrop-filter: blur(10px);
    }

    .audio-player {
        background: var(--background-color);
        border-radius: 7px;
        padding: 20px;
        width: 400px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 1.5em;
        color: #666;
    }

    .custom-player {
        padding: 20px;
    }

    .player-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .control-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: var(--transition);
    }

    .control-btn:hover {
        background-color: var(--background-color);
    }

    .control-btn i {
        font-size: 1.2em;
        color: var(--primary-color);
    }

    .volume-control {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-left: 15px;
    }

    .volume-slider {
        width: 80px;
        height: 5px;
        -webkit-appearance: none;
        background: var(--primary-color);
        border-radius: 5px;
        outline: none;
    }

    .volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 12px;
        height: 12px;
        background: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
    }

    .progress-container {
        width: 100%;
    }

    .progress-bar {
        width: 100%;
        height: 5px;
        background: var(--text-color);
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 8px;
        overflow: hidden;
    }

    .progress {
        width: 0%;
        height: 100%;
        background: var(--primary-color);
        border-radius: 5px;
        transition: width 0.1s linear;
    }

    .time-labels {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: var(--text-color);
    }

    .show {
        display: flex !important;
    }
</style>

<script>
    function openAudioModal(element) {
        const modal = document.getElementById('audio-modal');
        const audioPlayer = document.getElementById('audio-player');
        const source = audioPlayer.querySelector('source');
        const playBtn = document.getElementById('playBtn');

        modal.style.display = 'flex';
        modal.classList.add('show');
        source.src = element.getAttribute('data-audio-url');
        source.type = "audio/mpeg";
        audioPlayer.load();

        initializeAudioPlayer();
    }

    function closeAudioModal() {
        const modal = document.getElementById('audio-modal');
        const audioPlayer = document.getElementById('audio-player');

        audioPlayer.pause();
        modal.style.display = 'none';
        modal.classList.remove('show');
    }

    function initializeAudioPlayer() {
        const audio = document.getElementById('audio-player');
        const playBtn = document.getElementById('playBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const muteBtn = document.getElementById('muteBtn');
        const progressBar = document.getElementById('progressBar');
        const progress = document.getElementById('progress');
        const currentTimeEl = document.getElementById('currentTime');
        const durationEl = document.getElementById('duration');
        const volumeSlider = document.querySelector('.volume-slider');

        // Play/Pause
        playBtn.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                playBtn.innerHTML = '<i class="ph ph-pause"></i>';
            } else {
                audio.pause();
                playBtn.innerHTML = '<i class="ph ph-play"></i>';
            }
        });

        // Update progress bar
        audio.addEventListener('timeupdate', () => {
            const progressPercent = (audio.currentTime / audio.duration) * 100;
            progress.style.width = `${progressPercent}%`;

            const minutes = Math.floor(audio.currentTime / 60);
            const seconds = Math.floor(audio.currentTime % 60);
            currentTimeEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        });

        // Update duration
        audio.addEventListener('loadedmetadata', () => {
            const minutes = Math.floor(audio.duration / 60);
            const seconds = Math.floor(audio.duration % 60);
            durationEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        });

        // Click on progress bar
        progressBar.addEventListener('click', (e) => {
            const width = progressBar.clientWidth;
            const clickX = e.offsetX;
            const duration = audio.duration;

            audio.currentTime = (clickX / width) * duration;
        });

        // Volume control
        volumeSlider.addEventListener('input', (e) => {
            const volume = e.target.value / 100;
            audio.volume = volume;
            muteBtn.innerHTML = volume === 0 ?
                '<i class="ph ph-speaker-none"></i>' :
                '<i class="ph ph-speaker-high"></i>';
        });

        // Mute button
        muteBtn.addEventListener('click', () => {
            if (audio.volume > 0) {
                audio.volume = 0;
                volumeSlider.value = 0;
                muteBtn.innerHTML = '<i class="ph ph-speaker-none"></i>';
            } else {
                audio.volume = 1;
                volumeSlider.value = 100;
                muteBtn.innerHTML = '<i class="ph ph-speaker-high"></i>';
            }
        });

        // Previous and Next buttons (reset/end)
        prevBtn.addEventListener('click', () => {
            audio.currentTime = 0;
        });

        nextBtn.addEventListener('click', () => {
            audio.currentTime = audio.duration;
        });
    }
</script>
@endsection