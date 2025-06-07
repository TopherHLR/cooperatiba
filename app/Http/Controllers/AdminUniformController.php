<?php

namespace App\Http\Controllers;

use App\Models\Uniform;
use App\Models\UniformModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUniformController extends Controller
{
    public function index()
    {
        $uniforms = UniformModel::paginate(10);
        return view('productcatalog', compact('uniforms'));
    }

    public function create()
    {
        // Your view already handles this with the modal
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sizes' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('uniforms', 'public');

        $uniform = UniformModel::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'sizes' => $request->sizes,
            'description' => $request->description,
            'image_url' => Storage::url($imagePath),
        ]);

        return redirect()->route('admin.productcatalog')->with('success', 'Product added successfully!');
    }

    public function show(UniformModel $uniform)
    {
        // Not needed for your current implementation
    }

    public function edit(UniformModel $uniform)
    {
        // Your view already handles this with the modal
    }

    public function update(Request $request, UniformModel $uniform)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sizes' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'sizes' => $request->sizes,
            'description' => $request->description,
        ];

        // Handle image update if new image is provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($uniform->image_url) {
                $oldImagePath = str_replace('/storage', '', parse_url($uniform->image_url, PHP_URL_PATH));
                Storage::disk('public')->delete($oldImagePath);
            }

            // Store new image
            $imagePath = $request->file('image')->store('uniforms', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $uniform->update($data);

        return redirect()->route('admin.productcatalog')->with('success', 'Product updated successfully!');
    }

    public function destroy(UniformModel $uniform)
    {
        // Delete associated image
        if ($uniform->image_url) {
            $imagePath = str_replace('/storage', '', parse_url($uniform->image_url, PHP_URL_PATH));
            Storage::disk('public')->delete($imagePath);
        }

        $uniform->delete();

        return redirect()->route('admin.productcatalog')->with('success', 'Product deleted successfully!');
    }
}