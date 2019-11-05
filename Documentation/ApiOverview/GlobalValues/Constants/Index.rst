.. include:: ../../../Includes.txt

.. _globals-constants:

=========
Constants
=========

Constants normally define paths and database information. These values
are global and cannot be changed when they are first defined. This is
why constants are used for such vital information.

These constants are defined at various points during the bootstrap sequence.

The column "Avail. in FE" is an indicator that tells you if the
constant, variable or class mentioned is also available to scripts
running under the frontend of the "cms" extension.

.. note::

   To make the table below a bit more compact, namespaces were left out. Here
   are the fully qualified class names referred to below:

   - "SystemEnvironmentBuilder" = :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder`
   - "Bootstrap" = :php:`\TYPO3\CMS\Core\Core\Bootstrap`


Table 1: Traditional List
=========================

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
        .. note::

          this constant has been marked as deprecated and will be removed with TYPO3 v10. Use :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()` to retrieve the information.
          Use :php:`Environment::isWindows()` and :php:`Environment::isUnix()` instead.


         Operating system; Windows = "WIN", other = "" (presumed to be some
         sort of Unix)
   :FE:
         Yes


 - :Constant:
         PATH\_thisScript
   :Defined:
         SystemEnvironmentBuilder::definePaths()
   :Description:

         .. note::

            this constant has been marked as deprecated and will be removed with TYPO3 v10. Use :php:`\TYPO3\CMS\Core\Core\Environment::getCurrentScript()` to retrieve the information.


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
        .. note::

            this constant has been marked as deprecated and will be removed with TYPO3 v10. Use :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3'` to retrieve the information.


         Abs. path of the TYPO3 admin dir.
   :FE:
         No


 - :Constant:
         PATH\_site
   :Defined:
         SystemEnvironmentBuilder::definePaths()
   :Description:
         .. note::

            this constant has been marked as deprecated and will be removed with TYPO3 v10. Use :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/'` to retrieve the information.


         Absolute path to directory with the frontend (one directory above
         :code:`\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3/`)
   :FE:
         Yes


 - :Constant:
         PATH\_typo3conf
   :Defined:
         SystemEnvironmentBuilder::definePaths()
   :Description:

         .. note::

            this constant has been marked as deprecated and will be removed with TYPO3 v10. Use :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf'` to retrieve the information.


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
=======================

Check :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::defineBaseConstants()`
for updates.


This Version, Branch and Copyright
----------------------------------

===================================== =======================================================
Constant                              Example value
===================================== =======================================================
TYPO3_version                         '7.6.1-dev'
TYPO3_branch                          '7.6'
TYPO3_copyright_year                  '1998-2015'
===================================== =======================================================


TYPO3 External Links
--------------------

===================================== =======================================================
Constant                              Example value
===================================== =======================================================
TYPO3_URL_GENERAL                     'https://typo3.org/'
TYPO3_URL_LICENSE                     'https://typo3.org/typo3-cms/overview/licenses/'
TYPO3_URL_EXCEPTION                   'https://typo3.org/go/exception/CMS/'
TYPO3_URL_MAILINGLISTS                'http://lists.typo3.org/cgi-bin/mailman/listinfo'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.

TYPO3_URL_DOCUMENTATION               'https://typo3.org/documentation/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_DOCUMENTATION_TSREF         'https://docs.typo3.org/typo3cms/TyposcriptReference/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_DOCUMENTATION_TSCONFIG      'https://docs.typo3.org/typo3cms/TSconfigReference/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_CONSULTANCY                 'https://typo3.org/support/professional-services/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_CONTRIBUTE                  'https://typo3.org/contribute/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_SECURITY                    'https://typo3.org/teams/security/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_DOWNLOAD                    'https://typo3.org/download/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_SYSTEMREQUIREMENTS          'https://typo3.org/typo3-cms/overview/requirements/'

                                      .. note::

                                          this constant has been marked as deprecated and will be removed with TYPO3 v10.


TYPO3_URL_DONATE                      'https://typo3.org/donate/online-donation/'
TYPO3_URL_WIKI_OPCODECACHE            'https://wiki.typo3.org/Opcode_Cache'
===================================== =======================================================


String Constants
----------------

===================================== ======================================================= ============
Constant                              Value                                                   Description
===================================== ======================================================= ============
NUL                                   chr(0)                                                  A null

                                                                                              .. note::

                                                                                                this constant has been marked as deprecated and will be removed with TYPO3 v10.
                                                                                                Use :php:`"\0"` instead.

TAB                                   chr(9)                                                  A tabulator


                                                                                              .. note::

                                                                                                this constant has been marked as deprecated and will be removed with TYPO3 v10.
                                                                                                Use :php:`"\t"` instead.

LF                                    chr(10)                                                 A linefeed
CR                                    chr(13)                                                 A carriage return
SUB                                   chr(26)                                                 A sub (substitute) character


                                                                                              .. note::

                                                                                                this constant has been marked as deprecated and will be removed with TYPO3 v10.
                                                                                                Use :php:`chr(26)` instead.

CRLF                                  CR + LF                                                 Carriage return + linefeed pair
===================================== ======================================================= ============


Security Related Constant
-------------------------

===================================== ======================================================= ============
Constant                              Value                                                   Description
===================================== ======================================================= ============
FILE_DENY_PATTERN_DEFAULT             '\\.(php[3-7]?|phpsh|phtml)(\\..*)?$|^\\.htaccess$'     Default value of fileDenyPattern
PHP_EXTENSIONS_DEFAULT                'php,php3,php4,php5,php6,php7,phpsh,inc,phtml'          List of file extensions that should be registered as php script file extensions
===================================== ======================================================= ============


Operating System Identifier
---------------------------

===================================== ======================================================= ============
Constant                              Value                                                   Description
===================================== ======================================================= ============
TYPO3_OS                              self::getTypo3Os())                                     Either "WIN" or empty string

                                                                                              .. note::

                                                                                                this constant has been marked as deprecated and will be removed with TYPO3 v10. Use :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()` to retrieve the information.
                                                                                                Use :php:`Environment::isWindows()` and :php:`Environment::isUnix()` instead.

===================================== ======================================================= ============


Service Error Constants
-----------------------

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

Filetypes
---------

Different types of files constants are defined in :php:`TYPO3\CMS\Core\Resource\AbstractFile`.
These constants are available for different groups of files as documented in
https://www.iana.org/assignments/media-types/media-types.xhtml

These file types are assigned to all FAL resources. They can, for example, be
used in Fluid to decide how to render different types of files.

==================== ===== =======================
Constant             Value Description
==================== ===== =======================
FILETYPE_UNKNOWN         0 Unknown
FILETYPE_TEXT            1 Any kind of text
FILETYPE_IMAGE           2 Any kind of image
FILETYPE_AUDIO           3 Any kind of audio
FILETYPE_VIDEO           4 Any kind of video
FILETYPE_APPLICATION     5 Any kind of application
==================== ===== =======================

HTTP Status Codes
-----------------

The different status codes available are defined in :php:`TYPO3\CMS\Core\Utility\HttpUtility`.
These constants are defined as documented in https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
