<?php

namespace App\Http\Controllers;

use App\CPU\ImageManager;
use App\Models\Customer;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\View\View
     */
    // public function index(User $model)
    // {
    //     return view('users.index');
    // }
    public function edit()
    {
        $customer = auth('customer')->user();

        return view('web-views.profile.profileEdit', compact('customer'));
    }

    public function update(Request $request)
    {
        // $image = $request->file('image');
        $image = $request->file('image');
        // foreach ($img as $image) {
        // }
        // dd($image);

        if ($image != null) {
            $imageName = ImageManager::update('profile/', auth('customer')->user()->image, 'png', $request->image);
        } else {
            $imageName = auth('customer')->user()->image;
        }

        Customer::where('id', auth('customer')->id())->update([
             'image' => $imageName,
         ]);

        if ($request['password'] != $request['con_password']) {
            Toastr::error('Password did not match.');

            return back();
        }

        $userDetails = [
             'name' => $request->name,
             'phone' => $request->phone,
             'password' => strlen($request->password) > 5 ? bcrypt($request->password) : auth('customer')->user()->password,
         ];
        if (auth('customer')->check()) {
            Customer::where(['id' => auth('customer')->id()])->update($userDetails);
            Toastr::info('Update successfully');

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
