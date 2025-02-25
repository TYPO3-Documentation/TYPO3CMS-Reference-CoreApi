.. include:: /Includes.rst.txt
.. index:: Sessions; Storage
.. _session-storage:

=========================
Session storage framework
=========================

TYPO3 comes with the option to choose between different storages for both
frontend and backend user sessions (called session backends).

The Core ships two session backends by default:

*   Database storage
*   Redis storage

By default user sessions are stored in the database using the database
storage backend.

.. index:: Sessions; Database storage
.. _sessions-database:

Database storage backend
========================

The database storage backend only requires two configuration options:
The table name (`table` option) and whether anonymous sessions (`has_anonymous` option) may be stored.

The default configuration used for sessions by the Core is:

.. code-block:: php

    'SYS' => [
        'session' => [
            'BE' => [
                'backend' => \TYPO3\CMS\Core\Session\Backend\DatabaseSessionBackend::class,
                'options' => [
                    'table' => 'be_sessions'
                ]
            ],
            'FE' => [
                'backend' => \TYPO3\CMS\Core\Session\Backend\DatabaseSessionBackend::class,
                'options' => [
                    'table' => 'fe_sessions',
                    'has_anonymous' => true,
                ]
            ]
        ],
    ],


.. index:: Sessions; Redis Storage
.. _sessions-redis:

Using Redis to store sessions
=============================

TYPO3 also comes with the possibility to store sessions in a Redis key-value database.

.. note::

    This requires a running Redis instance (refer to the Redis documentation for help on this)
    and the PHP extension "redis" to be installed.

The Redis session storage can be configured with :file:`config/system/settings.php` in the `SYS` entry:

A sample configuration will look like this:

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

The available options are:

`hostname`
    Name of the server the redis database service is running on.
    Default: 127.0.0.1

`port`
    Port number the redis database service is listening to. Default: 6379

`database`
    The redis database number to use. Default: 0

`password`
    The password to use when connecting to the specified database. Optional.

.. tip::
    If a Redis instance is running on the same machine as the webserver
    the hostname 'localhost' can be used.

.. index:: Sessions; Custom storage
.. _sessions-custom:

Writing your own session storage
================================

Custom sessions storage backends can be created by implementing the interface
:php:`\TYPO3\CMS\Core\Session\Backend\SessionBackendInterface`. The doc blocks
in the interface describe how the implementing class must behave. Any number
of options can be passed to the session backend.

A custom session storage backend can be used like this (similarly to
the Redis backend):

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

.. _sessions-manager:

:php:`SessionManager` API
=========================

..  include:: _SessionManager.rst.txt

.. _sessions-references:

References
==========

*   The Redis documentation https://redis.io/documentation
