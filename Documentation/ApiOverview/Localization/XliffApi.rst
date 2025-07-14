:navigation-title: XLIFF Api

..  include:: /Includes.rst.txt
..  _xliff-api:

=================================
XLIFF Api: Access language labels
=================================

..  contents:: Table of contents

..  _xliff-api-php:

PHP: LanguageService and LocalizationUtility
============================================

In PHP, a typical call in the Backend to fetch a string in the language selected by a user
looks like this:

.. code-block:: php

   $this->getLanguageService()->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.minutesHoursDaysYears')

:php:`getLanguageService()` is a call to a helper method that accesses :php:`$GLOBALS['LANG']`. In the Backend, the bootstrap
parks an initialized instance of :php:`\TYPO3\CMS\Core\Localization\LanguageService` at this place. This may change in the
future, but for now the LanguageService can be reliably fetched from this global.

..  note::

    The :php:`->sL()` API does *not* apply a :php:`htmlspecialchars()` call to the translated string. If the string
    is returned in a web context, it *must* be added manually.


If additional placeholders are used in a translation source, they must be injected, a call then typically looks like this:

..  code-block:: php

    // Text string in .xlf file has a placeholder:
    // <trans-unit id="message.description.fileHasBrokenReferences">
    //     <source>The file has %1s broken reference(s) but it will be deleted regardless.</source>
    // </trans-unit>
    sprintf($this->getLanguageService()->sL(
        'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:message.description.fileHasBrokenReferences'),
        count($brokenReferences)
    );

Various classes are involved in the localization process, with
:php:`\TYPO3\CMS\Core\Localization\LanguageService` providing the actual
methods to retrieve a localized label. :php:`sL()` loads a language file if needed first, and then
returns a label from it (using a string with the :php:`LLL:EXT:...` syntax as argument).

Extbase class :php:`\TYPO3\CMS\Extbase\Utility\LocalizationUtility` is essentially a
convenience wrapper around the :php:`\TYPO3\CMS\Core\Localization\LanguageService` class,
whose :php:`translate()` method also takes an array as argument and runs PHP's
:php:`vsprintf()` on the localized string. However, in the future it is expected this Extbase
specific class will melt down and somehow merged into the Core API classes to get rid of this
duplication.

..  _xliff-api-fluid:

Fluid: The translate ViewHelper
===============================

In Fluid, a typical call to fetch a string in the language selected by a user looks like this:

..  code-block:: html

    <f:translate key="key1" extensionName="SomeExtensionName" />
    // or inline notation
    {f:translate(key: 'someKey', extensionName: 'SomeExtensionName')}

If the correct context is set, the current extension name and language is
provided by the request. Otherwise it must be provided.

..  seealso::

    ViewHelper Reference: `Translate ViewHelper <f:translate> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-translate>`_
