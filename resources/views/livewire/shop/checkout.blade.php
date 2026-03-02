<div class="checkout-container">
    <!-- Progress Steps -->
    <div class="mb-10">
        <div class="flex justify-between relative">
            <div class="absolute top-1/2 left-0 w-full h-0.5 bg-dark-700 -z-10"></div>
            
            @foreach([1 => 'Adresse', 2 => 'Zahlung', 3 => 'Bestätigung'] as $stepNum => $stepName)
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg transition-all duration-300
                        @if($step >= $stepNum) bg-brand text-white @else bg-dark-700 text-dark-300 @endif
                        @if($step === $stepNum) scale-110 shadow-lg shadow-brand/50 @endif">
                        {{ $stepNum }}
                    </div>
                    <span class="text-sm font-medium @if($step >= $stepNum) text-dark-100 @else text-dark-300 @endif">
                        {{ $stepName }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Step 1: Address Form -->
    @if($step === 1)
        <div class="animate-fade-in">
            <h2 class="text-2xl font-bold text-dark-100 mb-6">Lieferadresse</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-dark-300 text-sm mb-2">Vorname *</label>
                    <input type="text" wire:model="formData.first_name" class="input-default">
                    @error('formData.first_name') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-dark-300 text-sm mb-2">Nachname *</label>
                    <input type="text" wire:model="formData.last_name" class="input-default">
                    @error('formData.last_name') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-dark-300 text-sm mb-2">Email *</label>
                <input type="email" wire:model="formData.email" class="input-default">
                @error('formData.email') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-dark-300 text-sm mb-2">Adresse *</label>
                <input type="text" wire:model="formData.address" class="input-default">
                @error('formData.address') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-dark-300 text-sm mb-2">PLZ *</label>
                    <input type="text" wire:model="formData.postal_code" class="input-default">
                    @error('formData.postal_code') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-dark-300 text-sm mb-2">Stadt *</label>
                    <input type="text" wire:model="formData.city" class="input-default">
                    @error('formData.city') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-dark-300 text-sm mb-2">Land *</label>
                <select wire:model="formData.country" class="input-default">
                    <option value="">Bitte wählen...</option>
                    <option value="DE">Deutschland</option>
                    <option value="AT">Österreich</option>
                    <option value="CH">Schweiz</option>
                </select>
                @error('formData.country') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="button" wire:click="updateStep(2)" class="btn-cta flex-1">
                    Weiter zur Zahlung
                </button>
            </div>
        </div>
    @endif

    <!-- Step 2: Payment -->
    @if($step === 2)
        <div class="animate-fade-in">
            <h2 class="text-2xl font-bold text-dark-100 mb-6">Zahlungsart</h2>
            
            <div class="space-y-4 mb-8">
                <label class="card flex items-center gap-4 p-4 cursor-pointer hover:border-brand transition-colors
                    @if($formData['payment_method'] === 'paypal') border-brand bg-brand/10 @endif">
                    <input type="radio" wire:model="formData.payment_method" value="paypal" class="form-radio brand h-5 w-5">
                    <div>
                        <div class="font-semibold text-dark-100">PayPal</div>
                        <div class="text-dark-300 text-sm">Bequem und sicher mit PayPal bezahlen</div>
                    </div>
                </label>

                <label class="card flex items-center gap-4 p-4 cursor-pointer hover:border-brand transition-colors
                    @if($formData['payment_method'] === 'credit_card') border-brand bg-brand/10 @endif">
                    <input type="radio" wire:model="formData.payment_method" value="credit_card" class="form-radio brand h-5 w-5">
                    <div>
                        <div class="font-semibold text-dark-100">Kreditkarte</div>
                        <div class="text-dark-300 text-sm">Sichere Zahlung mit Kreditkarte</div>
                    </div>
                </label>

                <label class="card flex items-center gap-4 p-4 cursor-pointer hover:border-brand transition-colors
                    @if($formData['payment_method'] === 'invoice') border-brand bg-brand/10 @endif">
                    <input type="radio" wire:model="formData.payment_method" value="invoice" class="form-radio brand h-5 w-5">
                    <div>
                        <div class="font-semibold text-dark-100">Rechnung</div>
                        <div class="text-dark-300 text-sm">Zahlung nach Erhalt der Ware</div>
                    </div>
                </label>
            </div>

            <div class="bg-dark-800 rounded-xl p-6 mb-8">
                <h3 class="font-semibold text-dark-100 mb-4">Zusammenfassung</h3>
                <div class="space-y-2 mb-4">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between text-dark-300 text-sm">
                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                            <span>{{ number_format($item->product->price * $item->quantity, 2) }} €</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-dark-700 pt-4 mt-4">
                    <div class="flex justify-between text-xl font-bold text-dark-100">
                        <span>Gesamt</span>
                        <span>{{ number_format($total * 1.19, 2) }} €</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="button" wire:click="updateStep(1)" class="btn-primary">
                    Zurück
                </button>
                <button type="button" wire:click="processOrder" class="btn-cta flex-1">
                    Zur Zahlung
                </button>
            </div>
        </div>
    @endif

    <!-- Step 3: Success -->
    @if($step === 3)
        <div class="animate-fade-in text-center py-12">
            <div class="w-24 h-24 mx-auto mb-6 text-success rounded-full bg-success/10 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-dark-100 mb-4">Bestellung erfolgreich!</h2>
            <p class="text-dark-300 mb-8 max-w-md mx-auto">
                Ihre Bestellung wurde entgegengenommen. Sie erhalten in Kürze eine Bestätigung per Email.
            </p>
            <a href="{{ route('home') }}" class="btn-primary">
                Weiter shoppen
            </a>
        </div>
    @endif
</div>
