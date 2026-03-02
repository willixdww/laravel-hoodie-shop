<x-layout.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-dark-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="bg-dark-700 rounded-xl overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
                </div>

                <!-- Product Details -->
                <div>
                    <div class="mb-4">
                        <a href="{{ route('home') }}" class="text-dark-400 hover:text-brand-DEFAULT transition-colors">
                            ← Zurück zum Shop
                        </a>
                    </div>

                    <h1 class="text-3xl font-bold text-white mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center mb-6">
                        <span class="text-4xl font-bold text-brand-DEFAULT mr-4">
                            {{ number_format($product->price, 2) }} €
                        </span>
                        @if($product->stock > 0)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                Auf Lager ({{ $product->stock }})
                            </span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                                Leider nicht verfügbar
                            </span>
                        @endif
                    </div>

                    <div class="prose prose-invert mb-8">
                        <h3 class="text-xl font-semibold text-white mb-2">Beschreibung</h3>
                        <p class="text-dark-300 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Selection Options -->
                    @if($product->stock > 0)
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-dark-400 mb-2 uppercase tracking-wider">Verfügbare Größen</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['S', 'M', 'L', 'XL'] as $size)
                                    @if($product->size == $size || $product->size == null)
                                        <button class="px-4 py-2 bg-dark-700 hover:bg-dark-600 text-white rounded-lg transition-colors">
                                            {{ $size }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-dark-400 mb-2 uppercase tracking-wider">Verfügbare Farben</h4>
                            <div class="flex gap-2">
                                @foreach(['Black', 'White', 'Blue', 'Gray', 'Navy', 'Green'] as $color)
                                    @if($product->color == $color || $product->color == null)
                                        <div class="w-8 h-8 rounded-full border-2 border-dark-600" style="background-color: {{ $color == 'Black' ? '#000000' : ($color == 'White' ? '#FFFFFF' : ($color == 'Blue' ? '#3B82F6' : ($color == 'Gray' ? '#6B7280' : '#1E3A8A'))) }}"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Add to Cart Form -->
                        <form id="add-to-cart-form" class="flex items-center gap-4">
                            <div class="flex items-center bg-dark-700 rounded-lg">
                                <button type="button" onclick="adjustQuantity(-1)" class="px-4 py-2 text-white hover:bg-dark-600 rounded-l-lg">
                                    -
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center bg-transparent text-white focus:outline-none">
                                <button type="button" onclick="adjustQuantity(1)" class="px-4 py-2 text-white hover:bg-dark-600 rounded-r-lg">
                                    +
                                </button>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="flex-1 bg-brand-DEFAULT hover:bg-brand-light text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                In den Warenkorb
                            </button>
                        </form>
                    @endif

                    <div class="mt-8 pt-8 border-t border-dark-700">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-semibold text-dark-400">Material</h4>
                                <p class="text-dark-300">100% Bio-Baumwolle</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-dark-400">Herstellung</h4>
                                <p class="text-dark-300">Fair produziert</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-dark-400">Lieferung</h4>
                                <p class="text-dark-300">Kostenlos ab 50 €</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-dark-400">Rückgabe</h4>
                                <p class="text-dark-300">30 Tage Widerruf</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function adjustQuantity(delta) {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value) || 1;
            value += delta;
            if (value < 1) value = 1;
            if (value > {{ $product->stock }}) value = {{ $product->stock }};
            input.value = value;
        }
    </script>
</x-layout.app>
