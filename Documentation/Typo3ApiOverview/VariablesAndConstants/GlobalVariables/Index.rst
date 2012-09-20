

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


Global variables
^^^^^^^^^^^^^^^^

**Notice:** Variables in italics  *may* be set in a script prior to
inclusion of "init.php" so they are optional.

**Notice:** The variables from "t3lib/stddb/tables.php" are only
available in the frontend occasionally or partly. Please read more in
the documentation of the "cms" extension on this issue.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Global variable
         Global variable

   Defined in
         Defined in

   Description
         Description

   Avail. in FE
         Avail. in FE


.. container:: table-row

   Global variable
         $TYPO3\_CONF\_VARS

   Defined in
         config\_default.php

   Description
         TYPO3 configuration array. Please refer to the source code of
         "t3lib/config\_default.php" where each option is described in detail
         as comments. The same comments are also available in the Install Tool
         under the menu "All Configuration"

   Avail. in FE
         YES


.. container:: table-row

   Global variable
         $TYPO3\_LOADED\_EXT

   Defined in
         config\_default.php

   Description
         Array with all loaded extensions listed with a set of paths. You can
         check if an extension is loaded by the function
         t3lib\_extMgm::isLoaded($key) where $key is the extension key of the
         module.

   Avail. in FE
         YES


.. container:: table-row

   Global variable
         $TYPO3\_DB

   Defined in
         init.php

   Description
         An instance of the TYPO3 DB wrapper class, t3lib\_db.

         You have to use this object for all interaction with the database.

         t3lib\_db contains mysql wrapper functions so you easily swap all
         hardcoded MySQL calls with function calls to $GLOBALS['TYPO3\_DB']->

   Avail. in FE
         YES


.. container:: table-row

   Global variable
         $EXEC\_TIME

   Defined in
         config\_default.php

   Description
         Is set to "time()" so that the rest of the script has a common value
         for the script execution time.

   Avail. in FE
         YES


.. container:: table-row

   Global variable
         $SIM\_EXEC\_TIME

   Defined in
         config\_default.php

   Description
         Is set to $EXEC\_TIME but can be altered later in the script if we
         want to simulate another execution-time when selecting from e.g. a
         database (used in the frontend for preview of future and past dates)

   Avail. in FE
         YES


.. container:: table-row

   Global variable
         $TYPO\_VERSION

   Defined in
         config\_default.php

   Description
         *Deprecated - used constant "TYPO3\_version" instead!*

   Avail. in FE
         YES


.. container:: table-row

   Global variable
         $TYPO3\_AJAX

   Defined in
         ajax.php

   Description
         Set to true to indicate that an AJAX call is being processed

   Avail. in FE
         -


.. container:: table-row

   Global variable
         $CLIENT

   Defined in
         init.php

   Description
         Array with browser information (based on HTTP\_USER\_AGENT). Array
         keys:

         "BROWSER" = msie,net,opera or blank,

         "VERSION" = browser version as double,

         "SYSTEM" = win,mac,unix

   Avail. in FE
         YES


.. container:: table-row

   Global variable
         $PARSETIME\_START

   Defined in
         init.php

   Description
         Time in milliseconds right after inclusion of the configuration.

   Avail. in FE
         -


.. container:: table-row

   Global variable
         $PAGES\_TYPES

   Defined in
         t3lib/stddb/tables.php

   Description
         See section on $TCA

   Avail. in FE
         (occastionally)


.. container:: table-row

   Global variable
         $ICON\_TYPES

   Defined in
         t3lib/stddb/tables.php

   Description
         See section on $TCA

   Avail. in FE
         (occastionally)


.. container:: table-row

   Global variable
         $LANG\_GENERAL\_LABELS

   Defined in
         t3lib/stddb/tables.php

   Description
         See section on $TCA

   Avail. in FE
         (occastionally)


.. container:: table-row

   Global variable
         $TCA

   Defined in
         t3lib/stddb/tables.php

   Description
         See section on $TCA

   Avail. in FE
         YES, partly


.. container:: table-row

   Global variable
         $TBE\_MODULES

   Defined in
         t3lib/stddb/tables.php

   Description
         The backend main/sub module structure. See section elsewhere plus
         sourcecode of "class.t3lib\_loadmodules.php" which also includes some
         examples.

   Avail. in FE
         (occastionally)


.. container:: table-row

   Global variable
         $TBE\_STYLES

   Defined in
         t3lib/stddb/tables.php

   Description


   Avail. in FE
         (occastionally)


.. container:: table-row

   Global variable
         $T3\_SERVICES

   Defined in
         t3lib/stddb/tables.php

   Description
         Global registration of services.

   Avail. in FE


.. container:: table-row

   Global variable
         $T3\_VAR

   Defined in
         config\_default.php

   Description
         Space for various internal global data storage in TYPO3. Each key in
         this array is a data space for an application. Keys currently defined
         for use is:

         ['callUserFunction'] + ['callUserFunction\_classPool']: Used by
         t3lib\_div::callUserFunction to store persistent objects.

         ['getUserObj'] : User by t3lib\_div::getUserObj to store persistent
         objects.

         ['RTEobj'] : Used to hold the current RTE object if any. See
         t3lib\_BEfunc.

         ['ext'][ *extension-key* ] : Free space for extensions.

   Avail. in FE


.. container:: table-row

   Global variable
         $FILEICONS

   Defined in
         t3lib/stddb/tables.php

   Description
         Assoc. array; keys are the type (e.g. "tif") and values are the
         filename (without path)

   Avail. in FE
         (occastionally)


.. container:: table-row

   Global variable
         $WEBMOUNTS

   Defined in
         init.php

   Description
         Array of uid's to be mounted in the page-tree

   Avail. in FE
         (depends)


.. container:: table-row

   Global variable
         $FILEMOUNTS

   Defined in
         init.php

   Description
         Array of filepaths on the server to be mountet in the directory tree

   Avail. in FE
         (depends)


.. container:: table-row

   Global variable
         $BE\_USER

   Defined in
         init.php

   Description
         Backend user object

   Avail. in FE
         (depends)


.. container:: table-row

   Global variable
         $temp\_\*

   Defined in
         -

   Description
         Various temporary variables are allowed to use global variables
         prefixed $temp\_

   Avail. in FE
         -


.. container:: table-row

   Global variable
         $typo\_db\*

   Defined in
         [config\_default.php but N/A!]

   Description
         Variables used inside of "typo3conf/localconf.php" to configure the
         database.

         **Notice:** These values are unset again by "config\_default.php".

   Avail. in FE
         -


.. container:: table-row

   Global variable
         *$TBE\_MODULES\_EXT*

   Defined in
         [In ext\_tables.php files of extensions]

   Description
         Used to store information about modules from extensions that should be
         included in "function menus" of real modules. See the Extension API
         for details.

         Unset in "config\_default.php"

   Avail. in FE
         (occasionally)


.. container:: table-row

   Global variable
         *$TCA\_DESCR*

   Defined in
         [tables.php files]

   Description
         Can be set to contain file references to local lang files containing
         TCA\_DESCR labels. See section about Context Sensitive Help.

         Unset in "config\_default.php"

   Avail. in FE


.. ###### END~OF~TABLE ######

