.. include:: /Includes.rst.txt
.. index:: Extension development; File name conventions
.. _extension-files-locations:
.. _extension-reserved-folders-legacy:

===================
Files and locations
===================

.. _extension-files:

Files
=====

An extension consists of:

1. A directory named by the *extension key* (which is a worldwide unique
   identification string for the extension), usually located in :file:`typo3conf/ext`
   for local extensions, or :file:`typo3/sysext` for system extensions.

2. Standard files with reserved names for configuration related to TYPO3
   (of which most are optional, see list below)

3. Any number of additional files for the extension functionality itself.

.. index:: Extension development; Reserved file names
.. _extension-reserved-filenames:

Reserved file names
===================

This lists files within an extension that have a specific meaning
by convention. TYPO3 will scan for reserved file names and
use the content for specific functionality. For example, if a svg logo of your extension
is placed at :file:`Resources/Public/Icons/Extension.svg`, the Extension Manager
will show that image.

Most of these files are not required. The exception are :file:`ext_emconf.php`
in :ref:`legacy installations not based on Composer <t3start:legacyinstallation>`
and :file:`composer.json` in :ref:`Composer installations <t3start:install>`
installations.

.. note::
   It is recommended to keep :file:`ext_emconf.php` and :file:`composer.json` in
   any public extension that is published to TYPO3 Extension Repository (TER), and
   to ensure optimal compatibility with Composer installations and legacy
   installations.

Do not introduce your own files in the root directory of
extensions with the name prefix :file:`ext_`, because that is reserved.

.. index:: File; EXT:{extkey}/composer.json
.. _files-composer-json:

:file:`composer.json`
---------------------

*-- required* in Composer installations

For more information, see :ref:`composer-json`.

.. versionchanged:: 11.4
   The ordering of installed extensions and their dependencies are loaded from
   the :file:`composer.json` file, instead of :file:`ext_emconf.php` in
   Composer installations.

.. note::
   Extension authors should ensure that the information in the :file:`composer.json`
   file is in sync with the one in the extensions' :file:`ext_emconf.php` file.
   This is especially important regarding constraints like `depends` , `conflicts`
   and `suggests`. Use the equivalent settings in :file:`composer.json` `require`,
   `conflict` and `suggest` to set dependencies and ensure a specific loading order.

.. index:: File; EXT:{extkey}/ext_emconf.php
.. _ext_emconf-php:

:file:`ext_emconf.php`
----------------------

*-- required* in legacy installations

Definition of extension properties.

Name, category, status etc. are used by the :guilabel:`Extensions` module in legacy
installations. The content of this file is described in more details in
:ref:`extension-declaration`.

For legacy installations the :file:`ext_emconf.php` file is the
source of truth for required dependencies and the loading order of active
extensions.

.. index::
   File; EXT:{extkey}/ext_localconf.php
   File; typo3conf/LocalConfiguration.php
.. _ext_localconf-php:

:file:`ext_localconf.php`
-------------------------

*-- optional*

Addition to :file:`LocalConfiguration.php`.
It should contain additional configuration of :php:`$GLOBALS['TYPO3_CONF_VARS']`.

This file contains hook definitions and plugin configuration. It must
not contain a PHP encoding declaration.

All :file:`ext_localconf.php` files of loaded extensions are
included right  *after* the files :file:`typo3conf/LocalConfiguration.php`
and :file:`typo3conf/AdditionalConfiguration.php` during TYPO3
:ref:`bootstrap <bootstrapping>`.

Pay attention to the rules for the contents of these files.
For more details, see the :ref:`section below <extension-configuration-files>`.

.. index:: File; EXT:{extkey}/ext_tables.php
.. _ext_tables-php:

:file:`ext_tables.php`
----------------------

*-- optional*

Contains extensions of existing tables,
declaration of backend modules, etc. All code in such files
is included after all the default definitions provided by the Core and
loaded after :file:`ext_localconf.php` files during TYPO3
:ref:`bootstrap <bootstrapping>`.

Pay attention to the rules for the contents of these files.
For more details, see the :ref:`section below <extension-configuration-files>`.

.. note::
   In old TYPO3 Core  versions, this file contained additions to the
   global :php:`$GLOBALS['TCA']` array. This changed since Core version 6.2
   to allow effective caching:

   TCA definition of new database tables must be done entirely
   in :file:`Configuration/TCA/<table name>.php`.
   These files are expected to contain the full TCA of the given table
   (as an array) and simply return it (with a :php:`return` statement).

   Customizations of existing tables must be done entirely
   in :file:`Configuration/TCA/Overrides/<table name>.php`.

.. index:: File; EXT:{extkey}/ext_tables.sql
.. _ext_tables-sql:

:file:`ext_tables.sql`
----------------------

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

:php:`['ctrl']['cruser_id'] = 'fieldName'`
  Often set to :php:`cruser` or :php:`createdby`

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


.. index:: File; EXT:{extkey}/ext_tables_static+adt.sql
.. _ext_tables_static+adt.sql:

:file:`ext_tables_static+adt.sql`
---------------------------------

Static SQL tables and their data.

If the extension requires static data you can dump it into an SQL file
by this name. Example for dumping mysql data from bash (being in the
extension directory):

.. code-block:: shell

   mysqldump --add-drop-table \
               --password=[password] [database name] \
               [tablename]  > ./ext_tables_static+adt.sql

:code:`--add-drop-table` will make sure to include a DROP TABLE
statement so any data is inserted in a fresh table.

You can also drop the table content using the Extension Manager in the backend.

.. note::

   The table structure of static tables needs to be in the
   :file:`ext_tables.sql` file as well - otherwise an installed static
   table will be reported as being in excess in the Install Tool.

.. warning::

   Static data is not meant to be extended by other extensions. On
   re-import all extended fields and data is lost due to `DROP TABLE`
   statements.


.. index:: File; EXT:{extkey}/ext_typoscript_constants.typoscript
.. _ext_typoscript_constants.typoscript:

:file:`ext_typoscript_constants.typoscript`
-------------------------------------------

Preset TypoScript constants. Will be included in the constants section
of all TypoScript templates.

.. warning::

   Use such a file if you absolutely need to load some TS (because you
   would get serious errors without it). Otherwise static templates or
   usage of the *Extension Management API* of class
   :php:`TYPO3\CMS\Core\Utility\ExtensionManagementUtility` are preferred.


.. _ext_typoscript_setup.typoscript:
.. index:: File; EXT:{extkey}/ext_typoscript_setup.typoscript

:file:`ext_typoscript_setup.typoscript`
---------------------------------------

Preset TypoScript setup. Will be included in the setup section of all
TypoScript templates.

.. warning::

   Use such a file if you absolutely need to load some TS (because you
   would get serious errors without it). Otherwise static templates or
   usage of the *Extension Management API* of class
   :php:`TYPO3\CMS\Core\Utility\ExtensionManagementUtility` are preferred.


.. index:: File; EXT:{extkey}/ext_conf_template.txt
.. _ext_conf_template.txt:

:file:`ext_conf_template.txt`
-----------------------------

Extension Configuration template.

Configuration code in TypoScript syntax setting up a series of values
which can be configured for the extension in the Install Tool.
:ref:`Read more about the file format here <extension-options>`.

If this file is present 'Settings' of the Install Tool provides you with an
interface for editing the configuration values defined in the file. The result is
written as an array to :file:`LocalConfiguration.php`
in the variable :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][`:code:`*extension_key*` :php:`]`


.. _requestmiddlewares.php:
.. index:: File; EXT:{extkey}/Configuration/RequestMiddlewares.php

:file:`RequestMiddlewares.php`
------------------------------

Full path to this file is: :file:`Configuration/RequestMiddlewares.php`.

Configuration of user-defined middlewares for frontend and backend. Extensions
that add middlewares or disable existing middlewares configure them in this
file. The file must return an array with the configuration. For more details,
see :ref:`request-handling-configuring-middlewares`.


.. index::
   File; EXT:{extkey}/Configuration/Backend/Routes.php
   File; EXT:{extkey}/Configuration/Backend/AjaxRoutes.php

.. _routes.php-and-ajaxroutes.php:

:file:`Routes.php` and :file:`AjaxRoutes.php`
---------------------------------------------

Full paths to these files are: :file:`Configuration/Backend/Routes.php` and
:file:`Configuration/Backend/AjaxRoutes.php`.

Registry of backend routes. Extensions that add backend modules must
register their routes here to be correctly linkable in the backend.
The file must return an array with routing details. See Core extensions
like :php:`backend` for examples.


.. index:: File; EXT:{extkey}/Configuration/Services.yaml

:file:`Configuration/Services.yaml`
-----------------------------------

Services can be configured in this file. TYPO3 uses it for:

* :ref:`Dependency Injection <configure-dependency-injection-in-extensions>`
* :ref:`Event Listeners <EventDispatcherRegistration>`
* Command Controllers (see :doc:`Feature: #89139 - Add dependency injection support for console commands <ext_core:Changelog/10.3/Feature-89139-AddDependencyInjectionSupportForConsoleCommands>`)
* :ref:`Registering a widget with the dashboard <ext_dashboard:register-new-widget>`

See :ref:`ServicesYaml` for details.

:file:`Resources/Public/Icons/Extension.svg`
--------------------------------------------

Alternatives: :file:`Resources/Public/Icons/Extension.png`, :file:`Resources/Public/Icons/Extension.gif`

SVG, PNG or 18x16 GIF extension icon

If it exists, this icon is displayed in the Extension Manager.
Preferred is using a SVG file, because the extension icon will look nicer
as a vector graphic (SVG) rather than a bitmap (PNG or GIF).


.. _extension-reserved-folders:

Reserved Folders
================

In the early days, every extension author baked his own bread when it came to
file locations of PHP classes, public web resources and templates.

With the rise of Extbase, a generally accepted structure for file
locations inside of extensions has been established. If extension authors
stick to this and the other Coding Guidelines, the system helps in various ways. For instance, if putting
PHP classes into the :file:`Classes/` folder and using appropriate namespaces for the classes,
the system will be able to autoload these files.

Extension kickstarters like the
`Extension Builder <https://extensions.typo3.org/extension/extension_builder>`_
will create the correct structure for you.

It is described below:

.. index:: Path; EXT:{extkey}/Classes

Classes
  Contains all PHP classes. One class per file. Should have sub folders like
  :code:`Controller/`, :code:`Domain/`, :code:`Service/` or :code:`View/`.
  For more details on class file namings and PHP namespaces, see chapter
  :ref:`namespaces <namespaces>`.

.. index:: Path; EXT:{extkey}/Classes/Controller

Classes/Controller
  Contains MVC Controller classes.

.. index:: Path; EXT:{extkey}/Classes/Domain/Model

Classes/Domain/Model
  Contains MVC Domain model classes.

.. index:: Path; EXT:{extkey}/Classes/Domain/Repository

Classes/Domain/Repository
  Contains data repository classes.

.. index:: Path; EXT:{extkey}/Classes/ViewHelpers

Classes/ViewHelpers
  Helper classes used in (Fluid) views.

.. index:: Path; EXT:{extkey}/Configuration

Configuration
  General configuration folder. Some of the sub directories in here have reserved names with special meanings.
  All files in this directory and in the 2 sub directories :file:`TCA` and :file:`Backend` are automatically
  included during the TYPO3 bootstrap.

.. index:: Path; EXT:{extkey}/Configuration/Backend

Configuration/Backend/
  Contains backend routing configurations. See files description of :php:`Routes.php`
  and :php:`AjaxRoutes.php` :ref:`above <extension-reserved-filenames>`.

.. index:: Path; EXT:{extkey}/Configuration/TCA

Configuration/TCA
  One file per database table, using the name of the table for the file, plus
  ".php". Only for new tables.

.. index:: Path; EXT:{extkey}/Configuration/TCA/Overrides

Configuration/TCA/Overrides
  For extending existing tables.
  General advice: One file per database table, using the name of the table for the file, plus ".php".
  For more informations, see chapter :ref:`Extending the TCA Array <storing-changes-extension>`.

.. index:: Path; EXT:{extkey}/Configuration/TsConfig/Page

Configuration/TsConfig/Page
  page TSconfig, see chapter :ref:`'page TSconfig' in the TSconfig Reference
  <t3tsconfig:PageTSconfig>`. Files should have the file extension
  :file:`.tsconfig`.

.. index:: Path; EXT:{extkey}/Configuration/TsConfig/User

Configuration/TsConfig/User
  User TSconfig, see chapter :ref:`'user TSconfig' in the TSconfig Reference
  <t3tsconfig:UserTSconfig>`. Files should have the file extension
  :file:`.tsconfig`.

.. index:: Path; EXT:{extkey}/Configuration/TypoScript

Configuration/TypoScript
  TypoScript static setup (:file:`setup.typoscript`) and constants
  (:file:`constants.typoscript`). Use subfolders if you have several static
  templates.

.. index:: Path; EXT:{extkey}/Documentation

Documentation
  Contains the extension documentation in ReStructuredText (ReST, .rst) format.
  Read more on the topic in chapter :ref:`extension documentation <extension-documentation>`.
  :file:`Documentation/` and its subfolders may contain several ReST files, images and other resources.

.. index:: File; EXT:{extkey}/Documentation/Index.rst

Documentation/Index.rst
  This file contains the cover page of the extension manual in ReST
  format. The name or format of the file may not be changed. You may
  include other ReST files as you like. See the `"Extension Template" on docs.typo3.org`_
  for more information about structure and syntax of extension manuals.

  .. _"Extension Template" on docs.typo3.org: https://docs.typo3.org/typo3cms/ExtensionManualExample/

.. index::
   Path; EXT:{extkey}/Resources
   pair: Extensions; JavaScript
   pair: Extensions; CSS

Resources
  Contains the sub folders :code:`Public/` and :code:`Private/`, which
  contain resources, possibly in further subfolders, e.g.
  :code:`Templates/`, :code:`Css/`, :code:`Language/`, :code:`Images/`
  or :code:`JavaScript/`. This is also the directory for non–TYPO3 files supplied with the
  extension. TYPO3 is licensed under GPL version 2 or any later version.
  Any non–TYPO3 code must be compatible with GPL version 2 or any later
  version.

.. index:: Path; EXT:{extkey}/Resources/Private/Language

Resources/Private/Language
  XLIFF files for localized labels.

.. index:: Path; EXT:{extkey}/Resources/Private/Layouts

Resources/Private/Layouts
  Main layouts for (Fluid) views.

.. index:: Path; EXT:{extkey}/Resources/Private/Partials

Resources/Private/Partials
  Partial templates for repetitive use.

.. index:: Path; EXT:{extkey}/Resources/Private/Templates

Resources/Private/Templates
  One template per action, stored in a folder named after each Controller.

.. index:: Path; EXT:{extkey}/Resources/Public

Resources/Public
   Public assets used in extensions (files that should be delivered by the web
   server) must be located in the Resources/Public folder of the extension. This folder should
   only be used for static assets. If you need to create assets
   during runtime, they should be stored in :code:`typo3temp/`.

   .. deprecated:: 11.5
      Having public assets in any but the folder Resources/Public has been
      deprecated with version 11.5.

.. index:: Path; EXT:{extkey}/Resources/Public/Css

Resources/Public/Css
  Any CSS file used by the extension.

.. index:: Path; EXT:{extkey}/Resources/Public/Images

Resources/Public/Images
  Any images used by the extension.

.. index:: Path; EXT:{extkey}/Resources/Public/JavaScript

Resources/Public/JavaScript
  Any JS file used by the extension.

.. index:: Path; EXT:{extkey}/Tests/Unit

Tests/Unit
  Contains unit tests and fixtures.

.. index:: Path; EXT:{extkey}/Tests/Functiona

Tests/Functional
  Contains functional tests and fixtures.
