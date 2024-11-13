@extends('logged.home')
@section('title', 'Videos')
@section('content')
@section('title-section', 'Video')
@section('section-type', 'Videos')
@section('section-active', 'All')

@section('form_action')
{{ route('upload.video') }}
@endsection

@section('input')
<input type="file" name="video_upload" id="file" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv" />
@endsection

@section('label_upload')
Upload Video
@endsection

<div class="wrapper">
    <div class="all-data">
        <div class="orders">
            <div class="header">
                <div class="header-left">
                    <i class="ph ph-video-camera"></i>
                    <h3>Videos</h3>
                </div>
                <div class="header-right">
                    <form action="{{route('video')}}" method="GET">
                        <input type="search" name="search" id="search_video" placeholder="Search video">
                        <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
                    </form>
                    <i class="ph ph-funnel"></i>
                </div>

            </div>
            <table>
                <thead>
                    <tr>
                        <th><i class="ph ph-funnel-simple"></i></th>
                        <th>Video</th>
                        <th>
                            <a href="{{ route('video', ['sort' => 'filename', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Name
                                @if($sortField === 'filename')
                                <i class="ph {{ $sortDirection === 'asc' ? 'ph-caret-up' : 'ph-caret-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('video', ['sort' => 'created_at', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Uploaded
                                @if($sortField === 'created_at')
                                <i class="ph {{ $sortDirection === 'asc' ? 'ph-caret-up' : 'ph-caret-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('video', ['sort' => 'file_size', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
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
                    @foreach($videos as $video)
                    <tr>
                        <td class="item-actions">
                            <i class="ph ph-dots-three-vertical"></i>
                            <div class="item-options">
                                <a href="#"><i class="ph ph-download-simple"></i> Download</a>
                                <a href="#"><i class="ph ph-trash"></i> Delete</a>
                            </div>
                        </td>
                        <td class="media-view">
                            <video class="gallery-video" preload="metadata">
                                <source src="{{ route('videos.show', $video->id) }}" type="{{ $video->file_type }}">
                                Your browser does not support the video tag.
                            </video>
                            <span data-video-url="{{ route('videos.show', $video->id) }}"
                                onclick="openVideoModal(this)"><i class="ph ph-play"></i></span>
                        </td>
                        <td>
                            <p>{{ $video->filename }}</p>
                        </td>
                        <td>{{\Carbon\Carbon::parse($video->created_at)->format('d-m-Y H:i') }}</td>

                        <td>
                            <p>
                                @php
                                $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                $bytes = $video->file_size;
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
                            <p>{{ $video->file_type }}</p>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($videos->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($videos->onFirstPage())
        <span class="pagination-item disabled">&laquo;</span>
        @else
        <a href="{{ $videos->appends(request()->except('page'))->previousPageUrl() }}" class="pagination-item">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($videos->getUrlRange(1, $videos->lastPage()) as $page => $url)
        @if ($page == $videos->currentPage())
        <span class="pagination-item active">{{ $page }}</span>
        @else
        <a href="{{ $videos->appends(request()->except('page'))->url($page) }}" class="pagination-item">{{ $page }}</a>
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($videos->hasMorePages())
        <a href="{{ $videos->appends(request()->except('page'))->nextPageUrl() }}" class="pagination-item">&raquo;</a>
        @else
        <span class="pagination-item disabled">&raquo;</span>
        @endif
    </div>
    @endif
</div>


<div class="video-modal">
    <div class="video-player">
        <span class="modal-close"><i class="ph ph-x-square"></i></span>
        <video id="video">
            <source src="" type="">
            Your browser does not support the video tag.
        </video>
        <div class="controls">
            <div class="controls-left">
                <button id="play-pause"><i class="ph ph-play"></i></button>
                <div class="volume-control">
                    <button id="volume-icon"><i class="ph ph-speaker-high"></i></button>
                    <input type="range" id="volume" min="0" max="1" step="0.01" value="1">
                </div>
            </div>
            <div class="controls-right">
                <i class="ph ph-timer"></i>
                <span id="current-time"> 00:00</span><i class="ph ph-line-vertical"></i><span id="total-duration">00:00</span>
                <button id="resize"><i class="ph ph-corners-out"></i></button>
                <!-- Minute area destination -->


            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/js/video.js') }}"></script>


@endsection