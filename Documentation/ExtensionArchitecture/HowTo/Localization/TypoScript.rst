..  include:: /Includes.rst.txt
..  index:: Localization; TypoScript
..  _extension-localization-typoscript:

==========
TypoScript
==========

..  _extension-localization-typoscript-gettext:

Output localized strings with TypoScript
========================================

The :ref:`getText property LLL <t3tsref:data-type-gettext-lll>` can be
used to fetch translations from a translation file and output it
in the current language:

..  literalinclude:: _blogListTitle.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/SitePackage/setup.typoscript

..  _extension-localization-typoscript-conditions:

TypoScript conditions based on the current language
===================================================

The condition function
:ref:`siteLanguage <t3tsref:condition-functions-in-frontend-context-function-siteLanguage>`
can be used to provide certain TypoScript configurations only for certain
languages. You can query for any property of the language in the
site configuration.

..  literalinclude:: _TypoScript/_currentLanguageCondition.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/SitePackage/setup.typoscript

..  _localization-typoscript-local-lang:

Changing localized terms using TypoScript
=========================================

..  attention::
    When localized strings are managed directly in TypoScript instead of :file:`.xlf`
    files the translations are not exported with export tools to be send to
    translation agencies. The language strings in TypoScript might be
    overlooked when introducing future translations.

It is possible to override texts in the plugin configuration in
TypoScript.

See :ref:`TypoScript reference,
_LOCAL_LANG <t3tsref:setup-plugin-local-lang-lang-key-label-key>`.

If, for example, you want to use the text "Remarks" instead of the
text "Comments", you can overwrite the identifier
:html:`comment_header` for the affected languages. For this, you can
add the following line to your TypoScript template:

..  literalinclude:: _TypoScript/_locallang_extbase.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

With this, you will overwrite the localization of the term
:html:`comment_header` for the languages "en", "de" and "zh"
in the blog example.

..  _localization-typoscript-local-lang-keys:

Which language key an override needs
------------------------------------

..  versionchanged:: 15.0
    :changelog: important-110175-1790179101

    :typoscript:`_LOCAL_LANG.default` overrode the labels of the English XLIFF
    file, because TYPO3 read `default` as English. It is a last resort now, so
    an override of an English label has to move to `en` or `en-US`.

Write the language key of the locale the override belongs to. TYPO3 resolves a
label in this order, and takes the first one it finds:

..  rst-class:: bignums

#.  The :typoscript:`_LOCAL_LANG` override of the locale, for example `fr-LU`.

#.  The :typoscript:`_LOCAL_LANG` override of the language of that locale, or
    of one of its fallback locales, for example `fr`.

#.  The label of the XLIFF file of the locale or of a fallback locale.

#.  :typoscript:`_LOCAL_LANG.default`, and only where the label exists in none
    of the above.

So `default` reaches the output only for a label that no XLIFF file carries.
Use it for a label of your own, and a language key for everything that
overrides a shipped label.

Write a key of a locale as the language in lowercase, a dash, and the country
in uppercase, so `fr-LU` and `en-US`. TYPO3 normalizes the key, so `fr_LU`
resolves to the same locale. Keep to one spelling in a project, which stays
easier to read.

The :file:`locallang.xlf` files of the extension do not need to be changed for
this.

..  attention::
    Setting :php:`_LOCAL_LANG` might not work for the ViewHelper
    :html:`<f:translate>` if used outside of the Extbase request.
    and the :html:`extensionName` ViewHelper attribute is not set and the key used
    does not follow the `LLL:EXT:extensionkey` syntax.

Outside of an Extbase request TYPO3 tries to infer the the extension key
from the :html:`extensionName` ViewHelper attribute or the language key
itself.

..  literalinclude:: _TypoScript/_locallang_fluidtemplate.typoscript
    :caption: Fictional root template

..  _localization-typoscript-stdwrap-lang:

`stdWrap.lang`
==============

:typoscript:`stdWrap` offers the :ref:`lang <t3tsref:stdwrap-lang>` property,
which can be used to provide localized strings directly from TypoScript.
This can be used as a quick fix but it is not recommended to
manage translations within the TypoScript code.
