<?php namespace GolfCanada\Golfnet\Facades;

use Illuminate\Support\Facades\Facade;

class Golfnet extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'golfnet';
	}

}
