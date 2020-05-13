.. include:: ../../../Includes.txt


.. _xliff-translating-server-crowdin:

=========================
Localization with Crowdin
=========================

.. tip::

   Crowdin is used for TYPO3 10 by default. Since 9.5.14 it can be enabled for TYPO3 9 by using a :ref:`feature toggle <xliff-translating-featuretoggle>`.

What is Crowdin
===============

Crowdin is a localization management platform and offers the core features essential for delivering great translation:

- **Single source**: Translate text once that is used in different versions and parts of the software.
- **Machine translation**: Let machines do the first pass and then human-translators can edit the suggestions.
- **Glossary**: we can use our own TYPO3 glossary to make sure specific words are properly translated (e.g. Template in german, TypoScript or SEO)
- **Translation memory**: we can reuse existing translations, no matter if done for the TYPO3 Core or an extension.
- **Crowdin** is a cloud-based content localization solution which offers a free plan for open source projects.

.. note::

   Crowdin is completely free of charge for open-source projects.


.. _crowdin-initiative:

Crowdin Initiative
==================

A TYPO3 initiative has been created which takes care of integrating Crowdin into TYPO3.
The initiative’s scope is to fulfill all features which have been available with Pootle and its integration.

Click `for more information <https://typo3.org/community/teams/typo3-development/initiatives/localization-with-crowdin/>`__.

Contribute in translation
=========================
There are basically two cases, where you can hook in with a helping hand:

1.     Contribution in general translation of TYPO3 core and extensions. While TYPO3 is growing in features and functionality, the need for translating new labels is growing too. You can contribute with help while TYPO3 is growing. Stick in and give a hand where you can. It can be translation a hole extension into your language or take a part of core for a makeover.

2.     If you are developing extensions, you can make the extension available for translating. Just follow :ref:`this guide <crowdin-extension-integration>` to make it available for the translation team.

If you don’t recon yourself as a translator, you can still participate. In the case where you stumble upon a typo, an error or non-translated term in TYPO3 in your language. Log in to Crowdin, join the project that host the typo and make a suggestion to the label in your language.

The quality of your work is more important than the quantity. Make sure spelling, grammar, capitals and punctuation are correct. Only use terminology consistent with the rest of the language pack. Don't make mistakes in technical parts of the strings, like variable placeholders, html etc. For these reasons, using automatic translation (e.g, Google Translate) is never good enough.

All services and documents that are visible to the user are translated by the translation team. It does not matter which language you speak. We already have a lot of language teams who are very active. Our claim is more diversity, to support us in our work at I18n.

More to Read
============

.. toctree::
   :titlesonly:

   Crowdin/ExtensionIntegration
   Crowdin/OnlineTranslation
   Crowdin/Workflow
   Crowdin/Faq
