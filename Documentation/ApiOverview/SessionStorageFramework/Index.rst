.. include:: ../../Includes.txt

.. _sessions:

Session Storage Framework
=========================

As of version 8.6, TYPO3 comes with the option to choose between different storages for both frontend end backend user
sessions. Previously, all sessions were stored in the database in the tables `fe_sessions`, `fe_session_data` and
`be_sessions`.

By default user sessions are stored in the database.

.. _sessions-redis:

Using Redis to store sessions
-----------------------------

TYPO3 also comes with the possibility to store sessions in a Redis key-value database.
.. note::

    This requires a running Redis instance, refer to the Redis documentation for help on this.

The Redis session storage can be configured with `LocalConfiguration.php` in the `SYS` entry:

.. code-block:: php

    'SYS' => [
        'session' => [
            'BE' => [
                'backend' => \TYPO3\CMS\Core\Session\Backend\RedisSessionBackend::class,
                'options' => [
                    'hostname' => 'redis.myhost.example',
                    'password' => 'passw0rd',
                    'database' => 0,
                    'port' => 6379
                ]
            ],
            'FE' => [
                'backend' => \TYPO3\CMS\Core\Session\Backend\RedisSessionBackend::class,
                'options' => [
                    'hostname' => 'redis.myhost.example',
                    'password' => 'passw0rd',
                    'database' => 0,
                    'port' => 6379
                ]
            ],
        ],
    ],

.. tip::

    If a Redis instance is running on the same machine as the webserver the hostname 'localhost' can be used instead.



.. _sessions-custom:

Writing your own session storage
--------------------------------

Custom sessions storage backends can be created by implementing the interface
:php:`\TYPO3\CMS\Core\Session\Backend\SessionBackendInterface`. The doc blocks in the interface describe how the
implementing class must behave. Any number of options can be passed to the session backend.

A custom session storage backend can be used like this (similarly to the Redis backend):

.. code-block:: php

    'SYS' => [
        'session' => [

            'FE' => [
                'backend' => \Vendor\Sessions\MyCustomSessionBackend::class,
                'options' => [
                    'foo' => 'bar',
                ]
            ],
        ],
    ],

.. _sessions-references:

References
----------

 - The Redis documentation https://redis.io/documentation
