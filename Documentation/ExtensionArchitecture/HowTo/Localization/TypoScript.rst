.. include:: /Includes.rst.txt
.. index:: Localization; TypoScript

==========
TypoScript
==========

Output localized strings with Typoscript
========================================

The :ref:`getText property LLL <t3tsref:data-type-gettext-lll>` can be
used to fetch translations from a translation file and output it
in the current language:

.. code-block:: typoscript
   :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

   lib.blogListTitle = TEXT
   lib.blogListTitle.data = LLL : EXT:blog_example/Resources/Private/Language/locallang.xlf:blog.list

TypoScript conditions based on the current language
===================================================

The condition function
:ref:`siteLanguage <t3tsref:condition-functions-in-frontend-context-function-siteLanguage>`
can be used to provide certain TypoScript configurations only for certain
languages. You can query for any property of the language in the
site configuration.

.. code-block:: typoscript
   :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

   [siteLanguage("locale") == "de_CH"]
       lib.something.value = This site has the locale "de_CH"
   [end]

   [siteLanguage("title") == "Italy"]
       lib.languageTitle.value = This site has the title "Italy"
   [end]


Changing localized terms using TypoScript
=========================================

.. attention::
   When localized strings are managed directly in TypoScript instead of :file:`.xlf`
   files the translations are not exported with export tools to be send to
   translation agencies. The language strings in TypoScript might be
   overlooked when introducing future translations.

It is possible to override texts in the plugin configuration in
TypoScript. See :ref:`TypoScript reference, _
LOCAL_LANG <t3tsref:setup-plugin-local-lang-lang-key-label-key>`.

If, for example, you want to use the text "Remarks" instead of the
text "Comments", you can overwrite the identifier
:html:`comment_header` for the affected languages. For this, you can
add the following line to your TypoScript template:

.. code-block:: typoscript
   :caption: EXT:blog_example/Configuration/TypoScript/setup.typoscript

   plugin.tx_blogexample._LOCAL_LANG.default.comment_header = Remarks
   plugin.tx_blogexample._LOCAL_LANG.de.comment_header = Bemerkungen
   plugin.tx_blogexample._LOCAL_LANG.zh.comment_header = 备注

With this, you will overwrite the localization of the term
:html:`comment_header` for the default language and the languages de and zh
in the blog example.

The :file:`locallang.xlf` files of the extension do not need to be changed for
this.

:typoscript:`stdWrap.lang`
==========================

:typoscript:`stdWrap` offers the :ref:`lang <t3tsref:stdwrap-lang>` property
with which localized strings can be provided directly by TypoScript.
This can be used as a quick fix but it is not recommended to
manage translations within the TypoScript code.
