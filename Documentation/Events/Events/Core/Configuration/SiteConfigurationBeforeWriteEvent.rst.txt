.. include:: /Includes.rst.txt
.. index:: Events; SiteConfigurationBeforeWriteEvent
.. _SiteConfigurationBeforeWriteEvent:

==================================
SiteConfigurationBeforeWriteEvent
==================================

.. versionadded:: 12.0
   The events SiteConfigurationLoadedEvent and SiteConfigurationBeforeWriteEvent
   have been introduced.

This event allows modification of the site configuration array before
before writing the configuration to disk.

.. note::
   If you need to change the configuration when it is loaded, use
   :ref:`SiteConfigurationLoadedEvent`.

Example
=======

To register an event listener to the new events, use the following code in your
:file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

    services:
      MyVendor\MyExtension\EventListener\SiteConfigurationBeforeWriteListener:
        tags:
          - name: event.listener
            identifier: 'myWriteListener'


API
===

.. include:: /CodeSnippets/Events/Core/SiteConfigurationBeforeWriteEvent.rst.txt
