<?php namespace Cviebrock\Sdata\Facades;

use Illuminate\Support\Facades\Facade;


class Sdata extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'sdata';
	}

}
