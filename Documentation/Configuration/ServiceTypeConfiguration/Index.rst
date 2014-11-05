.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Service type configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^

It may also be necessary to provide configuration options for the code
that uses the services (and not for usage inside the services
themselves). It is recommended to make use of the following syntax::

   $GLOBALS['TYPO3_CONF_VARS']['SVCONF'][service type]['setup'][config key] = value;

Example::

   $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = true;

This configuration can be placed in any configuration file (either
:file:`typo3conf/localconf.php` or some extension's
:file:`ext_localconf.php` ). There's no API for retrieving these
values. It's just a best practice recommendation.

