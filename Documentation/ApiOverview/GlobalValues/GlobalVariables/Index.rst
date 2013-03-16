.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _globals-variables:

Global variables
^^^^^^^^^^^^^^^^

.. note::
   Variables in italics *may* be set in a script prior to
   inclusion of :file:`init.php` so they are optional.

.. note::
   The variables from :file:`t3lib/stddb/tables.php` are only
   available in the frontend occasionally or partly.

.. t3-field-list-table::
 :header-rows: 1

 - :Variable,20: Global variable
   :Defined,20: Defined in
   :Description,50: Description
   :FE,10: Avail. in FE


 - :Variable:
         $TYPO3\_CONF\_VARS
   :Defined:
         config\_default.php
   :Description:
         TYPO3 configuration array. Please refer to the source code of
         :file:`t3lib/config_default.php` where each option is described in detail
         as comments. The same comments are also available in the Install Tool
         under the menu "All Configuration"
   :FE:
         Yes


 - :Variable:
         $TYPO3\_LOADED\_EXT
   :Defined:
         config\_default.php
   :Description:
         Array with all loaded extensions listed with a set of paths. You can
         check if an extension is loaded by the function
         :code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($key)` where :code:`$key` is the extension key.
   :FE:
         Yes


 - :Variable:
         $TYPO3\_DB
   :Defined:
         init.php
   :Description:
         An instance of the TYPO3 DB wrapper class, :code:`t3lib_db`.

         You have to use this object for all interaction with the database.

         :code:`t3lib_db` contains mysql wrapper functions so you easily swap all
         hardcoded MySQL calls with function calls to :code:`$GLOBALS['TYPO3_DB']->`.
   :FE:
         Yes


 - :Variable:
         $EXEC\_TIME
   :Defined:
         config\_default.php
   :Description:
         Is set to :code:`time()` so that the rest of the script has a common value
         for the script execution time.
   :FE:
         YES


 - :Variable:
         $SIM\_EXEC\_TIME
   :Defined:
         config\_default.php
   :Description:
         Is set to :code:`$EXEC_TIME` but can be altered later in the script if we
         want to simulate another execution-time when selecting from e.g. a
         database (used in the frontend for preview of future and past dates)
   :FE:
         Yes


 - :Variable:
         $TYPO\_VERSION
   :Defined:
         config\_default.php
   :Description:
         *Deprecated - used constant "TYPO3\_version" instead!*
   :FE:
         Yes


 - :Variable:
         $TYPO3\_AJAX
   :Defined:
         ajax.php
   :Description:
         Set to true to indicate that an AJAX call is being processed
   :FE:
         No


 - :Variable:
         $CLIENT
   :Defined:
         init.php
   :Description:
         Array with browser information (based on HTTP\_USER\_AGENT). Array
         keys:

         "BROWSER" = msie,net,opera or blank,

         "VERSION" = browser version as double,

         "SYSTEM" = win,mac,unix
   :FE:
         Yes


 - :Variable:
         $PARSETIME\_START
   :Defined:
         init.php
   :Description:
         Time in milliseconds right after inclusion of the configuration.
   :FE:
         No


 - :Variable:
         $PAGES\_TYPES
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         See :ref:`TCA Reference<t3tca:start>`
   :FE:
         (occasionally)


 - :Variable:
         $ICON\_TYPES
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         See :ref:`TCA Reference<t3tca:start>`
   :FE:
         (occasionally)


 - :Variable:
         $LANG\_GENERAL\_LABELS
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         See :ref:`TCA Reference<t3tca:start>`
   :FE:
         (occasionally)


 - :Variable:
         $TCA
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         See :ref:`TCA Reference<t3tca:start>`
   :FE:
         Yes, partly


 - :Variable:
         $TBE\_MODULES
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         The backend main/sub-module structure. See section elsewhere plus
         source code of class :code:`\TYPO3\CMS\Backend\Module\ModuleLoader` which also includes some
         examples.
   :FE:
         (occasionally)


 - :Variable:
         $TBE\_STYLES
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         Contains information related to BE skinning.
   :FE:
         (occasionally)


 - :Variable:
         $T3\_SERVICES
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         Global registration of services.
   :FE:
         Yes


 - :Variable:
         $T3\_VAR
   :Defined:
         config\_default.php
   :Description:
         Space for various internal global data storage in TYPO3. Each key in
         this array is a data space for an application. Keys currently defined
         for use is:

         ['callUserFunction'] + ['callUserFunction\_classPool']: Used by
         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction` to store singleton objects.

         ['getUserObj'] : Used by :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj` to store singleton
         objects.

         ['RTEobj'] : Used to hold the current RTE object if any. See
         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility`.

         ['ext'][ *extension-key* ] : Free space for extensions.
   :FE:
         Yes


 - :Variable:
         $FILEICONS
   :Defined:
         t3lib/stddb/tables.php
   :Description:
         Associative array; keys are the type (e.g. "tif") and values are the
         filename (without path).
   :FE:
         (occasionally)


 - :Variable:
         $WEBMOUNTS
   :Defined:
         init.php
   :Description:
         Array of uid's to be mounted in the page-tree.
   :FE:
         (depends)


 - :Variable:
         $FILEMOUNTS
   :Defined:
         init.php
   :Description:
         Array of filepaths on the server to be mounted in the directory tree.
   :FE:
         (depends)


 - :Variable:
         $BE\_USER
   :Defined:
         init.php
   :Description:
         Backend user object. See :ref:`be-user`.
   :FE:
         (depends)


 - :Variable:
         $temp\_\*
   :Defined:
         -
   :Description:
         Various temporary variables are allowed to use global variables
         prefixed :code:`$temp_`.
   :FE:
         -


 - :Variable:
         *$TBE\_MODULES\_EXT*
   :Defined:
         [In ext\_tables.php files of extensions]
   :Description:
         Used to store information about modules from extensions that should be
         included in "function menus" of real modules. See the Extension API
         for details.

         Unset in :code:`config_default.php`.
   :FE:
         (occasionally)


 - :Variable:
         *$TCA\_DESCR*
   :Defined:
         [tables.php files]
   :Description:
         Can be set to contain file references to local lang files containing
         TCA\_DESCR labels. See section about Context Sensitive Help.

         Unset in :code:`config_default.php`.
   :FE:
         No


.. _globals-exploring:

Exploring global variables
""""""""""""""""""""""""""

Many of the global variables described above can be inspected using the
Admin Tools > Configuration module.

.. warning::
   This module is always viewed in the BE context. Variables defined
   only in the FE context will not be visible there.

.. figure:: ../../../Images/ConfigurationModule.png
   :alt: The Configuration module in Admin Tools

   Viewing the :code:`$TCA` array using the Admin Tools > Configuration module

