..  include:: /Includes.rst.txt
..  index:: Localization; TypoScript
.. _extension-localization-typoscript:

==========
TypoScript
==========

.. _extension-localization-typoscript-gettext:

Output localized strings with Typoscript
========================================

The :ref:`getText property LLL <t3tsref:data-type-gettext-lll>` can be
used to fetch translations from a translation file and output it
in the current language:

..  code-block:: typoscript
    :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

    lib.blogListTitle = TEXT
    lib.blogListTitle {
        data = LLL : EXT:blog_example/Resources/Private/Language/locallang.xlf:blog.list
    }

.. _extension-localization-typoscript-conditions:

TypoScript conditions based on the current language
===================================================

The condition function
:ref:`siteLanguage <t3tsref:condition-functions-in-frontend-context-function-siteLanguage>`
can be used to provide certain TypoScript configurations only for certain
languages. You can query for any property of the language in the
site configuration.

..  literalinclude:: _TypoScript/_currentLanguageCondition.typoscript
    :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

..  _localization-typoscript-LOCAL_LANG:

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
    :caption: EXT:blog_example/Configuration/TypoScript/setup.typoscript

With this, you will overwrite the localization of the term
:html:`comment_header` for the default language and the languages "de" and "zh"
in the blog example.

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

..  _localization-typoscript-stdWrap.lang:

:typoscript:`stdWrap.lang`
==========================

:typoscript:`stdWrap` offers the :ref:`lang <t3tsref:stdwrap-lang>` property,
which can be used to provide localized strings directly from TypoScript.
This can be used as a quick fix but it is not recommended to
manage translations within the TypoScript code.
