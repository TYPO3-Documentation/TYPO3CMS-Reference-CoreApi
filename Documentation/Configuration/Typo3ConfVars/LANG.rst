..  include:: /Includes.rst.txt

..  _typo3ConfVars_sys_lang:
..  _typo3ConfVars_lang:

=============================
LANG - Language configuration
=============================

..  confval-menu::
    :name: globals-typo3-conf-vars-lang
    :display: tree
    :type:

..  _typo3ConfVars_sys_lang_requireApprovedLocalizations:

..  confval:: requireApprovedLocalizations
    :name: globals-typo3-conf-vars-sys-lang-requireApprovedLocalizations
    :Path: $GLOBALS['TYPO3_CONF_VARS']['LANG']['requireApprovedLocalizations']
    :type: bool
    :Default: true

    ..  versionchanged:: 14.0
        This option has been moved from `$GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['requireApprovedLocalizations']`.

    The attribute :xml:`approved` of the :ref:`XLIFF <xliff>` standard is
    respected by TYPO3 since version 12.0 when parsing XLF files. This attribute
    can either have the value :xml:`yes` or :xml:`no` and indicates whether the
    translation is final or not.

    ..  code-block:: xml
        :caption: EXT:my_extension/Resources/Private/Language/locallang.xml

        <trans-unit id="label2" approved="yes">
            <source>This is label #2</source>
            <target>Ceci est le libellé no. 2</target>
        </trans-unit>

    This setting can be used to control the behavior:

    :php:`true`
        Only translations with the attribute :xml:`approved` set to :xml:`yes`
        will be used. Any non-approved translation (value is set to :xml:`no`)
        will be ignored. If the attribute :xml:`approved` is omitted, the
        translation is still taken into account.

    :php:`false`
        All translations are used.

..  confval:: loader
    :name: globals-typo3-conf-vars-lang-loader
    :Path: $GLOBALS['TYPO3_CONF_VARS']['LANG']['loader']
    :type: array

    ..  versionchanged:: 14.0
        This option is a predecessor of `$GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['parser']`.

    Configures custom translation loaders.

..  confval:: format
    :name: globals-typo3-conf-vars-lang-format
    :Path: $GLOBALS['TYPO3_CONF_VARS']['LANG']['format']
    :type: bool
    :Default: true

    ..  versionchanged:: 14.0
        This option has been moved from `$GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['format']`.

..  confval:: availableLocales
    :name: globals-typo3-conf-vars-lang-availableLocales
    :Path: $GLOBALS['TYPO3_CONF_VARS']['LANG']['availableLocales']
    :type: array
    :Default: `['default']`

    ..  versionchanged:: 14.0
        This option has been moved from `$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['lang']['availableLanguages']`.

..  confval:: resourceOverrides
    :name: globals-typo3-conf-vars-lang-resourceOverrides
    :Path: $GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']
    :type: array
    :Default: `[]`

    ..  versionchanged:: 14.0
        This option has been moved from `$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']`.

    Allows overriding XLIFF files. This applies not only to translations but
    also to default language files.

    See also: `Custom translations <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-custom>`_

    The syntax is as follows:

    ..  code-block:: php

        $GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']
            ['EXT:frontend/Resources/Private/Language/locallang_tca.xlf'][]
                = 'EXT:examples/Resources/Private/Language/custom.xlf';
        // Override a German ("de") translation
        $GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']['de']
            ['EXT:news/Resources/Private/Language/locallang_modadministration.xlf'][]
                = 'EXT:examples/Resources/Private/Language/Overrides/de.locallang_modadministration.xlf';
