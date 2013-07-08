.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _file-structure:

File structure
^^^^^^^^^^^^^^

TYPO3 files use the following structure:

#. Opening PHP tag

#. Namespace

#. Copyright notice

#. Included files

#. Class information block in phpDoc format

#. PHP class

#. Optional module execution code (for example, in eID classes)

#. Closing PHP tag

The following sections discuss each of these parts.


Namespace
"""""""""

The namespace declaration of each PHP file in the TYPO3 Core shows
where the file belongs inside TYPO3 CMS. The namespace starts with
:code:`"TYPO3\CMS\"`, then the extension name in UpperCamelCase, a
backslash and then the name of the subfolder of :code:`Classes/`, in
which the file is located (if any). E.g. the file
:code:`typo3/sysext/frontend/Classes/ContentObject/ContentObjectRenderer.php`
with the class :code:`ContentObjectRenderer` is in the namespace
":code:`TYPO3\CMS\Frontend\ContentObject`".

:code:`use` statements can be added to this section.

Copyright notice
""""""""""""""""

TYPO3 is released under the terms of GNU General Public License
version 2 or any later version. The copyright notice with a reference
to the GPL must be included at the top of every TYPO3 PHP class file.
:code:`user_` files must have this copyright notice as well. Example::

   <?php
   namespace TYPO3\CMS\XXX;

   /***************************************************************
    *  Copyright notice
    *
    *  (c) YYYY Your name here (your@email.here)
    *  All rights reserved
    *
    *  This script is part of the TYPO3 project. The TYPO3 project is
    *  free software; you can redistribute it and/or modify
    *  it under the terms of the GNU General Public License as published by
    *  the Free Software Foundation; either version 2 of the License, or
    *  (at your option) any later version.
    *
    *  The GNU General Public License can be found at
    *  http://www.gnu.org/copyleft/gpl.html.
    *  A copy is found in the textfile GPL.txt and important notices to the license
    *  from the author is found in LICENSE.txt distributed with these scripts.
    *
    *
    *  This script is distributed in the hope that it will be useful,
    *  but WITHOUT ANY WARRANTY; without even the implied warranty of
    *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    *  GNU General Public License for more details.
    *
    *  This copyright notice MUST APPEAR in all copies of the script!
    ***************************************************************/

This notice may not be altered except for the year, author name and
author e-mail address.


Included files
""""""""""""""

Files are included using the :code:`require_once()` function. All TYPO3
files must use absolute paths in calls to :code:`require_once()`. There
are two ways to obtain the path to the included file:

#. Use one of the predefined TYPO3 constants: :code:`PATH_tslib`,
   :code:`PATH_typo3` or :code:`PATH_site`. The first three contain absolute paths to the
   corresponding TYPO3 directories. The last constant contains the
   absolute path to the TYPO3 root directory. Example::

      require_once(PATH_typo3 . 'sysext/frontend/Classes/Plugin/AbstractPlugin.php');


#. Use the :code:`ExtensionManagementUtility::extPath()` function. This
   function accepts two arguments: first the extension key and second the path
   to the included file inside the extension. The second argument is optional
   but recommended to use. Examples::

      require_once(ExtensionManagementUtility::extPath('lang', 'Classes/LanguageService.php'));
      require_once(ExtensionManagementUtility::extPath('lang') . 'Classes/LanguageService.php');

Always use one of these two ways to include files. This is required to
include files even from the current directory. Some installations do
not have the current directory in the PHP :code:`include path` and
:code:`require_once()` without a proper path will result in a fatal
PHP error.


Class information block
"""""""""""""""""""""""

The class information block provides basic information about the class
in the file. It should include a description of the class and
information about the author (or authors). Example::

   /**
    * This class provides XYZ plugin implementation.
    *
    * @author John Doe <john.doe@example.com>
    * @author Jane Doe <jane.doe@example.com>
    */


PHP class
"""""""""

The PHP class follows the class information block. PHP code must be
formatted as described in chapter "PHP syntax formatting".

The class name is expected to follow some conventions. It must be
identical to the file name and must be written in upper camel case.

Taking again the example of file
:code:`typo3/sysext/core/Classes/Cache/Backend/AbstractBackend.php`, the PHP class
declaration will look like::

   class AbstractBackend implements \TYPO3\CMS\Core\Cache\Backend\BackendInterface {
           …
   }


Optional module execution code
""""""""""""""""""""""""""""""

Module execution code instantiates the class and runs its method(s).
Typically this code can be found in :code:`eID` scripts and old Backend
modules. Here is how it may look like::

   $controller = GeneralUtility::makeInstance('tx_myext_ajaxcontroller');
   $controller->main();

This code must appear **after** the PHP class. :code:`$SOBE` is the
traditional, but not the required name.

