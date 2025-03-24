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

The example adds a
:ref:`route enhancer configuration <routing-advanced-routing-configuration-enhancers>`
provided by an extension with an event listener automatically. This way, there
is no need to :ref:`add an import manually <routing-examples-imports>` to the
site configuration.

..  literalinclude:: _SiteConfigurationLoadedEvent/_ImportRoutesIntoSiteConfiguration.php
    :language: php
    :caption: EXT:my_extension/Classes/Configuration/EventListener/ImportRoutesIntoSiteConfiguration.php

For more sophisticated examples, see also
`Automatically register route enhancer definitions stored in TYPO3 extensions <https://brotkrueml.dev/register-route-enhancer-definitions-extensions-automatically-typo3/>`__.


..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/SiteConfigurationLoadedEvent.rst.txt
