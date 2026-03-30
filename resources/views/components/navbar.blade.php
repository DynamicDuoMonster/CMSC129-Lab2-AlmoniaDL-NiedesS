<nav class="nav">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="nav__logo">SoleSearch</a>

    <!-- Search -->
    <div class="nav__search-wrap">
        <svg class="nav__search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="navSearchInput" placeholder="Search shoes..." class="nav__search-input">
    </div>

    <!-- Category Pills -->
    <div class="nav__pills">
        @foreach(\App\Models\Category::all() as $cat)
            <a href="{{ route('admin.shoes.index', ['category_id' => $cat->id]) }}" 
            class="nav__pill {{ request('category_id') == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach

        <a href="{{ route('admin.shoes.index', ['gender' => 'Mens']) }}" 
        class="nav__pill {{ request('gender') == 'Mens' ? 'active' : '' }}">Mens</a>
        
        <a href="{{ route('admin.shoes.index', ['gender' => 'Womens']) }}" 
        class="nav__pill {{ request('gender') == 'Womens' ? 'active' : '' }}">Womens</a>
    </div>

    <!-- Auth -->
    <div class="nav__auth">
        @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('layouts.index') }}" class="nav_link">Dashboard</a>
            @else
            <span class="nav_username">{{ auth()->user()->username }}</span>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav_link nav_logout-btn">Log out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="nav_link">Log in</a>
            @endauth
    </div>

</nav>

