<?php
namespace Greatsami\Mobilyws;

use Illuminate\Support\ServiceProvider;


class MobilywsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/config/mobilyws.php', 'mobilyws');
        if(!file_exists(config_path('mobilyws.php'))) {
            $this->publishes([__DIR__ . '/config/mobilyws.php' => config_path('mobilyws.php')]);
        }

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'mobilyws');
        if(!file_exists(resource_path('lang/en/mobilyws.php'))) {
            $this->publishes([__DIR__ . '/resources/lang/en' => resource_path('lang/en')]);
            $this->publishes([__DIR__ . '/resources/lang/ar' => resource_path('lang/ar')]);
        }

    }

    public function register()
    {
        $this->app->singleton('mobilyws',function($app) {
            return new Mobilyws();
        });
    }

}
