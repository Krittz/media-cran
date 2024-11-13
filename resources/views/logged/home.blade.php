<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrAn | @yield('title', 'Início')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>


</head>

<body>

    @if($errors->any())
    @include('logged.components.notify')
    @endif

    @include('logged.components.sidebar')
    <div class="content">
        @include('logged.components.header')
        <main>
            <div class="header">
                <div class="left">
                    <h1>@yield('title-section', 'Home')</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">@yield('section-type', 'Index') /</a></li>
                        <li><a href="#" class="active">@yield('section-active', 'Index')</a></li>
                    </ul>
                </div>
                @if (!request()->routeIs('home'))
                <div class="report">
                    <form action="@yield('form_action')" method="POST" enctype="multipart/form-data" class="upload">
                        @csrf
                        <div class="upload-area">

                            @yield('input')
                            <label for="file">@yield('label_upload')</label>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>
                @endif
            </div>
            <div class="main-content">
                @if(request()->routeIs('home'))
                <ul class="insights">
                    <li>
                        <i class="ph ph-stack"></i>
                        <span class="info">
                            <h3>{{ $totalFiles }}</h3>
                            <p>Total Files</p>
                        </span>
                    </li>
                    <li>
                        <i class="ph ph-camera"></i>
                        <span class="info">
                            <h3>{{ $totalImages }}</h3>
                            <p>Images Uploaded</p>
                        </span>
                    </li>
                    <li>
                        <i class="ph ph-video-camera"></i>
                        <span class="info">
                            <h3>{{ $totalVideos }}</h3>
                            <p>Videos Uploaded</p>
                        </span>
                    </li>
                </ul>
                @endif
                @yield('content')

            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/nav.js') }}"></script>
    <script src="{{ asset('assets/js/upload.js') }}"></script>
    <script src="{{ asset('assets/js/table.js') }}"></script>
</body>

</html>