<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        // $categories = Category::paginate(4); // Returns 10 categories per page
        $categories = Category::all();
        return response()->json($categories, 200); //200 OK. Request successful. The server has responded as required.
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "desc" => "nullable|string",
        ]);
        $category = Category::create($validated);
        return response()->json($category,201);
    }

    public function show($id) {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message"=> "Category not found"
            ],404);
        }

        return response()->json($category,200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $category->update($validated);
        return response()->json([
            $category,
            'message' => 'Category updated successfully',
        ], 200);
    }
}
