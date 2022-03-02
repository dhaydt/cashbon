<?php

namespace App\Http\Controllers\admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Project;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $admin = Admin::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $admin = Admin::get();
        }

        session()->put('title', 'Admin list');
        $admin = $admin->last()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.admin.list', compact('admin', 'search'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Nama pekerja dibutuhkan!',
            'phone.required' => 'Hp pekerja dibutuhkan!',
        ]);

        $check = Customer::where('phone', $request['phone'])->first();
        if (isset($check)) {
            Toastr::error('No Handphone sudah digunakan!');

            return redirect()->route('admin.userCustomer');
        }

        $data = new Customer();
        $data->name = $request['name'];
        $data->project = json_encode([]);
        $data->phone = $request['phone'];
        $data->password = bcrypt('12345678');
        $data->save();

        Toastr::success('Pekerja berhasil ditambahkan!');

        return redirect()->route('admin.userCustomer');
    }

    public function update(Request $request)
    {
        // dd($request);
        $project = Customer::where('id', $request['id'])->first();
        $project->name = $request['name'];
        $project->phone = $request['phone'];
        $project->save();
        Toastr::success('Pekerja berhasil diubah!');

        return redirect()->route('admin.userCustomer');
    }

    public function profile()
    {
        session()->put('title', 'Profile');

        return view('admin-views.admin.profile.editAdmin');
    }

    public function adminInfo(Request $request)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        if (auth('admin')->check()) {
            Admin::where(['id' => auth('admin')->id()])->update($data);
            Toastr::info('Update data berhasil.');

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function adminPass(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);
        if ($request['password'] != $request['c_password']) {
            Toastr::error('Password tidak sama.');

            return back();
        }

        $data = [
            'password' => bcrypt($request->password),
        ];
        if (auth('admin')->check()) {
            Admin::where(['id' => auth('admin')->id()])->update($data);
            Toastr::info('Password berhasil diganti');

            return redirect()->back();
        } else {
            Toastr::error('Gagal mengganti password');

            return redirect()->back();
        }
    }

    public function adminPict(Request $request)
    {
        $img = $request->file('image');
        // dd($img);
        if (!isset($img)) {
            Toastr::error('Pilih avatar anda');
        }

        $imageName = ImageManager::update('profile/', auth('admin')->user()->image, 'png', $img);

        Admin::where('id', auth('admin')->id())->update([
            'image' => $imageName,
        ]);
    }

    public function customerList(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $admin = Customer::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $admin = new Customer();
        }

        session()->put('title', 'Daftar pekerja');
        $pro = Project::orderBy('created_at', 'DESC')->get();
        $admin = $admin->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.customer.list', compact('admin', 'search', 'pro'));
    }

    public function customerView($id)
    {
        // dd($id);
        $user = Customer::where('id', $id)->first();

        return view('admin-views.customer.view.view', compact('user'));
    }

    public function destroy(Request $request)
    {
        // dd($request);
        $data = Customer::where('id', $request['id'])->first();
        $data->delete();
        Toastr::info('Pekerja berhasil dihapus!');

        return redirect()->back();
    }
}
