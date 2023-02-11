..  include:: /Includes.rst.txt
..  index:: Events; SlugRedirectChangeItemCreatedEvent
..  _SlugRedirectChangeItemCreatedEvent:


==================================
SlugRedirectChangeItemCreatedEvent
==================================

..  versionadded:: 12.2

The PSR-14 event :php:`\TYPO3\CMS\Redirects\Event\SlugRedirectChangeItemCreatedEvent`
is fired in the :php:`\TYPO3\CMS\Redirects\RedirectUpdate\SlugRedirectChangeItemFactory`
and allows extensions to manage the redirect sources for which redirects should
be created.

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

Registration of the event in the extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Redirects\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/redirects/add-redirect-source'
          after: 'redirects-add-plain-slug-replacement-source'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Redirects/MyEventListener.php

    namespace MyVendor\MyExtension\Redirects;

    use MyVendor\MyExtension\Redirects\CustomSource;
    use TYPO3\CMS\Redirects\Event\SlugRedirectChangeItemCreatedEvent;
    use TYPO3\CMS\Redirects\RedirectUpdate\PlainSlugReplacementRedirectSource;
    use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceCollection;

    final class MyEventListener {
        public function __invoke(SlugRedirectChangeItemCreatedEvent $event): void
        {
            // Retrieve change item and sources
            $changeItem = $event->getSlugRedirectChangeItem();
            $sources = $changeItem->getSourcesCollection()->all();

            // Remove plain slug replacement redirect source from sources
            $sources = array_filter(
                $sources,
                fn ($source) => !($source instanceof PlainSlugReplacementRedirectSource)
            );

            // Add custom source implementation
            $sources[] = new CustomSource();

            // Replace sources collection
            $changeItem = $changeItem->withSourcesCollection(
                new RedirectSourceCollection(...array_values($sources))
            );

            // Update changeItem in the event
            $event->setSlugRedirectChangeItem($changeItem);
        }
    }

Example of a :php:`CustomSource` implementation:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Redirects/CustomSource.php

    namespace MyVendor\MyExtension\Redirects;

    use TYPO3\CMS\Redirects\RedirectUpdate\RedirectSourceInterface;

    final class CustomSource implements RedirectSourceInterface
    {
        public function getHost(): string
        {
            return '*';
        }

        public function getPath(): string
        {
            return '/some-path';
        }

        public function getTargetLinkParameters(): array
        {
            return [];
        }
    }

API
===

.. include:: /CodeSnippets/Events/Redirects/SlugRedirectChangeItemCreatedEvent.rst.txt
