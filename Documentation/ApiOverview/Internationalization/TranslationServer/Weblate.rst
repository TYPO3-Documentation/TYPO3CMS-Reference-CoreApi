.. include:: ../../../Includes.txt


.. _xliff-translating-server-weblate:

=========================
Localization with Weblate
=========================

.. tip::

   Weblate is used for TYPO3, but not for everything yet.
   
   
.. seealso::

    *  `Issue tracking Weblate use <https://github.com/TYPO3-Documentation/T3DocTeam/issues/148>`__.
   

What is Weblate
===============

Weblate is a continuous localization management platform, offering the best experience for translators and in turn better resulting quality:

- **Method**: Use the different modes and failing checks to ensure quality.
- **Machine translation**: To be used sparingly.
- **Glossary**: we can use our own TYPO3 glossary to make sure specific words are properly translated (e.g. Template in german, TypoScript or SEO)
- **Translation memory**: we can reuse existing translations, no matter if done for the TYPO3 Core or an extension.
- **Source string errors**: Fix these yourself by clicking the link to source, or use the respective category of the comment section.
- **Context**: Only admins can upload contextual info like labels and descriptions. Ask if anything is unclear.
- **Screenshots**: Only admins can upload these, and for the time being users should single out problematic strings to do so for.
- **Weblate** is a copylefted libre software localization solution.


.. _weblate-initiative:

Weblate Initiative
==================

The current goal is to use Weblate for all translations of TYPO3.
This means adding all resources to an instance of Weblate.

.. seealso::

    *  `Localization with Weblate Initiative <https://develop.intelec.uni-passau.de/>`__.

Contributions
=============


1. General translation of TYPO3 core and extensions: As TYPO3 is growing in features and functionality, the need for translating new labels is growing too.
   You can contribute with help while TYPO3 is growing. Join in and give a hand where you can.

2. Make extentions available for translation by adding them and moving them over from Crowdin.

You don't have to translate to participate. If you find an error in TYPO3, or something that could be done better, you can make suggestions, and log in to edit any language.

The quality of your work is more important than the quantity. Make sure spelling (e.g. capitalization), grammar and punctuation are correct. Only use terminology consistent with the rest of the language pack. Don't make mistakes in technical parts of the strings, like variable placeholders, HTML etc. Relying on automatic translation (e.g, Google Translate) is forbidden.

The Weblate platforms have more interaction, and are more closely tied to improving source strings in the source code repository.

More to Read
============

.. toctree::
   :titlesonly:
