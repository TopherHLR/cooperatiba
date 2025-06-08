<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;   // for authentication
use App\Models\UniformModel;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use Carbon\Carbon;
// Using the Session facade (must import it)
use Illuminate\Support\Facades\Session;
use App\Models\OrderItemModel;

class UniformController extends Controller
{
    /**
     * Display a listing of uniforms
     */
    public function index()
    {
        $student = auth()->user()->student; // Adjust if needed
        $uniforms = UniformModel::all();

        return view('items', compact('student', 'uniforms'));
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
    public function buyNow(Request $request, $uniform_id)
    {
        Log::info('Form uniform_id', ['uniform_id' => $request->uniform_id]);
        Log::info('Route uniform_id', ['uniform_id' => $uniform_id]); // from route param


        Log::info('buyNow method called', [
            'uniform_id' => $uniform_id,
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        // Redirect to login if not authenticated
        if (!Auth::check()) {
            Log::warning("Unauthenticated user attempted to access buyNow");
            return redirect()->route('web.login')->withErrors(['error' => 'Please log in to proceed with your order.']);
        }
    
        // Try to find the uniform
        $uniform = UniformModel::where('uniform_id', $uniform_id)->first();
    
        if (!$uniform) {
            Log::error("Uniform not found for uniform_id: {$uniform_id}");
            abort(404, "Uniform not found");
        }
    
        Log::info('Uniform found', ['uniform' => $uniform]);
    
        $size = $request->input('size');
        $quantity = $request->input('quantity', 1);
    
        // Get student record using authenticated user ID
        $userId = Auth::id();
        $student = \App\Models\StudentModel::where('user_id', $userId)->first();
    
        if (!$student) {
            Log::error("Student not found for user_id: {$userId}");
            return back()->withErrors(['error' => 'Student record not found.']);
        }
    
        $studentId = $student->student_id;
    
        Log::info('Order details', [
            'size' => $size,
            'quantity' => $quantity,
            'student_id' => $studentId,
            'uniform_price' => $uniform->price
        ]);
    
        // Calculate total
        $totalPrice = $uniform->price * $quantity;
    
        // Create order
        $order = OrderModel::create([
            'student_id' => $studentId,
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
            'order_date' => Carbon::now(),
        ]);
    
        Log::info('Order created', ['order_id' => $order->order_id]);
        // Calculate subtotal price
        $subtotalPrice = $uniform->price * $quantity;
        // Create order item
        OrderItemModel::create([
            'order_id' => $order->order_id,
            'uniform_id' => $uniform->uniform_id,
            'size' => $size,
            'quantity' => $quantity,
            'price' => $uniform->price,
            'subtotal_price' => $subtotalPrice,
        ]);
    
        // Decrease stock
        $uniform->decrement('stock_quantity', $quantity);
    
        Log::info('Stock decremented', [
            'uniform_id' => $uniform->uniform_id,
            'new_stock_quantity' => $uniform->stock_quantity
        ]);
    
        return view('payment', [
            'uniforms' => [$uniform],
            'size' => $size,
            'quantity' => $quantity
        ]);
    }
    
    
    public function payment()
    {
        // Retrieve the purchase data from session
        $data = Session::get('payment_data');
    
        if (!$data) {
            // No data found, redirect to items page or show error
            return redirect()->route('items')->with('error', 'No payment data found.');
        }
    
        // Pass data to payment view
        return view('payment', $data);
    }
   

}