<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ihr Warenkorb ist leer');
        }
        
        return view('checkout.index', compact('cartItems', 'total'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|in:paypal,credit_card,invoice',
        ]);
        
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);
        
        // Create order items
        foreach ($cartItems as $item) {
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
        
        return redirect()->route('checkout.success', ['order_id' => $order->id]);
    }
    
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }
    
    private function getCartItems()
    {
        if (auth()->check()) {
            return \App\Models\CartItem::where('user_id', auth()->id())
                ->with('product')
                ->get();
        } else {
            $sessionId = session()->getId();
            return \App\Models\CartItem::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }
    }
    
    private function clearCart()
    {
        if (auth()->check()) {
            \App\Models\CartItem::where('user_id', auth()->id())->delete();
        } else {
            $sessionId = session()->getId();
            \App\Models\CartItem::where('session_id', $sessionId)->delete();
        }
    }
}
