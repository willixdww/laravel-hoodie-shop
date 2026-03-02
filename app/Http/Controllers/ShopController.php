<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $featuredProducts = Product::inRandomOrder()->limit(4)->get();
        
        $categories = Category::all();
        
        $productsQuery = Product::query();
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $productsQuery->where('category_id', $request->category);
        }
        
        // Filter by size
        if ($request->has('size') && $request->size) {
            $productsQuery->where('size', $request->size);
        }
        
        // Filter by color
        if ($request->has('color') && $request->color) {
            $productsQuery->where('color', $request->color);
        }
        
        // Sort
        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'price-asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            default:
                $productsQuery->orderBy('created_at', 'desc');
        }
        
        $products = $productsQuery->paginate(12);
        
        return view('shop.index', compact('featuredProducts', 'products', 'categories'));
    }
    
    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }
}
