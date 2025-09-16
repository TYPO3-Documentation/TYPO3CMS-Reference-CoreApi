..  include:: /Includes.rst.txt
..  _Locale-api:

======
Locale
======

..  versionadded:: 12.2

The :php:`\TYPO3\CMS\Core\Localization\Locale` class unifies the handling of
locales instead of dealing with "default" or other TYPO3-specific namings.

The :php:`Locale` class is instantiated with a string following the
`IETF RFC 5646`_ language tag standard:

..  code-block:: php

    use TYPO3\CMS\Core\Localization\Locale;

    $locale = new Locale('de-CH');

A locale supported by TYPO3 consists of the following parts
(`tags and subtags`_):

*   `ISO 639-1`_ / `ISO 639-2`_ compatible language key in lowercase
    (such as `fr` for French or `de` for German)
*   optionally the `ISO 15924`_ compatible language script system
    (4 letter, such as `Hans` as in `zh_Hans`)
*   optionally the region / country code according to `ISO 3166-1`_ standard in
    upper camelcase such as `AT` for Austria.

Examples for a locale string are:

*   `en` for English
*   `pt` for Portuguese
*   `da-DK` for Danish as used in Denmark
*   `de-CH` for German as used in Switzerland
*   `zh-Hans-CN` for Chinese with the simplified script as spoken in China
    (mainland)

The :php:`Locale` object can be used to create a new
:ref:`LanguageService <LanguageService-api>` object via the
:ref:`LanguageServiceFactory <LanguageServiceFactory-api>` for translating
labels. Previously, TYPO3 used the `default` language key, instead of the locale
`en` to identify the English language. Both are supported, but it is
encouraged to use `en-US` or `en-GB` with the region subtag to identify the
chosen language more precisely.

Example for using the :php:`Locale` class for creating a :php:`LanguageService`
object for translations:

..  literalinclude:: _LocaleExample.php
    :caption: EXT:my_extension/Classes/LocaleExample.php

..  _IETF RFC 5646: https://www.rfc-editor.org/rfc/rfc5646.html
..  _ISO 639-1: https://en.wikipedia.org/wiki/ISO_639-1
..  _ISO 639-2: https://en.wikipedia.org/wiki/ISO_639-2
..  _ISO 3166-1: https://en.wikipedia.org/wiki/ISO_3166-1
..  _ISO 15924: https://en.wikipedia.org/wiki/ISO_15924
..  _tags and subtags: https://www.rfc-editor.org/rfc/rfc5646.html#section-2

..  include:: _Locale.rst.txt
