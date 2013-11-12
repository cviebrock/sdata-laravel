<?php

return array(

	'name'        => 'Golf Canada sData Service Description',
	'apiVersion'  => '1.0.0',
	'description' => 'Web service for sData calls to Golf Canada\'s CRM',

	'operations' => [],

	'includes' => [
		__DIR__ . '/services/golfer.php',
		__DIR__ . '/services/address.php',
	]

);