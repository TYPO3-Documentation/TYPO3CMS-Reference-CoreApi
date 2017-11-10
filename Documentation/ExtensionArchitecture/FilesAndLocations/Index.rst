.. include:: ../../Includes.txt


.. _extension-files-locations:

===================
Files and locations
===================

**EM** stands for **Extension Manager**.


.. _extension-files:

Files
"""""

An extension consists of:

#. a directory named by the *extension key* (which is a worldwide unique
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

In general, do not introduce your own files in the root directory of
extensions with the name prefix "ext\_".


.. t3-field-list-table::
 :header-rows: 1

 - :Filename,20:    Filename
   :Description,80: Description

 - :Filename: ext\_emconf.php
   :Description:
         Definition of extension properties.

         |

         Name, category, status etc. Used by the EM. The content of this file
         is described in more details below. Note that it is auto-written by EM
         when extensions are imported from the repository.

         .. note::
            If this file is *not* present the EM will *not* find the
            extension.


 - :Filename: ext\_localconf.php
   :Description:
         Addition to :code:`LocalConfiguration.php` which is included if found. Should
         contain additional configuration of :code:`$GLOBALS['TYPO3_CONF_VARS']` and may include
         additional PHP class files.

         |

         All :code:`ext_localconf.php` files of included extensions are
         included right  **after** the :code:`typo3conf/LocalConfiguration.php` file
         has been included and database constants defined. Therefore you cannot
         setup database name, username, password though, because database
         constants are defined already at this point.

         .. note::
            Observe rules for content of these files. See section on
            caching below.

 - :Filename: ext\_tables.php
   :Description:
         Included if found. Contains extensions of existing tables,
         declaration of modules, backend styles etc. All code in such files
         is included after all the default definitions provided by the Core.

         |

         Since TYPO3 CMS 6.1, definition of new database tables should be
         done entirely in :file:`Configuration/TCA/(name of the table).php`.
         These files are expected to contain the full TCA of the given table
         (as an array) and simply return it (with a :code:`return` statement).

         |

         Since TYPO3 CMS 6.2, customizations of existing tables should be
         done entirely in :file:`Configuration/TCA/Overrides/(name of the table).php`.
         This way the TCA changes are cached.

 - :Filename: ext\_tables.sql
   :Description:
         SQL definition of database tables.

         |

         This file should contain a table-structure dump of the tables used by
         the extension. It is used for evaluation of the database structure and
         is therefore important to check and update the database when an
         extension is enabled.If you add additional fields (or depend on
         certain fields) to existing tables you can also put them here. In that
         case insert a :code:`CREATE TABLE` structure for that table, but remove all
         lines except the ones defining the fields you need.

         |

         The :file:`ext\_tables.sql` file may not necessarily be "dumpable" directly to MySQL (because of
         the semi-complete table definitions allowed defining only required
         fields, see above). But the EM or Install Tool can handle this. The
         only very important thing is that the syntax of the content is exactly
         like MySQL made it so that the parsing and analysis of the file is
         done correctly by the EM.

 - :Filename: ext\_tables\_static+adt.sql
   :Description:
         Static SQL tables and their data.

         |

         If the extension requires static data you can dump it into a sql-file
         by this name.Example for dumping mysql data from bash (being in the
         extension directory):

         .. code-block:: csh

            mysqldump --password=[password] [database name] [tablename] --add-drop-table > ./ext_tables_static.sql

         :code:`--add-drop-table` will make sure to include a DROP TABLE
         statement so any data is inserted in a fresh table.

         |

         You can also drop the table content using the EM in the backend.

         .. note::
            The table structure of static tables needs to be in the
            ext\_tables.sql file as well - otherwise an installed static table
            will be reported as being in excess in the EM!
           
         .. warning::
         
            Static data is not meant to be extended by other extensions. On re-import 
            all extended fields and data is lost due to `DROP TABLE` statements.
            

 - :Filename: ext\_typoscript\_constants.txt
   :Description:
         Preset TypoScript constants. Will be included in the constants section of all
         TypoScript templates.

         .. warning::

            Use such a file if you absolutely need to load some TS (because you would get serious errors without it).
            Otherwise static templates or usage of the
            :ref:`Extension Management API <t3cmsapi:TYPO3\\CMS\\Core\\Utility\\ExtensionManagementUtility>`
            are preferred.

 - :Filename: ext\_typoscript\_setup.txt
   :Description:
         Preset TypoScript setup. Will be included in the setup section of all TypoScript
         templates.

         .. warning::

            Use such a file if you absolutely need to load some TS (because you would get serious errors without it).
            Otherwise static templates or usage of the
            :ref:`Extension Management API <t3cmsapi:TYPO3\\CMS\\Core\\Utility\\ExtensionManagementUtility>`
            are preferred.

 - :Filename: ext\_conf\_template.txt
   :Description:
         Extension Configuration template.

         |

         Configuration code in TypoScript syntax setting up a series of values
         which can be configured for the extension in the EM.
         :ref:`Read more about the file format here <extension-options>`.


         |

         If this file is present the EM provides you with an interface for
         editing the configuration values defined in the file. The result is
         written as a serialized array to :code:`LocalConfiguration.php`
         in the variable :code:`$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][`
         :code:`*extension_key*` :code:`]`

         |

         If you want to do user processing before the content from the
         configuration form is saved (or shown for that sake) there is a hook
         in the EM which is configurable with :code:`$GLOBALS['TYPO3_CONF_VARS']
         ['SC_OPTIONS']['typo3/mod/tools/em/index.php']['tsStyleConfigForm'][] = "`
         :code:`*function reference*` :code:`"`

 - :Filename: ext\_icon.gif, ext\_icon.png or ext\_icon.svg
   :Description:
         Extension Icon

         |

         18x16 GIF, PNG or SVG icon for the extension.

         .. note::

            Extension icon will look nicer when provided as vector graphics (SVG)
            rather than bitmaps (GIF or PNG).


 - :Filename: class.ext\_update.php
   :Description:
         Local Update tool class

         |

         If this file is found it will install a new menu item, "UPDATE", in
         the EM when looking at details for the extension. When this menu item
         is selected the class inside of this file (named "ext\_update") will
         be instantiated and the method "main()" will be called and expected to
         return HTML content.

         |

         Also you must add the function "access()" and make it return a boolean
         value whether or not the menu item should be shown. This feature is
         meant to let you disable the update tool if you can somehow detect
         that it has already been run and doesn't need to run again.The point
         of this file is to give extension developers the possibility to
         provide an update tool if their extensions in newer versions require
         some updates to be done.

 - :Filename: ext\_autoload.php
   :Description:
         Since TYPO3 CMS 4.3, it is possible to declare classes in this file so
         that they will be automatically detected by the TYPO3 autoloader. This
         means that it is not necessary to require the related class files
         anymore. See the :ref:`autoload` chapter for more details.

         |

         Not needed anymore since TYPO3 CMS 6.1, when using :ref:`namespaces <namespaces>`.


.. _extension-reserved-folders:

Reserved folders
""""""""""""""""

The current standard for files location - except for the special files mentioned
above - is inspired by TYPO3 Flow. It is necessary to use such structure in Extbase-based
extensions and recommended for all extensions anyway.

In order to use :ref:`namespaces`, class files **must** be located in a
:file:`Classes` folder.

Refer to the :ref:`Extbase and Fluid <t3extbasebook:start>` book for more information
on extension structure. Also look at the "examples" extension.

The `Extension Builder extension <http://typo3.org/extensions/repository/view/extension_builder>`_
will create the right structure for you. It is described below:

Classes/Controller
  Contains MVC Controller classes.

Classes/Domain/Model
  Contains MVC Domain model classes.

Classes/Domain/Repository
  Contains data repository classes.

Classes/ViewHelpers
  Helper classes used in the views.

Configuration/TsConfig/Page
  Page TSconfig, see chapter :ref:`'Page TSconfig' in the TSconfig Reference <t3tsconfig:PageTSconfig>`.
  Files should have the file extension :file:`.tsconfig`.
  
Configuration/TsConfig/User
  User TSconfig, see chapter :ref:`'User TSconfig' in the TSconfig Reference <t3tsconfig:UserTSconfig>`.
  Files should have the file extension :file:`.tsconfig`.

Configuration/TypoScript
  TypoScript static setup (:file:`setup.txt`) and constants (:file:`constants.txt`).
  Use subfolders if your have several static templates.

Configuration/TCA
  One file per database table, using the name of the table for the file, plus ".php".
  Only for new tables.

Configuration/TCA/Overrides
  For extending existing tables, one file per database table,
  using the name of the table for the file, plus ".php".

Documentation
  Contains the manual in reStructuredText format (:ref:`read more on the topic <extension-documentation>`).

Resources/Private/Language
  XLIFF files for localized labels.

Resources/Private/Layouts
  Main layouts for the views.

Resources/Private/Partials
  Partial templates for repetitive use.

Resources/Private/Templates
  One template per action, stored in a folder named after each Controller.

Resources/Public/Css
  Any CSS file used by the extension.

Resources/Public/Images
  Any images used by the extension.

Resources/Public/JavaScript
  Any JS file used by the extension.

Tests/Unit
  Contains unit testing classes.


.. _extension-reserved-folders-legacy:

Legacy structure
~~~~~~~~~~~~~~~~

The structure of older extensions was not so clearly defined, but it generally
adhered to the following conventions:

.. t3-field-list-table::
 :header-rows: 1

 - :Filename,20:    Filename
   :Description,80: Description

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
