<div class="cart-container">
    @if($cartItems->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto mb-6 text-dark-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-dark-100 mb-2">Ihr Warenkorb ist leer</h2>
            <p class="text-dark-300 mb-6">Besuchen Sie unseren Shop, um Produkte hinzuzufügen.</p>
            <a href="{{ route('home') }}" class="btn-primary">Jetzt Shoppen</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                @foreach($cartItems as $item)
                    <div class="card p-6 mb-4 flex items-center gap-4 animate-fade-in">
                        <!-- Product Image -->
                        <div class="w-24 h-30 flex-shrink-0">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-dark-100 mb-1">{{ $item->product->name }}</h3>
                            <p class="text-brand font-bold text-xl">{{ number_format($item->product->price, 2) }} €</p>
                            <p class="text-dark-300 text-sm mt-1">Größe: {{ $item->product->size ?? 'One Size' }}</p>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="flex items-center gap-2">
                            <button 
                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                @if($item->quantity <= 1) disabled @endif
                                class="w-8 h-8 flex items-center justify-center bg-dark-700 rounded-lg hover:bg-dark-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-xl"
                            >
                                -
                            </button>
                            <input 
                                type="number" 
                                wire:model="updateQuantity.{{ $item->id }}"
                                wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                class="w-16 h-8 text-center bg-dark-700 border border-dark-600 rounded-lg text-dark-100 focus:border-brand focus:outline-none"
                                min="1"
                                max="100"
                            >
                            <button 
                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                class="w-8 h-8 flex items-center justify-center bg-dark-700 rounded-lg hover:bg-dark-600 transition-colors text-xl"
                            >
                                +
                            </button>
                        </div>

                        <!-- Total for item -->
                        <div class="text-right">
                            <p class="font-bold text-dark-100">{{ number_format($item->product->price * $item->quantity, 2) }} €</p>
                            <button 
                                wire:click="removeItem({{ $item->id }})"
                                class="text-error text-sm hover:text-error-hover mt-1 transition-colors"
                            >
                                Entfernen
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-dark-100 mb-6 pb-2 border-b border-dark-700">Zusammenfassung</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-dark-300">
                            <span>Zwischensumme</span>
                            <span>{{ number_format($total, 2) }} €</span>
                        </div>
                        <div class="flex justify-between text-dark-300">
                            <span>Versand</span>
                            <span class="text-success">Kostenlos</span>
                        </div>
                        <div class="flex justify-between text-dark-300">
                            <span>MwSt. (19%)</span>
                            <span>{{ number_format($total * 0.19, 2) }} €</span>
                        </div>
                        <div class="flex justify-between text-2xl font-bold text-dark-100 pt-4 border-t border-dark-700">
                            <span>Gesamt</span>
                            <span>{{ number_format($total * 1.19, 2) }} €</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('checkout.index') }}" class="btn-cta w-full block text-center">
                            Zur Kasse
                        </a>
                        <button wire:click="clearCart" class="btn-secondary w-full">
                            Warenkorb leeren
                        </button>
                        <a href="{{ route('home') }}" class="btn-primary w-full block text-center">
                            Weiter shoppen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@script
<script>
    $wire.on('item-removed', ({ itemId }) => {
        // Animation for removed item
        const item = document.querySelector(`[data-cart-item="${itemId}"]`);
        if (item) {
            item.style.transform = 'translateX(100%)';
            item.style.opacity = '0';
            setTimeout(() => item.remove(), 300);
        }
    });
</script>
@endscript
