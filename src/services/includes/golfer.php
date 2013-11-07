<?php

return array(
  'name' => 'Golf Canada sData Service Description - Golfers',
  'description' => 'sData calls related to golfers',

  'operations' => [

    'getAllGolfers' => [
      'httpMethod'    => 'GET',
      'uri'           => 'contacts',
      'summary'       => 'Get basic information on all golfers',
      'responseClass' => 'Sdata\\V1\\Support\\Collection',
      'data' => [
        'responseCollection' => 'Golfer',
      ],
      'parameters' => [
        'where' => [
          'location' => 'query',
          'type'     => 'string',
          'default'  => 'Type eq "Member Golfer"',
          'static'   => true
        ],
        'select' => [
          'location' => 'query',
          'type'     => 'string',
          'default'  => 'FirstName,LastName,Email,Type',
          'static'   => false
        ],
        'start' => [
          'location' => 'query',
          'type'     => 'integer',
          'default'  => 1,
          'sentAs'   => 'startIndex'
        ],
        'count' => [
          'location' => 'query',
          'type'     => 'integer',
          'default'  => 10
        ]
      ]
    ],

    'getGolfer' => [
      'httpMethod'    => 'GET',
      'uri'           => "contacts('{id}')",
      'summary'       => 'Get specific golfer',
      'responseClass' => 'Golfer',
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