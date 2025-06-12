<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;   // for authentication
use App\Models\UniformModel;
use App\Models\OrderHistoryModel;
use App\Models\CartsModel;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\StudentModel;
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
        $student = null;

        if (auth()->check()) {
            $student = auth()->user()->student; // Only access if logged in
        }

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
     * Process buy now request
     */
    public function checkout(Request $request, $uniform_id = null)
    {
        Log::info('Checkout initiated.', ['uniform_id' => $uniform_id]);

        if (!$uniform_id) {
            Log::error('Checkout failed: No uniform ID provided.');
            return redirect()->route('items')->with('error', 'No uniform selected.');
        }

        $uniform = UniformModel::where('uniform_id', $uniform_id)->first();

        if (!$uniform) {
            Log::error('Checkout failed: Uniform not found.', ['uniform_id' => $uniform_id]);
            return redirect()->route('items')->with('error', 'Uniform not found.');
        }

        $size = $request->input('size');
        $quantity = $request->input('quantity', 1);
        $paymentMethod = $request->input('payment_method', 'gcash');

        Log::info('Uniform found, proceeding to checkout.', [
            'uniform_id' => $uniform_id,
            'size' => $size,
            'quantity' => $quantity,
            'payment_method' => $paymentMethod,
        ]);

        return view('payment', [
            'uniforms' => [$uniform],
            'size' => $size,
            'quantity' => $quantity,
            'payment_method' => $paymentMethod
        ]);
    }
    public function buyNow(Request $request, $uniform_id)
    {
        Log::info('Form uniform_id', ['uniform_id' => $request->uniform_id]);
        Log::info('Route uniform_id', ['uniform_id' => $uniform_id]);

        Log::info('buyNow method called', [
            'uniform_id' => $uniform_id,
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        if (!Auth::check()) {
            Log::warning("Unauthenticated user attempted to access buyNow");
            return redirect()->route('web.login')->withErrors(['error' => 'Please log in to proceed with your order.']);
        }

        $uniform = UniformModel::where('uniform_id', $uniform_id)->first();

        if (!$uniform) {
            Log::error("Uniform not found for uniform_id: {$uniform_id}");
            abort(404, "Uniform not found");
        }

        $size = $request->input('size');
        $quantity = $request->input('quantity', 1);
        $paymentMethod = $request->input('payment_method', 'gcash'); // Default to gcash if not provided

        // Validate payment method
        if (!in_array($paymentMethod, ['gcash', 'facetoface'])) {
            Log::error("Invalid payment method: {$paymentMethod}");
            return back()->withErrors(['error' => 'Invalid payment method selected.']);
        }

        $userId = Auth::id();
        $student = StudentModel::where('user_id', $userId)->first();

        if (!$student) {
            Log::error("Student not found for user_id: {$userId}");
            return back()->withErrors(['error' => 'Student record not found.']);
        }

        $studentId = $student->student_id;

        $totalPrice = $uniform->price * $quantity;

        $order = OrderModel::create([
            'student_id' => $studentId,
            'total_price' => $totalPrice,
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'order_date' => Carbon::now(),
        ]);

        Log::info('Order created', ['order_id' => $order->order_id, 'payment_method' => $paymentMethod]);

        $subtotalPrice = $uniform->price * $quantity;

        OrderItemModel::create([
            'order_id' => $order->order_id,
            'uniform_id' => $uniform->uniform_id,
            'size' => $size,
            'quantity' => $quantity,
            'price' => $uniform->price,
            'subtotal_price' => $subtotalPrice,
        ]);

        $uniform->decrement('stock_quantity', $quantity);

        Log::info('Stock decremented', [
            'uniform_id' => $uniform->uniform_id,
            'new_stock_quantity' => $uniform->stock_quantity
        ]);

        // Insert initial status history
        OrderHistoryModel::create([
            'order_id' => $order->order_id,
            'status' => 'pending',
            'updated_at' => now(),
            'updated_by' => $userId
        ]);

        Log::info('Initial status history recorded', [
            'order_id' => $order->order_id,
            'status' => 'pending',
            'updated_by' => $userId
        ]);


    // ✅ Redirect to the orders page after successful purchase
    return redirect()->route('web.orders')->with('success', 'Order placed successfully!');
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
    public function addToCart(Request $request, $uniform_id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        CartsModel::create([
            'user_id' => auth()->id(),
            'uniform_id' => $uniform_id,
            'quantity' => $request->quantity,
            'size' => $request->size,
        ]);

        return back()->with('success', 'Item added to cart!');
    }

}