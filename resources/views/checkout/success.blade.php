<x-layout.app>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-dark-800 rounded-2xl p-8 text-center shadow-2xl">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-white mb-4">Vielen Dank für Ihre Bestellung!</h1>
            <p class="text-dark-300 mb-8 text-lg">
                Ihre Bestellung mit der Nummer <span class="text-brand-DEFAULT font-bold">#{{ $order->id }}</span> wurde erfolgreich aufgegeben.
            </p>

            <div class="bg-dark-700 rounded-xl p-6 mb-8">
                <h2 class="text-lg font-semibold text-white mb-4">Bestellübersicht</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-dark-300">Bestellnummer:</span>
                        <span class="text-white font-mono">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-300">Bestelldatum:</span>
                        <span class="text-white">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-300">Zahlungsmethode:</span>
                        <span class="text-white">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark-300">Gesamtbetrag:</span>
                        <span class="text-brand-DEFAULT font-bold text-xl">{{ number_format($order->total_amount * 1.19, 2) }} €</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <a href="{{ route('orders.index') }}" class="inline-block bg-brand-DEFAULT hover:bg-brand-light text-white font-bold py-3 px-8 rounded-lg transition-colors">
                    Meine Bestellungen
                </a>
                <a href="{{ route('home') }}" class="inline-block bg-dark-700 hover:bg-dark-600 text-white font-medium py-3 px-8 rounded-lg transition-colors">
                    Weiter einkaufen
                </a>
            </div>

            <p class="mt-8 text-dark-400 text-sm">
                Wir haben Ihre Bestellung erhalten und werden diese so schnell wie möglich bearbeiten. Sie erhalten eine Bestätigung per E-Mail.
            </p>
        </div>
    </div>
</x-layout.app>
