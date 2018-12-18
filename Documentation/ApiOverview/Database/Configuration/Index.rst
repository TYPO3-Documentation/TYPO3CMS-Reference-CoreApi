.. include:: ../../../Includes.txt

.. _database-configuration:

Configuration
-------------

Configuring `doctrine-dbal` for `TYPO3 CMS` is all about specifying the single database endpoints
and handing over connection credentials. The framework supports the parallel usage of multiple
database connections, a specific connection is mapped depending on its table name. The table space
can be seen as a transparent layer that determines which specific connection is chosen for a query
to a single or a group of tables: It allows "swapping-out" single tables from the `Default` connection
to point them to a different database endpoint.

As with other central configuration options, the database endpoint and mapping configuration happens
within :file:`typo3conf/LocalConfiguration.php` and ends up in :php:`$GLOBALS['TYPO3_CONF_VARS']` after
core bootstrap. The specific sub-array is :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']`.

A typical, basic example using only the `Default` connection with a single database endpoint::

   // LocalConfiguration.php
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

* The `Default` connection must be configured, this can not be left out or renamed.

* For mysqli, if the `host` is set to `localhost` and if the default `PHP` options in this area are not
  changed, the connection will be socket based. This saves a little overhead. To force a `TCP/IP` based
  connection even for `localhost`, the `IPv4` or `IPv6` address `127.0.0.1` and `::1/128` respectively
  must be used as `host` value.

* The connect options are hand over to `doctrine-dbal` without much manipulation from `TYPO3 CMS` side.
  Please refer to the
  `doctrine connection docs <http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html>`__
  for a full overview of settings.

* If `charset` option is not specified it defaults to `utf8`.

* The option `wrapperClass` is used by TYPO3 to insert the extended
  :ref:`Connection <database-connection>` class :php:`TYPO3\CMS\Database\Connection` as main facade
  around `doctrine-dbal`.


A slightly more complex example with two connections, mapping the `sys_log` table to a different endpoint::

   // LocalConfiguration.php
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
         'Syslog' => [
            'charset' => 'utf8',
            'dbname' => 'syslog_dbname',
            'driver' => 'mysqli',
            'host' => 'syslog_host',
            'password' => '***',
            'port' => 3306,
            'user' => 'syslog_user',
         ],
      ],
      'TableMapping' => [
         'sys_log' => 'Syslog'
      ]
   ],
   // [...]


Remarks:

* The array key `Syslog` is just a name, it can be different but it's good practice to give it
  a useful speaking name.

* It is possible to map multiple tables to a different endpoint by adding further table name /
  connection name pairs to `TableMapping`.

* Mind this "connection per table" approach is limited: If in the above example a join query
  that spans over different connections is fired, an exception is raised. It is up to the
  administrator to group affected tables to the same connection in those cases, or a developer
  should implement some fallback logic to suppress the `join()`.


.. attention::

    Connections to databases `postgres`, `maria` and `mysql` are actively tested.
    However, `mssql` is currently not actively tested.

    Furthermore, the `TYPO3 CMS` installer supports only a single `mysql` or `mariadb` connection
    at the moment and the connection details can not be properly edited within the `All configuration`
    section of the Install Tool.
