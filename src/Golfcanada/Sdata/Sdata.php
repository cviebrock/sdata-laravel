<?php namespace Golfcanada\Sdata;

use Guzzle\Common\Collection;
use Guzzle\Common\Event;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Cviebrock\Guzzle\Plugin\StripBom\StripBomPlugin;

class Sdata extends Client {

	public static function factory( $config = array() )
  {

		// The following values are required when creating the client
		$required = array(
			'base_url',
			'username',
			'password',
		);

    // Merge in default settings and validate the config
    $config = Collection::fromConfig($config, array(), $required);

    // Create a new sData client
    $client = new self($config->get('base_url'), $config);

    // JSON by default
		$client->setDefaultOption('query/format', 'json');

		// Authentication
		$client->setDefaultOption('auth', array( $config->get('username'), $config->get('password'), 'Basic' ) );

    // Strip the BOM from results
    $client->addSubscriber( new StripBomPlugin() );

    // Optional logging
		if ( $config->get('log') )
		{
			$client->getEventDispatcher()->addListener('request.before_send', function(Event $event) {
				$req = $event['request'];
				\Log::info('sData', [
					'request'=>$req->getMethod() . ' ' . $req->getResource()
				]);
			});
		}

		// Set the service description
		$services = \Config::get('sdata::services');
    $client->setDescription( ServiceDescription::factory($services) );

    // Done
    return $client;

	}



	public function getClubs($search=null)
	{
		$uri = 'accounts?where=Type eq "Member Club"';
		if ( $search )
		{
			$uri .= ' and AccountName like "%' . trim(\Str::lower($search)) . '%"';
		}
		$uri .= '&select=AccountName,Fax,MainPhone,WebAddress,Address/City,Address/State';
		$req = $this->get($uri);
		return $this->processRequest( $req );
	}


	public function getClub($id)
	{
		$uri = "accounts('". $id ."')";
		$uri .= '?select=AccountName,Fax,MainPhone,WebAddress,Address/City,Address/State';
		$req = $this->get($uri);
		return $this->processRequest( $req );
	}



	protected function processRequest( Request $request )
	{
		try {
			$response = $request->send();
		} catch ( \Guzzle\Http\Exception\ClientErrorResponseException $e ) {
			$code = $e->getResponse()->getStatusCode();
			if ($code==404) {
				return null;
			}
			throw($e);
		}
		return $this->processResponse( $response );

	}


	protected function processResponse( Response $response )
	{

		$json = $response->json();

		if (array_key_exists('$resources', $json)) {
			$array = $this->processJson( $json['$resources'] );
			foreach($array as $k=>$v) {
				$array[$k] = array_dot($v);
			}
			return new \Illuminate\Support\Collection($array);
		} else {
			return array_dot( $this->processJson( $json ) );
		}

	}

	protected function processJson( $array )
	{
		foreach($array as $k=>$v) {
			if (substr($k,0,1)==='$' && $k!=='$key')
			{
				unset($array[$k]);
			}
			else if (is_array($v))
			{
				$array[$k] = $this->processJson($v);
			}
		}

		return $array;
	}

}