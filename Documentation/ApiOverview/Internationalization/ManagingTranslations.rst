..  include:: /Includes.rst.txt
..  index:: Internationalization; Manage translations
..  _managing-translating:

=================================
Managing translations for backend
=================================

This sections highlights the different ways to translate and manage XLIFF files.


..  index:: Internationalization; Fetch translations
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

    ..  group-tab:: Legacy installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 language:update


..  index:: Internationalization; Local translations
..  _xliff-translating-local:

Local translations
==================

With `Virtaal <http://translate.sourceforge.net/wiki/virtaal/index>`_ it is
possible to translate XLIFF files locally. Virtaal is an open source,
cross-platform application.

..  figure:: /Images/ExternalImages/System/InternationalizationXliffWithVirtaal.png
    :alt: Virtaal screenshot

    Translating with Virtaal, with suggestions from other software

Translating files locally is useful for extensions which should not be published
or for creating :ref:`custom translations <xliff-translating-custom>`.


..  index:: Internationalization; Custom translations
..  _xliff-translating-custom:

Custom translations
===================

:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']` allows to
override XLIFF files. Actually, this is not just about translations. Default
language files can also be overridden. The syntax is as follows:

..  code-block:: php
    :caption: EXT:examples/ext_localconf.php

    // Override a file in the default language
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:frontend/Resources/Private/Language/locallang_tca.xlf'][]
        = 'EXT:examples/Resources/Private/Language/custom.xlf';
    // Override a German ("de") translation
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']['EXT:news/Resources/Private/Language/locallang_modadministration.xlf'][]
        = 'EXT:examples/Resources/Private/Language/Overrides/de.locallang_modadministration.xlf';


The German language file looks like this:

..  code-block:: xml
    :caption: EXT:examples/Resources/Private/Language/Overrides/de.locallang_modadministration.xlf

    <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
    <xliff version="1.0">
        <file source-language="en" datatype="plaintext" date="2013-03-09T18:44:59Z" product-name="examples">
            <header/>
            <body>
                <trans-unit id="pages.title_formlabel" xml:space="preserve">
                    <source>Most important title</source>
                    <target>Wichtigster Titel</target>
                </trans-unit>
            </body>
        </file>
    </xliff>


and the result can be easily seen in the backend:

..  figure:: /Images/ManualScreenshots/Internationalization/InternationalizationLabelOverride.png
    :alt: Custom label

    Custom translation in the TYPO3 backend


..  important::
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


..  index:: Internationalization; Custom languages
..  _xliff-translating-languages:

Custom languages
================

:ref:`i18n_languages` describes the languages which are supported by default.

It is possible to add custom languages to the TYPO3 backend and create the translations
locally using XLIFF files.

First of all, the language must be declared:

..  code-block:: php
    :caption: typo3conf/AdditionalConfiguration.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['user'] = [
        'gsw_CH' => 'Swiss German',
    ];

This new language does not have to be translated entirely. It can be defined
as a fallback to another language, so that only differing labels have to be
translated:

..  code-block:: php
    :caption: typo3conf/AdditionalConfiguration.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['dependencies'] = [
        'gsw_CH' => ['de_AT', 'de'],
    ];

In this case, we define that "gsw_CH" (the `official code
<https://www.localeplanet.com/icu/>`_ for "Schwiizertüütsch" - that is "Swiss
German") can fall back on "de_AT" (another custom translation) and then on "de".

The translations must be stored in the appropriate labels path sub-folder
(:ref:`Environment-labels-path`), in this case :file:`/gsw_CH`.

The least you need to do is to translate the label with the name of the language
itself so that it appears in the user settings. In our example, this would be in
the file :file:`/gsw_CH/setup/mod/gsw_CH.locallang.xlf`.

..  code-block:: xml

    <?xml version='1.0' encoding='utf-8'?>
    <xliff version="1.0">
        <file source-language="en" target-language="gsw_CH" datatype="plaintext">
            <header/>
            <body>
                <trans-unit id="lang_gsw_CH" approved="yes">
                    <source>Swiss German</source>
                    <target state="translated">Schwiizertüütsch</target>
                </trans-unit>
            </body>
        </file>
   </xliff>

..  include:: /Images/AutomaticScreenshots/Internationalization/CustomLanguage.png.rst.txt

..  note::
    Each language will always fall back on the default one (i.e. English) if no
    a translation is found. A custom language will fall back on its "parent"
    language automatically. Thus, in our second example of "de_AT" (German for
    Austria), there would be no need to define a fallback for "de_AT" if it fell
    back to "de".

..  seealso::
    Configure :yaml:`typo3Language` to use custom languages in the frontend,
    see :ref:`sitehandling-addinglanguages` for details.
