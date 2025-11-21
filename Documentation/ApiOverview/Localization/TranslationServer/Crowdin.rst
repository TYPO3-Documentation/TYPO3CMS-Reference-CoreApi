..  include:: /Includes.rst.txt
..  index::
    Localization; Crowdin
    Crowdin
..  _xliff-translating-server-crowdin:

=========================
Localization with Crowdin
=========================

..  youtube:: 5TnUh0AzqHE

------------

..  contents:: Table of contents

..  toctree::
    :titlesonly:
    :caption: More to read

    Crowdin/ExtensionIntegration
    Crowdin/OnlineTranslation
    Crowdin/Workflow
    Crowdin/Bestpractice
    Crowdin/Faq

..  _xliff-translating-server-crowdin-what-is:

What is Crowdin?
================

`Crowdin`_ is a cloud-based localization management platform and offers features
essential for delivering great translation:

Single source
    Translate text once that is used in different versions and parts of the
    software.

Machine translation
    Let machines do the first pass and then  human-translators can edit the
    suggestions.

Glossary
    We can use our own TYPO3 glossary to make sure specific words are properly
    translated (for example, "Template" in German, "TypoScript" or "SEO").

Translation memory
    We can reuse existing translations, no matter if done for the TYPO3 Core or
    an extension.

..  _Crowdin: https://crowdin.com/

..  _xliff-translating-server-crowdin-contribute:

..  index:: Crowdin; Translations

Contribute translations
=======================

There are basically two cases where you can provide a helping hand:

Join our `group of translators and proofreaders`_ and help where you can. This
can be the translation of a whole extension into your language or the revision
of a part of the Core.

#.  Contribution to the general translation of the TYPO3 Core and extensions:
    As TYPO3 is growing in features and functionality, the need for translating
    new labels grows as well. You can contribute with help while TYPO3 is
    growing. Join in and give a hand where you can. This can be the translation
    of a whole extension into your language or the revision of a part of the
    Core.

#.  If you develop extensions, you can make the extension available for
    translation. Just follow :ref:`crowdin-extension-integration` to make it
    available to the translation team.

Even if you do not see yourself as a translator, you can still participate. In
case you stumble across a typo, an error or an untranslated term in your
language in TYPO3: Log in to Crowdin, join the project where you found the typo
and make a suggestion for the label in your language.

The quality of your work is more important than its quantity. Ensure correct
spelling (for example, capitalization), grammar, and punctuation. Use only
terminology that is consistent with the rest of the language pack. Do not make
mistakes in the technical parts of the strings, such as variable placeholders,
HTML, etc. For these reasons, using an automatic translation (e.g. DeepL, Google
Translate, AI) is never good enough.

All services and documents that are visible to the user are translated by the
team of translators and proofreaders. It does not matter which language you
speak. We already have many language teams that are very active. Our goal is
more diversity to help us with our work on internationalization.

..  _group of translators and proofreaders: https://crowdin.com/profile/TYPO3
