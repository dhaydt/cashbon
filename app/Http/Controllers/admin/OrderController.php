<?php

namespace App\Http\Controllers\admin;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $product = Product::active()->get();
        session()->put('title', 'Manual Order');
        $service = Service::get();

        return view('admin-views.order.manualOrder', compact('product', 'service'));
    }

    public function listOrder(Request $request, $status)
    {
        $orders = Order::where('type', 'service')->get();
        session()->put('title', 'Service Ordered');

        return view('admin-views.order.service.list', compact('orders'));
    }

    public function list(Request $request, $status)
    {
        $orders = Order::where('type', 'product')->get();
        session()->put('title', 'Product Ordered');

        return view('admin-views.order.list', compact('orders'));

        $query_param = [];
        $search = $request['search'];
        // dd($request);
        $start = $request['start-date'];
        $end = $request['end-date'];
        if (session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1) {
            $query = Order::whereHas('details', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('added_by', 'admin');
                });
            })->with(['customer']);

            if ($status != 'all') {
                $orders = $query->where(['order_status' => $status]);
            } else {
                $orders = $query;
            }

            if ($request->has('search')) {
                $key = explode(' ', $request['search']);
                $orders = $orders->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('id', 'like', "%{$value}%")
                            ->orWhere('order_status', 'like', "%{$value}%")
                            ->orWhere('transaction_ref', 'like', "%{$value}%");
                    }
                });
                $query_param = ['search' => $request['search']];
            }

            if ($request->has('start-date')) {
                if ($start == $end) {
                    $orders = $orders->where('created_at', 'like', "%{$start}%");
                } else {
                    $orders = $orders->whereBetween('created_at', [$start, $end]);
                }
                $query_param = ['start-date' => $start, 'end-date' => $end];
            }
        } else {
            if ($status != 'all') {
                $orders = Order::with(['customer'])->where(['order_status' => $status]);
            } else {
                $orders = Order::with(['customer']);
            }

            if ($request->has('search')) {
                $key = explode(' ', $request['search']);
                $orders = $orders->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('id', 'like', "%{$value}%")
                            ->orWhere('order_status', 'like', "%{$value}%")
                            ->orWhere('transaction_ref', 'like', "%{$value}%");
                    }
                });
                $query_param = ['search' => $request['search']];
                // dd($query_param);
            }

            if ($request->has('start-date')) {
                if ($start == $end) {
                    $orders = $orders->where('created_at', 'like', "%{$start}%");
                } else {
                    $orders = $orders->whereBetween('created_at', [$start, $end]);
                }
                $query_param = ['start-date' => $start, 'end-date' => $end];
            }
        }

        $orders = $orders->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.order.list', compact('orders', 'search', 'start', 'end'));
    }

    public function addToCart(Request $request)
    {
        // dd($request->type);
        if ($request->type == 'service') {
            $cart = CartManager::add_service_cart($request);

            return response()->json($cart);
        }
        $cart = CartManager::add_to_cart($request);
        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        return response()->json($cart);
    }

    public function updateNavCart()
    {
        return response()->json(['data' => view('layouts.backend.partials.cart')->render()]);
    }

    public function shop_cart()
    {
        if (auth('admin')->check() && Cart::where(['customer_id' => auth('admin')->id()])->count() > 0) {
            $user = auth('admin')->id();
            // if (auth('customer')->user()->district == null) {
            //     // dd('no distrcit');
            //     $country = DB::table('country')->get();

            //     Toastr::warning(translate('Please fill your address first'));

            //     return view('web-views.addAddress', compact('country'));
            // }

            // $address = ShippingAddress::where('customer_id', $user)->first();

            $data = [
                'name' => 'Keranjang belanja',
            ];
            session()->put('category', $data);
            // session()->put('address_id', $address->id);

            return view('admin-views.order.shop-cart');
        }
        Toastr::info('no_items_in_basket');

        return redirect()->route('admin.order.manual');
    }

    public function removeFromCart(Request $request)
    {
        $user = Helpers::get_admin();
        // dd($user);
        // session()->forget('offline_cart');
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

    public function updateQuantity(Request $request)
    {
        $response = CartManager::update_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        if ($response['status'] == 0) {
            return response()->json($response);
        }

        return response()->json(view('admin-views.order.partials.cart_details')->render());
    }

    public function checkout_details(Request $request)
    {
        $cart_group_ids = CartManager::get_cart_group_ids();

        if (count($cart_group_ids) > 0) {
            $data = [
                'name' => 'Alamat Pengiriman',
            ];
            session()->put('category', $data);

            // app('App\Http\Controllers\admin\OrderController')->checkout_payment();
        }

        Toastr::info('no items in basket');

        return redirect('/');
    }

    public function checkout_complete(Request $request)
    {
        $cart = session()->get('cart_group_id');
        $type = Cart::where('cart_group_id', $cart)->first();
        // dd($type);
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        foreach (CartManager::get_cart_group_ids() as $group_id) {
            $data = [
                'payment_method' => 'cash',
                'order_status' => 'delivered',
                'payment_status' => 'paid',
                'type' => $type->type,
                'order_group_id' => $unique_id,
                'cart_group_id' => $group_id,
            ];
            // dd($request);
            $order_id = OrderManager::generate_order($data);
            session()->put('orderID', $order_id);
            array_push($order_ids, $order_id);
        }

        // session()->put('payment', $request['payment_method']);

        CartManager::cart_clean();

        $data = [
            'name' => 'Transaksi berhasil',
        ];
        session()->put('category', $data);

        return view('admin-views.order.checkout-complete');
    }

    public function indexService()
    {
        $product = Service::active()->get();
        session()->put('title', 'Manual Order Service');
        $service = Service::get();

        return view('admin-views.order.service.manualOrder', compact('product', 'service'));
    }
}
