:navigation-title: Label references

..  include:: /Includes.rst.txt
..  _label-reference:

==============================
Label references / LLL strings
==============================

Strings prefixed with `LLL:` are found in many places in TYPO3. They are "label
references" - references to labels that will be translated into the current language.

The general format of a label reference is:

..  code-block:: text

    LLL:EXT:<extension_key>/<path_to_xliff_file>:<identifier>

For example:

..  code-block:: text

    LLL:EXT:my_extension/Resources/Private/Language/locallang_db.xlf:mytable.myfield

If a different language is set or a language file is
`overridden <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-custom>`_,
the path is automatically adjusted.

..  contents:: Table of contents

..  _label-reference-storage:

File paths in label references
==============================

Localized labels are stored in files with
`XLIFF format <https://docs.typo3.org/permalink/t3coreapi:xliff>`_.
Most XLIFF files are located in
:folder:`EXT:my_extension/Resources/Private/Language/` and its subfolders.

In some cases the locations are different:

*   **Site sets** – Localization files for site set definitions are stored in
    the site set folder, for example:
    :file:`EXT:my_extension/Configuration/Sets/MySet/labels.xlf`
*   **Content blocks** – Third-party extensions can define their own structure.
    For example, the extension
    :composer:`friendsoftypo3/content-blocks` stores labels alongside the
    content block definitions:
    :file:`EXT:my_extension/Configuration/Sets/MySet/labels.xlf`

..  _label-reference-resolve:

Resolving localized labels
==========================

In many cases, such as the
`label of a TCA field <https://docs.typo3.org/permalink/t3tca:confval-columns-label>`_,
you can use a label reference, and TYPO3 will resolve it.

If label references are not resolved, you can do it manually:

..  _label-reference-resolve-fluid:

Fluid: Using the f:translate ViewHelper
---------------------------------------

Use the :ref:`f:translate <t3viewhelper:typo3-fluid-translate>` ViewHelper to
insert translated strings in Fluid templates.

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:translate key="LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey" />
    <!-- or as inline Fluid: -->
    {f:translate(key: 'LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey')}

See also: `The translation ViewHelper f:translate
<https://docs.typo3.org/permalink/t3coreapi:f-translate>`_

..  _label-reference-resolve-typoscript:

TypoScript: Using the getText property
--------------------------------------

The :ref:`getText property LLL <t3tsref:data-type-gettext-lll>` can be used to
fetch translations from a language file and render them in the current language.

..  code-block:: typoscript
    :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

    lib.blogListTitle = TEXT
    lib.blogListTitle {
        data = LLL : EXT:blog_example/Resources/Private/Language/locallang.xlf:blog.list
    }

Make sure to leave spaces around the colon following `LLL` (as required by
general getText syntax).

See also:
`Output localized strings with TypoScript
<https://docs.typo3.org/permalink/t3coreapi:extension-localization-typoscript-gettext>`_

..  _label-reference-resolve-php:

PHP: Using the LanguageService
------------------------------

In PHP localized labels can be retrieved via the
:php-short:`\TYPO3\CMS\Core\Localization\LanguageService`, which can be created
using the :php-short:`\TYPO3\CMS\Core\Localization\LanguageServiceFactory`.

The recommended way to determine the correct
:php-short:`LanguageService` instance depends on context:

*   **Frontend:** use the language in the current request object
    (:php-short:`Psr\Http\Message\ServerRequestInterface`) or the default site
    language.
*   **Backend:** use the language of the logged-in backend user.
*   **CLI:** determine the language programmatically depending on your use case
    (for example, when sending emails via scheduler tasks).

For more details, see
`Localization in PHP <https://docs.typo3.org/permalink/t3coreapi:extension-localization-php>`_.

Once you have the correct LanguageService instance, you can resolve labels as follows:

..  code-block:: php

    use TYPO3\CMS\Core\Localization\LanguageService;

    private function translateSomething(
        LanguageService $languageService,
        string $labelReference
    ): string {
        return $languageService->sL($labelReference);
    }
