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
                <i class="ph ph-images"></i>
                Image
            </a>
        </li>
        <li class="{{ request()->routeIs('video') ? 'active' : '' }}">
            <a href="{{ route('video') }}">
                <i class="ph ph-film-reel"></i>
                Video
            </a>
        </li>
    </ul>
    <form action="{{ route('logout') }}" method="POST" class="logout">
        @csrf
        <button type="submit"><i class="ph ph-power"></i></button>
    </form>
</div>