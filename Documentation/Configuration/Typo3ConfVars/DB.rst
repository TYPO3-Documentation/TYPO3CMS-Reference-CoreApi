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

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  confval-menu::
    :name: globals-typo3-conf-vars-db
    :display: tree
    :type:

..  _typo3ConfVars_db_additionalQueryRestrictions:

..  confval:: additionalQueryRestrictions
    :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']
    :name: typo3-conf-vars-db-additionalQueryRestrictions
    :type: array
    :Default: []

    It is possible to add additional query restrictions by adding class names as
    key to :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']`.
    Have a look into the chapter :ref:`database-custom-restrictions` for details.

..  _typo3ConfVars_db_connections:

..  confval:: Connections
    :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']
    :name: typo3-conf-vars-db-connections
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

    ..  _typo3ConfVars_db_connections_charset:

    ..  confval:: charset
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['charset']
        :name: typo3-conf-vars-db-connection-name-charset
        :type: string
        :Default: 'utf8'

        The charset used when connecting to the database. Can be used with
        MySQL/MariaDB and PostgreSQL.

    ..  _typo3ConfVars_db_connections_dbname:

    ..  confval:: dbname
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['dbname']
        :name: typo3-conf-vars-db-connection-name-dbname
        :type: string

        Name of the database/schema to connect to. Can be used with
        MySQL/MariaDB and PostgreSQL.

    ..  confval:: defaultTableOptions
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['defaultTableOptions']
        :name: typo3-conf-vars-db-connection-name-defaultTableOptions
        :type: array

        Defines the charset and collation options for tables for MySQL/MariaDB:

        .. code-block:: php
            :caption: config/system/settings.php | typo3conf/system/settings.php

            'Connections' => [
                'Default' => [
                    'driver' => 'mysqli',
                    // ...
                    'charset' => 'utf8mb4',
                    'defaultTableOptions' => [
                        'charset' => 'utf8mb4',
                        'collation' => 'utf8mb4_unicode_ci',
                    ],
                ],
            ]

        For new installations the above is the default.


    ..  _typo3ConfVars_db_connections_driver:

    ..  confval:: driver
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['driver']
        :name: typo3-conf-vars-db-connection-name-driver
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

    ..  _typo3ConfVars_db_connections_host:

    ..  confval:: host
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['host']
        :name: typo3-conf-vars-db-connection-name-host
        :type: string

        Hostname or IP address of the database to connect to. Can be used with
        MySQL/MariaDB and PostgreSQL.

    ..  _typo3ConfVars_db_connections_password:

    ..  confval:: password
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['password']
        :name: typo3-conf-vars-db-connection-name-password
        :type: string

        Password to use when connecting to the database.

    ..  _typo3ConfVars_db_connections_path:

    ..  confval:: path
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['path']
        :name: typo3-conf-vars-db-connection-name-path
        :type: string

        The filesystem path to the SQLite database file.

    ..  _typo3ConfVars_db_connections_port:

    ..  confval:: port
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['port']
        :name: typo3-conf-vars-db-connection-name-port
        :type: string

        Port of the database to connect to. Can be used with MySQL/MariaDB and
        PostgreSQL.

    ..  _typo3ConfVars_db_connections_tableoptions:

    ..  confval:: tableoptions
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['tableoptions']
        :name: typo3-conf-vars-db-connection-name-tableoptions
        :type: array
        :Default: []

        ..  deprecated:: 13.4
            Since TYPO3 v11 the :php:`tableoptions` keys were silently migrated
            to :confval:`typo3-conf-vars-db-connection-name-defaultTableOptions`,
            which is the proper Doctrine DBAL connection option for MariaDB and
            MySQL.

            Furthermore, Doctrine DBAL 3.x switched from using they array key
            :php:`collate` to :php:`collation`, ignoring the old array key with
            Doctrine DBAL 4.x. This was silently migrated by TYPO3, too.

            These silent migrations are now deprecated in favor of using the
            final array keys.

        **Migration:**

        Review :php:`settings.php` and :php:`additional.php` and adapt the
        deprecated configuration by renaming affected array keys.

        ..  code-block:: diff

             'Connections' => [
                 'Default' => [
            -        'tableoptions' => [
            +        'defaultTableOptions' => [
            -            'collate' => 'utf8mb4_unicode_ci',
            +            'collation' => 'utf8mb4_unicode_ci',
                     ],
                 ],
             ],

    ..  _typo3ConfVars_db_connections_unixsocket:

    ..  confval:: unix_socket
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['unix_socket']
        :name: typo3-conf-vars-db-connection-name-unix-socket
        :type: string

        Name of the socket used to connect to the database. Can be used with
        MySQL/MariaDB.

    ..  _typo3ConfVars_db_connections_user:

    ..  confval:: user
        :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['user']
        :name: typo3-conf-vars-db-connection-name-user
        :type: string

        Username to use when connecting to the database.

..  _typo3ConfVars_db_tablemapping:

..  confval:: TableMapping
    :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']['TableMapping']
    :name: globals-typo3-conf-vars-db-tableMapping
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
