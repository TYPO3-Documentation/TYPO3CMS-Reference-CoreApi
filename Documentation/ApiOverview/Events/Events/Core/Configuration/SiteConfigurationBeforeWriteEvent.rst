..  include:: /Includes.rst.txt
..  index:: Events; SiteConfigurationBeforeWriteEvent
..  _SiteConfigurationBeforeWriteEvent:

=================================
SiteConfigurationBeforeWriteEvent
=================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\SiteConfigurationBeforeWriteEvent`
allows the modification of the :ref:`site configuration <sitehandling>` array
before writing the configuration to disk.

..  note::
    If you need to change the configuration when it is loaded, use
    :ref:`SiteConfigurationLoadedEvent`.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/SiteConfigurationBeforeWriteEvent.rst.txt
