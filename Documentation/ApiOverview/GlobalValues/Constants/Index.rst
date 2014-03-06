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

.. note::

   To make the table below a bit more compact, namespaces were left out. Here
   are the fully qualified class names referred to below:

   - "SystemEnvironmentBuilder" = :code:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder`
   - "Bootstrap" = :code:`\TYPO3\CMS\Core\Core\Bootstrap`


.. t3-field-list-table::
 :header-rows: 1

 - :Constant,20: Constant
   :Defined,30: Defined in
   :Description,40: Description
   :FE,10: Avail. in FE


 - :Constant:
         TYPO3\_MODE
   :Defined:
         init.php
   :Description:
         Mode of TYPO3: Set to either "FE" or "BE" depending on frontend or
         backend execution. So in :file:`init.php` and :file:`thumbs.php` this value is
         "BE".
   :FE:
         Yes

         value = "FE"


 - :Constant:
         TYPO3\_OS
   :Defined:
         SystemEnvironmentBuilder::getTypo3Os()
   :Description:
         Operating systen; Windows = "WIN", other = "" (presumed to be some
         sort of Unix)
   :FE:
         Yes


 - :Constant:
         PATH\_thisScript
   :Defined:
         SystemEnvironmentBuilder::definePaths()
   :Description:
         Abs. path to current script.
   :FE:
         Yes


 - :Constant:
         TYPO3\_mainDir
   :Defined:
         SystemEnvironmentBuilder::definePaths()
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
         SystemEnvironmentBuilder::definePaths()
   :Description:
         Abs. path of the TYPO3 admin dir (:code:`PATH_site + TYPO3_mainDir`).
   :FE:
         No


 - :Constant:
         PATH\_typo3\_mod
   :Defined:
         SystemEnvironmentBuilder::definePaths()
   :Description:
         Relative path (from the :code:`PATH_typo3`) to a properly configured module.
         Based on :code:`TYPO3_MOD_PATH`.
   :FE:
         No


 - :Constant:
         PATH\_site
   :Defined:
         SystemEnvironmentBuilder::definePaths()
   :Description:
         Absolute path to directory with the frontend (one directory above
         :code:`PATH_typo3`)
   :FE:
         Yes


 - :Constant:
         PATH\_typo3conf
   :Defined:
         SystemEnvironmentBuilder::definePaths()
   :Description:
         Absolute TYPO3 configuration path (local, not part of source).
   :FE:
         Yes


 - :Constant:
         TYPO3\_db
   :Defined:
         Bootstrap::populateLocalConfiguration()
   :Description:
         Name of the database, for example "t3\_coreinstall". Is defined after
         the inclusion of :file:`typo3conf/LocalConfiguration.php` (same for the other
         :code:`TYPO3_*` constants below.
   :FE:
         Yes


 - :Constant:
         TYPO3\_db\_username
   :Defined:
         Bootstrap::populateLocalConfiguration()
   :Description:
         Database username
   :FE:
         Yes


 - :Constant:
         TYPO3\_db\_password
   :Defined:
         Bootstrap::populateLocalConfiguration()
   :Description:
         Database password
   :FE:
         Yes


 - :Constant:
         TYPO3\_db\_host
   :Defined:
         Bootstrap::populateLocalConfiguration()
   :Description:
         Database hostname, e.g. "localhost"
   :FE:
         Yes


 - :Constant:
         TYPO3\_extTableDef\_script
   :Defined:
         Bootstrap::populateLocalConfiguration()
   :Description:
         Name of a php-include script found in "typo3conf/" that contains PHP
         code that further modifies the table definitions set by the TYPO3 CMS Core.

         **Deprecated.** Make Extensions instead.
   :FE:
         Yes


 - :Constant:
         TYPO3\_DLOG
   :Defined:
         Bootstrap::defineLoggingAndExceptionConstants()
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
         If defined and set true the bootstrapping process will return to the
         parent script *even if no backend user was authenticated!*

         For example, this constant is set by the :file:`index.php` script so it can
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
         shell script <t3inside:initialize-cli-mode>` in :ref:`Inside TYPO3 <t3inside:start>`.
   :FE:
         No


 - :Constant:
         *TYPO3\_version*
   :Defined:
         SystemEnvironmentBuilder::defineBaseConstants()
   :Description:
         The TYPO3 version, as a "x.y.z" number. Development versions will be either
         "x.y.z-dev" for stable versions or "x.y-dev" for the current master.
   :FE:
         Yes

