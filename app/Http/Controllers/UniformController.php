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

    public function showPayment(Request $request)
    {
        Log::info('Payment view initiated.', ['request_data' => $request->all()]);

        // Get items from request (array of {uniform_id, size, quantity})
        $items = $request->input('items', []);
        $fromCart = $request->input('from_cart', 0);
        $paymentMethod = $request->input('payment_method', 'gcash');

        // Handle single item checkout (via GET or direct buy)
        if (empty($items) && $request->has('uniform_id')) {
            $uniformId = $request->input('uniform_id');
            $size = $request->input('size');
            $quantity = $request->input('quantity', 1);

            $uniform = UniformModel::where('uniform_id', $uniformId)->first();
            if (!$uniform) {
                Log::error('Payment failed: Uniform not found.', ['uniform_id' => $uniformId]);
                return redirect()->route('items')->with('error', 'Uniform not found.');
            }

            $items = [
                [
                    'uniform_id' => $uniformId,
                    'size' => $size,
                    'quantity' => $quantity,
                ]
            ];
        }

        // Validate and process items
        if (empty($items)) {
            Log::error('Payment failed: No items provided.');
            return redirect()->route('items')->with('error', 'No items selected.');
        }

        $uniforms = [];
        $total = 0;

        foreach ($items as $item) {
            $uniform = UniformModel::where('uniform_id', $item['uniform_id'])->first();
            if (!$uniform) {
                Log::warning('Uniform not found, skipping.', ['uniform_id' => $item['uniform_id']]);
                continue;
            }

            $quantity = (int) $item['quantity'];
            $subtotal = $uniform->price * $quantity;

            $uniforms[] = [
                'uniform' => $uniform,
                'size' => $item['size'],
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        if (empty($uniforms)) {
            Log::error('Payment failed: No valid uniforms found.');
            return redirect()->route('items')->with('error', 'No valid items found.');
        }


        return view('payment', [
            'uniforms' => $uniforms,
            'total' => $total,
            'from_cart' => $fromCart,
            'payment_method' => $paymentMethod,
        ]);
    }

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

        return view('payment', [
            'uniforms' => [$uniform],
            'size' => $size,
            'quantity' => $quantity,
            'payment_method' => $paymentMethod
        ]);
    }
    public function buyNow(Request $request)
    {
        $isFromCart = $request->boolean('from_cart');

        Log::info('buyNow method called', [
            'from_cart' => $isFromCart,
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        if (!Auth::check()) {
            Log::warning("Unauthenticated user attempted to access buyNow");
            return redirect()->route('web.login')
                            ->withErrors(['error' => 'Please log in to proceed with your order.']);
        }

        $uniformIds = $request->input('uniforms', []);
        $sizes = $request->input('sizes', []);
        $quantities = $request->input('quantities', []);
        $paymentMethod = $request->input('payment_method', 'gcash');

        // Validate input arrays
        if (empty($uniformIds) || count($uniformIds) !== count($sizes) || count($sizes) !== count($quantities)) {
            Log::error('Invalid input data: Mismatched or empty arrays', [
                'uniforms_count' => count($uniformIds),
                'sizes_count' => count($sizes),
                'quantities_count' => count($quantities)
            ]);
            return back()->withErrors(['error' => 'Invalid items selected.']);
        }

        if (!in_array($paymentMethod, ['gcash', 'Face to Face'])) {
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
        $totalPrice = 0;
        $orderItems = [];

        // Process each item
        foreach ($uniformIds as $index => $uniformId) {
            $uniform = UniformModel::where('uniform_id', $uniformId)->first();
            if (!$uniform) {
                Log::warning("Uniform not found for uniform_id: {$uniformId}");
                continue; // Skip invalid uniforms
            }

            $size = $sizes[$index];
            $quantity = (int) $quantities[$index];
            $subtotal = $uniform->price * $quantity;

            $orderItems[] = [
                'uniform' => $uniform,
                'size' => $size,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];

            $totalPrice += $subtotal;
        }

        if (empty($orderItems)) {
            Log::error('No valid items to process');
            return back()->withErrors(['error' => 'No valid items found.']);
        }

        // Create order
        $order = OrderModel::create([
            'student_id' => $studentId,
            'total_price' => $totalPrice,
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'order_date' => Carbon::now(),
        ]);

        Log::info('Order created', [
            'order_id' => $order->order_id,
            'payment_method' => $paymentMethod,
            'total_price' => $totalPrice
        ]);

        // Create order items and update stock
        foreach ($orderItems as $item) {
            OrderItemModel::create([
                'order_id' => $order->order_id,
                'uniform_id' => $item['uniform']->uniform_id,
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'price' => $item['uniform']->price,
                'subtotal_price' => $item['subtotal'],
            ]);

            $item['uniform']->decrement('stock_quantity', $item['quantity']);

        }

        // Record order history
        OrderHistoryModel::create([
            'order_id' => $order->order_id,
            'status' => 'pending',
            'updated_at' => now(),
            'updated_by' => $userId
        ]);

        // Remove items from cart if from_cart
        if ($isFromCart) {

            foreach ($orderItems as $item) {
                CartsModel::where('user_id', $userId)
                    ->where('uniform_id', $item['uniform']->uniform_id)
                    ->where('size', $item['size'])
                    ->delete();

                Log::info('Cart item removed', [
                    'uniform_id' => $item['uniform']->uniform_id,
                    'size' => $item['size']
                ]);
            }
        }

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
    public function fetchCartItems()
    {
        $cartItems = CartsModel::with('uniform')
            ->where('user_id', auth()->id())
            ->get();

        // Log each cart item and its related uniform
        foreach ($cartItems as $item) {
            Log::info('Cart Item', [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'uniform_id' => $item->uniform_id,
                'quantity' => $item->quantity,
                'uniform_exists' => $item->uniform ? true : false,
                'price' => optional($item->uniform)->price,
            ]);
        }

        return response()->json($cartItems);
    }

    public function remove($id)
    {
        $deleted = CartsModel::where('id', $id)->where('user_id', auth()->id())->delete();
        Log::info('Cart item removed', [
            'id' => $id,
            'deleted' => $deleted,
            'user_id' => auth()->id()
        ]);
        return response()->json(['success' => true]);
    }
}