

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Introduction
------------

This document describes the services functionality included in the
TYPO3 core since version 3.6.0.

Services are designed to be overridden so that you can extend, improve
or – in general – modify the behavior of the TYPO3 or any extension
that uses services without having to change the original code of TYPO3
or of the extension.

Services are PHP classes inside of an extension similar to FE-plugins
(or inside the core of TYPO3, for some base services). Usually when
you use a class, you address it directly by creating an instance:

::

   require_once(t3lib_extMgm::extPath('some_extension').'class.tx_some_extension_class.php');
   $obj = t3lib_div::makeInstance('tx_some_extension_class');

Using a service class is done by calling a function which chooses the
right service automatically by passing only the requested service type
name and not the class name:

::

   $serviceObj = t3lib_div::makeInstanceService('my_service_type');

The difference is that the class name itself and its usage is not
hardcoded. The same service can be provided by different extensions.
The service with the highest priority and quality is chosen
automatically.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   TwoReasonsToUseServices/Index

