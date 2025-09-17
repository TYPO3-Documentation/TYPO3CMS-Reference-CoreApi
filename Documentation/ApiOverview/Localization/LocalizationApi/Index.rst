..  include:: /Includes.rst.txt
..  index::
    pair: Localization; API
..  _localization-api:

================
Localization API
================

The Localization API provides the building blocks TYPO3 uses to resolve locales
and translate labels from XLIFF files in both Backend and Frontend code. It
covers locale parsing and normalization, creation of context-aware translation
services, and convenient helpers for TypoScript, Extbase and Fluid.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: `Locale <https://docs.typo3.org/permalink/t3coreapi:locale-api>`_

        Parse and normalize IETF BCP 47 language tags (e.g. `de-CH`) to build a
        precise locale context for translations.

    ..  card:: `LanguageServiceFactory <https://docs.typo3.org/permalink/t3coreapi:languageservicefactory-api>`_

        Create context-aware `LanguageService <https://docs.typo3.org/permalink/t3coreapi:languageservice-api>`_ instances
        at runtime.

    ..  card:: `LanguageService <https://docs.typo3.org/permalink/t3coreapi:languageservice-api>`_

        Translate labels via `LLL:EXT:...` in PHP; loads XLIFF resources on demand.

    ..  card:: :ref:`LocalizationUtility (Extbase) <extbase-localization-utility-api>`

        Convenience wrapper to translate labels inside Extbase.

    ..  card:: `Localization in TypoScript <https://docs.typo3.org/permalink/t3coreapi:extension-localization-typoscript>`_

        Using `LLL:EXT:...` labels in TypoScript.

..  toctree::
    :titlesonly:
    :glob:
    :hidden:

    *
