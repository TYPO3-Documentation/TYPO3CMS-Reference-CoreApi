.. include:: /Includes.rst.txt
.. index::
   Services API; Override service registration
   TYPO3_CONF_VARS; T3_SERVICES
.. _services-configuration-registration-changes:

=============================
Override service registration
=============================

The priority and other values of the original service registration can be
overridden in any extension's :file:`ext_localconf.php` file. Example:


..  literalinclude:: _RegistrationChanges/_ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

The general syntax is:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['T3_SERVICES'][service type][service key][option key] = value;

Registration options are described in more details in
:ref:`Implementing a service <services-developer-implementing>`.
Any of these options may be overridden using the above
syntax. However caution should be used depending on the options.
:code:`className` should not be overridden in such a way.
Instead a new service should be implemented using an alternate
class.
