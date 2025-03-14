:navigation-title: Localization

..  include:: /Includes.rst.txt
..  index:: Extbase; Localization

============
Localization
============

..  todo: Link to core documentation of language files.

Multilingual websites are widespread nowadays, which means that the
web-available texts have to be localized. Extbase provides the helper class
:php:`\TYPO3\CMS\Extbase\Utility\LocalizationUtility` for the translation of the labels. Besides,
there is the Fluid ViewHelper `<f:translate>`, with the help of whom you can use that
functionality in templates.

The localization class has only one public static method called `translate`, which
does all the translation. The method can be called like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/SomeController.php

    use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

    $someString = LocalizationUtility::translate($key, $extensionName, $arguments);

`$key`
    The identifier to be translated. If the format *LLL:path:key* is given, then this
    identifier is used, and the parameter `$extensionName` is ignored. Otherwise, the
    file :file:`Resources/Private/Language/locallang.xlf` from the given extension is loaded,
    and the resulting text for the given key in the current language returned.

`$extensionName`
    The extension name. It can be fetched from the request.

`$arguments`
    It allows you to specify an array of arguments. In the `LocalizationUtility`, these arguments will be passed to the function `vsprintf`. So you can insert dynamic values in every translation. You can find the possible wildcard specifiers under `<https://www.php.net/manual/function.sprintf.php#refsect1-function.sprintf-parameters>`__.

    *Example language file with inserted wildcards*

    ..  literalinclude:: _Localization/_locallang.xlf
        :language: xml
        :caption: EXT:my_extension/Resources/Private/Language/locallang.xlf


    *Called translations with arguments to fill data in wildcards*

    ..  code-block:: php
        :caption: EXT:my_extension/Classes/Controller/SomeController.php

        use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

        $someString = LocalizationUtility::translate('count_posts', 'BlogExample', [$countPosts, $countComments])

        $anotherString = LocalizationUtility::translate('greeting', 'BlogExample', [$userName])
