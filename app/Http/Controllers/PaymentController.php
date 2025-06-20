<?php

namespace App\Http\Controllers;

use App\Models\UniformModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showPayment(Request $request)
    {

        // Get items from request (array of {uniform_id, size, quantity})
        $items = $request->input('items', []);
        $fromCart = $request->input('from_cart', 0);
        $paymentMethod = $request->input('payment_method', 'gcash');

        // Handle single item checkout (backward compatibility or direct buy)
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
}