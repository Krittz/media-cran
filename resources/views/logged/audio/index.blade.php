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
                            <audio>
                                <source src="{{ route('audios.show', $audio->id) }}" type="{{ $audio->file_type}} ">
                                Your browser does not support the audio tag.
                            </audio>
                            <i class="ph ph-vinyl-record"></i>
                            <span onclick="openAudioModal(this)" data-audio-url="{{ route('audios.show', $audio->id) }}"><i class="ph ph-play"></i></span>
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

@endsection