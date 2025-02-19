..  include:: /Includes.rst.txt
..  index:: Events; SiteConfigurationLoadedEvent
..  _SiteConfigurationLoadedEvent:

============================
SiteConfigurationLoadedEvent
============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\SiteConfigurationLoadedEvent`
allows the modification of the :ref:`site configuration <sitehandling>` array
before loading the configuration.

..  note::
    If you need to change the configuration before it is saved to disk, use
    :ref:`SiteConfigurationBeforeWriteEvent`.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/SiteConfigurationLoadedEvent.rst.txt
