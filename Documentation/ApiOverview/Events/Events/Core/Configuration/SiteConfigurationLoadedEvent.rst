..  include:: /Includes.rst.txt
..  index:: Events; SiteConfigurationLoadedEvent
..  _SiteConfigurationLoadedEvent:

============================
SiteConfigurationLoadedEvent
============================

..  versionadded:: 12.0

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\SiteConfigurationLoadedEvent`
allows the modification of the :ref:`site configuration <sitehandling>` array
before loading the configuration.

..  note::
    If you need to change the configuration before it is saved to disk, use
    :ref:`SiteConfigurationBeforeWriteEvent`.

Example
=======

To register an event listener to the new event, use the following code in your
:file:`Services.yaml`:

..  literalinclude:: _SiteConfigurationLoadedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

API
===

..  include:: /CodeSnippets/Events/Core/SiteConfigurationLoadedEvent.rst.txt
