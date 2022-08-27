.. include:: /Includes.rst.txt
.. index::
   Localization; PHP
.. _extension-localization-php:

====================
Localization in PHP
====================

Sometimes you have to localize a string in PHP code, for
example inside of a controller or a ViewHelper.

You can get the translation of a string into the current language via:

..  code-block:: php
    :caption: EXT:my_extension/Classes/SomeClass.php

    $translatedString = $GLOBALS['LANG']->sL($translationKey);

Where :php:`$translationKey` has the following format:

..  code-block:: php
    :caption: EXT:my_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;

    $translationKey = 'LLL:EXT:my_extension'
        . '/Resources/Private/Language/locallang.xlf:' . $key;

As the access to this global variable will probably change in future versions
of TYPO3 it is considered best practice to use a wrapper function:

..  code-block:: php
    :caption: EXT:my_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Localization\LanguageService;

    public function myMethod(string $translationKey): void {
        $translatedString = self::getLanguageService()->sL($translationKey);
        // ...
    }

    protected static function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

Localization in Extbase context
===============================

In Extbase context you can use the method
`\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $extensionName)`.

This method requires the localization key as the first and the extension's
name as the second parameter. Then the corresponding text in the current
language will be loaded from this extension's :file:`locallang.xlf` file.

The function :php:`translate()` takes translation overrides from TypoScript into
account. See :ref:`localization-typoscript-LOCAL_LANG`.

Localization in a pi-based controllers
======================================

If the current plugin controller inherits from
:ref:`AbstractPlugin <abstractplugin>`, a so-called pi-based plugin, the
following method can be used for localization:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyPluginController.php

    <?php

    namespace Vendor\MyExtension\Controller;

    use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
    use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
    use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;
    // ...

    class MyPluginController extends AbstractPlugin
    {
        public function main($content, $conf)
            {

                // ...
                $translatedString = $this->pi_getLL($key);
                // ...
            }
    }

The function :php:`pi_getLL` takes translation overrides from TypoScript into
account. See :ref:`localization-typoscript-LOCAL_LANG`.
