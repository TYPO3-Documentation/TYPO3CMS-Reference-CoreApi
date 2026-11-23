..  include:: /Includes.rst.txt
..  index:: Events; BeforeRecordLanguageOverlayEvent
..  _BeforeRecordLanguageOverlayEvent:

==================================
`BeforeRecordLanguageOverlayEvent`
==================================

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Event\BeforeRecordLanguageOverlayEvent`
can be used to modify information (such as the
:ref:`LanguageAspect <context-api-aspects-language>` or the actual incoming
record from the database) before the database is queried.

..  seealso::
    *   :ref:`AfterRecordLanguageOverlayEvent <AfterRecordLanguageOverlayEvent>`

..  _BeforeRecordLanguageOverlayEvent-example:

Example: Overlay the records of one table with connected translations
======================================================================

In this example, the records of one table are overlaid with their connected
translations, as on a site with `fallbackType: strict`. This may be
necessary if your site is configured with free mode, but you have a record
type that has languages connected. The listener sets the overlay type
:php:`LanguageAspect::OVERLAYS_ON_WITH_FLOATING`.

..  versionchanged:: 15.0
    :changelog: deprecation-111326-1793692850

    The example used the overlay type :php:`LanguageAspect::OVERLAYS_ON`,
    which is deprecated.

..  literalinclude:: _BeforeRecordLanguageOverlayEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Domain/Language/MyEventListener.php

..  _BeforeRecordLanguageOverlayEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Domain\Event\BeforeRecordLanguageOverlayEvent
