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
        /* Responsive Grid Logic */
        .shoes {
            display: grid;
            /* Creates as many columns as fit, each at least 450px wide */
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        /* Adjusts for smaller screens where 450px might be too wide */
        @media (max-width: 600px) {
            .shoes {
                grid-template-columns: 1fr;
            }
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
                    {{-- Updated: Component handles the wide layout internally --}}
                    <x-shoe-detail-card :shoe="$shoe" />
                </div>
            @empty
                <div class="empty-state">
                    <p class="empty-msg">No shoes found in the inventory.</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- Add Shoe Panel --}}
    @include('components.addform')


    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => openPanel());
    </script>
    @endif

    @vite(['resources/js/app.js'])
</body>
</html>