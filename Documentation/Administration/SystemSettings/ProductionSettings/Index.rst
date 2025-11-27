.. include:: /Includes.rst.txt

.. index:: Production Settings; Environment

.. _production-settings:

===================
Production Settings
===================

To ensure a secure installation of TYPO3 on a production server, the following settings need to be set:

- :guilabel:`System > Settings > Configuration Presets` The "Live" preset has to be chosen to make sure no debug output is displayed.
  When using environment specific configurations, the recommended way is to specifically set the values for
  error/debugging configuration values instead of presets, like:

  ..  code-block:: php
      :caption: config/system/additional.php | typo3conf/system/additional.php

      $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = '0';
      $GLOBALS['TYPO3_CONF_VARS']['SYS']['sqlDebug'] = '0';
      $GLOBALS['TYPO3_CONF_VARS']['FE']['debug'] = '0';
      $GLOBALS['TYPO3_CONF_VARS']['BE']['debug'] = '0';

  These can be set for example through the :ref:`environment-configuration`.
- `HTTPS` should be used on production servers and :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSL']` should be set to `true`.
- Enforce HSTS (Strict-Transport-Security header) in the web servers configuration.
- The `TYPO3_CONTEXT` environment variable should be set to a main context of `Production` (can be verified on the top right in the TYPO3 backend :guilabel:`Application Information`). It should be used to select the appropriate `base variant` for the target system in the Site Configuration.
- Configure the :ref:`TYPO3 logging framework <t3coreapi:logging-configuration>` to log messages of high severity including and above WARNING or ERROR
  and continue to rotate log files stored in :file:`var/log`.
- Verify the :ref:`file permissions <t3coreapi:security-file-directory-permissions>` are correct on the live system.
