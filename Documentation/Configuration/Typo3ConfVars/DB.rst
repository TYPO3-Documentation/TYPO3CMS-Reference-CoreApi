.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; DB
.. _typo3ConfVars_db:

=================================
$GLOBALS['TYPO3_CONF_VARS']['DB']
=================================

.. index::
   TYPO3_CONF_VARS DB; additionalQueryRestrictions
.. _typo3ConfVars_db_additionalQueryRestrictions:

$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']
================================================================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']

   :type: array
   :Default: []

   It is possible to add additional query restrictions by adding class names as
   key to :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']`.
   Have a look into the chapter :ref:`database-custom-restrictions` for details.


.. index::
   TYPO3_CONF_VARS DB; Connections
.. _typo3ConfVars_db_connections:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']
================================================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']

   :type: array

   One or more database connections can be configured under the
   :php:`Connections` key. There must be at least one configuration with the
   :php:`Default` key, in which the default database is configured, for example:

   .. code-block:: php
      :caption: typo3conf/LocalConfiguration.php

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
   setup (e.g. for logging or caching). For example, the following snippet could
   be used to swap the :sql:`sys_log` table to another database or even another
   database server:

   .. code-block:: php
      :caption: typo3conf/LocalConfiguration.php

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
          'Syslog' => [
              'charset' => 'utf8mb4',
              'driver' => 'mysqli',
              'dbname' => 'syslog_dbname',
              'host' => 'syslog_host',
              'password' => '***',
              'port' => 3306,
              'user' => 'syslog_user',
          ],
      ],
      'TableMapping' => [
          'sys_log' => 'Syslog',
      ]


.. index::
   TYPO3_CONF_VARS DB; Connections Charset
.. _typo3ConfVars_db_connections_charset:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['charset']
------------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['charset']

   :type: string
   :Default: 'utf8'

   The charset used when connecting to the database. Can be used with
   MySQL/MariaDB and PostgreSQL.


.. index::
   TYPO3_CONF_VARS DB; Connections Database name
.. _typo3ConfVars_db_connections_dbname:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['dbname']
-----------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['dbname']

   :type: string

   Name of the database/schema to connect to. Can be used with
   MySQL/MariaDB and PostgreSQL.


.. index::
   TYPO3_CONF_VARS DB; Connections Driver
.. _typo3ConfVars_db_connections_driver:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['driver']
-----------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['driver']

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


.. index::
   TYPO3_CONF_VARS DB; Connections Host
.. _typo3ConfVars_db_connections_host:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['host']
-------------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['host']

   :type: string

   Hostname or IP address of the database to connect to. Can be used with
   MySQL/MariaDB and PostgreSQL.


.. index::
   TYPO3_CONF_VARS DB; Connections Password
.. _typo3ConfVars_db_connections_password:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['password']
-------------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['password']

   :type: string

    Password to use when connecting to the database.


.. index::
   TYPO3_CONF_VARS DB; Connections Path
.. _typo3ConfVars_db_connections_path:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['path']
-------------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['path']

   :type: string

   The filesystem path to the SQLite database file.


.. index::
   TYPO3_CONF_VARS DB; Connections Port
.. _typo3ConfVars_db_connections_port:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['port']
---------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['port']

   :type: string

   Port of the database to connect to. Can be used with MySQL/MariaDB and
   PostgreSQL.


.. index::
   TYPO3_CONF_VARS DB; Connections Table options
.. _typo3ConfVars_db_connections_tableoptions:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['tableoptions']
-----------------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['tableoptions']

   :type: array
   :Default: []

   Defines the charset and collate options for tables for MySQL/MariaDB:

   .. code-block:: php
      :caption: typo3conf/LocalConfiguration.php

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


.. index::
   TYPO3_CONF_VARS DB; Connections Unix socket
.. _typo3ConfVars_db_connections_unixsocket:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['unix_socket']
----------------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['unix_socket']

   :type: string

   Name of the socket used to connect to the database. Can be used with
   MySQL/MariaDB.

.. index::
   TYPO3_CONF_VARS DB; Connections User
.. _typo3ConfVars_db_connections_user:

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['user']
---------------------------------------------------------------------------

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][<connection_name>]['user']

   :type: string

   Username to use when connecting to the database.


.. index::
   TYPO3_CONF_VARS DB; TableMapping
.. _typo3ConfVars_db_tablemapping:

$GLOBALS['TYPO3_CONF_VARS']['DB']['TableMapping']
=================================================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['DB']['TableMapping']

   :type: array
   :Default: []

   When a TYPO3 table is swapped to another database (either on the same host
   or another host) this table must be mapped to the other database.

   For example, the :sql:`sys_log` table should be swapped to another database:

   .. code-block:: php
      :caption: typo3conf/LocalConfiguration.php

      'Connections' => [
          'Default' => [
              // ...
          ],
          'Syslog' => [
              'charset' => 'utf8mb4',
              'driver' => 'mysqli',
              'dbname' => 'syslog_dbname',
              'host' => 'syslog_host',
              'password' => '***',
              'port' => 3306,
              'user' => 'syslog_user',
          ],
      ],
      'TableMapping' => [
          'sys_log' => 'Syslog',
      ]
