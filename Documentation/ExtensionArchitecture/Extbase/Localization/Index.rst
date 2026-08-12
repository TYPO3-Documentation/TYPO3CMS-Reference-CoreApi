:navigation-title: Localization

..  include:: /Includes.rst.txt
..  index:: Extbase; Localization
..  _extbase-localisation:

=======================
Localization in Extbase
=======================

..  Ported from old docs, combining two pages:
    - Extbase/Reference/Localization.rst (whole page, no old anchor —
      "Localization" title section). New anchor: extbase-localisation-translate.
    - Extbase/Reference/Domain/Model/Localization/Index.rst (whole page).
      Old anchors: extbase-model-localization, extbase-model-localizedUid.

..  todo::
    Needs review: This page was ported from the old Extbase documentation and
    needs updating to the rewrite conventions.

..  warning::
    The information on this page might be outdated!

..  _extbase-localisation-translate:

Translating labels with the `LocalizationUtility`
=================================================

Multilingual websites are widespread nowadays, which means that the
web-available texts have to be localized. Extbase provides the helper class
:php:`\TYPO3\CMS\Extbase\Utility\LocalizationUtility` for the translation of the labels. Besides,
there is the Fluid ViewHelper `<f:translate>`, with the help of whom you can use that
functionality in templates.

The localization class has only one public static method called `translate`, which
does all the translation. The method can be called like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/SomeController.php

    use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

    $someString = LocalizationUtility::translate($key, $extensionName, $arguments);

`$key`
    The identifier to be translated. If the format *LLL:path:key* is given, then this
    identifier is used, and the parameter `$extensionName` is ignored. Otherwise, the
    file :file:`Resources/Private/Language/locallang.xlf` from the given extension is loaded,
    and the resulting text for the given key in the current language returned.

`$extensionName`
    The extension name. It can be fetched from the request.

`$arguments`
    It allows you to specify an array of arguments. In the `LocalizationUtility`, these arguments will be passed to the function `vsprintf`. So you can insert dynamic values in every translation. You can find the possible wildcard specifiers under `<https://www.php.net/manual/function.sprintf.php#refsect1-function.sprintf-parameters>`__.

    *Example language file with inserted wildcards*

    ..  literalinclude:: _snippets/_locallang.xlf
        :language: xml
        :caption: EXT:my_extension/Resources/Private/Language/locallang.xlf


    *Called translations with arguments to fill data in wildcards*

    ..  code-block:: php
        :caption: EXT:my_extension/Classes/Controller/SomeController.php

        use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

        $someString = LocalizationUtility::translate('count_posts', 'BlogExample', [$countPosts, $countComments])

        $anotherString = LocalizationUtility::translate('greeting', 'BlogExample', [$userName])

..  _extbase-localisation-model:
..  _extbase-model-localization:

Localization of Extbase models
==============================

..  _extbase-localisation-localized-uid:
..  _extbase-model-localizedUid:

Identifiers in localized models
-------------------------------

Domain models have a main identifier :php:`uid` and an additional property
:php:`_localizedUid`.

Depending on whether the `overlay type <https://docs.typo3.org/permalink/t3coreapi:context-api-aspects-language-overlay-types>`_
language aspect is enabled (:typoscript:`LanguageAspect::OVERLAYS_ON` or
:typoscript:`LanguageAspect::OVERLAYS_MIXED`) or disabled (:typoscript:`LanguageAspect::OVERLAYS_OFF`),
the identifier contains different values.

When the overlay language aspect is enabled, then the :php:`uid`
property contains the :php:`uid` value of the default language record and
the :php:`uid` of the translated record is kept in the :php:`_localizedUid`.

+------------------------------------------------------------+-------------------------+---------------------------+
| Context                                                    | Record in language 0    | Translated record         |
+============================================================+=========================+===========================+
| Database                                                   | uid:2                   | uid:11, l10n_parent:2     |
+------------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with Overlay language aspect enabled  | uid:2, _localizedUid:2  | uid:2, _localizedUid:11   |
+------------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with Overlay language aspect disabled | uid:2, _localizedUid:2  | uid:11, _localizedUid:11  |
+------------------------------------------------------------+-------------------------+---------------------------+

..  hint::
    If your project uses :composer:`typo3/cms-workspaces` there is yet another
    additional property, :php:`_versionedUid`. Refer to the
    :doc:`Workspaces documentation <ext_workspaces:Index>` for details on
    workspace overlays.
