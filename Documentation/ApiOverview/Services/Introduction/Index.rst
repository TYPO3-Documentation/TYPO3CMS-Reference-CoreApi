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
    much attraction over the years. The core itself only uses it for frontend
    and backend user :ref:`authentication <authentication>`.

    Additionally, only a couple of extensions use the Services API, and not
    much happened to the underlying codebase lately. Extension authors may
    want to ignore this API for new stuff and implement own factory or service
    related patterns that may fit needs better.

.. important::

    This chapter is about the Services API provided by the core. Don't confuse
    it with casual PHP classes within the directory :file:`Classes/Service` found in many
    extensions - they usually do not use the API mentioned here.

    Classes in the scope of this chapter - directly or indirectly - are extending the
    service class :php:`TYPO3\CMS\Core\Service\AbstractService` or
    the authentication service base class :php:`TYPO3\CMS\Core\Service\AbstractAuthenticationService`.

    In comparison, for additional information on what the Core usually understands
    as "casual" service class, see the :ref:`coding guidelines. <cgl-services>`


The whole Services API works as a registry. Services are registered
with a number of parameters, and each service can easily be overridden
by another one with improved features or more specific capabilities,
for example. This can be achieved without having to change the original
code of TYPO3 CMS or of an extension.

Services are simply PHP classes packaged inside an extension.
The usual way to instantiate a class in TYPO3 CMS is::

   $object = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);


Getting a service instance is achieved using a different API. The
PHP class is not directly referenced. Instead a service is identified
by its type, sub type and exclude service keys::

   use TYPO3\CMS\Core\Utility\GeneralUtility;

   $serviceObject = GeneralUtility::makeInstanceService(
      'my_service_type',
      'my_service_subtype',
      ['not_used_service_type1', 'not_used_service_type2']
   );


parameters for makeInstanceService:
* string $serviceType: 
   Type of service (service key)
* string $serviceSubType (default ''):
   Sub type like file extensions or similar. Defined by the service.
* array $excludeServiceKeys (default []):
   List of service keys which should be excluded in the search for a service. Array.

The same service can be provided by different extensions.
The service with the highest priority and quality (more on that later)
is chosen automatically for you.


.. _services-introduction-good-reasons:

Two reasons for using the Services API
======================================


.. _services-introduction-good-reasons-implementation:

1. Freedom of implementation
----------------------------

A service may be implemented multiple times to take into account
different environments like operating systems (Unix, Linux, Windows, Mac),
available PHP extensions or other third-party dependencies (other
programming languages, binaries, etc.).

Imagine an extension which could rely on a Perl script for very good
results. Another implementation could exist, that relies only on PHP,
but gives results of lesser quality. With a service you could switch
automatically between the two implementations just by testing the
availability or not of Perl on the server.


.. _services-introduction-good-reasons-extensibility:

2. Extend functionality with extensions
---------------------------------------

Services are able to handle sub types. Consider the services of type
"auth" which perform both the frontend and backend authentication. They provide
a total of six sub types, each of which can be overridden independently
by extensions. Then a chain of services may exist, out of which the appropriate "auth" service identified
by the subtype will be taken.

The base authentification service class
(:php:`\TYPO3\CMS\Core\Authentication\AuthenticationService`), which extends 
(:php:`\TYPO3\CMS\Core\Authentication\AbstractAuthenticationService`) and is
provided by extension "core", is extended by the "rsaauth" extension
for the subtypes "processLoginDataBE" and "processLoginDataFE".
This base service class is also used in the install tool backend module controller for the subtype "authUserBE".
It is used for any kind of authentication or authorization towards backend and frontend users.

These overrides do not change the public API of the "auth" service type,
meaning that developers can rely on it without worrying about what other extensions
might be doing.

The abstract service class :php:`TYPO3\CMS\Core\Service\AbstractService` is used for any kind of Service API, which
also includes manipulating files and execution of external applications, which is there for legacy reasons since TYPO3 3.x, where the Service API was added. This class is not used any more in the TYPO3 core.
