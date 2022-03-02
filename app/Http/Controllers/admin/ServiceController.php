<?php

namespace App\Http\Controllers\admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $admin = Service::get();

        session()->put('title', 'Service');
        $last = $admin->last();
        if (isset($last)) {
            $admin = $admin->last()->paginate(Helpers::pagination_limit());
        }

        return view('admin-views.service.listService', compact('admin'));
    }

    public function add()
    {
        return view('admin-views.service.addService');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'images' => 'required',
            'image' => 'required',
            'price' => 'required|numeric|min:1',
        ], [
            'images.required' => 'Product images is required!',
        ]);

        $p = new Service();
        // $p->user_id = 1;
        // $p->added_by = 'admin';
        $p->name = $request->name[array_search('en', $request->lang)];

        $p->details = $request->description[array_search('en', $request->lang)];

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('service/', 'png', $img);
            }
            $p->images = json_encode($product_images);
        }
        $p->thumbnail = ImageManager::upload('service/thumbnail/', 'png', $request->image);

        //combinations end
        // $p->variation = json_encode($variations);
        // $p->unit_price = BackEndHelper::currency_to_usd($request->unit_price);
        $p->price = $request->price;
        // $p->purchase_price = BackEndHelper::currency_to_usd($request->purchase_price);
        // $p->purchase_price = $request->purchase_price;
        // $p->tax = $request->tax_type == 'flat' ? $request->tax : $request->tax;
        // $p->tax_type = $request->tax_type;
        // $p->label = $request->label;
        // $p->discount = $request->discount_type == 'flat' ? $request->discount : $request->discount;
        // $p->discount_type = $request->discount_type;
        // $p->attributes = json_encode($request->choice_attributes);
        // $p->current_stock = abs($stock_count);

        // $p->meta_title = $request->meta_title;
        // $p->meta_description = $request->meta_description;
        // $p->meta_image = ImageManager::upload('product/meta/', 'png', $request->meta_image);

        // $p->video_provider = 'youtube';
        // $p->video_url = $request->video_link;
        $p->status = 1;

        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            $p->save();

            $data = [];
            foreach ($request->lang as $index => $key) {
                if ($request->name[$index] && $key != 'en') {
                    array_push($data, [
                        'translationable_type' => 'App\Model\Product',
                        'translationable_id' => $p->id,
                        'locale' => $key,
                        'key' => 'name',
                        'value' => $request->name[$index],
                    ]);
                }
                if ($request->description[$index] && $key != 'en') {
                    array_push($data, [
                        'translationable_type' => 'App\Model\Product',
                        'translationable_id' => $p->id,
                        'locale' => $key,
                        'key' => 'description',
                        'value' => $request->description[$index],
                    ]);
                }
            }
            // Translation::insert($data);

            Toastr::success('Service Berhasil dittambahkan!');

            return redirect()->route('admin.listService');
        }
    }

    public function updateStatus(Request $request)
    {
        $product = Service::where(['id' => $request['id']])->first();
        $success = 1;
        if ($request['status'] == 1) {
            if ($product->added_by == 'seller' && $product->request_status == 0) {
                $success = 0;
            } else {
                $product->status = $request['status'];
            }
        } else {
            $product->status = $request['status'];
        }
        $product->save();

        return response()->json([
            'success' => $success,
        ], 200);
    }

    public function edit($id)
    {
        $product = Service::find($id);

        return view('admin-views.service.editService', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'unit_price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Product name is required!',
        ]);

        $product = Service::find($id);
        $product->name = $request->name[array_search('en', $request->lang)];

        $product->details = $request->description[array_search('en', $request->lang)];
        $product_images = json_decode($product->images);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('service/', 'png', $img);
            }
            $product->images = json_encode($product_images);
        }

        $product->price = $request->unit_price;

        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            $product->save();

            Toastr::success('Product updated successfully.');

            return back();
        }
    }

    public function delete($id)
    {
        $product = Service::find($id);
        foreach (json_decode($product['images'], true) as $image) {
            ImageManager::delete('/service/'.$image);
        }
        // ImageManager::delete('/service/thumbnail/'.$product['thumbnail']);
        $product->delete();
        // FlashDealProduct::where(['product_id' => $id])->delete();
        // DealOfTheDay::where(['product_id' => $id])->delete();
        Toastr::success('Service removed successfully!');

        return back();
    }
}
