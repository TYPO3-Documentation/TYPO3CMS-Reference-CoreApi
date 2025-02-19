..  include:: /Includes.rst.txt
..  index:: Events; BeforeRecordLanguageOverlayEvent
..  _BeforeRecordLanguageOverlayEvent:

================================
BeforeRecordLanguageOverlayEvent
================================

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Event\BeforeRecordLanguageOverlayEvent`
can be used to modify information (such as the
:ref:`LanguageAspect <context_api_aspects_language>` or the actual incoming
record from the database) before the database is queried.

..  seealso::
    *   :ref:`AfterRecordLanguageOverlayEvent`

..  _BeforeRecordLanguageOverlayEvent-example:

Example: Change the overlay type to "on" (connected)
====================================================

In this example, we will change the overlay type to "on" (connected). This may
be necessary if your site is configured with free mode, but you have a record
type that has languages connected.

..  literalinclude:: _BeforeRecordLanguageOverlayEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Language/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

..  _BeforeRecordLanguageOverlayEvent-api:

API
===

..  include:: /CodeSnippets/Events/Core/BeforeRecordLanguageOverlayEvent.rst.txt
