..  include:: /Includes.rst.txt

..  index::
    TYPO3_CONF_VARS; DB
    Database; Connections
..  _typo3ConfVars_db:

=========================
DB - Database connections
=========================

The following configuration variables can be used to configure settings for
the connection to the database:

..  contents::
    :local:

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  index::
    TYPO3_CONF_VARS DB; additionalQueryRestrictions
..  _typo3ConfVars_db_additionalQueryRestrictions:

additionalQueryRestrictions
===========================

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']

    :type: array
    :Default: []

    It is possible to add additional query restrictions by adding class names as
    key to :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']`.
    Have a look into the chapter :ref:`database-custom-restrictions` for details.


..  index::
    TYPO3_CONF_VARS DB; Connections
..  _typo3ConfVars_db_connections:

Connections
===========

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']

    :type: array

    One or more database connections can be configured under the
    :php:`Connections` key. There must be at least one configuration with the
    :php:`Default` key, in which the default database is configured, for example:

    .. code-block:: php
        :caption: config/system/settings.php | typo3conf/system/settings.php

        'Connections' => [
            'Default' => [
                'charset' => 'utf8mb4',
                'driver' => 'mysqli',
                'dbname' => 'typo3_database',
                'host' => '127.0.0.1',
                'password' => 'typo3',
                'port' => 3306,
                'user' => 'typo3',
            ],
        ]

    It is possible to swap out tables from the default database and use a specific
    setup (for instance, for caching). For example, the following snippet could
    be used to swap the :sql:`be_sessions` table to another database or even another
    database server:

    ..  code-block:: php
        :caption: config/system/settings.php | typo3conf/system/settings.php

        'Connections' => [
            'Default' => [
                'charset' => 'utf8mb4',
                'driver' => 'mysqli',
                'dbname' => 'typo3_database',
                'host' => '127.0.0.1',
                'password' => '***',
                'port' => 3306,
                'user' => 'typo3',
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

    ..  note::
        The connection options described below are the most commonly used. These
        options correspond to the options of the underlying Doctrine DBAL
        library. Please refer to the `Doctrine DBAL connection details
        <https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html#connection-details>`__
        for a full overview of settings.

..  index::
    TYPO3_CONF_VARS DB; Connections Charset
..  _typo3ConfVars_db_connections_charset:

charset
-------

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['charset']

    :type: string
    :Default: 'utf8'

    The charset used when connecting to the database. Can be used with
    MySQL/MariaDB and PostgreSQL.


..  index::
    TYPO3_CONF_VARS DB; Connections Database name
..  _typo3ConfVars_db_connections_dbname:

dbname
------

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['dbname']

    :type: string

    Name of the database/schema to connect to. Can be used with
    MySQL/MariaDB and PostgreSQL.


..  index::
    TYPO3_CONF_VARS DB; Connections Driver
..  _typo3ConfVars_db_connections_driver:

driver
------

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['driver']

    :type: string

    The built-in driver implementation to use. The following drivers are
    currently available:

    mysqli
        A MySQL/MariaDB driver that uses the mysqli extension.
    pdo_mysql
        A MySQL/MariaDB driver that uses the pdo_mysql PDO extension.
    pdo_pgsql
        A PostgreSQL driver that uses the pdo_pgsql PDO extension.
    pdo_sqlite
        An SQLite driver that uses the pdo_sqlite PDO extension.


..  index::
    TYPO3_CONF_VARS DB; Connections Host
..  _typo3ConfVars_db_connections_host:

host
----

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['host']

    :type: string

    Hostname or IP address of the database to connect to. Can be used with
    MySQL/MariaDB and PostgreSQL.


..  index::
    TYPO3_CONF_VARS DB; Connections Password
..  _typo3ConfVars_db_connections_password:

password
--------

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['password']

    :type: string

    Password to use when connecting to the database.


..  index::
    TYPO3_CONF_VARS DB; Connections Path
..  _typo3ConfVars_db_connections_path:

path
----

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['path']

    :type: string

    The filesystem path to the SQLite database file.


..  index::
    TYPO3_CONF_VARS DB; Connections Port
..  _typo3ConfVars_db_connections_port:

port
----

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['port']

    :type: string

    Port of the database to connect to. Can be used with MySQL/MariaDB and
    PostgreSQL.


..  index::
    TYPO3_CONF_VARS DB; Connections Table options
..  _typo3ConfVars_db_connections_tableoptions:

tableoptions
------------

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['tableoptions']

    :type: array
    :Default: []

    Defines the charset and collate options for tables for MySQL/MariaDB:

    .. code-block:: php
        :caption: config/system/settings.php | typo3conf/system/settings.php

        'Connections' => [
            'Default' => [
                'driver' => 'mysqli',
                // ...
                'charset' => 'utf8mb4',
                'tableoptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci',
                ],
            ],
        ]

    For new installations the above is the default.


..  index::
    TYPO3_CONF_VARS DB; Connections Unix socket
..  _typo3ConfVars_db_connections_unixsocket:

unix_socket
-----------

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['unix_socket']

    :type: string

    Name of the socket used to connect to the database. Can be used with
    MySQL/MariaDB.

..  index::
    TYPO3_CONF_VARS DB; Connections User
..  _typo3ConfVars_db_connections_user:

user
----

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['user']

    :type: string

    Username to use when connecting to the database.


..  index::
    TYPO3_CONF_VARS DB; TableMapping
..  _typo3ConfVars_db_tablemapping:

TableMapping
============

..  confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['TableMapping']

    :type: array
    :Default: []

    When a TYPO3 table is swapped to another database (either on the same host
    or another host) this table must be mapped to the other database.

    For example, the :sql:`be_sessions` table should be swapped to another
    database:

    ..  code-block:: php
        :caption: config/system/settings.php | typo3conf/system/settings.php

        'Connections' => [
            'Default' => [
                // ...
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
