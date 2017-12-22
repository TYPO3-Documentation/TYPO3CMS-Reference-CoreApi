.. include:: ../../../Includes.txt


.. _services-configuration-service-type-configuration:

Service type configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^

It may also be necessary to provide configuration options for the code
that uses the services (and not for usage inside the services
themselves). It is recommended to make use of the following syntax:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SVCONF'][service type]['setup'][config key] = value;

Example:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = true;

This configuration can be placed in a local configuration file
(:file:`ext_localconf.php` ). There's no API for retrieving these
values. It's just a best practice recommendation.

