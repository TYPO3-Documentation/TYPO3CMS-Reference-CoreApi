..  include:: /Includes.rst.txt
..  index:: Localization; Manage translations
..  _managing-translating:

=====================
Managing translations
=====================

This sections highlights the different ways to translate and manage XLIFF files.


..  index:: Localization; Fetch translations
..  _xliff-translating-fetch:

Fetching translations
=====================

The backend module :guilabel:`Admin Tools > Maintenance > Manage Language Packs`
allows to manage the list of available languages to your users and can fetch and
update language packs of TER and Core extensions from the official translation server.
The module is rather straightforward to use and should be pretty much self-explanatory.
Downloaded language packs are stored in the environment's
:ref:`Environment-labels-path`.

..  include:: /Images/AutomaticScreenshots/AdminTools/ManageLanguagePacks.rst.txt


Language packs can also be fetched using the command line:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 language:update

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 language:update


..  index:: Localization; Local translations
..  _xliff-translating-local:

Local translations
==================

With `t3ll <https://github.com/garfieldius/t3ll>`__ it is possible to translate
XLIFF files locally. t3ll is an open source, cross-platform application and runs
on console under Linux, MacOS and Windows. It opens its editor inside a Google
Chrome or Chromium window.

..  figure:: /Images/ExternalImages/System/t3ll.png
    :alt: t3ll screenshot

    Translating with t3ll

Just call on a console, for example:

..  tabs::

    ..  group-tab:: Linux / MacOS

        ..  code-block:: bash

            t3ll path/to/your/extension/Resources/Private/Language/locallang.xlf

    ..  group-tab:: Windows

        ..  code-block:: powershell

            t3ll.exe path\to\your\extension\Resources\Private\Language\locallang.xlf

Translating files locally is useful for extensions which should not be published
or for creating :ref:`custom translations <xliff-translating-custom>`.


..  index:: Localization; Custom translations
..  _xliff-translating-custom:

Custom translations
===================

:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']` allows to
override XLIFF files. Actually, this is not just about translations. Default
language files can also be overridden. The syntax is as follows:

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:examples/ext_localconf.php

The German language file looks like this:

..  literalinclude:: _de.locallang_modadministration.xlf
    :language: xml
    :caption: EXT:examples/Resources/Private/Language/Overrides/de.locallang_modadministration.xlf


and the result can be easily seen in the backend:

..  figure:: /Images/ManualScreenshots/Internationalization/InternationalizationLabelOverride.png
    :alt: Custom label

    Custom translation in the TYPO3 backend


..  attention::
    -   You do not have to copy the full reference file, but only the labels you
        want to translate.
    -   The path to the file to be overridden must be specified as
        :file:`EXT:my_extension/...` and have the extension `xlf`.

..  attention::
    The following is a **bug** but must be taken as a constraint for now:

    -   The files containing the custom labels must be located inside an
        extension. Other locations will not be considered.
    -   The original translation needs to exist in the environment's
        :ref:`Environment-labels-path` or next to the base translation file in
        extensions, for example in
        :file:`my_extension/Resources/Private/Language/`.


..  index:: Localization; Custom languages
..  _xliff-translating-languages:

Custom languages
================

TYPO3 :ref:`supports many languages <i18n_languages>` by default. But it is also
possible to add custom languages and create the translations locally using XLIFF
files.

..  rst-class:: bignums-xxl

#.  Define the language

    As example, we "gsw_CH" (the official code for “Schwiizertüütsch” - that is
    "Swiss German") as additional language:

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['user'] = [
            'gsw_CH' => 'Swiss German',
        ];

#.  Add fallback to another language

    This new language does not have to be translated entirely. It can be defined
    as a fallback to another language, so that only differing labels have to be
    translated:

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['dependencies'] = [
            'gsw_CH' => ['de_AT', 'de'],
        ];

    In this case, we define that "gsw_CH" can fall back on "de_AT" (another
    custom translation) and then on "de".

#.  Add translation files

    The translations for system extensions and extensions from :abbr:`TER (TYPO3
    Extension Repository)` must be stored in the appropriate labels path
    sub-folder (:ref:`Environment-labels-path`), in this case :file:`gsw_CH`.

    The least you need to do is to translate the label with the name of the language
    itself so that it appears in the user settings. In our example, this would be in
    the file :file:`gsw_CH/setup/Resources/Private/Language/gsw_CH.locallang.xlf`.

    ..  code-block:: xml
        :caption: gsw_CH/setup/Resources/Private/Language/gsw_CH.locallang.xlf

        <?xml version="1.0" encoding="UTF-8"?>
        <xliff xmlns="urn:oasis:names:tc:xliff:document:1.2" version="1.2">
            <file source-language="en" target-language="gsw_CH" datatype="plaintext" original="EXT:setup/Resources/Private/Language/locallang.xlf">
                <body>
                    <trans-unit id="lang_gsw_CH" approved="yes">
                        <source>Swiss German</source>
                        <target>Schwiizertüütsch</target>
                    </trans-unit>
                </body>
            </file>
        </xliff>

    The custom language is now available in the user settings:

    ..  include:: /Images/AutomaticScreenshots/Internationalization/CustomLanguage.png.rst.txt

    For translations in own extensions you can provide the custom language files
    in the :file:`Resources/Private/Language/` folder of the extension, for
    example :file:`gsw_CH.locallang_db.xlf`.

..  note::
    Each language will always fall back on the default one (i.e. English) if no
    a translation is found. A custom language will fall back on its "parent"
    language automatically. Thus, in our second example of "de_AT" (German for
    Austria), there would be no need to define a fallback for "de_AT" if it fell
    back to "de".

..  seealso::
    Configure :yaml:`typo3Language` to use custom languages in the frontend,
    see :ref:`sitehandling-addinglanguages` for details.
