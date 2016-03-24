
.. include:: ../../Includes.txt



.. _namespaces:

Namespaces
==========

Since version 6.0, TYPO3 CMS uses PHP namespaces for all classes in the Core.

The general structure of namespaces is the following::

   \{VendorName}\{PackageName}\({CategoryName}\)*{ClassName}


For the Core, the *vendor name* is :code:`TYPO3\CMS` and the *package name* corresponds
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


.. _namespaces-example:

Core example
------------

The good old :code:`t3lib_div` class has been renamed to::

   \TYPO3\CMS\Core\Utility\GeneralUtility

This means that the class is now found in the "core" system extension, in folder
:file:`Classes/Utility`, in a file named :file:`GeneralUtility.php`.


.. _namespaces-extensions:

Usage in extensions
-------------------

Extension developers are free to use their own vendor name. *Important:* It may consist of *one* segment only. Vendor names must start with an uppercase character and are usually written in UpperCamelCase style. In order to avoid problems with different filesystems, only the characters a-z, A-Z, 0-9 and the dash sign "-" are allowed for package names – don't use special characters::

   // good vendor name:
   \Webcompany

   // wrong vendor name:
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



.. _namespaces-extbase:

Namespaces in Extbase
---------------------

When registering components in Extbase, the vendor name must be used on top of the extension key.

For a backend module::

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
       '<vendorName>.<ExtensionName>',
       // ...
   );


For a frontend module::

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       '<vendorName>.<ExtensionName>',
       // ...
   );


.. important::
   - Do not forget the dot after the vendor name.
   - Do not use dots inside the vendor name.


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

Creating instances
------------------

When creating instances using :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()`
the leading backslash must be omitted and all other backslashes escaped, even when using
single quotes. Thus the following code is correct::

   $contentObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);


There is no need to use :code:`require()` or :code:`include()` statements. All classes that follow
namespace conventions will automatically located and included by the autoloader.


.. _namespaces-references:

References
----------

For more information about PHP namespaces in general, you may want to refer to the
`PHP documentation <http://www.php.net/manual/en/language.namespaces.php>`_ and
in particular the `Namespaces FAQ <http://www.php.net/manual/en/language.namespaces.faq.php>`_.
