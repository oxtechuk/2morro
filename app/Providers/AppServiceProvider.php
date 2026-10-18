<?php

namespace App\Providers;

use App\Enums\OrderStatus;
use App\Enums\Roles;
use App\Models\GeneraleSetting;
use App\Models\Order;
use App\Models\User;
use App\Repositories\LanguageRepository;
use App\Repositories\ThemeColorRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');

        if (file_exists(app_path('helpers.php'))) {
            require_once app_path('helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(request()->ip() != '127.0.0.1'){
            Schema::defaultStringLength(191);
            if (!file_exists(base_path('storage/installed')) && !request()->is('install') && !request()->is('install/*')) {
                header("Location: install");
                exit;
            }
        }

        view()->composer('*', function ($view) {
            $languages = (class_exists(LanguageRepository::class) && Schema::hasTable('languages'))
                ? LanguageRepository::getAll()
                : collect([
                    (object)['id' => 1, 'name' => 'ar', 'title' => 'العربية'],
                    (object)['id' => 2, 'name' => 'en', 'title' => 'English'],
                ]);
            $setting = function_exists('generaleSetting') ? generaleSetting('setting') : null;
            $view->with('languages', $languages);
            $view->with('generaleSetting', $setting);
        });
    }
}
