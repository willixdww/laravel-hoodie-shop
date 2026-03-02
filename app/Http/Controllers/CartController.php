<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        
        // Check if item already in cart
        $cartItem = $this->getCartItem($product->id);
        
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $this->addToCart($product->id, $quantity);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produkt zum Warenkorb hinzugefügt');
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cartItem = $this->getCartItemById($request->cart_item_id);
        
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }
        
        return redirect()->route('cart.index');
    }
    
    public function remove($id)
    {
        $cartItem = $this->getCartItemById($id);
        
        if ($cartItem) {
            $cartItem->delete();
        }
        
        return redirect()->route('cart.index');
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
    
    private function getCartItem($productId)
    {
        if (auth()->check()) {
            return \App\Models\CartItem::where('product_id', $productId)
                ->where('user_id', auth()->id())
                ->first();
        } else {
            $sessionId = session()->getId();
            return \App\Models\CartItem::where('product_id', $productId)
                ->where('session_id', $sessionId)
                ->first();
        }
    }
    
    private function getCartItemById($id)
    {
        return \App\Models\CartItem::find($id);
    }
    
    private function addToCart($productId, $quantity)
    {
        if (auth()->check()) {
            \App\Models\CartItem::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'user_id' => auth()->id(),
            ]);
        } else {
            $sessionId = session()->getId();
            \App\Models\CartItem::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'session_id' => $sessionId,
            ]);
        }
    }
}
