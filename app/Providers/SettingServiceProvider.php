<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Bind the Setting Model
        $this->app->bind('settings', function ($app) {
            return new Setting();
        });
        // Using AliasLoader, register it as a facade.
        $loader = AliasLoader::getInstance();
        $loader->alias('Setting', Setting::class);
    }

    public function boot()
    {
        // Check if the App is runnign in Console and If the table exists with the name settings.
        if (!\App::runningInConsole() && count(Schema::getColumnListing('settings'))) {
            $settings = Setting::all();
            foreach ($settings as $key => $setting) {
                Config::set('settings.' . $setting->key, $setting->value);
            }
        }
    }
}
