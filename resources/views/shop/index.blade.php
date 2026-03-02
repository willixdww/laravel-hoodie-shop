<x-app-layout>
    <div class="min-h-screen bg-dark-900">
        <!-- Hero Section -->
        <div class="relative bg-dark-800 overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-r from-dark-900 via-dark-800 to-dark-900 opacity-90"></div>
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center opacity-20"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in">
                    Premium Hoodies & Jeans
                </h1>
                <p class="text-xl md:text-2xl text-dark-300 mb-10 max-w-2xl mx-auto animate-fade-in" style="animation-delay: 0.2s">
                    Stilvolle Kleidung für jeden Tag - hochwertig, nachhaltig, fair produziert
                </p>
                <a href="#featured" class="inline-flex items-center px-8 py-3 border border-dark-100 text-dark-100 text-lg font-semibold rounded-lg hover:bg-dark-100 hover:text-dark-900 transition-all duration-300 animate-scale-in">
                    Jetzt Shoppen
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" id="featured">
            <!-- Filter and Sort Bar -->
            <div class="flex flex-col md:flex-row gap-6 mb-8">
                <!-- Sidebar Filters -->
                <div class="w-full md:w-64 flex-shrink-0 space-y-6">
                    <div class="filter-section">
                        <h3 class="filter-title">Kategorien</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-dark-300 hover:text-dark-100 cursor-pointer">
                                <input type="checkbox" class="form-checkbox brand-default rounded bg-dark-700 border-dark-600 text-dark-100">
                                <span>Hoodies</span>
                            </label>
                            <label class="flex items-center gap-2 text-dark-300 hover:text-dark-100 cursor-pointer">
                                <input type="checkbox" class="form-checkbox brand-default rounded bg-dark-700 border-dark-600 text-dark-100">
                                <span>Jeans</span>
                            </label>
                            <label class="flex items-center gap-2 text-dark-300 hover:text-dark-100 cursor-pointer">
                                <input type="checkbox" class="form-checkbox brand-default rounded bg-dark-700 border-dark-600 text-dark-100">
                                <span>Accessories</span>
                            </label>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3 class="filter-title">Größe</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <button class="px-3 py-1 rounded text-sm border border-dark-600 text-dark-300 hover:border-brand hover:text-brand transition-colors">
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3 class="filter-title">Preis</h3>
                        <div class="space-y-3">
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-dark-300 text-sm">€</span>
                                <input type="number" placeholder="Min" class="input-default pl-8 text-sm">
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-dark-300 text-sm">€</span>
                                <input type="number" placeholder="Max" class="input-default pl-8 text-sm">
                            </div>
                            <input type="range" min="0" max="500" class="w-full h-2 bg-dark-700 rounded-lg appearance-none cursor-pointer accent-brand">
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Sort Bar -->
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-dark-300">
                            <span class="font-semibold text-dark-100">{{ $products->total() }}</span> Produkte
                        </p>
                        <div class="flex items-center gap-2">
                            <label class="text-dark-300 text-sm">Sortieren nach:</label>
                            <select class="sort-select text-sm">
                                <option value="newest">Neueste</option>
                                <option value="price-asc">Preis: Aufsteigend</option>
                                <option value="price-desc">Preis: Absteigend</option>
                                <option value="name">Name A-Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            @livewire('shop.product-card', ['product' => $product], key($product->id))
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" id="categories">
            <h2 class="text-3xl font-bold text-white mb-10 text-center">Kategorien</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('home') }}?category={{ $category->id }}" class="category-card">
                        <div class="w-20 h-20 mx-auto bg-brand rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white text-2xl font-bold">{{ strlen($category->name) > 2 ? substr($category->name, 0, 2) : $category->name }}</span>
                        </div>
                        <h3 class="text-lg font-medium text-dark-100">{{ $category->name }}</h3>
                        <p class="text-dark-300 text-sm mt-1">{{ $category->products->count() }} Produkte</p>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-gradient-to-r from-brand to-brand-hover rounded-3xl p-12 md:p-16 text-center text-white shadow-2xl">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Bereit für Ihren neuen Look?</h2>
                <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto text-brand-100">
                    Entdecken Sie unsere Kollektion und finden Sie das perfekte Teil für sich. 
                    Qualität, die Sie spüren können.
                </p>
                <a href="{{ route('home') }}" class="inline-block px-10 py-4 bg-white text-brand font-bold rounded-lg hover:bg-dark-100 hover:text-brand transition-all duration-300 transform hover:-translate-y-1 shadow-xl">
                    Jetzt Shoppen
                </a>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>
</x-app-layout>

@script
<script>
    // Cart badge animation
    $wire.on('cart-updated', () => {
        const badge = document.getElementById('cart-badge');
        if (badge) {
            badge.classList.add('animate-pulse');
            setTimeout(() => {
                badge.classList.remove('animate-pulse');
            }, 500);
        }

        // Show toast notification
        showToast('Produkt zum Warenkorb hinzugefügt');
    });

    function showToast(message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast animate-slide-in';
        toast.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>${message}</span>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>
@endscript
