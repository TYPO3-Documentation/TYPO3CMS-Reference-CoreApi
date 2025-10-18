:navigation-title: Localization

..  include:: /Includes.rst.txt
..  index::
    ! Localization
    see: Localization; Localization
..  _locallang:
..  _locallang-elements:
..  _locallang-elements-nesting:
..  _locallang-elements-value:
..  _locallang-ext:
..  _locallang-example-backend:
..  _internationalization:

..  _localization:

==========================================
Localization: Translating labels in TYPO3
==========================================

In TYPO3, two main types of texts require translation:

Interface labels and messages
    Texts shown in the frontend or backend,
    usually stored in the file system in `XLIFF format
    <https://docs.typo3.org/permalink/t3coreapi:xliff>`_, for example in
    :file:`locallang.xlf`.
Localized content
    Translated editorial content, such as localized
    database records or language-specific files (e.g. PDF versions).

This section covers the first type: *labels and messages*.
For translating editorial content, see the `Localized content
<https://docs.typo3.org/permalink/t3translate:localized-content>`_ chapter in
the Frontend Localization Guide.

TYPO3 uses translatable strings for nearly all backend labels, enabling a fully
localizable user interface. All text uses UTF-8 encoding.

The default language is American English (en_US). The TYPO3 Core ships only
with English labels, and extensions should do the same.

All label files use the :ref:`XLIFF format <xliff>` and are typically stored in
:file:`Resources/Private/Language/`. (Older extensions may still use legacy
paths.)

This chapter explains the XLIFF format, TYPO3-specific details, and tools for
managing translations.

..  toctree::
    :titlesonly:

    Labels
    Languages
    ManagingTranslations
    TranslationServer/Index
    LocalizationApi/Index
