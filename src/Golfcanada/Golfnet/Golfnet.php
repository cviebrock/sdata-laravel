<?php namespace Golfcanada\Golfnet;

use Golfcanada\Sdata;

class Golfnet {

	protected $sdata;

	function _construct( Sdata $sdata )
	{
		$this->sdata = $sdata;
	}

}