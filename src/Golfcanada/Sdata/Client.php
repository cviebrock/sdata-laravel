<?php namespace Golfcanada\Sdata;


// use ArrayAccess;
// use Carbon;
// use Closure;
// use Config;
// use DateTime;
// use Illuminate\Support\Collection;
// use Illuminate\Support\Contracts\ArrayableInterface;
// use Illuminate\Support\Contracts\JsonableInterface;
// use Illuminate\Support\Str;
use Guzzle\Common\Collection;
use Guzzle\Common\Event;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Cviebrock\Guzzle\Plugin\StripBom\StripBomPlugin;

class Client extends Client {

	public static function factory( $config = array() )
  {

		// The following values are required when creating the client
		$required = array(
			'base_url',
			'username',
			'password',
			'version',
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
		$path = __DIR__ . '/' . $config->get('version') . '/services.php';
    $client->setDescription(ServiceDescription::factory($path));

    // Done
    return $client;

	}

}