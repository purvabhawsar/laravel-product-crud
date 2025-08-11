<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductImage;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('images')->get();
        return view('products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');

    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Create Product
        $product = Product::create([
            'name'  => $request->name,
            'price' => $request->price
        ]);

        // Store Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product created successfully!');
    }


    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    $product = Product::with('images')->findOrFail($id);
    return view('products.show', compact('product'));
}


    /**
     * Show the form for editing the specified resource.
     */
public function edit($id)
{
    $product = Product::with('images')->findOrFail($id);
    return view('products.edit', compact('product'));
}





    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $product->update([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    // Handle deleting old images
    if ($request->has('delete_images')) {
        foreach ($request->delete_images as $imageId) {
            $image = ProductImage::find($imageId);
            if ($image) {
                Storage::delete($image->image_path);
                $image->delete();
            }
        }
    }

    // Handle uploading new images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path
            ]);
        }
    }

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}

public function deleteImage($id)
{
    $image = ProductImage::findOrFail($id);

    // Delete from storage
    if (\Storage::exists($image->image_path)) {
        \Storage::delete($image->image_path);
    }

    $image->delete();

    return response()->json(['success' => true]);
}




    /**
     * Remove the specified resource from storage.
     */
 public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
}


public function apiIndex()
{
    return response()->json(Product::all());
}

public function apiShow($id)
{
    $product = Product::find($id);
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }
    return response()->json($product);
}




}
