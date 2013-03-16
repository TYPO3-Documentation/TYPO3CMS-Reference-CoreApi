.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _globals-constants:

Constants
^^^^^^^^^

Constants normally define paths and database information. These values
are global and cannot be changed when they are first defined. This is
why constants are used for such vital information.

These constants are defined at various points during the bootstrap sequence.

.. t3-field-list-table::
 :header-rows: 1

 - :Constant,20: Constant
   :Defined,20: Defined in
   :Description,50: Description
   :FE,10: Avail. in FE


 - :Constant:
         TYPO3\_OS
   :Defined:
         init.php
   :Description:
         Operating systen; Windows = "WIN", other = "" (presumed to be some
         sort of Unix)
   :FE:
         Yes


 - :Constant:
         TYPO3\_MODE
   :Defined:
         init.php
   :Description:
         Mode of TYPO3: Set to either "FE" or "BE" depending on frontend or
         backend execution. So in :file:`init.php` and file:`thumbs.php` this value is
         "BE".
   :FE:
         Yes

         value = "FE"


 - :Constant:
         PATH\_thisScript
   :Defined:
         init.php
   :Description:
         Abs. path to current script.
   :FE:
         Yes


 - :Constant:
         TYPO3\_mainDir
   :Defined:
         init.php
   :Description:
         This is the directory of the backend administration for the sites of
         this TYPO3 installation. Hardcoded to :code:`typo3/`. Must be a subdirectory
         to the website. See elsewhere for descriptions on how to change the
         default admin directory, :code:`typo3/`, to something else.
   :FE:
         Yes


 - :Constant:
         PATH\_typo3
   :Defined:
         init.php
   :Description:
         Abs. path of the TYPO3 admin dir (:code:`PATH_site + TYPO3_mainDir`).
   :FE:
         No


 - :Constant:
         PATH\_typo3\_mod
   :Defined:
         init.php
   :Description:
         Relative path (from the :code:`PATH_typo3`) to a properly configured module.
         Based on :code:`TYPO3_MOD_PATH`.
   :FE:
         No


 - :Constant:
         PATH\_site
   :Defined:
         init.php
   :Description:
         Absolute path to directory with the frontend (one directory above
         :code:`PATH_typo3`)
   :FE:
         Yes


 - :Constant:
         PATH\_t3lib
   :Defined:
         init.php
   :Description:
         Absolute path to :file:`t3lib/` (general TYPO3 library) within the TYPO3 admin
         directory.
   :FE:
         Yes


 - :Constant:
         PATH\_typo3conf
   :Defined:
         init.php
   :Description:
         Absolute TYPO3 configuration path (local, not part of source)

         Must be defined in order for :file:`t3lib/config_default.php` to return!
   :FE:
         Yes


 - :Constant:
         TYPO3\_db
   :Defined:
         config\_default.php
   :Description:
         Name of the database, for example "t3\_coreinstall". Is defined after
         the inclusion of :file:`typo3conf/localconf.php` (same for the other
         :code:`TYPO3_*` constants below.
   :FE:
         Yes


 - :Constant:
         TYPO3\_db\_username
   :Defined:
         config\_default.php
   :Description:
         Database username
   :FE:
         Yes


 - :Constant:
         TYPO3\_db\_password
   :Defined:
         config\_default.php
   :Description:
         Database password
   :FE:
         Yes


 - :Constant:
         TYPO3\_db\_host
   :Defined:
         config\_default.php
   :Description:
         Database hostname, e.g. "localhost"
   :FE:
         Yes


 - :Constant:
         TYPO3\_tables\_script
   :Defined:
         config\_default.php
   :Description:
         By default :file:`t3lib/stddb/tables.php` is included as the main table
         definition file. Alternatively this constant can be set to the
         filename of an alternative :file:`tables.php` file. Must be located in
         :file:`typo3conf/`.

         **Deprecated** . Make Extensions instead.
   :FE:
         Yes


 - :Constant:
         TYPO3\_extTableDef\_script
   :Defined:
         config\_default.php
   :Description:
         Name of a php-include script found in "typo3conf/" that contains PHP
         code that further modifies the variables set by
         :file:`t3lib/stddb/tables.php`.

         **Deprecated.** Make Extensions instead.
   :FE:
         Yes


 - :Constant:
         TYPO3\_languages
   :Defined:
         config\_default.php
   :Description:
         Defines the system language keys in TYPO3 backend.
   :FE:
         Yes


 - :Constant:
         TYPO3\_DLOG
   :Defined:
         config\_default.php
   :Description:
         If true, calls to :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::devLog()` can be made in both frontend
         and backend; This is event logging which can help to track debugging
         in general.
   :FE:
         Yes


 - :Constant:
         *TYPO3\_MOD\_PATH*
   :Defined:
         [prior to init.php]
   :Description:
         Path to module relative to :code:`PATH_typo3` (as defined in the module
         configuration). Must be defined prior to :file:`init.php`.
   :FE:
         -


 - :Constant:
         *TYPO3\_enterInstallScript*
   :Defined:
         [prior to init.php]
   :Description:
         If defined and set true the Install Tool is activated and the script
         exits after that. Used in :file:`typo3/install/index.php`:

         **Example:** ::

            define('TYPO3_enterInstallScript', '1');
   :FE:
         No


 - :Constant:
         *TYPO3\_PROCEED\_IF\_NO\_USER*
   :Defined:
         [prior to init.php]
   :Description:
         If defined and set true the :file:`init.php` script will return to the
         parent script *even if no backend user was authenticated!*

         This constant is set by for instance the :file:`index.php` script so it can
         include :file:`init.php` and still show the login form::

            define('TYPO3_PROCEED_IF_NO_USER', 1);
            require ('init.php');

         Please be very careful with this feature - use it only when you have
         total control of what you are doing!
   :FE:
         No


 - :Constant:
         *TYPO3\_cliMode*
   :Defined:
         [prior to init.php]
   :Description:
         Initiates CLI (Command Line Interface) mode. This is used when you
         want a shell executable PHP script to initialize a TYPO3 backend.

         For more details see :ref:`Initializing TYPO3 backend in a PHP
         shell script<t3inside:initialize-cli-mode>` in :ref:`Inside TYPO3<t3inside:start>`.
   :FE:
         No


 - :Constant:
         *TYPO3\_version*
   :Defined:
         config\_default.php
   :Description:
         The TYPO3 version:

         x.x.x for released versions,

         x.x.x-dev for development versions leading up to releases

         x.x.x-bx for beta-versions
   :FE:
         Yes

