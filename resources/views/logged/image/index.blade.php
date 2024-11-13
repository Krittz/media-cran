@extends('logged.home')
@section('title', 'Images')
@section('content')

@section('title-section', 'Image')
@section('section-type', 'Images')
@section('section-active', 'All')

@section('form_action')
{{ route('upload.image') }}
@endsection
@section('input')
<input type="file" name="image_upload" id="file" accept="image/png,image/jpeg,image/jpg,image/gif,image/bitmap" />
@endsection

@section('label_upload')
Upload Image
@endsection

<div class="wrapper">
    <div class="all-data">
        <div class="orders">
            <div class="header">
                <div class="header-left">
                    <i class="ph ph-camera"></i>
                    <h3>Images</h3>
                </div>
                <div class="header-right">
                    <form action="{{route('image')}}" method="GET">
                        <input type="search" name="search" id="search_image" placeholder="Search image">
                        <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
                    </form>
                    <i class="ph ph-funnel"></i>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th><i class="ph ph-funnel-simple"></i></th>
                        <th>Image</th>
                        <th>
                            <a href="{{ route('image', ['sort' => 'filename', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Name
                                @if($sortField === 'filename')
                                <i class="ph {{ $sortDirection === 'asc' ? 'ph-caret-up' : 'ph-caret-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('image', ['sort' => 'created_at', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Uploaded
                                @if($sortField === 'created_at')
                                <i class="ph {{ $sortDirection === 'asc' ? 'ph-caret-up' : 'ph-caret-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('image', ['sort' => 'file_size', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
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
                    @foreach($images as $image)
                    <tr>
                        <td class="item-actions">
                            <i class="ph ph-dots-three-vertical"></i>
                            <div class="item-options">
                                <a href="#" onclick="openAlbum(this)"><i class="ph ph-stack-plus"></i>Add Album</a>
                                <a href="#"><i class="ph ph-download-simple"></i> Download</a>
                                <a href="#"><i class="ph ph-trash"></i> Delete</a>
                            </div>
                        </td>
                        <td class="media-view">
                            <img src="{{ route('images.show', $image->id) }}" alt="{{ $image->filename }}" loading="lazy">
                            <span
                                data-image-url="{{ route('images.show', $image->id) }}"
                                onclick="openModal(this)"><i class="ph ph-eye"></i></span>
                        </td>
                        <td>
                            <p>{{ $image->filename }}</p>
                        </td>
                        <td>{{\Carbon\Carbon::parse($image->created_at)->format('d-m-Y H:i') }}</td>
                        <td>
                            <p>
                                @php
                                $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                $bytes = $image->file_size;
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
                            <p>{{$image->file_type}}</p>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Exibir a paginação, se houver -->
    @if ($images->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($images->onFirstPage())
        <span class="pagination-item disabled">&laquo;</span>
        @else
        <a href="{{ $images->appends(request()->except('page'))->previousPageUrl() }}" class="pagination-item">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($images->getUrlRange(1, $images->lastPage()) as $page => $url)
        @if ($page == $images->currentPage())
        <span class="pagination-item active">{{ $page }}</span>
        @else
        <a href="{{ $images->appends(request()->except('page'))->url($page) }}" class="pagination-item">{{ $page }}</a>
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($images->hasMorePages())
        <a href="{{ $images->appends(request()->except('page'))->nextPageUrl() }}" class="pagination-item">&raquo;</a>
        @else
        <span class="pagination-item disabled">&raquo;</span>
        @endif
    </div>
    @endif
</div>

<div id="modal" class="modal">
    <span class="close-modal" onclick="closeModal()"><i class="ph ph-x-square"></i></span>
    <img id="modal-image" src="" alt="Modal Image">
    <div id="caption" class="caption"></div>
</div>
<div class="album-modal" id="modalPlaylists">
    <i class="ph ph-x-square" onclick="closeAlbumList()"></i>
    @include('logged.components.playlists')
</div>

<script>
    function openModal(element) {

        const modal = document.getElementById('modal');
        const modalImg = document.getElementById('modal-image');
        modal.style.display = 'flex';
        modal.classList.add('show');
        modalImg.src = element.getAttribute('data-image-url');;
        modalImg.alt = element.getAttribute('alt');

    }

    function openAlbum(element) {
        const modal = document.getElementById('modalPlaylists');
        modal.classList.add('show');
    }

    function closeModal() {
        const modal = document.getElementById('modal');
        modal.classList.remove('show');
        modal.style.display = 'none';
    }

    function closeAlbumList() {
        const modal = document.getElementById('modalPlaylists');
        modal.classList.remove('show');
        
    }
</script>

@endsection