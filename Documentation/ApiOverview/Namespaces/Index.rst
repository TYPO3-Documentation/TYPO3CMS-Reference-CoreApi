.. include:: /Includes.rst.txt
.. index:: ! Namespaces
.. _namespaces:

Namespaces
==========

Since version 6.0, TYPO3 CMS uses PHP namespaces for all classes in the Core.

The general structure of namespaces is the following::

   \{VendorName}\{PackageName}\({CategoryName}\)*{ClassName}


For the Core, the *vendor name* is :php:`TYPO3\CMS` and the *package name* corresponds
to a system extension.

All classes must be located inside the :file:`Classes` folder at the root of the
(system) extension. The *category name* may contain several segments that correspond
to the path inside the :file:`Classes` folder.

Finally the *class name* is the same as the corresponding file name, without the
:file:`.php` extension.

"UpperCamelCase" is used for all segments.

.. tip::

   `See the chapter about 'ClassAliasMap.php' in the 6.2 documentation.
   <https://docs.typo3.org/typo3cms/CoreApiReference/6.2/ApiOverview/Namespaces/Index.html#namespaces-migrations-classaliasmap>`__.
   It may help you with migrating code from old to new conventions.


.. index:: pair: Namespaces; Core
.. _namespaces-example:

Core example
------------

The good old :php:`t3lib_div` class has been renamed to::

   \TYPO3\CMS\Core\Utility\GeneralUtility

This means that the class is now found in the `core` system extension, in folder
:file:`Classes/Utility`, in a file named :file:`GeneralUtility.php`.


.. index:: pair: Namespaces; Extensions
.. _namespaces-extensions:

Usage in extensions
-------------------

Extension developers are free to use their own vendor name. *Important:* It may consist of *one* segment only. Vendor names must start with an uppercase character and are usually written in UpperCamelCase style. In order to avoid problems with different filesystems, only the characters a-z, A-Z, 0-9 and the dash sign "-" are allowed for package names – don't use special characters::

   // correct vendor name for 'web company':
   \WebCompany

   // wrong vendor name for 'web company':
   \Web\Company

.. attention::

   The vendor name `TYPO3\CMS` is reserved and may not be used by extensions!

The package name corresponds to the extension key. Underscores in the extension
key are removed in the namespace and replaced by upper camel-case. So extension key::

   weird-name_examples

would become::

   Weird-nameExamples

in the namespace.

As mentioned above, all classes **must** be located in the :file:`Classes` folder inside
your extension. All sub-folders translate to a segment of the category name and the class
name is the file name without the :file:`.php` extension.

Looking at the "examples" extension, class::

   examples/Classes/Controller/DefaultController.php

corresponds to namespace::

   \Documentation\Examples\Controller\DefaultController

Inside the class, the namespace is declared as::

   <?php
   namespace Documentation\Examples\Controller;


.. index:: pair: Namespaces; Extbase
.. _namespaces-extbase:

Namespaces in Extbase
---------------------

When registering components in Extbase, the "UpperCamelCase" notation of the
extension key is used.

For a backend module::

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
       '<ExtensionName>',
       // ...
   );


For a frontend module::

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       '<ExtensionName>',
       // ...
   );


.. index:: pair: Namespaces; Tests
.. _namespaces-test:

Namespaces for test classes
---------------------------

As for ordinary classes, namespaces for test classes start with a vendor name
followed by the extension key.

All test classes reside in a :file:`Tests` folder and thus the third segment
of the namespace must be "Tests". Unit tests are located in a :file:`Unit` folder
which is the fourth segment of the namespace. Any further subfolders will
be subsequent segments.

So a test class in :file:`EXT:foo_bar_baz/Tests/Unit/Bla/` will have as namespace
:code:`\Vendor\FooBarBaz\Tests\Unit\Bla`.


.. _namespaces-instances:

Creating Instances
------------------

The following example shows how you can create instances by means of
:php:`GeneralUtility::makeInstance()`::

   $contentObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);

Or, use :php:`use` to make the code more readable::

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

   $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);


`include` and `required`
------------------------

There is no need for :php:`require()` or :php:`include()` statements. All
classes adhering to namespace conventions will automatically be located and
included by the autoloader.


.. _namespaces-references:

References
----------

For more information about PHP namespaces in general, you may want to refer to the
`PHP documentation <https://www.php.net/manual/en/language.namespaces.php>`_ and
in particular the `Namespaces FAQ <https://www.php.net/manual/en/language.namespaces.faq.php>`_.
