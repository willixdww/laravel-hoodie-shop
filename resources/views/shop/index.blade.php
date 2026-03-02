<x-layout.app>
    <div class="min-h-screen bg-dark-900">
        <!-- Hero Section -->
        <div class="relative bg-dark-800 overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-r from-dark-900 to-dark-800 opacity-90"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Premium Hoodies & Jeans
                </h1>
                <p class="text-xl md:text-2xl text-dark-300 mb-10">
                    Stilvolle Kleidung für jeden Tag - hochwertig, nachhaltig, fair produziert
                </p>
                <a href="#featured" class="inline-flex items-center px-6 py-3 border border-dark-600 text-dark-100 text-base font-medium rounded-md hover:bg-dark-600 hover:text-white transition-colors">
                    Jetzt Shoppen
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <div id="featured" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-3xl font-bold text-white mb-10 text-center">Empfohlene Produkte</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                    <div class="group bg-dark-800 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative overflow-hidden aspect-[4/5]">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-white mb-2 truncate">{{ $product->name }}</h3>
                            <p class="text-brand-DEFAULT font-bold text-xl mb-3">{{ number_format($product->price, 2) }} €</p>
                            <a href="{{ route('products.show', $product->id) }}" class="block w-full bg-brand-DEFAULT hover:bg-brand-light text-white text-center py-2 rounded-md transition-colors">
                                Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Categories -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-3xl font-bold text-white mb-10 text-center">Kategorien</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('home') }}?category={{ $category->id }}" class="bg-dark-800 rounded-xl p-8 text-center hover:bg-dark-700 transition-colors group">
                        <div class="w-16 h-16 mx-auto bg-brand-DEFAULT rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="text-white text-2xl font-bold">{{ strlen($category->name) > 2 ? substr($category->name, 0, 2) : $category->name }}</span>
                        </div>
                        <h3 class="text-lg font-medium text-white">{{ $category->name }}</h3>
                        <p class="text-dark-400 text-sm mt-1">{{ $category->products->count() }} Produkte</p>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-gradient-to-r from-brand-DEFAULT to-brand-light rounded-2xl p-12 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Bereit für Ihren neuen Look?</h2>
                <p class="text-lg mb-8">Entdecken Sie unsere Kollektion und finden Sie das perfekte Teil für sich.</p>
                <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-white text-brand-DEFAULT font-bold rounded-lg hover:bg-dark-100 transition-colors">
                    Jetzt Shoppen
                </a>
            </div>
        </div>
    </div>
</x-layout.app>
