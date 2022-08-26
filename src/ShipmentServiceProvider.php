<?php

namespace WalkerChiu\Shipment;

use Illuminate\Support\ServiceProvider;

class ShipmentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
           __DIR__ .'/config/shipment.php' => config_path('wk-shipment.php'),
        ], 'config');

        // Publish migration files
        $from = __DIR__ .'/database/migrations/';
        $to   = database_path('migrations') .'/';
        $this->publishes([
            $from .'create_wk_shipment_table.php'
                => $to .date('Y_m_d_His', time()) .'_create_wk_shipment_table.php'
        ], 'migrations');

        $this->loadTranslationsFrom(__DIR__.'/translations', 'php-shipment');
        $this->publishes([
            __DIR__.'/translations' => resource_path('lang/vendor/php-shipment'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                config('wk-shipment.command.cleaner')
            ]);
        }

        config('wk-core.class.shipment.shipment')::observe(config('wk-core.class.shipment.shipmentObserver'));
        config('wk-core.class.shipment.shipmentLang')::observe(config('wk-core.class.shipment.shipmentLangObserver'));
        config('wk-core.class.shipment.shipany')::observe(config('wk-core.class.shipment.shipanyObserver'));
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    private function bladeDirectives()
    {
    }

    /**
     * Merges user's and package's configs.
     *
     * @return void
     */
    private function mergeConfig()
    {
        if (!config()->has('wk-shipment')) {
            $this->mergeConfigFrom(
                __DIR__ .'/config/shipment.php', 'wk-shipment'
            );
        }

        $this->mergeConfigFrom(
            __DIR__ .'/config/shipment.php', 'shipment'
        );
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param String  $path
     * @param String  $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        if (
            !(
                $this->app instanceof CachesConfiguration
                && $this->app->configurationIsCached()
            )
        ) {
            $config = $this->app->make('config');
            $content = $config->get($key, []);

            $config->set($key, array_merge(
                require $path, $content
            ));
        }
    }
}
