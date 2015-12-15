
.. include:: ../../../Includes.txt






.. _globals-constants:

=========
Constants
=========

Constants normally define paths and database information. These values
are global and cannot be changed when they are first defined. This is
why constants are used for such vital information.

These constants are defined at various points during the bootstrap sequence.

.. note::

   To make the table below a bit more compact, namespaces were left out. Here
   are the fully qualified class names referred to below:

   - "SystemEnvironmentBuilder" = :ref:`t3cmsapi:TYPO3\\CMS\\Core\\Core\\SystemEnvironmentBuilder`
   - "Bootstrap" = :ref:`t3cmsapi:TYPO3\\CMS\\Core\\Core\\Bootstrap`


Table 1
-------

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


 - :Constant:
         *TYPO3\_branch*
   :Defined:
         SystemEnvironmentBuilder::defineBaseConstants()
   :Description:
         The TYPO3 version Branch, as a "x.y" number. Without the patch level.
   :FE:
         Yes


Table 2: Base Constants
-----------------------

Check :ref:`t3cmsapi:TYPO3\\CMS\\Core\\Core\\SystemEnvironmentBuilder::defineBaseConstants`
for updates.


This version, branch and copyright
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

===================================== =======================================================
Constant                              (Example) Value
===================================== =======================================================
TYPO3_version                         '7.6.1-dev'
TYPO3_branch                          '7.6'
TYPO3_copyright_year                  '1998-2015'
===================================== =======================================================


TYPO3 external links
~~~~~~~~~~~~~~~~~~~~

===================================== =======================================================
Constant                              (Example) Value
===================================== =======================================================
TYPO3_URL_GENERAL                     'https://typo3.org/'
TYPO3_URL_LICENSE                     'https://typo3.org/typo3-cms/overview/licenses/'
TYPO3_URL_EXCEPTION                   'https://typo3.org/go/exception/CMS/'
TYPO3_URL_MAILINGLISTS'               'http://lists.typo3.org/cgi-bin/mailman/listinfo'
TYPO3_URL_DOCUMENTATION               'https://typo3.org/documentation/'
TYPO3_URL_DOCUMENTATION_TSREF         'https://docs.typo3.org/typo3cms/TyposcriptReference/'
TYPO3_URL_DOCUMENTATION_TSCONFIG      'https://docs.typo3.org/typo3cms/TSconfigReference/'
TYPO3_URL_CONSULTANCY                 'https://typo3.org/support/professional-services/'
TYPO3_URL_CONTRIBUTE                  'https://typo3.org/contribute/'
TYPO3_URL_SECURITY                    'https://typo3.org/teams/security/'
TYPO3_URL_DOWNLOAD                    'https://typo3.org/download/'
TYPO3_URL_SYSTEMREQUIREMENTS          'https://typo3.org/typo3-cms/overview/requirements/'
TYPO3_URL_DONATE                      'https://typo3.org/donate/online-donation/'
TYPO3_URL_WIKI_OPCODECACHE            'https://wiki.typo3.org/Opcode_Cache'
===================================== =======================================================


String constants
~~~~~~~~~~~~~~~~

===================================== ======================================================= ============
Constant                              (Example) Value                                         Description
===================================== ======================================================= ============
NUL                                   chr(0)                                                  A null
TAB                                   chr(9)                                                  A tabulator
LF                                    chr(10)                                                 A linefeed
CR                                    chr(13)                                                 A carriage return
SUB                                   chr(26)                                                 A sub (substitute) character
CRLF                                  CR + LF                                                 Carriage return + linefeed pair
===================================== ======================================================= ============


Security related constant
~~~~~~~~~~~~~~~~~~~~~~~~~

===================================== ======================================================= ============
Constant                              (Example) Value                                         Description
===================================== ======================================================= ============
FILE_DENY_PATTERN_DEFAULT             '\\.(php[3-7]?|phpsh|phtml)(\\..*)?$|^\\.htaccess$'     Default value of fileDenyPattern
PHP_EXTENSIONS_DEFAULT                'php,php3,php4,php5,php6,php7,phpsh,inc,phtml'          List of file extensions that should be registered as php script file extensions
===================================== ======================================================= ============


Operating system identifier
~~~~~~~~~~~~~~~~~~~~~~~~~~~

===================================== ======================================================= ============
Constant                              (Example) Value                                         Description
===================================== ======================================================= ============
TYPO3_OS                              self::getTypo3Os())                                     Either "WIN" or empty string
===================================== ======================================================= ============


Service error constants
~~~~~~~~~~~~~~~~~~~~~~~

===================================== ======================================================= ============
Constant                              (Example) Value                                         Description
===================================== ======================================================= ============
T3_ERR_SV_GENERAL                     -1                                                      General error - something went wrong
T3_ERR_SV_NOT_AVAIL                   -2                                                      During execution it showed that the service is not available and should be ignored. The service itself should call $this->setNonAvailable()
T3_ERR_SV_WRONG_SUBTYPE               -3                                                      Passed subtype is not possible with this service
T3_ERR_SV_NO_INPUT                    -4                                                      Passed subtype is not possible with this service
T3_ERR_SV_FILE_NOT_FOUND              -20                                                     File not found which the service should process
T3_ERR_SV_FILE_READ                   -21                                                     File not readable
T3_ERR_SV_FILE_WRITE                  -22                                                     File not writable
T3_ERR_SV_PROG_NOT_FOUND              -40                                                     Passed subtype is not possible with this service
T3_ERR_SV_PROG_FAILED                 -41                                                     Passed subtype is not possible with this service
===================================== ======================================================= ============

