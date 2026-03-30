<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash - SoleSearch</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700" rel="stylesheet" />
    @vite([
        'resources/css/app.css',
        'resources/css/dashboard.css',
        'resources/css/trash.css',
    ])
</head>
<body>

    @include('components.navbar')

    <div class="trash-page">

        {{-- Back Button --}}
        <a href="{{ route('admin.shoes.index') }}" class="trash-back-btn">← Back to Dashboard</a>

        <h1 class="trash-title">🗑 Trash</h1>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Empty State --}}
        @if($shoes->isEmpty())
            <p class="trash-empty">Trash is empty.</p>

        {{-- Trash Grid --}}
        @else
            <div class="trash-grid">
                @foreach($shoes as $shoe)
                    <div class="trash-card">

                        {{-- Shoe Image --}}
                        @if(!empty($shoe->image_url) && count($shoe->image_url) > 0)
                            <img
                                src="{{ $shoe->image_url[0] }}"
                                alt="{{ $shoe->shoe_name }}"
                                class="trash-card-img"
                            />
                        @else
                            <div class="trash-card-img-placeholder">No Image</div>
                        @endif

                        {{-- Info --}}
                        <div class="trash-card-body">
                            <h3 class="trash-card-name">{{ $shoe->shoe_name }}</h3>
                            <p class="trash-card-brand">{{ $shoe->brand }}</p>
                            <p class="trash-card-price">P{{ number_format($shoe->price, 2) }}</p>
                        </div>

                        {{-- Actions --}}
                        <div class="trash-card-actions">

                            {{-- Restore --}}
                            <form action="{{ route('admin.shoes.restore', $shoe->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-restore">↩ Restore</button>
                            </form>

                            {{-- Permanent Delete --}}
                            <form
                                action="{{ route('admin.shoes.destroy', $shoe->id) }}"
                                method="POST"
                                id="deleteForm-{{ $shoe->id }}"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="button"
                                    class="btn-permanent-delete"
                                    onclick="showConfirm({
                                        icon: '🗑',
                                        title: 'Delete Permanently?',
                                        message: 'This cannot be undone. The shoe and its images will be removed forever.',
                                        okLabel: 'Delete',
                                        onConfirm: () => document.getElementById('deleteForm-{{ $shoe->id }}').submit()
                                    })"
                                >🗑 Delete Permanently</button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    @include('components.confirm-modal')
</body>
</html>
