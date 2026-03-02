<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-white mb-8">Kasse</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <div class="bg-dark-800 rounded-2xl p-6 shadow-xl mb-8">
                    <h2 class="text-xl font-bold text-white mb-6 pb-4 border-b border-dark-700">Lieferadresse</h2>
                    
                    <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-dark-400 mb-2">Vorname</label>
                                <input type="text" id="first_name" name="first_name" required class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-DEFAULT">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-dark-400 mb-2">Nachname</label>
                                <input type="text" id="last_name" name="last_name" required class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-DEFAULT">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-dark-400 mb-2">E-Mail-Adresse</label>
                            <input type="email" id="email" name="email" required class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-DEFAULT">
                        </div>

                        <div class="mb-6">
                            <label for="address" class="block text-sm font-medium text-dark-400 mb-2">Straße und Hausnummer</label>
                            <input type="text" id="address" name="address" required class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-DEFAULT">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-dark-400 mb-2">PLZ</label>
                                <input type="text" id="postal_code" name="postal_code" required class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-DEFAULT">
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-dark-400 mb-2">Stadt</label>
                                <input type="text" id="city" name="city" required class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-DEFAULT">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="country" class="block text-sm font-medium text-dark-400 mb-2">Land</label>
                            <select id="country" name="country" required class="w-full bg-dark-700 border border-dark-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-DEFAULT">
                                <option value="">Bitte wählen</option>
                                <option value="DE">Deutschland</option>
                                <option value="AT">Österreich</option>
                                <option value="CH">Schweiz</option>
                                <option value="FR">Frankreich</option>
                                <option value="IT">Italien</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="bg-dark-800 rounded-2xl p-6 shadow-xl">
                    <h2 class="text-xl font-bold text-white mb-6 pb-4 border-b border-dark-700">Zahlung</h2>
                    
                    <form action="{{ route('checkout.process') }}" method="POST" id="payment-form">
                        @csrf
                        <input type="hidden" name="first_name" id="first_name_payment">
                        <input type="hidden" name="last_name" id="last_name_payment">
                        <input type="hidden" name="email" id="email_payment">
                        <input type="hidden" name="address" id="address_payment">
                        <input type="hidden" name="postal_code" id="postal_code_payment">
                        <input type="hidden" name="city" id="city_payment">
                        <input type="hidden" name="country" id="country_payment">
                        
                        <div class="space-y-4">
                            <label class="flex items-start gap-4 p-4 bg-dark-700 rounded-lg cursor-pointer hover:bg-dark-600 transition-colors">
                                <input type="radio" name="payment_method" value="paypal" class="mt-1 w-5 h-5 text-brand-DEFAULT focus:ring-brand-DEFAULT" checked>
                                <div>
                                    <span class="text-white font-medium">PayPal</span>
                                    <p class="text-dark-400 text-sm mt-1">Bequem und sicher mit Ihrem PayPal-Konto bezahlen</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 bg-dark-700 rounded-lg cursor-pointer hover:bg-dark-600 transition-colors">
                                <input type="radio" name="payment_method" value="credit_card" class="mt-1 w-5 h-5 text-brand-DEFAULT focus:ring-brand-DEFAULT">
                                <div>
                                    <span class="text-white font-medium">Kreditkarte</span>
                                    <p class="text-dark-400 text-sm mt-1">Bezahlen Sie sicher mit Ihrer Kreditkarte</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 bg-dark-700 rounded-lg cursor-pointer hover:bg-dark-600 transition-colors">
                                <input type="radio" name="payment_method" value="invoice" class="mt-1 w-5 h-5 text-brand-DEFAULT focus:ring-brand-DEFAULT">
                                <div>
                                    <span class="text-white font-medium">Rechnung</span>
                                    <p class="text-dark-400 text-sm mt-1">Bezahlen Sie nach Erhalt der Ware</p>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-dark-800 rounded-2xl p-6 shadow-xl sticky top-8">
                    <h2 class="text-xl font-bold text-white mb-6">Bestellübersicht</h2>
                    
                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-dark-700 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-white line-clamp-1">{{ $item->product->name }}</h3>
                                    <p class="text-dark-400 text-sm">x{{ $item->quantity }}</p>
                                </div>
                                <p class="text-white font-medium">
                                    {{ number_format($item->product->price * $item->quantity, 2) }} €
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-dark-700 pt-4 space-y-3">
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

                    <button type="button" onclick="submitCheckoutForm()" class="block w-full bg-brand-DEFAULT hover:bg-brand-light text-white text-center font-bold py-4 rounded-lg transition-colors mt-6">
                        Zahlungspflichtig bestellen
                    </button>
                    
                    <p class="text-center text-dark-400 text-sm mt-4">
                        Durch Klicken auf "Zahlungspflichtig bestellen" erklären Sie sich mit unseren <a href="#" class="text-brand-DEFAULT hover:underline">AGB</a> und <a href="#" class="text-brand-DEFAULT hover:underline">Datenschutzrichtlinien</a> einverstanden.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitCheckoutForm() {
            // Copy form values to payment form
            document.getElementById('first_name_payment').value = document.getElementById('first_name').value;
            document.getElementById('last_name_payment').value = document.getElementById('last_name').value;
            document.getElementById('email_payment').value = document.getElementById('email').value;
            document.getElementById('address_payment').value = document.getElementById('address').value;
            document.getElementById('postal_code_payment').value = document.getElementById('postal_code').value;
            document.getElementById('city_payment').value = document.getElementById('city').value;
            document.getElementById('country_payment').value = document.getElementById('country').value;
            
            // Submit the form
            document.getElementById('payment-form').submit();
        }
    </script>
</x-layout.app>
