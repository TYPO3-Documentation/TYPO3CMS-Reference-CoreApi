.. include:: /Includes.rst.txt
.. index:: File; EXT:{extkey}/ext_tables.sql
.. _ext_tables-sql:

=======================================
:file:`ext_tables.sql`
=======================================

*-- optional*

SQL definition of database tables.

This file should contain a table-structure dump of the tables used by
the extension. It is used for evaluation of the database structure and
is applied to the database when an
extension is enabled.

If you add additional fields (or depend on certain fields) to existing tables
you can also put them here. In that case insert a :code:`CREATE TABLE` structure
for that table, but remove all lines except the ones defining the fields you need,
here is an example adding a column to the pages table:

.. code-block:: sql

   CREATE TABLE pages (
         tx_myext_field int(11) DEFAULT '0' NOT NULL,
   );

TYPO3 will merge this table definition to the existing table definition when
comparing expected and actual table definitions. Partial definitions
can also contain indexes and other directives. They can also change
existing table fields though that is not recommended, because it may
create problems with the TYPO3 Core  and/or other extensions.

The :file:`ext_tables.sql` file may not necessarily be "dumpable"
directly to MySQL (because of the semi-complete table definitions allowed
defining only required fields). But the Extension Manager or Install Tool can handle this.

TYPO3 parses :code:`ext_tables.sql` files. TYPO3 expects that all
table definitions in this file look like the ones produced by the
:code:`mysqldump` utility. Incorrect definitions may not be recognized
by the TYPO3 SQL parser or may lead to MySQL errors, when TYPO3 tries
to apply them. If TYPO3 is not running on MySQL or directly compatible
other DBMS like MariaDB, the system will parse the file towards the
target DBMS like PostgreSQL.

.. _auto-generated-db-structure:

Auto generated structure
^^^^^^^^^^^^^^^^^^^^^^^^

The database schema analyzer automatically creates TYPO3 "management" related
database columns by reading a tables TCA and checking the :ref:`t3tca:ctrl`
section for table capabilities. Field definitions in :file:`ext_tables.sql` take
precedence over automatically generated fields, so the Core never overrides a
manually specified column definition from an :file:`ext_tables.sql` file.

These columns below are automatically added if not defined in
:file:`ext_tables.sql` for database tables that provide a :php:`$GLOBALS['TCA']`
definition:

:php:`uid` and :php:`PRIMARY KEY`
  If uid field is not provided inside :file:`ext_tables.sql`, the :php:`PRIMARY KEY`
  **must** be omitted, too.

:php:`pid` and :php:`KEY parent`
  Column pid is :php:`unsigned` if the table is not workspace aware, the default
  index :php:`parent` includes :php:`pid` and :php:`hidden` as well as
  :php:`deleted` if the latter two are specified in :php:`TCA`
  :ref:`t3tca:ctrl`. The parent index creation is only applied if column
  :php:`pid` is auto generated, too.

:php:`['ctrl']['tstamp'] = 'fieldName'`
  Often set to :php:`tstamp` or :php:`updatedon`

:php:`['ctrl']['crdate'] = 'fieldName'`
  Often set to :php:`crdate` or :php:`createdon`

:php:`['ctrl']['delete'] = 'fieldName'`
  Often set to :php:`deleted`

:php:`['ctrl']['enablecolumns']['disabled'] = 'fieldName'`
  Often set to :php:`hidden` or :php:`disabled`

:php:`['ctrl']['enablecolumns']['starttime'] = 'fieldName'`
  Often set to :php:`starttime`

:php:`['ctrl']['enablecolumns']['endtime'] = 'fieldName'`
  Often set to :php:`endtime`

:php:`['ctrl']['enablecolumns']['fe_group'] = 'fieldName'`
  Often set to :php:`fe_group`

:php:`['ctrl']['sortby'] = 'fieldName'`
  Often set to :php:`sorting`

:php:`['ctrl']['descriptionColumn'] = 'fieldName'`
  Often set to :php:`description`

:php:`['ctrl']['editlock'] = 'fieldName'`
  Often set to :php:`editlock`

:php:`['ctrl']['languageField'] = 'fieldName'`
  Often set to :php:`sys_language_uid`

:php:`['ctrl']['transOrigPointerField'] = 'fieldName'`
  Often set to :php:`l10n_parent`

:php:`['ctrl']['translationSource'] = 'fieldName'`
  Often set to :php:`l10n_source`

:php:`l10n_state`
  Column added if :php:`languageField` and :php:`transOrigPointerField` are set

:php:`['ctrl']['origUid'] = 'fieldName'`
  Often set to :php:`t3_origuid`

:php:`['ctrl']['transOrigDiffSourceField'] = 'fieldName'`
  Often set to :php:`l10n_diffsource`

:php:`['ctrl']['versioningWS'] = true` - :php:`t3ver_*` columns
  Columns that make a table workspace aware. All those fields are prefixed with
  :php:`t3ver_`, for example :php:`t3ver_oid`. A default
  index named :php:`t3ver_oid` to fields :php:`t3ver_oid` and :php:`t3ver_wsid` is
  added, too.
