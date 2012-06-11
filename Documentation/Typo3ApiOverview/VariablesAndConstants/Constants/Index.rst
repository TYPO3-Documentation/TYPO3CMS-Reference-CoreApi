

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


Constants
^^^^^^^^^

Constants normally define paths and database information. These values
are global and cannot be changed when they are first defined. This is
why constants are used for such vital information.

These constants are defined by either init.php or scripts included
from that script.

**Notice:** Constants in italics  *may* be set in a script prior to
inclusion of init.php so they are optional.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Constant
         Constant
   
   Defined in
         Defined in
   
   Description
         Description
   
   Avail. in FE
         Avail. in FE


.. container:: table-row

   Constant
         TYPO3\_OS
   
   Defined in
         init.php
   
   Description
         Operating systen; Windows = “WIN”, other = “” (presumed to be some
         sort of Unix)
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_MODE
   
   Defined in
         init.php
   
   Description
         Mode of TYPO3: Set to either “FE” or “BE” depending on frontend or
         backend execution. So in "init.php" and "thumbs.php" this value is
         "BE"
   
   Avail. in FE
         YES
         
         value = "FE"


.. container:: table-row

   Constant
         PATH\_thisScript
   
   Defined in
         init.php
   
   Description
         Abs. path to current script.
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_mainDir
   
   Defined in
         init.php
   
   Description
         This is the directory of the backend administration for the sites of
         this TYPO3 installation. Hardcoded to “typo3/”. Must be a subdirectory
         to the website. See elsewhere for descriptions on how to change the
         default admin directory, "typo3/", to something else.
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         PATH\_typo3
   
   Defined in
         init.php
   
   Description
         Abs. path of the TYPO3 admin dir (PATH\_site + TYPO3\_mainDir).
   
   Avail. in FE
         -


.. container:: table-row

   Constant
         PATH\_typo3\_mod
   
   Defined in
         init.php
   
   Description
         Relative path (from the PATH\_typo3) to a properly configured module.
         Based on TYPO3\_MOD\_PATH.
   
   Avail. in FE
         -


.. container:: table-row

   Constant
         PATH\_site
   
   Defined in
         init.php
   
   Description
         Abs. path to directory with the frontend (one directory above
         PATH\_typo3)
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         PATH\_t3lib
   
   Defined in
         init.php
   
   Description
         Abs. path to "t3lib/" (general TYPO3 library) within the TYPO3 admin
         dir
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         PATH\_typo3conf
   
   Defined in
         init.php
   
   Description
         Abs. TYPO3 configuration path (local, not part of source)
         
         Must be defined in order for "t3lib/config\_default.php" to return!
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_db
   
   Defined in
         config\_default.php
   
   Description
         Name of the database, for example "t3\_coreinstall". Is defined after
         the inclusion of "typo3conf/localconf.php" (same for the other
         TYPO3\_\* constants below
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_db\_username
   
   Defined in
         config\_default.php
   
   Description
         Database username
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_db\_password
   
   Defined in
         config\_default.php
   
   Description
         Database password
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_db\_host
   
   Defined in
         config\_default.php
   
   Description
         Database hostname, e.g. “localhost”
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_tables\_script
   
   Defined in
         config\_default.php
   
   Description
         By default "t3lib/stddb/tables.php" is included as the main table
         definition file. Alternatively this constant can be set to the
         filename of an alternative "tables.php" file. Must be located in
         "typo3conf/"
         
         **Deprecated** . Make Extensions instead.
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_extTableDef\_script
   
   Defined in
         config\_default.php
   
   Description
         Name of a php-include script found in "typo3conf/" that contains php-
         code that further modifies the variables set by
         "t3lib/stddb/tables.php"
         
         **Deprecated.** Make Extensions instead.
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_languages
   
   Defined in
         config\_default.php
   
   Description
         Defines the system language keys in TYPO3s backend.
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         TYPO3\_DLOG
   
   Defined in
         config\_default.php
   
   Description
         If true, calls to t3lib\_div::devLog() can be made in both frontend
         and backend; This is event logging which can help to track debugging
         in general.
   
   Avail. in FE
         YES


.. container:: table-row

   Constant
         *TYPO3\_MOD\_PATH*
   
   Defined in
         [prior to init.php]
   
   Description
         Path to module relative to PATH\_typo3 (as defined in the module
         configuration). Must be defined prior to "init.php".
   
   Avail. in FE
         -


.. container:: table-row

   Constant
         *TYPO3\_enterInstallScript*
   
   Defined in
         [prior to init.php]
   
   Description
         If defined and set true the Install Tool is activated and the script
         exits after that. Used in "typo3/install/index.php":
         
         **Example:**
         
         ::
         
            define('TYPO3_enterInstallScript', '1');
   
   Avail. in FE
         -


.. container:: table-row

   Constant
         *TYPO3\_PROCEED\_IF\_NO\_USER*
   
   Defined in
         [prior to init.php]
   
   Description
         If defined and set true the "init.php" script will return to the
         parent script  *even if no backend user was authenticated!*
         
         This constant is set by for instance the "index.php" script so it can
         include "init.php" and still show the login form:
         
         ::
         
            define("TYPO3_PROCEED_IF_NO_USER", 1);
            require ("init.php");
         
         Please be very careful with this feature - use it only when you have
         total control of what you are doing!
   
   Avail. in FE
         -


.. container:: table-row

   Constant
         *TYPO3\_cliMode*
   
   Defined in
         [prior to init.php]
   
   Description
         Initiates CLI (Command Line Interface) mode. This is used when you
         want a shell executable PHP script to initialize a TYPO3 backend.
         
         For more details see section about “Initialize TYPO3 backend in a PHP
         shell script” in “Inside TYPO3”
   
   Avail. in FE


.. container:: table-row

   Constant
         *TYPO3\_version*
   
   Defined in
         config\_default.php
   
   Description
         The TYPO3 version:
         
         x.x.x for released versions,
         
         x.x.x-dev for development versions leading up to releases
         
         x.x.x-bx for beta-versions
   
   Avail. in FE
         YES


.. ###### END~OF~TABLE ######

