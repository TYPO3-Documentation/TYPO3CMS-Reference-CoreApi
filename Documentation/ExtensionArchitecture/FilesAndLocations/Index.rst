

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


.. _extension-files-locations:

Files and locations
^^^^^^^^^^^^^^^^^^^


.. _extension-files:

Files
"""""

An extension consists of

#. a directory named by the  *extension key* (which is a worldwide unique
   identification string for the extension)

#. standard files with reserved names for configuration related to TYPO3
   (of which most are optional, see list below)

#. any number of additional files for the extension itself.


.. _extension-reserved-filenames:

Reserved filenames
""""""""""""""""""

This list of filenames are all reserved filenames in the root
directory of extensions. None of them are required but for example you
cannot have a TYPO3 extension recognized by TYPO3 without the
"ext\_emconf.php" file etc. You can read more details like that in the
table below.

In general, do not introduce your own files in root directory of
extensions with the name prefix "ext\_".


.. t3-field-list-table::
 :header-rows: 1

 - :Filename,20:    Filename
   :Description,80: Description

 - :Filename: ext\_emconf.php
   :Description:
         Definition of extension properties.

         Name, category, status etc. Used by the EM. The content of this file
         is described in more details below. Note that it is auto-written by EM
         when extensions are imported from the repository.

         .. note::
            If this file is  *not* present the EM will  *not* find the
            extension.


 - :Filename: ext\_localconf.php
   :Description:
         Addition to :code:`localconf.php` which is included if found. Should
         contain additional configuration of :code:`$TYPO3_CONF_VARS` and may include
         additional PHP class files.

         All :code:`ext_localconf.php` files of included extensions are
         included right  **after** the :code:`typo3conf/localconf.php` file has
         been included and database constants defined. Therefore you cannot
         setup database name, username, password though, because database
         constants are defined already at this point.

         .. note::
            Observe rules for content of these files. See section on
            caching below.

 - :Filename: ext\_tables.php
   :Description:
         Addition to :code:`tables.php` which is included if found.
         Shouldcontain configuration of tables, modules, backend styles etc.
         Everything which can be done in an "extTables" file is allowed here.

         All :code:`ext_tables.php` files of loaded extensions are included
         right  **after** the :code:`tables.php` file in the order they are
         defined in the global array :code:`TYPO3_LOADED_EXT` but right
         before a general "extTables" file (defined with the var
         :code:`$typo_db_extTableDef_script` in the
         :code:`typo3conf/localconf.php` file, later set as the constant
         :code:`TYPO3_extTableDef_script` ). Thus a general "extTables" file
         in typo3conf/ may overrule any settings made by loaded extensions.

         You should  *not* use this file for setting up
         :code:`$TYPO3_CONF_VARS` . See "ext\_localconf.php" above.

         .. note::
            Observe rules for content of these files. See section below.

 - :Filename: ext\_tables.sql
   :Description:
         SQL definition of database tables.

         This file should contain a table-structure dump of the tables used by
         the extension. It is used for evaluation of the database structure and
         is therefore important to check and update the database when an
         extension is enabled.If you add additional fields (or depend on
         certain fields) to existing tables you can also put them here. In that
         case insert a CREATE TABLE structure for that table, but remove all
         lines except the ones defining the fields you need.The ext\_tables.sql
         file may not necessarily be "dumpable" directly to MySQL (because of
         the semi-complete table definitions allowed defining only required
         fields, see above). But the EM or Install Tool can handle this. The
         only very important thing is that the syntax of the content is exactly
         like MySQL made it so that the parsing and analysis of the file is
         done correctly by the EM.

 - :Filename: ext\_tables\_static+adt.sql
   :Description:
         Static SQL tables and their data.

         If the extension requires static data you can dump it into a sql-file
         by this name.Example for dumping mysql data from bash (being in the
         extension directory):

         ::

            mysqldump --password=[password] [database name] [tablename] --add-drop-table > ./ext_tables_static.sql

         :code:`--add-drop-table` will make sure to include a DROP TABLE
         statement so any data is inserted in a fresh table.

         You can also drop the table content using the EM in the backend.

         .. note::
            The table structure of static tables needs to be in the
            ext\_tables.sql file as well - otherwise an installed static table
            will be reported as being in excess in the EM!

 - :Filename: ext\_typoscript\_constants.txt
   :Description:
         Preset TypoScript constants

         *Deprecated (use static template files instead, see Extension Management (extMgm) API
         description)*

         Such a file will be included in the constants section of all
         TypoScript templates.

 - :Filename: ext\_typoscript\_setup.txt
   :Description:
         Preset TypoScript setup

         *Deprecated (use static template files instead, see Extension Management (extMgm) API
         description)*

         Such a file will be included in the setup section of all TypoScript
         templates.

 - :Filename: ext\_typoscript\_editorcfg.txt
   :Description:
         ext\_typoscript\_editorcfg.txt
         *Deprecated*

         This file is not used anymore. It may be encountered in very old extensions.

 - :Filename: ext\_conf\_template.txt
   :Description:
         Extension Configuration template.

         Configuration code in TypoScript syntax setting up a series of values
         which can be configured for the extension in the EM.

         If this file is present the EM provides you with an interface for
         editing the configuration values defined in the file. The result is
         written as a serialized array to :code:`localconf.php` file in the
         variable :code:`$TYPO3_CONF_VARS['EXT']['extConf'][`
         :code:`*extension_key*` :code:`]`

         The content of the "res/" folder is used for filelists in
         configuration forms.

         If you want to do user processing before the content from the
         configuration form is saved (or shown for that sake) there is a hook
         in the EM which is configurable with :code:`$TYPO3_CONF_VARS
         ['SC_OPTIONS']['typo3/mod/tools/em/index.php']['tsStyleConfigForm'][] = "`
         :code:`*function reference*` :code:`"`

 - :Filename: ext\_icon.gif
   :Description:
         Extension Icon

         18x16 gif icon for the extension.

 - :Filename: (\*/) locallang\*.xml
   :Description:
         Localized strings.

         The filename :code:`locallang.xml` (or any file matching
         :code:`locallang*.xml` ) is used for traditional definition of
         language labels in the :code:`$LOCAL_LANG` array. If you use this
         name consistently those files will be detected by the translation
         tool!

 - :Filename: class.ext\_update.php
   :Description:
         Local Update tool class

         If this file is found it will install a new menu item, "UPDATE", in
         the EM when looking at details for the extension. When this menu item
         is selected the class inside of this file (named "ext\_update") will
         be instantiated and the method "main()" will be called and expected to
         return HTML content.

         Also you must add the function "access()" and make it return a boolean
         value whether or not the menu item should be shown. This feature is
         meant to let you disable the update tool if you can somehow detect
         that it has already been run and doesn't need to run again.The point
         of this file is to give extension developers the possibility to
         provide an update tool if their extensions in newer versions require
         some updates to be done.

 - :Filename: ext\_autoload.php
   :Description:
         Since TYPO3 4.3, it is possible to declare classes in this file so
         that they will be automatically detected by the TYPO3 autoloader. This
         means that it is not necessary to require the related class files
         anymore. See the "Autoloading" chapter for more details.

 - :Filename: ext\_api\_php.dat
   :Description:
         PHP API data

         A file containing a serialized PHP array with API information for the
         PHP classes in the extension. The file is created - and viewed! - with
         tools found in the extension "extdeveval" (Extension Development
         Evaluator)

 - :Filename: pi\*/
   :Description:
         Typical folder for a frontend plugin class.

 - :Filename: mod\*/
   :Description:
         Typical folder for a backend module.

 - :Filename: sv\*/
   :Description:
         Typical folder for a service.

 - :Filename: res\*/
   :Description:
         Extensions normally consist of other files: Classes, images, html-
         files etc. Files not related to either a frontend plugin (pi/) or
         backend module (mod/) might be put in a subfolder of the extension
         directory named "res/" (for "resources") but you can do it as you like
         (inside of the extension directory that is).The "res/" folder content
         will be listed as files you can select in the configuration interface.

         Files in this folder can also be selected in a selector box if you set
         up Extension configuration in a "ext\_conf\_template.txt" file.

