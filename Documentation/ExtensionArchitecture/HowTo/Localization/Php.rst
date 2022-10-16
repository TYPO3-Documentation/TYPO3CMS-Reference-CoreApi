.. include:: /Includes.rst.txt
.. index::
   Localization; PHP
.. _extension-localization-php:

====================
Localization in PHP
====================

Sometimes you have to localize a string in PHP code, for
example inside of a controller or a ViewHelper.

Localization in plain PHP (frontend context)
============================================

In plain PHP use the class :php:`LanguageServiceFactory` to create a
:php:`LanguageService` from the current site language:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Utility/SomeUtilityClass.php

    $languageServiceFactory = GeneralUtility::makeInstance(LanguageServiceFactory::class);
    $languageService = $languageServiceFactory->createFromSiteLanguage($request->getAttribute('language')
        ?? $request->getAttribute('site')->getDefaultLanguage());
    $languageService->sL(...)

If possible consider to use :ref:`DependencyInjection`:


Localization in backend context
===============================

If you are in the backend context

.. todo: Add information on ViewHelper and non-Extbase context

Localization in Extbase context
===============================

In :ref:`Extbase <extbase>` context you can use the method
`\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $extensionName)`.

This method requires the localization key as the first and the extension's
name as optional second parameter. For all available parameters
see :ref:`below <extbase-localization-utility-api>`. Then the corresponding
text in the current language will be loaded from this extension's
:file:`locallang.xlf` file.

The method :php:`translate()` takes translation overrides from TypoScript into
account. See :ref:`localization-typoscript-LOCAL_LANG`.

Example
-------

In this example the content of the flash message to be displayed in the backend
gets translated:

..  include:: /CodeSnippets/Extbase/Controllers/PhpLocalization.rst.txt

The string in the translation file is defined like this:

..  code-block:: xml
    :caption: EXT: examples/Resources/Private/Language/locallang.xlf
    :emphasize-lines: 8

    <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
    <xliff version="1.0">
        <file source-language="en" datatype="plaintext" original="messages" date="2013-03-09T18:44:59Z" product-name="examples">
            <header/>
            <body>
                <!-- ... -->
                <trans-unit id="new_relation" xml:space="preserve">
                    <source>Content element "%1$s" (uid: %2$d) has the following relations:</source>
                </trans-unit>
            </body>
        </file>
    </xliff>

The :php:`arguments` will be replaced in the localized strings by
the `PHP function sprintf <https://www.php.net/manual/en/function.sprintf.php>`__.

This behaviour is the same like in a
:ref:`Fluid translate ViewHelper with arguments <extension-localization-fluid-arguments>`.


.. _extbase-localization-utility-api:

API of the Extbase :php:`LocalizationUtility`
---------------------------------------------

..  include:: /CodeSnippets/Extbase/LocalizationUtilityApi.rst.txt
