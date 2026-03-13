.. include:: /Includes.rst.txt
.. index::
   Localization; PHP
.. _extension-localization-php:

====================
Localization in PHP
====================

Sometimes you have to localize a string in PHP code, for
example inside of a controller or a user function.

Which method of localization to use depends on the current context:

..  contents::
    :local:

Localization in plain PHP
=========================

.. note::

    The :php:`\TYPO3\CMS\Core\Localization\LanguageService` could formerly be
    accessed via the global variable :php:`$GLOBALS['LANG']`. This is now
    discouraged. Use :php:`LanguageServiceFactory` instead.

The :php:`\TYPO3\CMS\Core\Localization\LanguageService` is available if a
backend user has been initialized, in particular in the following contexts:

*   frontend: only if there is a logged-in backend user
*   backend: always, except in :guilabel:`System` modules (for example within
    an upgrade wizard in the backend)
*   install tool / install tool modules in backend (e.g. Upgrade Wizard): no
*   in cli: only if a backend user was initialized, e.g. by
    `TYPO3\CMS\Core\Core\Bootstrap::initializeBackendUser()`

The :php:`LanguageServiceFactory` can be used to instantiate. Please see the examples below.

:ref:`The methods provided by the instantiated LanguageService <LanguageService-api>`
class then be used to translate texts using the language keys of XLIFF language
files.

Localization in frontend context
--------------------------------

In plain PHP use the class :ref:`LanguageServiceFactory <LanguageServiceFactory-api>`
to create a :ref:`LanguageService <LanguageService-api>` from the current
site language:

..  literalinclude:: _php/MyUserFunction.php
    :caption: EXT:my_extension/Classes/UserFunction/MyUserFunction.php

:ref:`DependencyInjection` should be available in most contexts where you need
translations. Also the current request is available in entry point such as
custom non-Extbase controllers, user functions, data processors etc.

Localization in backend context
-------------------------------

In the backend context you should use the
:ref:`LanguageServiceFactory <LanguageServiceFactory-api>`
to create the required :ref:`LanguageService <LanguageService-api>`.

..  literalinclude:: _php/MyBackendClass.php
    :caption: EXT:my_extension/Classes/Backend/MyBackendClass.php

..  attention::
    During development you are usually logged into the backend. So the global
    variable :php:`$GLOBALS['LANG']` might be available in the frontend. Once
    logged out it is usually not available. **Never** depend on
    :php:`$GLOBALS['LANG']` in the frontend unless you know what you are doing.

Localization without context
----------------------------

If you should happen to be in a context where none of these are available,
for example a static function, you can still do translations:

..  literalinclude:: _php/MyUtility.php
    :caption: EXT:my_extension/Classes/Utility/MyUtility.php

.. _extension-localization-extbase:

Localization in Extbase
=======================

In :ref:`Extbase <extbase>` context you can use the method
:ref:`\\TYPO3\\CMS\\Extbase\\Utility\\LocalizationUtility::translate($key, $extensionName) <extbase-localization-utility-api>`.

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

..  literalinclude:: _php/locallang.xlf
    :language: xml
    :emphasize-lines: 8

The :php:`arguments` will be replaced in the localized strings by
the `PHP function sprintf <https://www.php.net/manual/en/function.sprintf.php>`__.

This behaviour is the same like in a
:ref:`Fluid translate ViewHelper with arguments <extension-localization-fluid-arguments>`.

Examples
========

..  _example-localization-middleware:

Provide localized strings via JSON by a middleware
--------------------------------------------------

In the following example we use the :ref:`language service API <LanguageService-api>`
to provide a list of localized season names. This list could then be loaded in
the frontend via Ajax.

You can finde the complete example on
`GitHub, EXT:examples, HaikuSeasonList <https://github.com/TYPO3-Documentation/t3docs-examples/blob/main/Classes/Middleware/HaikuSeasonList.php>`__.

As we do not need a full frontend context with TypoScript the JSON is returned
by a :ref:`PSR-15 middleware <request-handling>`.

Beside other factories needed by our response, we inject the
:ref:`LanguageServiceFactory <LanguageServiceFactory-api>` with
:ref:`constructor dependency injection <Constructor-injection>`.

..  include:: _php/_LanguageServiceFactoryDI.rst.txt

The main method :php:`process()` is called with a
:php:`Psr\Http\Message\ServerRequestInterface` as argument that can be used to detect the
current language and is therefore passed on to the private method :php:`getSeasons()` doing the
actual translation:

..  include:: _php/_ProcessMiddleware.rst.txt

Now we can let the :php:`\TYPO3\CMS\Core\Localization\LanguageServiceFactory` to
create a :php:`\TYPO3\CMS\Core\Localization\LanguageService` from the request's
language, falling back to the default language of the site.

The :php:`LanguageService` can then be queried for the localized strings:

..  include:: _php/_LanguageServiceSl.rst.txt
