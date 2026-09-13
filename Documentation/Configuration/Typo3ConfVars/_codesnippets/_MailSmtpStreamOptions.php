<?php

return [
  // ...
  'MAIL' => [
    'transport' => 'smtp',
    'transport_smtp_server' => 'localhost:1025',
    'transport_smtp_stream_options' => [
      'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
      ],
    ],
  ],
  // ...
];
