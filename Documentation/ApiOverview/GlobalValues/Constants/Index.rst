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

   - "SystemEnvironmentBuilder" = :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder`
   - "Bootstrap" = :php:`\TYPO3\CMS\Core\Core\Bootstrap`


Table 1: Traditional List
-------------------------

.. t3-field-list-table::
 :header-rows: 1

 - :Constant,20: Constant
   :Defined,30: Defined in
   :Description,40: Description
   :FE,10: Avail. in FE


 - :Constant:
         TYPO3\_MODE
   :Defined:
         :php:`\TYPO3\CMS\Backend\Http\Application::defineLegacyConstants()`
         :php:`\TYPO3\CMS\Core\Console\CommandApplication::defineLegacyConstants()`
         :php:`\TYPO3\CMS\Frontend\Http\Application::defineLegacyConstants()`
         :php:`\TYPO3\CMS\Install\Http\Application::defineLegacyConstants()`
   :Description:
         Mode of TYPO3: Set to either "FE" or "BE" depending on frontend or
         backend execution and context.
   :FE:
         Yes

         value = "FE"


 - :Constant:
         TYPO3\_OS
   :Defined:
         SystemEnvironmentBuilder::defineBaseConstants()
   :Description:
         Operating system; Windows = "WIN", other = "" (presumed to be some
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

Check :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::defineBaseConstants()`
for updates.


This version, branch and copyright
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

===================================== =======================================================
Constant                              Example value
===================================== =======================================================
TYPO3_version                         '7.6.1-dev'
TYPO3_branch                          '7.6'
TYPO3_copyright_year                  '1998-2015'
===================================== =======================================================


TYPO3 external links
~~~~~~~~~~~~~~~~~~~~

===================================== =======================================================
Constant                              Example value
===================================== =======================================================
TYPO3_URL_GENERAL                     'https://typo3.org/'
TYPO3_URL_LICENSE                     'https://typo3.org/typo3-cms/overview/licenses/'
TYPO3_URL_EXCEPTION                   'https://typo3.org/go/exception/CMS/'
TYPO3_URL_MAILINGLISTS                'http://lists.typo3.org/cgi-bin/mailman/listinfo'
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
Constant                              Value                                                   Description
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
Constant                              Value                                                   Description
===================================== ======================================================= ============
FILE_DENY_PATTERN_DEFAULT             '\\.(php[3-7]?|phpsh|phtml)(\\..*)?$|^\\.htaccess$'     Default value of fileDenyPattern
PHP_EXTENSIONS_DEFAULT                'php,php3,php4,php5,php6,php7,phpsh,inc,phtml'          List of file extensions that should be registered as php script file extensions
===================================== ======================================================= ============


Operating system identifier
~~~~~~~~~~~~~~~~~~~~~~~~~~~

===================================== ======================================================= ============
Constant                              Value                                                   Description
===================================== ======================================================= ============
TYPO3_OS                              self::getTypo3Os())                                     Either "WIN" or empty string
===================================== ======================================================= ============


Service error constants
~~~~~~~~~~~~~~~~~~~~~~~

===================================== ======================================================= ============
Constant                              Value                                                   Description
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

