..  include:: /Includes.rst.txt
..  index:: Events; ModifyBlindedConfigurationOptionsEvent
..  _ModifyBlindedConfigurationOptionsEvent:

======================================
ModifyBlindedConfigurationOptionsEvent
======================================

..  versionadded:: 12.2
    The event serves as a direct replacement for the deprecated hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Lowlevel\Controller\ConfigurationController']['modifyBlindedConfigurationOptions']`.

The PSR-14 event :php:`\TYPO3\CMS\Lowlevel\Event\ModifyBlindedConfigurationOptionsEvent`
is fired in the :php:`\TYPO3\CMS\Lowlevel\ConfigurationModuleProvider\GlobalVariableProvider`
and the :php:`\TYPO3\CMS\Lowlevel\ConfigurationModuleProvider\SitesYamlConfigurationProvider`
while building the configuration array to be displayed in the
:guilabel:`System > Configuration` module. It allows to blind (hide) any
configuration options. Usually such options are passwords or other sensitive
information.

Using the :php:`getProviderIdentifier()` method of the event, listeners are able
to determine the context the event got dispatched in. This is useful to prevent
duplicate code execution, since the event is dispatched for multiple providers.
The method returns the identifier of the configuration provider as registered
in the :ref:`configuration module <config-module>`.


Example
=======

..  literalinclude:: _ModifyBlindedConfigurationOptionsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Lowlevel/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Lowlevel/ModifyBlindedConfigurationOptionsEvent.rst.txt
