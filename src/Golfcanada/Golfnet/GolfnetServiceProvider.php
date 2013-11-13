<?php namespace Golfcanada\Golfnet;

use Illuminate\Support\ServiceProvider;

class GolfnetServiceProvider extends ServiceProvider {

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
		$this->package('golfcanada/golfnet');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerSdata();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('golfnet');
	}

	public function registerSdata()
	{
		$this->app['golfnet'] = $this->app->share(function($app)
		{
			return new Golfnet( new Sdata );
		});
	}

}