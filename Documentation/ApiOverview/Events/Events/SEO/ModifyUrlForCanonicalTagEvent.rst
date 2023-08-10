..  include:: /Includes.rst.txt
..  index:: Events; ModifyUrlForCanonicalTagEvent
..  _ModifyUrlForCanonicalTagEvent:


=============================
ModifyUrlForCanonicalTagEvent
=============================

With the PSR-14 event `\TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent`
the URL for the :html:`href` attribute of the canonical tag can be altered or
emptied.

Example
=======

Registration of the event in the :file:`Services.yaml`:

..  literalinclude:: _ModifyUrlForCanonicalTagEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Changing the host of the current request and setting it as canonical:

..  literalinclude:: _ModifyUrlForCanonicalTagEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Seo/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Seo/ModifyUrlForCanonicalTagEvent.rst.txt
