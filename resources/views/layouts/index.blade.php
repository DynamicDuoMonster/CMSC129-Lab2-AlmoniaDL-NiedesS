<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SoleSearch</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,700" rel="stylesheet" />

    @vite([
        'resources/css/app.css',
        'resources/css/dashboard.css',
        'resources/css/components/shoe-detail-card.css'
    ])

    <style>
        .shoes {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            padding: 20px 0;
        }

        @media (max-width: 1100px) {
            .shoes { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 600px) {
            .shoes { grid-template-columns: 1fr; }
        }

        .shoe-card-container {
            width: 100%;
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #2ecc71;
            margin-bottom: 20px;
        }

        /* ── Pagination ── */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            padding: 32px 0 24px;
        }

        .pagination-wrap a,
        .pagination-wrap span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            transition: all 0.15s;
            border: 1px solid #2a2a2a;
            color: #888;
            background: #111;
        }

        .pagination-wrap a:hover {
            background: #1e1e1e;
            border-color: #444;
            color: #fff;
        }

        .pagination-wrap span.current {
            background: #c9954a;
            border-color: #c9954a;
            color: #000;
            font-weight: 700;
            cursor: default;
        }

        .pagination-wrap span.disabled {
            opacity: 0.3;
            cursor: default;
            pointer-events: none;
        }

        .pagination-info {
            text-align: center;
            color: #555;
            font-size: 12px;
            margin-top: -16px;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>

    @include('components.navbar')

    <div class="admin-dashboard">

        {{-- Header --}}
        <div class="dashboard-header">
            <h2>All Products</h2>
            <div class="header-actions">
                <a href="{{ route('admin.shoes.trash') }}" class="trash-btn">🗑 Trash</a>
                <button class="add-btn" id="openPanel">+ Add Shoe</button>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Shoes Grid --}}
        <div class="shoes">
            @forelse($shoes as $shoe)
                <div class="shoe-card-container">
                    <x-shoe-detail-card :shoe="$shoe" />
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <p class="empty-msg">No shoes found in the inventory.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($shoes->hasPages())
            <div class="pagination-wrap">
                {{-- Prev --}}
                @if($shoes->onFirstPage())
                    <span class="disabled">← Prev</span>
                @else
                    <a href="{{ $shoes->previousPageUrl() }}">← Prev</a>
                @endif

                {{-- Page Numbers --}}
                @foreach($shoes->getUrlRange(1, $shoes->lastPage()) as $page => $url)
                    @if($page == $shoes->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($shoes->hasMorePages())
                    <a href="{{ $shoes->nextPageUrl() }}">Next →</a>
                @else
                    <span class="disabled">Next →</span>
                @endif
            </div>

            <p class="pagination-info">
                Showing {{ $shoes->firstItem() }}–{{ $shoes->lastItem() }} of {{ $shoes->total() }} products
            </p>
        @endif

    </div>

    {{-- Add Shoe Panel --}}
    @include('components.addform')

    {{-- Edit Shoe Panel --}}
    @include('components.editform')

    {{-- Confirm Modal --}}
    @include('components.confirm-modal')

    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => openPanel());
    </script>
    @endif

    @vite(['resources/js/app.js'])
</body>
</html>
