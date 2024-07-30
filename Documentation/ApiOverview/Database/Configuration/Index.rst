..  include:: /Includes.rst.txt
..  index::
    Doctrine; Configuration
    File; config/system/settings.php
    TYPO3_CONF_VARS; DB
..  _database-configuration:

=============
Configuration
=============

The configuration of Doctrine DBAL for TYPO3 is about specifying the single
database endpoints and passing the connection credentials. The framework
supports the parallel usage of multiple database connections, a specific
connection is mapped depending on its table name. The table space can be seen as
a transparent layer that determines which specific connection is chosen for a
query to a single or a group of tables: It allows "swapping out" single tables
from the `Default` connection to point them to a different database endpoint.

As with other central configuration options, the database endpoint and mapping
configuration is done in :file:`config/system/settings.php` and ends up in
:php:`$GLOBALS['TYPO3_CONF_VARS']` after the Core :ref:`bootstrap
<bootstrapping>`. The specific sub-array is
:php:`$GLOBALS['TYPO3_CONF_VARS']['DB']`.

Example: one connection
=======================

A typical basic example using only the `Default` connection with a single
database endpoint:

..  code-block:: php
    :caption: config/system/settings.php

    // [...]
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => 'theDatabaseName',
                'driver' => 'mysqli',
                'host' => 'theHost',
                'password' => 'theConnectionPassword',
                'port' => 3306,
                'user' => 'theUser',
            ],
        ],
    ],
    // [...]


Remarks:

*   The `Default` connection must be configured, this can not be left out or
    renamed.

*   For the :php:`mysqli` driver: If the :php:`host` is set to :php:`localhost`
    and if the default PHP options in this area are not changed, the connection
    will be socket-based. This saves a little overhead. To force a TCP/IP-based
    connection even for :php:`localhost`, the IPv4 address `127.0.0.1` or IPv6
    address `::1/128` respectively must be used as :php:`host` value.

*   The connection options are passed to Doctrine DBAL without much
    manipulation from TYPO3 side. Please refer to the
    `doctrine connection docs`_ for a full overview of the settings.

*   If the :php:`charset` option is not specified, it defaults to :php:`utf8`.

*   The option :php:`wrapperClass` is used by TYPO3 to insert the extended
    :ref:`Connection <database-connection>` class
    :php:`\TYPO3\CMS\Core\Database\Connection` as main facade around Doctrine DBAL.

.. _doctrine connection docs: https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html


Example: two connections
========================

..  attention::
    ..  versionchanged:: 13.0

    TYPO3 expects all "main" Core system tables to be configured for the
    :php:`Default` connection (especially :sql:`sys_*`, :sql:`pages`,
    :sql:`tt_content` and in general all tables that have
    :ref:`TCA <t3tca:start>` configured). The reason for this is to improve
    performance with joins between tables. Cross-database joins are almost
    impossible.

    One scenario for using a separate database connection is to query data
    directly from a third-party application in a custom extension. Another
    use case is database-based caches.

Another example with two connections, where the :sql:`be_sessions` table is
mapped to a different endpoint:

..  code-block:: php
    :caption: config/system/settings.php

    // [...]
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => 'default_dbname',
                'driver' => 'mysqli',
                'host' => 'default_host',
                'password' => '***',
                'port' => 3306,
                'user' => 'default_user',
            ],
            'Sessions' => [
                'charset' => 'utf8mb4',
                'driver' => 'mysqli',
                'dbname' => 'sessions_dbname',
                'host' => 'sessions_host',
                'password' => '***',
                'port' => 3306,
                'user' => 'some_user',
            ],
        ],
        'TableMapping' => [
            'be_sessions' => 'Sessions',
        ]
    ],
    // [...]


Remarks:

*   The array key :php:`Sessions` is just a name. It can be different, but it is
    good practice to give it a useful, descriptive name.

*   It is possible to map multiple tables to a different endpoint by adding
    further table name / connection name pairs to :php:`TableMapping`.


..  attention::
    The TYPO3 installer supports only a single MariaDB or MySQL connection at
    the moment.

..  seealso::
    :ref:`Overview of all DB configuration options <typo3ConfVars_db_connections>`
