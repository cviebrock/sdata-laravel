<?php namespace Golfcanada\Golfnet;

use Golfcanada\Sdata;

class Golfnet {

	protected $sdata;

	function _construct( Sdata $sdata )
	{
		$this->sdata = $sdata;
	}


	function getClub( $id )
	{
		$req = $this->sdata->get('accounts("'.$id.'")');
		$rsp = $req->send();
		return $req->json();
	}


}