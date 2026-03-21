<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SoleSearch</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700" rel="stylesheet" />
    @vite(['resources/css/dashboard.css', 'resources/css/app.css'])
</head>
<body>

    @include('components.navbar')

    <div class="admin-dashboard">

        {{-- Header --}}
        <div class="dashboard-header">
            <h2>All Products</h2>
            <div class="header-actions">
                <a href='#' class="trash-btn">🗑 Trash</a>
                <a href="#" class="add-btn">+ Add Shoe</a>
                <form method="POST" action="#" style="display:inline;">
                    @csrf
                </form>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Shoes Grid --}}
        <div class="shoes">
            @forelse($shoes as $shoe)
                <div class="shoe-card-admin">
                    {{-- Images --}}
                    <div class="shoe-images">
                        @if(!empty($shoe->image_url[0]))
                            <img src="{{ asset('storage/' . $shoe->image_url[0]) }}" alt="{{ $shoe->shoe_name }}" class="shoe-img" />
                        @else
                            <div class="shoe-img-placeholder">No Image</div>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="shoe-info">
                        <h3>{{ $shoe->shoe_name }}</h3>
                        <p class="shoe-brand">{{ $shoe->brand }}</p>
                        <p class="shoe-price">${{ number_format($shoe->price, 2) }}</p>
                        <p class="shoe-meta">{{ $shoe->category }} · {{ $shoe->gender }}</p>
                        <p class="shoe-colors">
                            @foreach($shoe->color as $c)
                                <span class="color-tag">{{ $c }}</span>
                            @endforeach
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="admin-actions">
                        <a href="{{ route('admin.shoes.edit', $shoe->id) }}" class="btn-edit">Edit</a>

                        <form method="POST" action="{{ route('admin.shoes.softDelete', $shoe->id) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-delete"
                                onclick="return confirm('Move this shoe to trash?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="empty-msg">No shoes found.</p>
            @endforelse
        </div>

    </div>

</body>
</html>
