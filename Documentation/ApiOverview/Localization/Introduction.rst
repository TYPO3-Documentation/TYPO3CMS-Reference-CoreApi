.. include:: /Includes.rst.txt

============
Introduction
============

Except for some low level functions, TYPO3 exclusively uses localizable
strings for all labels displayed in the backend. This means that the whole user
interface may be translated. The encoding is strictly UTF-8.

The default language is American (US) English, and the Core ships only with such
labels (and so should extensions).

All labels are stored in :ref:`XLIFF format <xliff>`, generally located in the
:file:`Resources/Private/Language/` folder of an extension (old locations
may still be found in some places).

The format, TYPO3 specific details and managing interfaces of XLIFF are
outlined in detail in this chapter.
