<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        // $products = Product::with('category')->get(); // Eager load the category relationship
        return response()->json($products, 200); //200 OK. Request successful. The server has responded as required.
    }
    public function store(Request $request) {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "price" => "required|numeric",
            "desc" => "nullable|string",
            "stock" => "required|integer",
            'category_id' => 'required|integer',
        ]);
        $product = Product::create($validated);
        // Send the new product back to the frontend. The frontend uses this response to update the state immediately.
        return response()->json($product,201); // 201 Created. A new resource was created successfully.
    }
    public function show($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "message"=> "Product not found"
            ],404);
        }

        return response()->json($product,200);
    }
    public function update(Request $request, $id) {
        $product = Product::find($id);
        // $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
