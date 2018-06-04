.. include:: ../../Includes.txt


.. _cgl-file-structure:

File structure
^^^^^^^^^^^^^^

TYPO3 files use the following structure:

#. Opening PHP tag (including strict_types declaration)

#. Namespace

#. Copyright notice

#. Namespace imports

#. Class information block in phpDoc format

#. PHP class

#. Optional module execution code

The following sections discuss each of these parts.


Namespace
"""""""""

The namespace declaration of each PHP file in the TYPO3 Core shows
where the file belongs inside TYPO3 CMS. The namespace starts with
:php:`TYPO3\CMS`, then the extension name in UpperCamelCase, a
backslash and then the name of the subfolder of :file:`Classes/`, in
which the file is located (if any). E.g. the file
:file:`typo3/sysext/frontend/Classes/ContentObject/ContentObjectRenderer.php`
with the class :code:`ContentObjectRenderer` is in the namespace
:php:`TYPO3\CMS\Frontend\ContentObject`.

:code:`use` statements can be added to this section.

Copyright notice
""""""""""""""""

TYPO3 is released under the terms of GNU General Public License
version 2 or any later version. The copyright notice with a reference
to the license text must be included at the top of every TYPO3 PHP class
file. user files must have this copyright notice as well. Example::

   <?php
   declare(strict_types=1);
   namespace TYPO3\CMS\XXX;

   /*
    * This file is part of the TYPO3 CMS project.
    *
    * It is free software; you can redistribute it and/or modify it under
    * the terms of the GNU General Public License, either version 2
    * of the License, or any later version.
    *
    * For the full copyright and license information, please read the
    * LICENSE.txt file that was distributed with this source code.
    *
    * The TYPO3 project - inspiring people to share!
    */

The wording must not be changed/updated/extended, under any circumstances.


Namespace imports
"""""""""""""""""

Necessary PHP Classes should be imported like explained in PSR-2::

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Core\Utility\HttpUtility;

Put one blank line before and after import statements.
Also put one import statement per line.

Class information block
"""""""""""""""""""""""

The class information block provides basic information about the class
in the file. It should include a description of the class. Example::

   /**
    * This class provides XYZ plugin implementation.
    */


PHP class
"""""""""

The PHP class follows the class information block. PHP code must be
formatted as described in chapter "PHP syntax formatting".

The class name is expected to follow some conventions. It must be
identical to the file name and must be written in upper camel case.

Taking again the example of file
:file:`typo3/sysext/core/Classes/Cache/Backend/AbstractBackend.php`, the PHP class
declaration will look like::

   class AbstractBackend implements \TYPO3\CMS\Core\Cache\Backend\BackendInterface
   {
           …
   }


Optional module execution code
""""""""""""""""""""""""""""""

Module execution code instantiates the class and runs its method(s).
Typically this code can be found in :code:`eID` scripts and old Backend
modules. Here is how it may look like::

   $controller = GeneralUtility::makeInstance(\Vendor\MyNamespace\MyExtension\Controller\AjaxController::class);
   $controller->main();

This code must appear **after** the PHP class.
