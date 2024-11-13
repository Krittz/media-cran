<div class="sidebar close" id="sidebar">
    <a href="#" class="logo">
        <img src="{{asset('assets/img/c-logo.svg')}}" alt="Logo" width="40px" height="40px">

    </a>

    <ul class="side-menu">
        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}">
                <i class="ph ph-house-simple"></i>
                Home
            </a>
        </li>
        <li class="{{ request()->routeIs('image') ? 'active' : '' }}">
            <a href="{{ route('image') }}">
                <i class="ph ph-camera"></i>
                Image
            </a>
        </li>
        <li class=" {{ request()->routeIs('album') ? 'active' : '' }}">
            <a href="{{ route('album') }}">
                <i class="ph ph-images"></i>
                Album
            </a>
        </li>
        <li class="{{ request()->routeIs('video') ? 'active' : '' }}">
            <a href="{{ route('video') }}">
                <i class="ph ph-video-camera"></i>
                Video
            </a>
        </li>
        <li class="{{ request()->routeIs('collection') ? 'active' : '' }}">
            <a href="{{ route('collection') }}">
                <i class="ph ph-film-strip"></i>
                Collection
            </a>
        </li>
    </ul>
    <form action="{{ route('logout') }}" method="POST" class="logout">
        @csrf
        <button type="submit"><i class="ph ph-power"></i></button>
    </form>
</div>