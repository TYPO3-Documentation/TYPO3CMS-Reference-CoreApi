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


..  index:: Constants; Filetypes

File types
==========

Different types of file constants are defined in :php:`\TYPO3\CMS\Core\Resource\AbstractFile`.
These constants are available for different groups of files as documented in
https://www.iana.org/assignments/media-types/media-types.xhtml

These file types are assigned to all :ref:`FAL <fal>` resources. They can, for
example, be used in :ref:`Fluid <fluid>` to decide how to render different types
of files.

========================================= ===== =======================
Constant                                  Value Description
========================================= ===== =======================
:php:`AbstractFile::FILETYPE_UNKNOWN`         0 Unknown
:php:`AbstractFile::FILETYPE_TEXT`            1 Any kind of text
:php:`AbstractFile::FILETYPE_IMAGE`           2 Any kind of image
:php:`AbstractFile::FILETYPE_AUDIO`           3 Any kind of audio
:php:`AbstractFile::FILETYPE_VIDEO`           4 Any kind of video
:php:`AbstractFile::FILETYPE_APPLICATION`     5 Any kind of application
========================================= ===== =======================


.. index:: Constants; HTTP status codes

HTTP status codes
=================

The different status codes available are defined in
:t3src:`core/Classes/Utility/HttpUtility.php`.
These constants are defined as documented in
https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
