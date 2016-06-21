.. include:: ../../Includes.txt


Service configuration
^^^^^^^^^^^^^^^^^^^^^

Some services will not need additional configuration. Others may have
some options that can be set in the Extension Manager. Yet others may
be configured via local configuration files (either
:code:`typo3conf/localconf.php` or some extension's
:code:`ext\_localconf.php` ). Example::

   $TYPO3_CONF_VARS['SVCONF']['auth']['tx_example_sv1']['foo'] = 'bar';

The syntax is::

   $TYPO3_CONF_VARS['SVCONF'][service type][service key][config key] = value;

A configuration can also be set for all services belonging to the same
service type by using the keyword "default" instead of a service key::

   $TYPO3_CONF_VARS['SVCONF'][service type]['default'][config key] = value;

The available configuration settings should be described in the
service's documentation. See "Service API" below to see how you can
read these values properly inside your service.

