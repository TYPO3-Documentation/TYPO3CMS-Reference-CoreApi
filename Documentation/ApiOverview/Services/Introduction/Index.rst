.. include:: /Includes.rst.txt
.. index:: ! Services API
.. _services-introduction:

============
Introduction
============

This document describes the services functionality included in the
TYPO3 Core.

.. note::

   The Services API is one of the older core APIs that did not find
   much traction over the years. The core itself only uses it for frontend
   and backend user :ref:`authentication <authentication>`.

   Additionally, only a couple of extensions use the Services API, and not
   much happened to the underlying codebase lately. Extension authors may
   want to ignore this API for new stuff and implement own factory or service
   related patterns that may fit needs better.

.. attention::

   This chapter is about the Services API provided by the core. Don't confuse
   it with casual PHP classes within the directory :file:`Classes/Service` found in many
   extensions - they usually do not use the API mentioned here.

   Authentication service classes in the Core extend
   :php:`TYPO3\CMS\Core\Service\AbstractAuthenticationService`.

   In comparison, for additional information on what the Core usually understands
   as "casual" service class, see the :ref:`coding guidelines. <cgl-services>`


The whole Services API works as a registry. Services are registered
with a number of parameters, and each service can easily be overridden
by another one with improved features or more specific capabilities,
for example. This can be achieved without having to change the original
code of TYPO3 CMS or of an extension.

Services are PHP classes packaged inside an extension.
The usual way to instantiate a class in TYPO3 CMS is:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

   $object = GeneralUtility::makeInstance(ContentObjectRenderer::class);


Getting a service instance is achieved using a different API. The
PHP class is not directly referenced. Instead a service is identified
by its type, sub type and exclude service keys:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   // use TYPO3\CMS\Core\Utility\GeneralUtility;

   $serviceObject = GeneralUtility::makeInstanceService(
      'my_service_type',
      'my_service_subtype',
      ['not_used_service_type1', 'not_used_service_type2']
   );


parameters for makeInstanceService:

*  string $serviceType:
   Type of service (service key)

*  string $serviceSubType (default ''):
   Sub type like file extensions or similar. Defined by the service.

*  array $excludeServiceKeys (default []):
   List of service keys which should be excluded in the search for a service. Array.

The same service can be provided by different extensions.
The service with the highest priority and quality (more on that later)
is chosen automatically for you.


.. _services-introduction-good-reasons:
.. _services-introduction-good-reasons-implementation:
.. _services-introduction-good-reasons-extensibility:

Reasons for using the Services API
==================================

The :php:`AbstractService` has been removed and it is planned to also
deprecate the other methods of the Service API in the future. The Service API
should only be used for frontend and backend user :ref:`authentication
<authentication>`.
