<?php

namespace App\Providers;

use App\CPU\Helpers;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path().'/CPU/helpers.php';
        if ($this->app->isLocal()) {
            $this->app->register(\Amirami\Localizator\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });

        try {
            $web = BusinessSetting::all();
            $settings = Helpers::get_settings($web, 'colors');
            $data = json_decode($settings['value'], true);
            $web_config = [
                'primary_color' => $data['primary'],
                'secondary_color' => $data['secondary'],
                'name' => Helpers::get_settings($web, 'company_name'),
                'phone' => Helpers::get_settings($web, 'company_phone'),
                'web_logo' => Helpers::get_settings($web, 'company_web_logo'),
                'flash_banner' => Helpers::get_settings($web, 'flash_sale_banner'),
                'mob_logo' => Helpers::get_settings($web, 'company_mobile_logo'),
                'fav_icon' => Helpers::get_settings($web, 'company_fav_icon'),
                'email' => Helpers::get_settings($web, 'company_email'),
                'about' => Helpers::get_settings($web, 'about_us'),
                'footer_logo' => Helpers::get_settings($web, 'company_footer_logo'),
                'copyright_text' => Helpers::get_settings($web, 'company_copyright_text'),
            ];

            //     //language
            $language = BusinessSetting::where('type', 'language')->first();

            //     //currency
            //     \App\CPU\Helpers::currency_load();

            View::share(['web_config' => $web_config, 'language' => $language]);

            Schema::defaultStringLength(191);
        } catch (\Exception $ex) {
        }
    }
}
