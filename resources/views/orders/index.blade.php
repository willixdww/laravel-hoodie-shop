<x-layout.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-white mb-8">Meine Bestellungen</h1>

        @if($orders->isEmpty())
            <div class="bg-dark-800 rounded-2xl p-12 text-center">
                <div class="text-6xl mb-4">📦</div>
                <h2 class="text-2xl font-semibold text-white mb-4">Noch keine Bestellungen</h2>
                <p class="text-dark-300 mb-6">Schauen Sie sich unsere Produkte an und tätigen Sie Ihre erste Bestellung.</p>
                <a href="{{ route('home') }}" class="inline-block bg-brand-DEFAULT hover:bg-brand-light text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    Produkte ansehen
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-dark-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-white">Bestellung #{{ $order->id }}</h2>
                                <p class="text-dark-400 text-sm">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-medium
                                    {{ $order->status == 'pending' ? 'bg-yellow-500/20 text-yellow-500' : 
                                       ($order->status == 'processing' ? 'bg-blue-500/20 text-blue-500' :
                                       ($order->status == 'shipped' ? 'bg-purple-500/20 text-purple-500' :
                                       ($order->status == 'delivered' ? 'bg-green-500/20 text-green-500' : 'bg-gray-500/20 text-gray-500'))) }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-dark-300">
                                <span>Zwischensumme:</span>
                                <span>{{ number_format($order->total_amount, 2) }} €</span>
                            </div>
                            <div class="flex justify-between text-dark-300">
                                <span>Versand:</span>
                                <span class="text-green-500">Kostenlos</span>
                            </div>
                            <div class="flex justify-between text-dark-300">
                                <span>MwSt (19%):</span>
                                <span>{{ number_format($order->total_amount * 0.19, 2) }} €</span>
                            </div>
                            <div class="border-t border-dark-700 pt-3 flex justify-between text-white font-bold text-xl">
                                <span>Gesamt:</span>
                                <span>{{ number_format($order->total_amount * 1.19, 2) }} €</span>
                            </div>
                        </div>

                        <div class="bg-dark-700 rounded-xl overflow-hidden mb-6">
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-dark-400 uppercase tracking-wider mb-3">Artikel</h3>
                                <ul class="space-y-2">
                                    @foreach($order->items as $item)
                                        <li class="flex justify-between py-2 border-b border-dark-600 last:border-0">
                                            <span class="text-white">{{ $item->product->name }}</span>
                                            <span class="text-dark-300">x{{ $item->quantity }}</span>
                                            <span class="text-white font-medium">{{ number_format($item->price, 2) }} €</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="#" class="text-dark-400 hover:text-brand-DEFAULT text-sm">
                                Rechnung herunterladen
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout.app>
