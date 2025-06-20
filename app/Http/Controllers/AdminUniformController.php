<?php

namespace App\Http\Controllers;

use App\Models\Uniform;
use App\Models\UniformModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class AdminUniformController extends Controller
{
    public function index()
    {
        try {
            $uniforms = UniformModel::paginate(10);
            return view('productcatalog', compact('uniforms'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load product catalog.');
        }
    }

    public function store(Request $request)
    {
        Log::info('Entered Uniform store method.');

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'new_stock' => 'nullable|integer|min:0',
                'size' => 'required|string',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/clothes/uniforms', 'public');
            } else {
                return back()->with('error', 'Image upload failed.');
            }

            $uniform = UniformModel::create([
                'name' => $request->name,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'new_stock' => $request->new_stock ?? 0,
                'size' => $request->size,
                'description' => $request->description,
                'image_url' => Storage::url($imagePath),
            ]);

            return redirect()->route('admin.productcatalog')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing uniform product: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred while adding the product.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'new_stock' => 'nullable|integer|min:0',
            'size' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uniform = UniformModel::findOrFail($id);

        // Only use DB value + new_stock
        $updatedStock = $uniform->stock_quantity + ($request->new_stock ?? 0);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $updatedStock,
            'new_stock' => $request->new_stock ?? 0,
            'size' => $request->size,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {

            if ($uniform->image_url) {
                $oldImagePath = str_replace('/storage', '', parse_url($uniform->image_url, PHP_URL_PATH));
                Storage::disk('public')->delete($oldImagePath);

            }

            $imagePath = $request->file('image')->store('uniforms', 'public');
            $data['image_url'] = Storage::url($imagePath);

        }

        $uniform->update($data);


        return redirect()->route('admin.productcatalog')->with('success', 'Product updated successfully!');
    }

    public function destroy(UniformModel $uniform)
    {
        if ($uniform->image_url) {
            $imagePath = str_replace('/storage', '', parse_url($uniform->image_url, PHP_URL_PATH));
            Storage::disk('public')->delete($imagePath);
        }

        $uniform->delete();

        return redirect()->route('admin.productcatalog')->with('success', 'Product deleted successfully!');
    }
}