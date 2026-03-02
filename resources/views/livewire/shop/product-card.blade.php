<div class="product-card">
    <!-- Image Container -->
    <div class="product-card-image">
        <img 
            src="{{ $product->image_url }}" 
            alt="{{ $product->name }}" 
            loading="lazy"
            class="product-card-image-img"
        >
        
        <!-- Hover Overlay -->
        <div class="product-card-hover-overlay">
            <button 
                wire:click="addToCart"
                class="bg-brand text-white px-6 py-2 rounded-lg font-semibold hover:bg-brand-hover transition-all duration-200 ease-out animate-scale-in flex items-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add to Cart
            </button>
        </div>

        <!-- Category Badge -->
        @if($product->category)
            <span class="product-badge">
                {{ $product->category->name }}
            </span>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <h3 class="text-lg font-semibold text-dark-100 mb-1 truncate" title="{{ $product->name }}">
            {{ $product->name }}
        </h3>
        
        <div class="flex items-center gap-2 mb-2">
            <span class="text-brand font-bold text-xl">
                {{ number_format($product->price, 2) }} €
            </span>
            
            @if($product->stock < 10)
                <span class="text-error text-xs font-medium bg-error/10 px-2 py-0.5 rounded">
                    Only {{ $product->stock }} left
                </span>
            @endif
        </div>

        <!-- Product Actions -->
        <div class="flex gap-2 mt-3">
            <a 
                href="{{ route('products.show', $product->id) }}"
                class="flex-1 text-center py-2 text-sm font-medium text-dark-100 bg-dark-700 hover:bg-dark-600 rounded-lg transition-colors"
            >
                Details
            </a>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('cart-updated', () => {
        // Trigger cart badge animation
        const badge = document.getElementById('cart-badge');
        if (badge) {
            badge.classList.add('animate-pulse');
            setTimeout(() => {
                badge.classList.remove('animate-pulse');
            }, 500);
        }
    });
</script>
@endscript
