..  include:: /Includes.rst.txt
..  _LanguageService-loaders:

===================
Translation loaders
===================

..  versionchanged:: 14.0
    The TYPO3 localization system has been migrated to use Symfony Translation
    components.

    Custom language parsers, registered via
    `$GLOBALS['TYPO3_CONF_VARS']['SYS']['lang']['parser']['xlf']` are not
    supported anymore.

In order to load translation files TYPO3 uses class
:php:`\TYPO3\CMS\Core\Localization\Loader\XliffLoader` for XLIFF file processing.

TYPO3 overrides the default XLIFF loader provided by Symfony to implement
special functionality like
`$GLOBALS['TYPO3_CONF_VARS']['LANG']['requireApprovedLocalizations']  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-lang-requireapprovedlocalizations>`_.

..  _LanguageService-loaders-custom:

Example: A custom json translation file loader
==============================================

..  versionadded:: 14.0

Extension developers can now implement custom translation loaders by
implementing Symfony's translation loader interfaces:

..  literalinclude:: _codesnippets/_JsonFileLoader.php
    :caption: EXT:my_extension/Classes/JsonFileLoader.php

Register custom loaders via configuration:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['LANG']['loader']['json'] = \MyExtension\Translation\JsonFileLoader::class;
