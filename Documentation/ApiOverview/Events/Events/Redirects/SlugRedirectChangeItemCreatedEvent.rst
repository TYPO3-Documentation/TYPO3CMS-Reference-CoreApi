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

Examples
========

Using the :php:`PageTypeSource`
-------------------------------

The source type implementation based on
:php:`\TYPO3\CMS\Redirects\RedirectUpdate\PageTypeSource`
provides the page type number as additional value. The main use case
for this source type is to provide additional source types where the source host
and path are taken from a full built URI before the page slug change occurred for
a specific page type. This avoids the need for extension authors to implement a
custom source type for the same task, and instead providing a custom event
listener to build sources for non-zero page types.

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _SlugRedirectChangeItemCreatedEvent/_PageTypeSource/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _SlugRedirectChangeItemCreatedEvent/_PageTypeSource/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

With a custom source implementation
-----------------------------------

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

Default event listeners
=======================

The listener :php:`\TYPO3\CMS\Redirects\EventListener\AddPageTypeZeroSource`
creates a :php:`\TYPO3\CMS\Redirects\RedirectUpdate\PageTypeSource` for a page
before the slug has been changed. The full URI is built to fill the `source_host`
and `source_path`, which takes configured `RouteEnhancers` and `RouteDecorators`
into account, e.g. the `PageType route decorator`.

..  note::

    If `source_host` and `source_path` lead to the same outcome for page type 0
    using the full URI building like the
    :php:`\TYPO3\CMS\Redirects\RedirectUpdate\PlainSlugReplacementSource`, the
    :php:`PlainSlugReplacementSource` is replaced with the :php:`PageTypeSource`.

It is not possible to configure for which page types sources should be added. If
you need to do so, read :ref:`additional `PageTypeSource` auto-create redirect source type <feature-94499-1675615570>`
which contains an example how to implement a custom event listener based on
:php:`PageTypeSource`.

In case that :php:`PageTypeSource` for page type `0` results in a different
source, the :php:`PlainSlugReplacementSource` is not removed to keep the original
behaviour, which some instances may rely on.

This behaviour can be modified by adding an event listener for
:php:`SlugRedirectChangeItemCreatedEvent`:

Remove plain slug source if page type 0 differs:
------------------------------------------------

Registration of the event in your extension's :file:`Services.yaml`:

..  literalinclude:: _SlugRedirectChangeItemCreatedEvent/_AddPageTypeZeroSource/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _SlugRedirectChangeItemCreatedEvent/_AddPageTypeZeroSource/_Services.yaml
    :language: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Redirects/SlugRedirectChangeItemCreatedEvent.rst.txt
