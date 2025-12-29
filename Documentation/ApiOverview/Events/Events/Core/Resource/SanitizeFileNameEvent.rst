..  include:: /Includes.rst.txt
..  index:: Events; SanitizeFileNameEvent
..  _SanitizeFileNameEvent:

=====================
SanitizeFileNameEvent
=====================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\SanitizeFileNameEvent` is
fired when a file name is sanitized. Event listeners can modify the sanitized
file name in order to apply custom naming conventions (for example, replacing
whitespace with hyphens for SEO-friendly file names).

..  _SanitizeFileNameEvent-example:

Example: Sanitize a file name with hyphens instead of underscores
=================================================================

The following listener uses the original (unsanitized) file name to replace
whitespace with hyphens and assigns the result as sanitized file name.

..  literalinclude:: _SanitizeFileNameEvent/_SeoFriendlyFileNameListener.php
    :caption: EXT:my_extension/Classes/EventListener/SeoFriendlyFileNameListener.php

..  _SanitizeFileNameEvent-api:

SanitizeFileNameEvent API
=========================

..  versionchanged:: 14.0
    The original (unsanitized) file name can now be retrieved using
    :php:`SanitizeFileNameEvent::getOriginalFileName()`.

..  include:: /CodeSnippets/Events/Core/Resource/SanitizeFileNameEvent.rst.txt
