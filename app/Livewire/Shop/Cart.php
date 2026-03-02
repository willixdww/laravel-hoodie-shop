<?php

namespace App\Shop\Components;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Product;

class Cart extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $updateQuantity = [];

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
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $this->validate([
            "updateQuantity.{$cartItemId}" => 'required|integer|min:1|max:100',
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->quantity = $this->updateQuantity[$cartItemId];
        $cartItem->save();

        $this->loadCartItems();
        $this->dispatch('cart-updated');
    }

    public function removeItem($cartItemId)
    {
        CartItem::destroy($cartItemId);
        $this->loadCartItems();
        $this->dispatch('cart-updated');
        $this->dispatch('item-removed', itemId: $cartItemId);
    }

    public function clearCart()
    {
        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())->delete();
        } else {
            $sessionId = session()->getId();
            CartItem::where('session_id', $sessionId)->delete();
        }

        $this->cartItems = [];
        $this->total = 0;
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.shop.cart');
    }
}
