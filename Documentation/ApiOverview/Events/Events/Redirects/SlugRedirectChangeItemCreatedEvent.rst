..  include:: /Includes.rst.txt
..  index:: Events; SlugRedirectChangeItemCreatedEvent
..  _SlugRedirectChangeItemCreatedEvent:


==================================
SlugRedirectChangeItemCreatedEvent
==================================

..  versionadded:: 12.2

The PSR-14 event :php:`\TYPO3\CMS\Redirects\Event\SlugRedirectChangeItemCreatedEvent`
is fired in the :php:`\TYPO3\CMS\Redirects\RedirectUpdate\SlugRedirectChangeItemFactory`
class and allows extensions to manage the redirect sources for which redirects
should be created.

TYPO3 already implements the
:t3src:`redirects/Classes/EventListener/AddPlainSlugReplacementSource.php`
listener. It is used to add the plain slug value based source type, which
provides the same behavior as before. Implementing this as a Core listener
gives extension authors the ability to remove the source added by
:php:`AddPlainSlugReplacementSource` when their listeners are registered and
executed afterwards. See the example below.

The implementation of the
:t3src:`redirects/Classes/RedirectUpdate/RedirectSourceInterface.php` interface
is required for custom source classes. Using this interface enables automatic
detection of implementations. Additionally, this allows to transport custom
information and data.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _SlugRedirectChangeItemCreatedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _SlugRedirectChangeItemCreatedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

Example of a :php:`CustomSource` implementation:

..  literalinclude:: _SlugRedirectChangeItemCreatedEvent/_CustomSource.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/CustomSource.php

API
===

..  include:: /CodeSnippets/Events/Redirects/SlugRedirectChangeItemCreatedEvent.rst.txt
