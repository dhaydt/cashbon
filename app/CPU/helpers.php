<?php

namespace App\CPU;

use App\Models\Admin;
use App\Models\Approver;
use App\Models\BusinessSetting;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\App;

class Helpers
{
    public static function pagination_limit()
    {
        $pagination_limit = BusinessSetting::where('type', 'pagination_limit')->first();
        if ($pagination_limit != null) {
            return $pagination_limit->value;
        } else {
            return 25;
        }
    }

    public static function getApprover($id)
    {
        $approver = Approver::where('id', $id)->first();

        return $approver;
    }

    public static function default_lang()
    {
        if (strpos(url()->current(), '/api')) {
            $lang = App::getLocale();
        } elseif (session()->has('local')) {
            $lang = session('local');
        } else {
            $data = Helpers::get_business_settings('language');
            $code = 'en';
            $direction = 'ltr';
            foreach ($data as $ln) {
                if (array_key_exists('default', $ln) && $ln['default']) {
                    $code = $ln['code'];
                    if (array_key_exists('direction', $ln)) {
                        $direction = $ln['direction'];
                    }
                }
            }
            session()->put('local', $code);
            Session::put('direction', $direction);
            $lang = $code;
        }

        return $lang;
    }

    public static function coupon_discount($request)
    {
        $discount = 0;
        $user = Helpers::get_admin($request);
        $couponLimit = Order::where('customer_id', $user->id)
            ->where('coupon_code', $request['coupon_code'])->count();

        $coupon = Coupon::where(['code' => $request['coupon_code']])
            ->where('limit', '>', $couponLimit)
            ->where('status', '=', 1)
            ->whereDate('start_date', '<=', Carbon::parse()->toDateString())
            ->whereDate('expire_date', '>=', Carbon::parse()->toDateString())->first();

        if (isset($coupon)) {
            $total = 0;
            foreach (CartManager::get_cart(CartManager::get_cart_group_ids($request)) as $cart) {
                $product_subtotal = $cart['price'] * $cart['quantity'];
                $total += $product_subtotal;
            }
            if ($total >= $coupon['min_purchase']) {
                if ($coupon['discount_type'] == 'percentage') {
                    $discount = (($total / 100) * $coupon['discount']) > $coupon['max_discount'] ? $coupon['max_discount'] : (($total / 100) * $coupon['discount']);
                } else {
                    $discount = $coupon['discount'];
                }
            }
        }

        return $discount;
    }

    public static function currency_converter($val)
    {
        setlocale(LC_MONETARY, 'en_US');

        $price = floatval($val);

        return 'Rp. '.number_format($price);
    }

    public static function get_admin($request = null)
    {
        $user = null;
        if (auth('admin')->check()) {
            $user = auth('admin')->user(); // for web
        } elseif ($request != null && $request->user() != null) {
            $user = $request->user(); //for api
        } elseif (session()->has('admin_id')) {
            $user = Admin::find(session('admin_id'));
        }

        if ($user == null) {
            $user = 'offline';
        }

        return $user;
    }

    public static function get_customer($request = null)
    {
        $user = null;
        if (auth('customer')->check()) {
            $user = auth('customer')->user(); // for web
        } elseif ($request != null && $request->user() != null) {
            $user = $request->user(); //for api
        } elseif (session()->has('customer_id')) {
            $user = Customer::find(session('customer_id'));
        }

        if ($user == null) {
            $user = 'offline';
        }

        return $user;
    }

    public static function tax_calculation($price, $tax, $tax_type)
    {
        $amount = ($price / 100) * $tax;

        return $amount;
    }

    public static function get_product_discount($product, $price)
    {
        $discount = 0;
        if ($product->discount_type == 'percent') {
            $discount = ($price * $product->discount) / 100;
        } elseif ($product->discount_type == 'flat') {
            $discount = $product->discount;
        }

        return floatval($discount);
    }

    public static function get_shipping_methods()
    {
        $id = auth('customer')->id();
        // dd($id);
        // $user = User::find($id);
        $user = Customer::find($id);
        // dd($user);
        $to_district = 39;
        $to_type = $user->city_type;
        // $product = Product::find($product_id);
        // dd($product);
        $weight = '1';

        $from_city = '151';
        $from_type = 'Kota';
        $from_type = 'Kota';
        // $from_state = '21';
        // $ShippingMethod = ShippingMethod::where(['status' => 1])->where(['creator_id' => $seller_id, 'creator_type' => $type])->get();

        $curl = curl_init();
        // JNE
        curl_setopt_array($curl, [
            CURLOPT_URL => config('rajaongkir.url').'/cost',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS => 'origin='.$from_city.'&originType='.$from_type.'&destination='.$to_city.'&destinationType='.$to_type.'&weight='.$weight.'&courier=jne',
            CURLOPT_POSTFIELDS => 'origin='.$from_city.'&originType=city&destination='.$to_district.'&destinationType=subdistrict&weight='.$weight.'&courier=jne',
            CURLOPT_HTTPHEADER => [
                'content-type: application/x-www-form-urlencoded',
                'key:'.config('rajaongkir.api_key'),
            ],
        ]);

        $responseJne = curl_exec($curl);
        $errJne = curl_error($curl);

        curl_close($curl);

        if ($errJne) {
            echo 'cURL Error #:'.$errJne;
        } else {
            $response = json_decode($responseJne, true);
            // dd($response);
            $data_ongkir = $response['rajaongkir']['results'];
            // $data_ongkir = $response;

            // $jne = json_encode($data_ongkir);
            // dd($data_ongkir);

            // return with([$data_ongkir, $ShippingMethod]);
        }

        $curl = curl_init();
        // SICEPAT
        curl_setopt_array($curl, [
            CURLOPT_URL => config('rajaongkir.url').'/cost',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS => 'origin='.$from_city.'&originType='.$from_type.'&destination='.$to_city.'&destinationType='.$to_type.'&weight='.$weight.'&courier=jne',
            CURLOPT_POSTFIELDS => 'origin='.$from_city.'&originType=city&destination='.$to_district.'&destinationType=subdistrict&weight='.$weight.'&courier=sicepat',
            CURLOPT_HTTPHEADER => [
                'content-type: application/x-www-form-urlencoded',
                'key:'.config('rajaongkir.api_key'),
            ],
        ]);

        $responseSicepat = curl_exec($curl);
        $errSicepat = curl_error($curl);

        curl_close($curl);

        if ($errSicepat) {
            echo 'cURL Error #:'.$errSicepat;
        } else {
            $response = json_decode($responseSicepat, true);
            $sicepat = $response['rajaongkir']['results'];
            // $data_ongkir = $response;

            // $jne = json_encode($data_ongkir);
            // dd($sicepat);

            // return with([$data_ongkir, $ShippingMethod]);
        }

        // TIKI
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => config('rajaongkir.url').'/cost',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'origin='.$from_city.'&originType=city&destination='.$to_district.'&destinationType=subdistrict&weight='.$weight.'&courier=tiki',
            CURLOPT_HTTPHEADER => [
                'content-type: application/x-www-form-urlencoded',
                'key:'.config('rajaongkir.api_key'),
            ],
        ]);

        $responseTiki = curl_exec($curl);
        $errTiki = curl_error($curl);

        curl_close($curl);

        if ($errTiki) {
            echo 'cURL Error #:'.$errTiki;
        } else {
            $response = json_decode($responseTiki, true);
            $tiki = $response['rajaongkir']['results'];

            // $jne = json_encode($data_ongkir);
            // dd($data_ongkir);

            return with([[$data_ongkir, $tiki, $sicepat]]);
        }
    }

    public static function get_settings($object, $type)
    {
        $config = null;
        foreach ($object as $setting) {
            if ($setting['type'] == $type) {
                $config = $setting;
            }
        }

        return $config;
    }

    public static function get_business_settings($name)
    {
        $config = null;
        $check = ['currency_model', 'currency_symbol_position', 'system_default_currency', 'language', 'company_name'];

        if (in_array($name, $check) == true && session()->has($name)) {
            $config = session($name);
        } else {
            $data = BusinessSetting::where(['type' => $name])->first();
            if (isset($data)) {
                $config = json_decode($data['value'], true);
                if (is_null($config)) {
                    $config = $data['value'];
                }
            }

            if (in_array($name, $check) == true) {
                session()->put($name, $config);
            }
        }

        return $config;
    }

    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', $str);
    }

    public function translate($key)
    {
        $local = Helpers::default_lang();
        App::setLocale($local);

        $lang_array = include base_path('resources/lang/'.$local.'/messages.php');
        $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));

        if (!array_key_exists($key, $lang_array)) {
            $lang_array[$key] = $processed_key;
            $str = '<?php return '.var_export($lang_array, true).';';
            file_put_contents(base_path('resources/lang/'.$local.'/messages.php'), $str);
            $result = $processed_key;
        } else {
            $result = __('messages.'.$key);
        }

        return $result;
    }

    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }

        return $err_keeper;
    }

    public static function send_push_notif_to_device($fcm_token, $data)
    {
        // dd($data);
        $key = 'AAAAhmPgxWA:APA91bGLrQAAoOPWqt3ZUWz2H3LwTbkhTaFYYh0gq3lFhSy5sDg98SFyIXF3uz9r44Wb3bFXQTbmIGcOzHFOz4SAgyUeyfqZJROFLsP_DLb37CaPBRqytM25Y8HpDgIsTcQNDZcJj1HB';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $header = ['authorization: key='.$key.'',
            'content-type: application/json',
        ];

        $postdata = '{
            "to" : "'.$fcm_token.'",
            "data" : {
                "title" :"'.$data['project'].'",
                "body" : "'.$data['pekerjaan'].'",
                "status" : "'.$data['status'].'",
                "nilai":"'.$data['dipinjamkan'].'",
                "is_read": 0
            },
            "notification" : {
                "title" :"'.$data['project'].'",
                "body" : "'.$data['pekerjaan'].'",
                "status" : "'.$data['status'].'",
                "nilai":"'.$data['dipinjamkan'].'",
                "is_read": 0,
                "icon" : "new",
                "sound" : "default"
            }
        }';

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Get URL content
        $result = curl_exec($ch);
        // close handle to release resources
        curl_close($ch);

        return $result;
    }
}
