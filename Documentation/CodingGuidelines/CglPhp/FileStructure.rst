..  include:: /Includes.rst.txt


..  _cgl-file-structure:

==============
File structure
==============

TYPO3 files use the following structure:

#. Opening PHP tag (including strict_types declaration)

#. Copyright notice

#. Namespace

#. Namespace imports

#. Class information block in phpDoc format

#. PHP class

#. Optional module execution code

The following sections discuss each of these parts.


Namespace
=========

The namespace declaration of each PHP file in the TYPO3 Core shows
where the file belongs inside TYPO3 CMS. The namespace starts with
:php:`TYPO3\CMS`, then the extension name in UpperCamelCase, a
backslash and then the name of the subfolder of :file:`Classes/`, in
which the file is located (if any). E.g. the file
:file:`typo3/sysext/frontend/Classes/ContentObject/ContentObjectRenderer.php`
with the class :php:`ContentObjectRenderer` is in the namespace
:php:`TYPO3\CMS\Frontend\ContentObject`.

:php:`use` statements can be added to this section.

Copyright Notice
================

TYPO3 is released under the terms of GNU General Public License
version 2 or any later version. The copyright notice with a reference
to the license text must be included at the top of every TYPO3 PHP class
file. User files must have this copyright notice as well. Example:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    <?php
    declare(strict_types = 1);

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

     namespace Vendor\SomeExtension\SomeFolder;

The wording must not be changed/updated/extended, under any circumstances.


Namespace imports
=================

Necessary PHP classes should be imported like explained in the
`TYPO3 Coding Standards <https://github.com/TYPO3/coding-standards>`__,
(based on PER-CS1.0 / PSR-12 at the time of this writing, transitioning towards
PER-CS2.0):

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Utility\HttpUtility;
    use TYPO3\CMS\Core\Cache\Backend\BackendInterface;

Put one blank line before and after import statements.
Also put one import statement per line.

Class information block
=======================

The class information block provides basic information about the class
in the file. It should include a description of the class. Example:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    /**
     * This class provides XYZ plugin implementation.
     */

..  _cgl-namespaces-class-names:

PHP class
=========

The PHP class follows the class information block. PHP code must be formatted
as described in chapter :ref:`"PHP syntax formatting" <cgl-php-syntax-formatting>`.

The class name is expected to follow some conventions. It must be
identical to the file name and must be written in upper camel case.

The namespace and class names of user files follow the same rules as
class names of the TYPO3 Core files do.

The namespace declaration of each user file should show where the file
belongs inside its extension. The namespace starts with
:code:`"Vendor\MyNamespace\"`, where "Vendor" is your vendor name and
"MyNamespace" is the extension name in UpperCamelCase. Then follows the
name of the subfolder of :file:`Classes/`, in which the file is located
(if any). E.g. the file
:file:`EXT:realurl/Classes/Controller/AliasesController.php`
with the class :php:`AliasesController` is in the namespace
":php:`DmitryDulepov\Realurl\Controller`".

A PHP class declaration looks like the following:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    class SomeClass extends AbstractBackend implements BackendInterface
    {
        // ...
    }


Optional module execution code
==============================

Module execution code instantiates the class and runs its method(s).
Typically this code can be found in :code:`eID` scripts and old Backend
modules. Here is how it may look like:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    $someClass = GeneralUtility::makeInstance(SomeClass::class);
    $someClass->main();

This code must appear **after** the PHP class.
