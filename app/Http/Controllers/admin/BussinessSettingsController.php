<?php

namespace App\Http\Controllers\admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BussinessSettingsController extends Controller
{
    public function companyInfo()
    {
        $company_name = BusinessSetting::where('type', 'company_name')->first();
        $company_email = BusinessSetting::where('type', 'company_email')->first();
        $company_phone = BusinessSetting::where('type', 'company_phone')->first();

        return view('admin-views.business-settings.website-info', [
            'company_name' => $company_name,
            'company_email' => $company_email,
            'company_phone' => $company_phone,
        ]);
    }

    public function updateInfo(Request $request)
    {
        if ($request['email_verification'] == 1) {
            $request['phone_verification'] = 0;
        } elseif ($request['phone_verification'] == 1) {
            $request['email_verification'] = 0;
        }

        //comapy shop banner
        $imgBanner = BusinessSetting::where(['type' => 'shop_banner'])->first();
        if ($request->has('shop_banner')) {
            $imgBanner = ImageManager::update('shop/', $imgBanner, 'png', $request->file('shop_banner'));
            DB::table('business_settings')->updateOrInsert(['type' => 'shop_banner'], [
                'value' => $imgBanner,
            ]);
        }
        // comapny name
        DB::table('business_settings')->updateOrInsert(['type' => 'company_name'], [
            'value' => $request['company_name'],
        ]);
        // company email
        DB::table('business_settings')->updateOrInsert(['type' => 'company_email'], [
            'value' => $request['company_email'],
        ]);
        // company Phone
        DB::table('business_settings')->updateOrInsert(['type' => 'company_phone'], [
            'value' => $request['company_phone'],
        ]);
        //company copy right text
        // DB::table('business_settings')->updateOrInsert(['type' => 'company_copyright_text'], [
        //     'value' => $request['company_copyright_text'],
        // ]);
        //company time zone
        DB::table('business_settings')->updateOrInsert(['type' => 'timezone'], [
            'value' => $request['timezone'],
        ]);
        //country
        DB::table('business_settings')->updateOrInsert(['type' => 'country_code'], [
            'value' => $request['country'],
        ]);
        //phone verification
        // DB::table('business_settings')->updateOrInsert(['type' => 'phone_verification'], [
        //     'value' => $request['phone_verification'],
        // ]);
        //email verification
        // DB::table('business_settings')->updateOrInsert(['type' => 'email_verification'], [
        //     'value' => $request['email_verification'],
        // ]);

        // DB::table('business_settings')->updateOrInsert(['type' => 'order_verification'], [
        //     'value' => $request['order_verification'],
        // ]);

        // DB::table('business_settings')->updateOrInsert(['type' => 'forgot_password_verification'], [
        //     'value' => $request['forgot_password_verification'],
        // ]);

        //web logo
        $webLogo = BusinessSetting::where(['type' => 'company_web_logo'])->first();
        if ($request->has('company_web_logo')) {
            $webLogo = ImageManager::update('company/', $webLogo, 'png', $request->file('company_web_logo'));
            BusinessSetting::where(['type' => 'company_web_logo'])->update([
                'value' => $webLogo,
            ]);
        }

        //mobile logo
        $mobileLogo = BusinessSetting::where(['type' => 'company_mobile_logo'])->first();
        if ($request->has('company_mobile_logo')) {
            $mobileLogo = ImageManager::update('company/', $mobileLogo, 'png', $request->file('company_mobile_logo'));
            BusinessSetting::where(['type' => 'company_mobile_logo'])->update([
                'value' => $mobileLogo,
            ]);
        }

        //Flash Deal Banner
        $flashDeal = BusinessSetting::where(['type' => 'flash_sale_banner'])->first();
        if ($request->has('flash_sale_banner')) {
            $flashDeal = ImageManager::update('company/', $flashDeal, 'png', $request->file('flash_sale_banner'));
            BusinessSetting::where(['type' => 'flash_sale_banner'])->update([
                'value' => $flashDeal,
            ]);
        }
        //web footer logo
        $webFooterLogo = BusinessSetting::where(['type' => 'company_footer_logo'])->first();
        if ($request->has('company_footer_logo')) {
            $webFooterLogo = ImageManager::update('company/', $webFooterLogo, 'png', $request->file('company_footer_logo'));
            BusinessSetting::where(['type' => 'company_footer_logo'])->update([
                'value' => $webFooterLogo,
            ]);
        }
        //fav icon
        $favIcon = BusinessSetting::where(['type' => 'company_fav_icon'])->first();
        if ($request->has('company_fav_icon')) {
            $favIcon = ImageManager::update('company/', $favIcon, 'png', $request->file('company_fav_icon'));
            BusinessSetting::where(['type' => 'company_fav_icon'])->update([
                'value' => $favIcon,
            ]);
        }

        //loader gif
        $loader_gif = BusinessSetting::where(['type' => 'loader_gif'])->first();
        if ($request->has('loader_gif')) {
            $loader_gif = ImageManager::update('company/', $loader_gif, 'png', $request->file('loader_gif'));
            BusinessSetting::updateOrInsert(['type' => 'loader_gif'], [
                'value' => $loader_gif,
            ]);
        }
        // web color setup
        $colors = BusinessSetting::where('type', 'colors')->first();
        if (isset($colors)) {
            BusinessSetting::where('type', 'colors')->update([
                'value' => json_encode(
                    [
                        'primary' => $request['primary'],
                        'secondary' => $request['secondary'],
                    ]),
            ]);
        } else {
            DB::table('business_settings')->insert([
                'type' => 'colors',
                'value' => json_encode(
                    [
                        'primary' => $request['primary'],
                        'secondary' => $request['secondary'],
                    ]),
            ]);
        }

        //pagination
        $request->validate([
            'pagination_limit' => 'numeric',
        ]);
        DB::table('business_settings')->updateOrInsert(['type' => 'pagination_limit'], [
            'value' => $request['pagination_limit'],
        ]);

        Toastr::success('Updated successfully');

        return back();
    }

    public function update_colors()
    {
    }

    public function updateCompany(Request $data)
    {
        dd($data);
    }

    public function updateCompanyEmail(Request $data)
    {
        dd($data);
    }

    public function updateCompanyPhone(Request $data)
    {
        dd($data);
    }

    public function uploadWebLogo(Request $data)
    {
        dd($data);
    }

    public function uploadMobileLogo(Request $data)
    {
        dd($data);
    }

    public function uploadFooterLogo(Request $data)
    {
        dd($data);
    }

    public function uploadFavIcon(Request $data)
    {
        dd($data);
    }
}
