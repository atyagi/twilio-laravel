<?php namespace Atyagi\TwilioLaravel;

use Illuminate\Support\ServiceProvider;
use Services_Twilio;

class TwilioLaravelServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $namespace = 'twilio-laravel';
        $path = __DIR__ . '/../..';
		$this->package('atyagi/twilio-laravel', $namespace, $path);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['twilio'] = $this->app->share(function($app) {
            $client = new Services_Twilio(
                $this->app->make('config')->get('twilio-laravel::sid'),
                $this->app->make('config')->get('twilio-laravel::token')
            );
            return new TwilioClient($app, $client);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
