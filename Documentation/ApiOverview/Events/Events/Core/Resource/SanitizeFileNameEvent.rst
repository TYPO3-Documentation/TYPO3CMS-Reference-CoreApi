..  include:: /Includes.rst.txt
..  index:: Events; SanitizeFileNameEvent
..  _SanitizeFileNameEvent:

=======================
`SanitizeFileNameEvent`
=======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\SanitizeFileNameEvent` is
fired when a file name is sanitized. Event listeners can modify the sanitized
file name in order to apply custom naming conventions (for example, replacing
whitespace with hyphens for SEO-friendly file names).

..  _SanitizeFileNameEvent-example:

Example: sanitize a file name with hyphens instead of underscores
=================================================================

The following listener uses the original (unsanitized) file name to replace
whitespace with hyphens and assigns the result as sanitized file name.

..  literalinclude:: _SanitizeFileNameEvent/_SeoFriendlyFileNameListener.php
    :caption: EXT:my_extension/Classes/EventListener/SeoFriendlyFileNameListener.php

..  _SanitizeFileNameEvent-transliterate:

Example: transliterate umlauts and accents in file names
========================================================

..  versionchanged:: 15.0
    :changelog: breaking-110966-1791465024

    The option `UTF8filesystem`, which transliterated file names when it was
    disabled, has been removed.

TYPO3 stores file names with their Unicode characters, so
:file:`Grüße.pdf` keeps its umlaut. The following listener replaces each
character that has an ASCII equivalent, so the file is stored as
:file:`Gruesse.pdf`, and :file:`Москва.jpg` as :file:`Moskva.jpg`. Letters
without an ASCII equivalent, such as Japanese ones, stay as they are, so
:file:`東京.png` and :file:`京都.png` keep different names. Every other
character, such as a space or an ampersand, becomes an underscore, except
dots, underscores, and hyphens.

..  literalinclude:: /_Examples/my_extension/Classes/EventListener/TransliterateFileNameListener.php
    :caption: EXT:my_extension/Classes/EventListener/TransliterateFileNameListener.php

..  _SanitizeFileNameEvent-api:

`SanitizeFileNameEvent` API
===========================

..  versionchanged:: 14.0
    The original (unsanitized) file name can now be retrieved using
    :php:`SanitizeFileNameEvent::getOriginalFileName()`.

..  typo3:api-class:: \TYPO3\CMS\Core\Resource\Event\SanitizeFileNameEvent
