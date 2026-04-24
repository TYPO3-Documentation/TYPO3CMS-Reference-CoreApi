..  include:: /Includes.rst.txt
..  _LanguageService-api:
..  _translator-api:

==============
Translator API
==============

..  versionadded:: 14.2

    The :php-short:`\TYPO3\CMS\Core\Localization\TranslatorInterface` has been
    introduced. :php-short:`\TYPO3\CMS\Core\Localization\LanguageService`
    now implements this interface, making it possible to type-hint against the
    interface instead of the concrete class.

Instances of :php:`\TYPO3\CMS\Core\Localization\TranslatorInterface`
translate strings in plain PHP.

For examples see :ref:`extension-localization-php`.  Create a
:php-short:`\TYPO3\CMS\Core\Localization\TranslatorInterface` with
:ref:`LanguageServiceFactory-api`.

In the backend context a :php-short:`\TYPO3\CMS\Core\Localization\TranslatorInterface`
is stored in the global variable :php:`$GLOBALS['LANG']`.

In the frontend a :php-short:`\TYPO3\CMS\Core\Localization\TranslatorInterface` can
be accessed via the contentObject:

..  literalinclude:: _ExampleController.php
    :caption: EXT:my_extension/Classes/Controller/ExampleController.php (not Extbase)

In the CLI context the global `$GLOBALS['LANG']` is not available and has to be
instantiated manually.

..  include:: _TranslatorInterface.rst.txt
