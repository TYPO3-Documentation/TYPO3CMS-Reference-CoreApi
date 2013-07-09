.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Registration changes
^^^^^^^^^^^^^^^^^^^^

The priority and other values of the services registration can be
overridden in :code:`typo3conf/localconf.php` . Example::

       // raise priority of service 'tx_example_sv1' to 110
   $TYPO3_CONF_VARS['T3_SERVICES']['auth']['tx_example_sv1']['priority'] = 110;

       // disable service 'tx_example_sv1'
   $TYPO3_CONF_VARS['T3_SERVICES']['auth']['tx_example_sv1']['enable'] = false;

The syntax is::

   $TYPO3_CONF_VARS['T3_SERVICES'][service type][service key][option key] = value;

Registration options are described in more details in "Implementing a
service" below. Any of these options may be overridden using the above
syntax. However caution should be used depending on the options.
"className" should not be overridden in such a way.
Instead a new service should be implemented using this alternate
class.
