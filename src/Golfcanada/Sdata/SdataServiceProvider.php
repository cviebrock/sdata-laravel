<?php namespace Golfcanada\Sdata;

use Illuminate\Support\ServiceProvider;

class SdataServiceProvider extends ServiceProvider {

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
		$this->package('golfcanada/sdata');
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
		return array('sdata');
	}

	public function registerSdata()
	{
		$this->app['sdata'] = $this->app->share(function($app)
		{
			$config = $app['config']->get('sdata::config');
			return Client::factory($config);
		});
	}

}