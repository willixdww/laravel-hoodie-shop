<x-layout.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-white mb-8">Ihr Warenkorb</h1>

        @if($cartItems->isEmpty())
            <div class="bg-dark-800 rounded-2xl p-12 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-semibold text-white mb-4">Ihr Warenkorb ist leer</h2>
                <p class="text-dark-300 mb-6">Schauen Sie sich unsere Produkte an und finden Sie etwas Besonderes für Sie.</p>
                <a href="{{ route('home') }}" class="inline-block bg-brand-DEFAULT hover:bg-brand-light text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    Produkte ansehen
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-dark-800 rounded-2xl overflow-hidden shadow-xl">
                        @foreach($cartItems as $item)
                            <div class="p-6 border-b border-dark-700 last:border-0">
                                <div class="flex items-start gap-4">
                                    <div class="w-24 h-32 bg-dark-700 rounded-lg overflow-hidden flex-shrink-0">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-white mb-2">{{ $item->product->name }}</h3>
                                        <p class="text-dark-300 mb-3">{{ $item->product->category->name }}</p>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <button onclick="updateQuantity({{ $item->id }}, -1)" class="w-8 h-8 bg-dark-700 hover:bg-dark-600 text-white rounded-lg flex items-center justify-center transition-colors">
                                                    -
                                                </button>
                                                <span class="text-white font-medium w-8 text-center">{{ $item->quantity }}</span>
                                                <button onclick="updateQuantity({{ $item->id }}, 1)" class="w-8 h-8 bg-dark-700 hover:bg-dark-600 text-white rounded-lg flex items-center justify-center transition-colors">
                                                    +
                                                </button>
                                            </div>
                                            <p class="text-brand-DEFAULT font-bold text-xl">
                                                {{ number_format($item->product->price * $item->quantity, 2) }} €
                                            </p>
                                        </div>
                                    </div>
                                    <button onclick="removeItem({{ $item->id }})" class="text-red-500 hover:text-red-600 ml-4 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-dark-800 rounded-2xl p-6 shadow-xl sticky top-8">
                        <h2 class="text-xl font-bold text-white mb-6">Zusammenfassung</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-dark-300">
                                <span>Zwischensumme</span>
                                <span>{{ number_format($total, 2) }} €</span>
                            </div>
                            <div class="flex justify-between text-dark-300">
                                <span>Versand</span>
                                <span class="text-green-500">Kostenlos</span>
                            </div>
                            <div class="flex justify-between text-dark-300">
                                <span>MwSt (19%)</span>
                                <span>{{ number_format($total * 0.19, 2) }} €</span>
                            </div>
                            <div class="border-t border-dark-700 pt-3 flex justify-between text-white font-bold text-xl">
                                <span>Gesamt</span>
                                <span>{{ number_format($total * 1.19, 2) }} €</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full bg-brand-DEFAULT hover:bg-brand-light text-white text-center font-bold py-4 rounded-lg transition-colors mb-4">
                            Zur Kasse
                        </a>
                        
                        <a href="{{ route('home') }}" class="block w-full bg-dark-700 hover:bg-dark-600 text-white text-center font-medium py-3 rounded-lg transition-colors">
                            Weiter einkaufen
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        function updateQuantity(itemId, delta) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('cart_item_id', itemId);
            formData.append('quantity', delta);

            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function removeItem(itemId) {
            if (!confirm('Möchten Sie dieses Produkt wirklich entfernen?')) {
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');

            fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    </script>
</x-layout.app>
