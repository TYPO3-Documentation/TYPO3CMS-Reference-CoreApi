..  include:: /Includes.rst.txt
..  index:: Events; BeforeLabelResourceResolvedEvent
..  _BeforeLabelResourceResolvedEvent:

================================
BeforeLabelResourceResolvedEvent
================================

..  versionadded:: 14.0

The PSR-14 event :php:`\TYPO3\CMS\Core\Mail\Event\BeforeLabelResourceResolvedEvent`
is dispatched before the message is sent by the mailer and can be
used to manipulate the :php:`\Symfony\Component\Mime\RawMessage` and the
:php:`\Symfony\Component\Mailer\Envelope`. Usually a
:php:`\Symfony\Component\Mime\Email` or :php:`\TYPO3\CMS\Core\Mail\FluidEmail`
instance is given as :php:`RawMessage`. Additionally the mailer instance is
given, which depends on the implementation - usually
:php:`\TYPO3\CMS\Core\Mail\Mailer`. It contains the
:php:`\Symfony\Component\Mailer\Transport` object, which can be retrieved using
the :php:`getTransport()` method.

The PSR-14 event :php:`\TYPO3\CMS\Core\Localization\Event\BeforeLabelResourceResolvedEvent`
is dispatched during translation domain resolution, directly after a domain
name has been generated from a language file path.
It allows extensions to **customize or adjust the generated domain name**
before the mapping is finalized.

This event is useful if your project or extension requires a different naming
scheme for domain identifiers or if you need to normalize file-to-domain
mappings in a specific way.

The event provides access to the following public properties:

* :php:`$fileName` – The absolute path of the language file being processed
* :php:`$extensionKey` – The extension key the file belongs to
* :php:`$domain` – The generated domain name (modifiable)

..  _BeforeLabelResourceResolvedEvent-example:

Example: Map translation domain for my_extension.messages to a different file
=============================================================================

This example listener shortens generated domain names for a specific extension:

..  literalinclude:: _BeforeLabelResourceResolvedEvent/_CustomTranslationDomainResolver.php
    :caption: EXT:my_extension/Classes/EventListener/CustomTranslationDomainResolver.php

..  _BeforeLabelResourceResolvedEvent-api:

API of the event BeforeLabelResourceResolvedEvent
=================================================

..  include:: /CodeSnippets/Events/Localization/BeforeLabelResourceResolvedEvent.rst.txt
