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

Example: transliterate file names to ASCII
==========================================

..  versionchanged:: 15.0
    :changelog: breaking-110966-1791465024

    The option `UTF8filesystem`, which transliterated file names when it was
    disabled, has been removed.

TYPO3 stores file names with their Unicode characters, so
:file:`Grüße.pdf` keeps its umlaut. The following listener replaces such
characters with their ASCII equivalent, so the file is stored as
:file:`Gruesse.pdf`. Every remaining byte that is not a word character, a dot,
or a hyphen becomes an underscore. A character without an ASCII equivalent,
such as a Japanese one, therefore turns into several underscores.

..  literalinclude:: _SanitizeFileNameEvent/_AsciiFileNameListener.php
    :caption: EXT:my_extension/Classes/EventListener/AsciiFileNameListener.php

..  _SanitizeFileNameEvent-api:

`SanitizeFileNameEvent` API
===========================

..  versionchanged:: 14.0
    The original (unsanitized) file name can now be retrieved using
    :php:`SanitizeFileNameEvent::getOriginalFileName()`.

..  include:: /CodeSnippets/Events/Core/Resource/SanitizeFileNameEvent.rst.txt
