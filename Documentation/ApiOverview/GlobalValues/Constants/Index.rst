..  include:: /Includes.rst.txt
..  index:: Constants
..  _globals-constants:

=========
Constants
=========

Constants in TYPO3 define paths and database information. These values
are global and cannot be changed.
Constants are defined at various points during the :ref:`bootstrap sequence
<bootstrapping>`.

To make the information below a bit more compact, namespaces were left out. Here
are the fully qualified class names referred to below:

Check :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::defineBaseConstants()`
method for more constants.

..  contents:: **Table of contents**
    :local:


..  index:: pair: Constants; Security

Security-related constant
=========================


..  index::
    Security; FILE_DENY_PATTERN_DEFAULT
    Constants; FILE_DENY_PATTERN_DEFAULT

FILE_DENY_PATTERN_DEFAULT
-------------------------

Default value of :ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['fileDenyPattern']
<typo3ConfVars_be_fileDenyPattern>`.

Defined in:
    :php:`\TYPO3\CMS\Core\Resource\Security\FileNameValidator::FILE_DENY_PATTERN_DEFAULT`

Example:
    :php:`\\.(php[3-8]?|phpsh|phtml|pht|phar|shtml|cgi)(\\..*)?$|\\.pl$|^\\.htaccess$`

Available in frontend:
    Yes


..  index::
    Constants; TYPO3
..  _globals-constants-typo3:

TYPO3
-----

TYPO3 still has some extension PHP script files executed in global context
without class or callable encapsulation, namely :file:`ext_localconf.php`,
:file:`ext_tables.php` and files within :file:`Configuration/TCA/Overrides/`.
When those files are located within the public document root of an instance and
called via HTTP directly, they may error out and render error messages. This can
be a security risk. To prevent this, those files **must** have a security gate
as first line:

..  code-block:: php

    <?php

    defined('TYPO3') or die();

    // ... your code

It is defined to :php:`true` in early TYPO3 bootstrap.

..  seealso::

    *   :ref:`ext_localconf.php <ext-localconf-php>`
    *   :ref:`ext_tables.php <ext-tables-php>`
    *   :ref:`Configuration/TCA/Overrides/ <extension-configuration-tca-overrides>`


..  index:: Constants; Filetypes
..  _globals-constants-file-types:

File types
==========

..  versionchanged:: 13.0
    The PHP backed enum :php:`\TYPO3\CMS\Core\Resource\FileType` has been
    introduced as a drop-in replacement for the public :php:`FILETYPE_*`
    constants in :php:`\TYPO3\CMS\Core\Resource\AbstractFile`. See
    :ref:`globals-constants-file-types-migration`.

    The constant file types have been marked as deprecated and will be
    removed with TYPO3 v14.0. To be compatible with TYPO3 v12 and v13 use
    the constants from :php:`\TYPO3\CMS\Core\Resource\AbstractFile`.

Different types of file constants are defined in the enum
:php:`\TYPO3\CMS\Core\Resource\FileType`. These cases are available for
different groups of files as documented in
https://www.iana.org/assignments/media-types/media-types.xhtml

These file types are assigned to all :ref:`FAL <fal>` resources. They can, for
example, be used in :ref:`Fluid <fluid>` to decide how to render different types
of files.

============================ ===== =======================
Enum case                    Value Description
============================ ===== =======================
:php:`FileType::UNKNOWN`         0 Unknown
:php:`FileType::TEXT`            1 Any kind of text
:php:`FileType::IMAGE`           2 Any kind of image
:php:`FileType::AUDIO`           3 Any kind of audio
:php:`FileType::VIDEO`           4 Any kind of video
:php:`FileType::APPLICATION`     5 Any kind of application
============================ ===== =======================


..  _globals-constants-file-types-migration:

Migration
---------

Migrate all usages to use the new enum :php:`\TYPO3\CMS\Core\Resource\FileType`
as follows:

* :php:`\TYPO3\CMS\Core\Resource\AbstractFile::FILETYPE_UNKNOWN` → :php:`\TYPO3\CMS\Core\Resource\FileType::UNKNOWN->value`
* :php:`\TYPO3\CMS\Core\Resource\AbstractFile::FILETYPE_TEXT` → :php:`\TYPO3\CMS\Core\Resource\FileType::TEXT->value`
* :php:`\TYPO3\CMS\Core\Resource\AbstractFile::FILETYPE_IMAGE` → :php:`\TYPO3\CMS\Core\Resource\FileType::IMAGE->value`
* :php:`\TYPO3\CMS\Core\Resource\AbstractFile::FILETYPE_AUDIO` → :php:`\TYPO3\CMS\Core\Resource\FileType::AUDIO->value`
* :php:`\TYPO3\CMS\Core\Resource\AbstractFile::FILETYPE_VIDEO` → :php:`\TYPO3\CMS\Core\Resource\FileType::VIDEO->value`
* :php:`\TYPO3\CMS\Core\Resource\AbstractFile::FILETYPE_APPLICATION` → :php:`\TYPO3\CMS\Core\Resource\FileType::APPLICATION->value`


.. index:: Constants; HTTP status codes

HTTP status codes
=================

The different status codes available are defined in
:t3src:`core/Classes/Utility/HttpUtility.php`.
These constants are defined as documented in
https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
