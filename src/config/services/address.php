<?php

return array(
  'name' => 'Golf Canada sData Service Description - Addresses',
  'description' => 'sData calls related to addresses',

  'operations' => [

    'getAddress' => [
      'httpMethod'    => 'GET',
      'uri'           => "addresses('{id}')",
      'summary'       => 'Get specific address',
      'responseClass' => 'Address',
      'parameters' => [
        'id' => [
          'location' => 'uri',
          'type'     => 'string',
          'required' => true
        ],
        'select' => [
          'location' => 'query',
          'type'     => 'string',
          'default'  => '*',
          'static'   => false
        ],
      ]
    ]

  ]
);