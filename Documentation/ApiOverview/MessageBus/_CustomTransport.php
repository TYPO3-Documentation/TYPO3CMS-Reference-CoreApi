<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['messenger'] = [
  'routing' => [
    // Use "messenger.transport.demo" as transport for DemoMessage
    \MyVendor\MyExtension\Queue\Message\DemoMessage::class => 'demo',

    // Use "messenger.transport.default" as transport for all other messages
    '*' => 'default',
  ],
];
