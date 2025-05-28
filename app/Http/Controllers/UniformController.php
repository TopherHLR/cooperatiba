<?php

namespace App\Http\Controllers;

use App\Models\UniformModel;
use Illuminate\Http\Request;

class UniformController extends Controller
{
    /**
     * Display a listing of uniforms
     */
    public function index()
    {
        $uniforms = UniformModel::all();
        return view('items', compact('uniforms'));
    }

    /**
     * Display the specified uniform
     */
    public function show($id)
    {
        $uniform = UniformModel::findOrFail($id);
        return view('items.show', compact('uniform'));
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request, $id)
    {
        $uniform = UniformModel::findOrFail($id);
        $size = $request->input('size');
        $quantity = $request->input('quantity', 1);
        
        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => 3 // This would be dynamic in a real implementation
        ]);
    }

    /**
     * Process buy now request
     */
    public function buyNow(Request $request, $id)
    {
        $uniform = UniformModel::findOrFail($id);
        $size = $request->input('size');
        $quantity = $request->input('quantity', 1);
        
        // Process immediate purchase logic here
        
        return redirect()->route('payment')->with([
            'uniform_id' => $uniform->uniform_id,
            'size' => $size,
            'quantity' => $quantity
        ]);
    }
}