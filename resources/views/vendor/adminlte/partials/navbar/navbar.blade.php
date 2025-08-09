@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav
    class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')


        {{-- User menu personnalisé --}}
        @if (Auth::user())
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    @if (Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="user-image img-circle elevation-2"
                            alt="Photo de profil">
                    @else
                        {{-- Image par défaut si pas de photo --}}
                        <img src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"
                            class="user-image img-circle elevation-2" alt="Photo par défaut">
                    @endif
                    <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Invité' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="user-header bg-primary">
                        @if (Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="img-circle elevation-2"
                                alt="Photo de profil">
                        @else
                            <img src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"
                                class="img-circle elevation-2" alt="Photo par défaut">
                        @endif
                        <p>
                            {{ Auth::user()->name ?? '' }}
                            <small>Membre depuis
                                {{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : '' }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profil</a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn btn-default btn-flat float-right">Déconnexion</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        @endif



        {{-- Right sidebar toggler link --}}
        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
