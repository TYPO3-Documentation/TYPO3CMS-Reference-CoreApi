.. include:: ../../../Includes.txt

.. _globals-constants:

=========
Constants
=========

Constants in TYPO3 define paths and database information. These values
are global and cannot be changed.
Constants are defined at various points during the bootstrap sequence.

.. hint::

   Some constants (and global variables) are being replaced by more
   flexible mechanisms. A number of constants have been deprecated
   in TYPO3 9 and removed in TYPO3 10. Please see :ref:`Environment`.
   For a list of removed constants, see :ref:`removed-constants` on
   this page.


To make the information below a bit more compact, namespaces were left out. Here
are the fully qualified class names referred to below:

- "SystemEnvironmentBuilder" = :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder`
- "Bootstrap" = :php:`\TYPO3\CMS\Core\Core\Bootstrap`


Check :php:`SystemEnvironmentBuilder::defineBaseConstants()`
for more constants.

Version, Branch and Copyright
=============================

TYPO3_branch
------------

The TYPO3 version Branch, as a "x.y" number. Without the patch level.

Defined in:
   :php:`SystemEnvironmentBuilder::defineBaseConstants()`

Example:
   "10.2"

Available in Frontend:
   Yes

TYPO3_version
-------------

The TYPO3 version, as a "x.y.z" number. Development versions will be either
"x.y.z-dev" for stable versions or "x.y-dev" for the current master.


Defined in:
   :php:`SystemEnvironmentBuilder::defineBaseConstants()`

Example:
   "10.2.0"

Available in Frontend:
   Yes

Paths
=====

TYPO3_mainDir
-------------

This is the directory of the backend administration for the sites of
this TYPO3 installation. Hardcoded to :code:`typo3/`. Must be a subdirectory
to the website.

Defined in:
   :php:`SystemEnvironmentBuilder::defineBaseConstants()`

Available in Frontend:
   Yes


Security Related Constant
=========================

FILE_DENY_PATTERN_DEFAULT
-------------------------

Default value of fileDenyPattern.

Defined in:
   :php:`SystemEnvironmentBuilder::defineBaseConstants()`

Example:
   :php:`'\\.(php[3-7]?|phpsh|phtml|pht|phar|shtml|cgi)(\\..*)?$|\\.pl$|^\\.htaccess$'`

Available in Frontend:
   Yes

PHP_EXTENSIONS_DEFAULT
----------------------

List of file extensions that should be registered as php script file extensions.

Defined in:
   :php:`SystemEnvironmentBuilder::defineBaseConstants()`

Example:
   :php:`'php,php3,php4,php5,php6,php7,phpsh,inc,phtml,pht,phar'`

Available in Frontend:
   Yes



Filetypes
=========

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
=================

The different status codes available are defined in :php:`TYPO3\CMS\Core\Utility\HttpUtility`.
These constants are defined as documented in https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml




Legacy Constants
================


TYPO3_MODE
----------

Mode of TYPO3: Set to either "FE" or "BE" depending on frontend or
backend execution and context.

.. important::

   About using TYPO3\_MODE in :file:`ext_localconf.php` and :file:`ext_tables.php`:

   It is recommended to AVOID checks for values on TYPO3_MODE or TYPO3_REQUESTTYPE constants
   (e.g. :php:`if (TYPO3_MODE === 'BE')` within these files (:file:`ext_localconf.php` and :file:`ext_tables.php`)
   as it limits the functionality to cache the whole systems configuration.
   Any extension author should remove the checks if not explicitly
   necessary, and re-evaluate if these context-depending checks could go inside the hooks / caller
   function directly.

   For more best practices of using these files, see :ref:`extension-configuration-files`.

Defined in:
   * :php:`\TYPO3\CMS\Backend\Http\Application::defineLegacyConstants()`
   * :php:`\TYPO3\CMS\Core\Console\CommandApplication::defineLegacyConstants()`
   * :php:`\TYPO3\CMS\Frontend\Http\Application::defineLegacyConstants()`
   * :php:`\TYPO3\CMS\Install\Http\Application::defineLegacyConstants()`

Example:
   "FE" or "BE"

Available in Frontend:
   Yes, value = "FE"



.. _removed-constants:

Removed Constants
=================

.. todo:: Remove this list in a next release and remove link on top of this page.

These constants were removed in TYPO3 10. You will find replacements in :ref:`Environment`.

String constants
----------------

* :php:`TAB` (Use :php:`"\t"` instead)
* :php:`NUL` (Use :php:`"\0"` instead)
* :php:`SUB` (Use :php:`chr(26)` instead)

Paths constants
---------------

* :php:`PATH_site`: Use :php:`Environment::getPublicPath()` to
  return the absolute path to the publically accessible folder (previously known
  as :php:`PATH_site`) without the trailing slash.
* :php:`PATH_thisScript`: Use :php:`Environment::getCurrentScript()` instead.
* :php:`PATH_typo3`: Use :php:`Environment::getPublicPath() . '/typo3/'` instead.
* :php:`PATH_typo3conf`: Use :php:`Environment::getPublicPath() . '/typo3conf'` instead

.. seealso::

   * :ref:`Environment::getPublicPath() <Environment-public-path>`
   * :ref:`Environment::getCurrentScript() <Environment-current-script>`


URL constants
-------------

* :php:`TYPO3_URL_MAILINGLISTS`
* :php:`TYPO3_URL_DOCUMENTATION`
* :php:`TYPO3_URL_DOCUMENTATION_TSREF`
* :php:`TYPO3_URL_DOCUMENTATION_TSCONFIG`
* :php:`TYPO3_URL_CONSULTANCY`
* :php:`TYPO3_URL_CONTRIBUTE`
* :php:`TYPO3_URL_SECURITY`
* :php:`TYPO3_URL_DOWNLOAD`
* :php:`TYPO3_URL_SYSTEMREQUIREMENTS`

Service constants
-----------------

The according constants have been moved to class constants of :php:`TYPO3\CMS\Core\Service\AbstractService`.

- :php:`T3_ERR_SV_GENERAL`
- :php:`T3_ERR_SV_NOT_AVAIL`
- :php:`T3_ERR_SV_WRONG_SUBTYPE`
- :php:`T3_ERR_SV_NO_INPUT`
- :php:`T3_ERR_SV_FILE_NOT_FOUND`
- :php:`T3_ERR_SV_FILE_READ`
- :php:`T3_ERR_SV_FILE_WRITE`
- :php:`T3_ERR_SV_PROG_NOT_FOUND`
- :php:`T3_ERR_SV_PROG_FAILED`


Other constants
---------------

* :php:`TYPO3_OS` (Use :php:`Environment::isWindows()` and :php:`Environment::isUnix()` instead)
* :php:`TYPO3_REQUESTTYPE_CLI`
