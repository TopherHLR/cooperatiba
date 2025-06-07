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
            Log::info('Fetched uniforms for product catalog', ['count' => $uniforms->count()]);
            return view('productcatalog', compact('uniforms'));
        } catch (\Exception $e) {
            Log::error('Error fetching uniforms: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load product catalog.');
        }
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
            'size' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('images/clothes/uniforms', 'public');

        $uniform = UniformModel::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'size' => $request->size,
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

    public function update(Request $request, $id)    
    {
        Log::info('Update method triggered.');
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'size' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        Log::info('Validation passed.', $validated);

            // Fetch the uniform by ID, throw 404 if not found
        $uniform = UniformModel::findOrFail($id);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'size' => $request->size,
            'description' => $request->description,
        ];
    
        if ($request->hasFile('image')) {
            Log::info('New image uploaded.');
    
            if ($uniform->image_url) {
                $oldImagePath = str_replace('/storage', '', parse_url($uniform->image_url, PHP_URL_PATH));
                Storage::disk('public')->delete($oldImagePath);
                Log::info('Old image deleted: ' . $oldImagePath);
            }
    
            $imagePath = $request->file('image')->store('uniforms', 'public');
            $data['image_url'] = Storage::url($imagePath);
            Log::info('New image stored: ' . $data['image_url']);
        }
    
        $uniform->update($data);
    
        Log::info('Uniform updated successfully.');
    
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