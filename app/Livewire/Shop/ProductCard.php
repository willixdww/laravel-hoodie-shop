<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;

class ProductCard extends Component
{
    public Product $product;

    public function addToCart()
    {
        // Add product to cart logic
        $cart = session()->get('cart', []);

        if (isset($cart[$this->product->id])) {
            $cart[$this->product->id]['quantity']++;
        } else {
            $cart[$this->product->id] = [
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => 1,
                'image' => $this->product->image_url,
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_count', collect($cart)->sum('quantity'));

        // Fire event for animation
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.shop.product-card');
    }
}
