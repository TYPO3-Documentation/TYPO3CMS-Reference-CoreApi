.. include:: ../../../Includes.txt


.. _xliff-translating-server-crowdin:

================================
Localization with Crowdin [beta]
================================

.. tip::

   The integration of Crowdin is currently in beta state. Once it is stabilized, it will be also available in installations using TYPO3 9 LTS.

What is Crowdin
---------------
Crowdin is a localization management platform and offers the core features essential for delivering great translation:

- **Single source**: Translate text once that is used in different versions and parts of the software.
- **Machine translation**: Let machines do the first pass and then human-translators can edit the suggestions.
- **Glossary**: we can use our own TYPO3 glossary to make sure specific words are properly translated (e.g. Template in german, TypoScript or SEO)
- **Translation memory**: we can reuse existing translations, no matter if done for the TYPO3 Core or an extension.
- **Crowdin** is a cloud-based content localization solution which offers a free plan for open source projects.

.. tip::

   Crowdin is completely free of charge for open-source projects.

Workflow
--------
The following workflow is used to bring a translation into a TYPO3 installation.

.. rst-class:: bignums

1. Creating translations

   The translations are managed on Crowdin at https://crowdin.com/project/typo3-cms.

   You can either translate all strings on the Crowdin platform or directly in the TYPO3 backend. This is described in detail at :ref:`crowdin-usage`.

2. Translation Export

   Once the translations are approved on Crowdin by a proof reader, those are automatically exported and copied to the translation server `beta-translation.typo3.org`.

   If interested in the technical details, take a look at the package XYZ TODO: Add link to repo.

3. Import translations into TYPO3 installations

   The translations can be downloaded within a TYPO3 installation.
   This is described at :ref:`xliff-translating-fetch`.

Crowdin initiative
------------------
A TYPO3 initiative has been created which takes care of integrating Crowdin into TYPO3.
The initiative’s scope is to fulfill all features which have been available with Pootle and its integration.

Click `for more information <https://typo3.org/community/teams/typo3-development/initiatives/localization-with-crowdin/>`__.

More to read
------------

.. toctree::
   :titlesonly:

   Crowdin/Usage
   Crowdin/ExtensionIntegration
