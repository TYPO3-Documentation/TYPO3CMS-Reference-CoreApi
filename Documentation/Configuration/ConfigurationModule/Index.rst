..  include:: /Includes.rst.txt
..  index::
    pair: Configuration; Module
    TYPO3_CONF_VARS; Validation
    TCA; Validation
..  _config-module:

====================
Configuration module
====================

..  note::
    The configuration module is only available, if the system extension `lowlevel`
    is installed.

The configuration module can be found at :guilabel:`System > Configuration`.
It allows integrators to view and validate the global configuration of TYPO3.
The module displays all relevant global variables such as
:ref:`TYPO3_CONF_VARS <typo3ConfVars>`, :doc:`TCA <t3tca:Index>` and many more,
in a tree format which is easy to browse through. Over time this module got
extended to also display the configuration of newly introduced features like the
:ref:`middleware stack <request-handling>` or
:ref:`event listeners <EventDispatcherListeners>`.

..  contents:: Table of Contents
    :local:


..  index::
    Configuration; Module extension
    Configuration; Module provider

Extending the configuration module
==================================

To make this module more powerful a dedicated API is available which
allows extension authors to extend the module so they can expose their own
configurations.

By the nature of the API it is even possible to not just add new
configuration but to also disable the display of existing configuration,
if not needed in the specific installation.

Basic implementation
--------------------

To extend the configuration module, a custom configuration provider needs to
be registered. Each "provider" is responsible for one configuration. The provider
is registered as a so-called "configuration module provider" by tagging it in the
:file:`Services.yaml` file. The provider class must implement
the :t3src:`lowlevel/Classes/ConfigurationModuleProvider/ProviderInterface.php`.

The registration of such a provider looks like the following:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    myextension.configuration.module.provider.myconfiguration:
        class: 'Vendor\Extension\ConfigurationModuleProvider\MyProvider'
        tags:
            - name: 'lowlevel.configuration.module.provider'
              identifier: 'myProvider'
              before: 'beUserTsConfig'
              after: 'pagesTypes'

A new service with a freely selectable name is defined by specifying the
provider class to be used. Further, the new service must be tagged with the
`lowlevel.configuration.module.provider` tag. Arbitrary attributes
can be added to this tag. However, some are reserved and required for internal
processing. For example, the `identifier` attribute is mandatory and must be
unique. Using the `before` and `after` attributes, it is possible to specify
the exact position on which the configuration will be displayed in the module
menu.

The provider class has to implement the methods as required by the interface.
A full implementation would look like this:

..  literalinclude:: _MyProvider.php
    :caption: EXT:my_extension/Classes/ConfigurationModule/MyProvider.php

The :php:`__invoke()` method is called from the provider registry and provides
all attributes, defined in the :file:`Services.yaml`. This can be used to set
and initialize class properties like the :php`$identifier` which can then be returned
by the required method :php:`getIdentifier()`. The :php:`getLabel()` method is
called by the configuration module when creating the module menu. And finally,
the :php:`getConfiguration()` method has to return the configuration as an
:php:`array` to be displayed in the module.

There is also the abstract class
:t3src:`lowlevel/Classes/ConfigurationModuleProvider/AbstractProvider.php` in place
which already implements the required methods; except :php:`getConfiguration()`.
Please note, when extending this class, the attribute `label` is expected in the
`__invoke()` method and must therefore be defined in the :file:`Services.yaml`.
Either a static text or a :ref:`localized label <localization>` can be used.

Since the registration uses the Symfony service container and provides all
attributes using :php:`__invoke()`, it is even possible to use
:ref:`dependency injection <DependencyInjection>` with constructor arguments in
the provider classes.


.. index::
   $GLOBALS; Display
   GlobalVariableProvider

Displaying values from `$GLOBALS`
---------------------------------

If you want to display a custom configuration from the :php:`$GLOBALS` array,
you can also use the already existing
:php:`TYPO3\CMS\Lowlevel\ConfigurationModuleProvider\GlobalVariableProvider`.
Define the key to be exposed using the `globalVariableKey` attribute.

This could look like this:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    myextension.configuration.module.provider.myconfiguration:
        class: 'TYPO3\CMS\Lowlevel\ConfigurationModuleProvider\GlobalVariableProvider'
        tags:
            - name: 'lowlevel.configuration.module.provider'
              identifier: 'myConfiguration'
              label: 'My global var'
              globalVariableKey: 'MY_GLOBAL_VAR'

Disabling an entry
------------------

To disable an already registered configuration add the :yaml:`disabled` attribute
set to :yaml:`true`. For example, if you intend to disable the `TBE_STYLES` key
you can use:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    lowlevel.configuration.module.provider.tbestyles:
        class: TYPO3\CMS\Lowlevel\ConfigurationModuleProvider\GlobalVariableProvider
        tags:
            - name: 'lowlevel.configuration.module.provider'
              disabled: true


..  _config-module-blind-options:

Blinding configuration options
==============================

..  versionchanged:: 12.2

Sensitive data (like passwords or access tokens) should not be displayed in the
configuration module. Therefore, the PSR-14 event
:ref:`ModifyBlindedConfigurationOptionsEvent` is available to blind such
configuration options.

For compatibility with TYPO3 v11 and v12 you can use the deprecated hook
:ref:`modifyBlindedConfigurationOptions <t3coreapi11:config-module-blind-options>`
which will be removed with TYPO3 v13.
