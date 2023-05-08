..  include:: /Includes.rst.txt
..  index:: Events; SiteConfigurationBeforeWriteEvent
..  _SiteConfigurationBeforeWriteEvent:

=================================
SiteConfigurationBeforeWriteEvent
=================================

..  versionadded:: 12.0

The PSR-14 event
:php:`\TYPO3\CMS\Core\Configuration\Event\SiteConfigurationBeforeWriteEvent`
allows the modification of the :ref:`site configuration <sitehandling>` array
before writing the configuration to disk.

..  note::
    If you need to change the configuration when it is loaded, use
    :ref:`SiteConfigurationLoadedEvent`.

Example
=======

To register an event listener to the new event, use the following code in your
:file:`Services.yaml`:

..  literalinclude:: _SiteConfigurationBeforeWriteEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

API
===

..  include:: /CodeSnippets/Events/Core/SiteConfigurationBeforeWriteEvent.rst.txt
