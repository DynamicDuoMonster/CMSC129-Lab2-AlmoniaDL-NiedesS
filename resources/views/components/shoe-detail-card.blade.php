@vite(['resources/css/components/shoe-detail-card.css'])

@props(['shoe', 'disableClick' => false])

<div
    class="shoe-details"
    x-data="{
        currentIndex: 0,
        isHovered: false,
        images: {{ json_encode($shoe->image_url ?? []) }},
        interval: null,

        get currentImage() {
            return this.images.length > 0 ? this.images[this.currentIndex] : '';
        },

        startCycle() {
            if (this.images.length > 1) {
                this.isHovered = true;
                this.interval = setInterval(() => {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                }, 1200);
            }
        },

        stopCycle() {
            this.isHovered = false;
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
            this.currentIndex = 0;
        }
    }"
    @mouseenter="startCycle()"
    @mouseleave="stopCycle()"
>
    {{-- Image Container (Left Side) --}}
    <div class="shoe-image-container">
        <img
            x-show="images.length > 0"
            :src="currentImage"
            alt="{{ $shoe->shoe_name }}"
            class="shoe-img"
            :key="currentIndex"
        />

        <div x-show="images.length === 0" class="shoe-img-placeholder">
            No Image
        </div>

        <template x-if="images.length > 1 && isHovered">
            <div class="image-dots">
                <template x-for="(img, i) in images" :key="i">
                    <div class="dot" :class="i === currentIndex ? 'active' : ''"></div>
                </template>
            </div>
        </template>
    </div>

    {{-- Info Container (Right Side) --}}
    <div class="shoe-info">
        <div class="shoe-text-meta">
            <span class="brand-badge">{{ $shoe->brand }}</span>
            <h4>{{ $shoe->shoe_name }}</h4>
            <p class="tags">
                {{ collect([$shoe->gender, $shoe->categoryModel->name ?? 'Uncategorized'])->filter()->join(' • ') }}
            </p>
            <p class="price">P{{ number_format($shoe->price) }}</p>
        </div>

        <div class="admin-actions">
            <button
                type="button"
                class="btn-edit-full"
                onclick="window.openEditPanel({{ json_encode($shoe) }})"
            >
                Edit Product
            </button>

            {{-- Soft Delete: uses confirm modal instead of browser confirm() --}}
            <form
                method="POST"
                action="{{ route('admin.shoes.softDelete', $shoe->id) }}"
                class="delete-form"
                id="trashForm-{{ $shoe->id }}"
            >
                @csrf
                @method('PATCH')
                <button
                    type="button"
                    class="btn-delete-full"
                    onclick="showConfirm({
                        icon: '🗑',
                        title: 'Move to Trash?',
                        message: 'This shoe will be moved to trash. You can restore it later.',
                        okLabel: 'Move to Trash',
                        onConfirm: () => document.getElementById('trashForm-{{ $shoe->id }}').submit()
                    })"
                >
                    Move to Trash
                </button>
            </form>
        </div>
    </div>
</div>
