<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    // GET /api/cart
    public function index()
    {
        return response()->json(Cart::all());
    }

    // POST /api/cart
    public function store(Request $request)
    {
        $cart = Cart::create($request->all());
        return response()->json($cart, 201);
    }

    // PUT /api/cart/{id}
    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cart->update($request->all());
        return response()->json($cart);
    }

    // DELETE /api/cart/{id}
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cart->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
