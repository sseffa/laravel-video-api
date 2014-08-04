<?php namespace Sseffa\VideoApi;

use Illuminate\Support\ServiceProvider;

/**
 * Class VideoApiServiceProvider
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
class VideoApiServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->package('sseffa/video-api');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $this->app['video-api'] = $this->app->share(function () {

            return new VideoApi();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return array("video-api");
    }
}
