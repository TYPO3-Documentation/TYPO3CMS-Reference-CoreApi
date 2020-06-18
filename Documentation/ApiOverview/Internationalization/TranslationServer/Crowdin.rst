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
- **Crowdin** is a cloud-based content localization solution.


.. _crowdin-initiative:

Crowdin Initiative
==================

A TYPO3 initiative has been created which takes care of integrating Crowdin into TYPO3.
The initiative’s scope is to fulfill all features which have been available with Pootle and its integration.

Click `for more information <https://typo3.org/community/teams/typo3-development/initiatives/localization-with-crowdin/>`__.

More to Read
============

.. toctree::
   :titlesonly:

   Crowdin/ExtensionIntegration
   Crowdin/Workflow
   Crowdin/Faq
