.. include:: /Includes.rst.txt
.. index:: Events; SiteConfigurationLoadedEvent
.. _SiteConfigurationLoadedEvent:

=============================
SiteConfigurationLoadedEvent
=============================

.. versionadded:: 12.0
   The events SiteConfigurationLoadedEvent and SiteConfigurationBeforeWriteEvent
   have been introduced.

This event allows modification of the site configuration array before
loading the configuration.

.. note::
   If you need to change the configuration before it is saved to disk, use
   :ref:`SiteConfigurationBeforeWriteEvent`.

Example
=======

To register an event listener to the new events, use the following code in your
:file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

    services:
      MyVendor\MyExtension\EventListener\SiteConfigurationLoadedListener:
        tags:
          - name: event.listener
            identifier: 'myLoadedListener'

API
===

.. include:: /CodeSnippets/Events/Core/SiteConfigurationLoadedEvent.rst.txt
