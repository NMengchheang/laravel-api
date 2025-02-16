<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        // $products = Product::with('category')->get(); // Eager load the category relationship
        return response()->json($users, 200); //200 OK. Request successful. The server has responded as required.
    }
    public function show($id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "message"=> "Category not found"
            ],404);
        }

        return response()->json($user,200);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'role' => 'sometimes|string',
            'status' => 'sometimes|string',
            'phone' => 'sometimes|string',
        ]);
        $user->update($validated);
        return response()->json([
            'user' => $user,
            'message' => 'User updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
