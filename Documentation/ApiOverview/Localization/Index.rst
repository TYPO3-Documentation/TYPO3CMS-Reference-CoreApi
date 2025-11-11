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

In TYPO3, two types of texts require translation:

Labels and messages
    Short texts shown in the frontend or backend,
    usually stored in `XLIFF format
    <https://docs.typo3.org/permalink/t3coreapi:xliff>`_ in the file system,
    for example, :file:`locallang.xlf`.
Content
    Editorial content, such as localized
    database records and language-specific files (for example, PDF versions).

This section covers the first type: *labels and messages*.
For translating editorial content, see the `Localized content
<https://docs.typo3.org/permalink/t3translate:localized-content>`_ chapter in
the Frontend Localization Guide.

TYPO3 uses translatable strings for backend labels, so that the
backend is fully localizable. All text uses UTF-8 encoding.

The default language is American English (en_US). The TYPO3 Core ships
with English labels only, and extensions should do the same.

All label files use the :ref:`XLIFF format <xliff>` and are typically stored in
:file:`Resources/Private/Language/`. (Older extensions may still use legacy
paths.)

This chapter explains the XLIFF format specific to TYPO3 and tools for
managing translations.

..  toctree::
    :titlesonly:

    Labels/Index
    Languages
    ManagingTranslations
    TranslationServer/Index
    LocalizationApi/Index
    XliffAPI
    XliffFormat
