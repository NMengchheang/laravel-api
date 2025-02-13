<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $existingCartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCartItem) {
            return response()->json([
                'message' => 'Product is already in the cart',
                'cartItem' => $existingCartItem
            ], 409); // 409 Conflict
        }
        // Add new cart item
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json($cartItem, 201);
    }

    // Show all cart items for a user
    public function index()
    {
        $user = Auth::user();
        $cartItems = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'cart_items.id as cart_id',
                'cart_items.quantity',
                'products.id as product_id',
                'products.name as product_name',
                'products.price',
                'products.category_id',
                'categories.title as category_name'
            )
            ->where('cart_items.user_id', $user->id)
            ->orderBy('cart_items.created_at', 'desc')
            ->get();

        return response()->json($cartItems);
    }

    public function count()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $count = CartItem::where('user_id', $user->id)->count();
        return response()->json(['count' => $count]);
    }

    // Update quantity cart item
    public function update(Request $request, $cart_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cartItem = CartItem::where('id', $cart_id)->where('user_id', $user->id)->first();
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return response()->json($cartItem, 200);
    }

    public function destroy($cart_id)
    {
        // $user = Auth::user();
        // if (!$user) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $cartItem = CartItem::findOrFail($cart_id);
        $cartItem->delete();

        return response()->json(null, 204);
    }
}
