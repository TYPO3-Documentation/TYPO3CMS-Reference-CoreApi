:navigation-title: Translation management

..  include:: /Includes.rst.txt
..  index:: Localization; Manage translations
..  _managing-translating:

==============================
Managing translations in TYPO3
==============================

This section highlights the different ways to translate and manage TYPO3
language files (XLIFF 1.2 and 2.0).

..  contents:: Table of contents

..  index:: Localization; Fetch translations
..  _xliff-translating-fetch:

Fetching translations or updating language packs
================================================

The backend module :guilabel:`Admin Tools > Maintenance > Manage Language Packs`
displays a list of available languages and can fetch or update language packs
for system and extension translations from the official TYPO3 translation server.

The module is straightforward to use. Downloaded language packs are stored in the
environment’s :ref:`Environment-labels-path`.

..  include:: /Images/AutomaticScreenshots/AdminTools/ManageLanguagePacks.rst.txt

Language packs can also be fetched using the command line:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 language:update

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 language:update

..  _load-language-pack:

Loading an additional language pack
===================================

Administrators can install additional language packs directly in the backend:

..  rst-class:: bignums

1.  Go to :guilabel:`Admin Tools > Maintenance > Manage Language Packs`

    ..  include:: /Images/AutomaticScreenshots/Modules/ManageLanguage.rst.txt

2.  Select :guilabel:`Add Language` and activate the new language:

    ..  include:: /Images/AutomaticScreenshots/Modules/ManageLanguagePacksAddLanguage.rst.txt

3.  The selected language is now available:

    ..  include:: /Images/AutomaticScreenshots/Modules/ManageLanguagePacksAddLanguageAddSuccess.rst.txt


..  index:: Localization; Local translations
..  _xliff-translating-local:

Translating XLIFF files locally
===============================

You can translate TYPO3 XLIFF files directly in your development environment
using any XML or translation editor that supports the XLIFF format.

TYPO3 14 and newer support both **XLIFF 1.2** and **XLIFF 2.0**:

-  **XLIFF 2.0:** uses `<unit>` elements and the `<target state="…">` attribute
   (`state="reviewed"` / `state="final"` = approved)
-  **XLIFF 1.2:** uses `<trans-unit>` and the `approved="yes"` attribute

Both formats are automatically detected and parsed by TYPO3.

You can use any text or translation editor to modify `.xlf` files locally.
Ensure that your chosen tool supports the XLIFF 2.0 format, which is the
default for TYPO3 14 and later.

..  index:: Localization; Custom translations
..  _xliff-translating-custom:

Overriding or extending translations
====================================

..  versionchanged:: 14.0
    `$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']` has been moved
    to `$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides'] <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-lang-resourceoverrides>`_.

Option `$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides'] <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-lang-resourceoverrides>`_
allows overriding XLIFF files. This applies to both translations and default
(language = English) files.

..  literalinclude:: _snippets/_ext_localconf.php
    :language: php
    :caption: EXT:examples/ext_localconf.php

The German language file could look like this:

..  literalinclude:: _snippets/_de.locallang_modadministration.xlf
    :language: xml
    :caption: EXT:examples/Resources/Private/Language/Overrides/de.locallang_modadministration.xlf

TYPO3 loads either XLIFF 1.2 or 2.0 — the format is detected automatically.

The result can be seen in the backend:

..  figure:: /Images/ManualScreenshots/Internationalization/InternationalizationLabelOverride.png
    :alt: Custom label

    Custom translation in the TYPO3 backend

..  attention::
    -   You only need to include the labels you want to override.
    -   The path to the file to be overridden must be specified as
        :file:`EXT:my_extension/...` and must end with `.xlf`.

..  attention::
    The following is a **known limitation**:

    -   Custom label files must be located inside an extension.
        Other locations are ignored.
    -   The original translation must exist in the environment’s
        :ref:`Environment-labels-path` or next to the base translation file in
        the extension, for example in
        :file:`my_extension/Resources/Private/Language/`.


..  index:: Localization; Custom languages
..  _xliff-translating-languages:

Adding custom languages
=======================

TYPO3 :ref:`supports many languages <i18n_languages>` by default, but you can also
add custom languages and provide your own translations using XLIFF 1.2 or 2.0.

..  rst-class:: bignums-xxl

#.  Define the language

    Example: add "gsw_CH" (Swiss German) as an additional language.

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['user'] = [
            'gsw_CH' => 'Swiss German',
        ];

#.  Add fallback to another language

    This language does not have to be translated completely.
    It can fall back to another language so that only differing labels
    need translation.

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['dependencies'] = [
            'gsw_CH' => ['de_AT', 'de'],
        ];

    In this example, "gsw_CH" falls back to "de_AT" and then to "de".

#.  Add translation files

    Translation files for system and extension labels must be stored under the
    correct subfolder of the environment’s :ref:`Environment-labels-path`.
    The minimum requirement is to translate the language name so it appears
    in the user settings.

    ..  tabs::

        ..  group-tab:: XLIFF 2.0 (recommended)

            ..  literalinclude:: _snippets/_gsw_CH.locallang_2.0.xlf
                :language: xml
                :caption: gsw_CH/setup/Resources/Private/Language/gsw_CH.locallang.xlf


        ..  group-tab:: XLIFF 1.2 (legacy)

            ..  literalinclude:: _snippets/_gsw_CH.locallang_1.2.xlf
                :language: xml
                :caption: gsw_CH/setup/Resources/Private/Language/gsw_CH.locallang.xlf

    The new language is now available in the backend user settings:

    ..  include:: /Images/AutomaticScreenshots/Internationalization/CustomLanguage.png.rst.txt

    For your own extensions, provide the custom language files in the
    :file:`Resources/Private/Language/` folder, for example
    :file:`gsw_CH.locallang_db.xlf`.

Each language always falls back on the default one (English) if no
translation is found. A custom language automatically falls back on its
defined dependencies. For example, "de_AT" would fall back on "de"
automatically.

..  seealso::
    Configure :yaml:`typo3Language` to use custom languages in the frontend.
    See :ref:`sitehandling-addinglanguages` for details.
