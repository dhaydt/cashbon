<?php

namespace App\Http\Controllers;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // dd($request);
        $cart = CartManager::add_to_cart($request);
        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        return response()->json($cart);
    }

    public function updateNavCart()
    {
        return response()->json(['data' => view('layouts.backend.partials.cart')->render()]);
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        $user = Helpers::get_admin();
        var_dump($user);
        if ($user == 'offline') {
            if (session()->has('offline_cart') == false) {
                session()->put('offline_cart', collect([]));
            }
            $cart = session('offline_cart');

            $new_collection = collect([]);
            foreach ($cart as $item) {
                if ($item['id'] != $request->key) {
                    $new_collection->push($item);
                }
            }

            session()->put('offline_cart', $new_collection);

            return response()->json($new_collection);
        } else {
            Cart::where(['id' => $request->key, 'customer_id' => auth('admin')->id()])->delete();
        }

        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('shipping_method_id');

        return response()->json(['data' => view('layouts.backend.partials.cart')]);
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $response = CartManager::update_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        if ($response['status'] == 0) {
            return response()->json($response);
        }

        return response()->json(view('layouts.backend.partials.cart')->render());
    }
}
