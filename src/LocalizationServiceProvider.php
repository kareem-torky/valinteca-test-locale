<?php

namespace Valinteca\Localization;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    public function register()
    {
        /**
         * Facades
         */
        $this->app->bind('locale', function($app) {
            return new Locale();
        });
      
        $loader = AliasLoader::getInstance();
        $loader->alias('Locale', "Valinteca\\Localization\\Facades\\Locale");

        /**
         * Config
         */
        $this->mergeConfigFrom(
            __DIR__ . '/../config/locales.php', 'locales'
        );

        /**
         * Helpers
         */
        $this->registerHelpers();
    }

    public function boot()
    {
        /**
         * Config
         */
        $this->publishes([
            __DIR__ . '/../config/locales.php' => config_path('locales.php'),
        ]);
    
        /**
         * Translations
         */
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'Localization');
 
        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/Localization'),
        ]);
    }

    private function registerHelpers()
    {
        $helperPath = __DIR__ . '/helpers.php';

        if (file_exists($helperPath)) {
            require_once $helperPath;
        }
    }
}