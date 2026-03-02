<?php

namespace App\Shop\Components;

use Livewire\Component;
use App\Models\Order;
use App\Models\CartItem;

class Checkout extends Component
{
    public $step = 1;

    public $formData = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'address' => '',
        'city' => '',
        'postal_code' => '',
        'country' => '',
        'payment_method' => 'paypal',
    ];

    public $cartItems = [];
    public $total = 0;
    public $errors = [];

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
    {
        if (auth()->check()) {
            $this->cartItems = CartItem::where('user_id', auth()->id())
                ->with('product')
                ->get();
        } else {
            $sessionId = session()->getId();
            $this->cartItems = CartItem::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        $this->total = $this->cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        if ($this->cartItems->isEmpty()) {
            return $this->dispatch('redirect', url: route('cart.index'));
        }
    }

    public function updateStep($step)
    {
        $this->step = $step;
    }

    public function validateAddress()
    {
        $validated = $this->validate([
            'formData.first_name' => 'required|string|max:255',
            'formData.last_name' => 'required|string|max:255',
            'formData.email' => 'required|email|max:255',
            'formData.address' => 'required|string|max:255',
            'formData.city' => 'required|string|max:255',
            'formData.postal_code' => 'required|string|max:20',
            'formData.country' => 'required|string|max:255',
        ]);

        return $validated;
    }

    public function validatePayment()
    {
        $validated = $this->validate([
            'formData.payment_method' => 'required|in:paypal,credit_card,invoice',
        ]);

        return $validated;
    }

    public function processOrder()
    {
        $validated = $this->validate([
            'formData.first_name' => 'required|string|max:255',
            'formData.last_name' => 'required|string|max:255',
            'formData.email' => 'required|email|max:255',
            'formData.address' => 'required|string|max:255',
            'formData.city' => 'required|string|max:255',
            'formData.postal_code' => 'required|string|max:20',
            'formData.country' => 'required|string|max:255',
            'formData.payment_method' => 'required|in:paypal,credit_card,invoice',
        ]);

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $this->total * 1.19,
                'status' => 'pending',
                'payment_method' => $validated['formData']['payment_method'],
                'shipping_address' => json_encode([
                    'first_name' => $validated['formData']['first_name'],
                    'last_name' => $validated['formData']['last_name'],
                    'address' => $validated['formData']['address'],
                    'city' => $validated['formData']['city'],
                    'postal_code' => $validated['formData']['postal_code'],
                    'country' => $validated['formData']['country'],
                ]),
            ]);

            foreach ($this->cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update stock
                $item->product->stock -= $item->quantity;
                $item->product->save();
            }

            // Clear cart
            $this->clearCart();

            return $this->dispatch('redirect', url: route('checkout.success', ['order_id' => $order->id]));
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.');
        }
    }

    private function clearCart()
    {
        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())->delete();
        } else {
            $sessionId = session()->getId();
            CartItem::where('session_id', $sessionId)->delete();
        }
    }

    public function render()
    {
        return view('livewire.shop.checkout');
    }
}
