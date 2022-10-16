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
name as optional second parameter. Then the corresponding text in the current
language will be loaded from this extension's :file:`locallang.xlf` file.

The method :php:`translate()` takes translation overrides from TypoScript into
account. See :ref:`localization-typoscript-LOCAL_LANG`.

.. todo: add an example from examples here
