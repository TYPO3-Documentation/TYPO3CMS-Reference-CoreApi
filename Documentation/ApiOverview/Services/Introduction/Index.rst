.. include:: /Includes.rst.txt
.. index:: ! Services API
.. _services-introduction:

============
Introduction
============

This document describes the services functionality included in the
TYPO3 CMS core.

.. note::

    The "Services" API is one of the older core API's that did not find
    much traction over the years. The core itself only uses it for frontend
    and backend user :ref:`authentication. <authentication>`

    Additionally, only a couple of extensions use the Services API, and not
    much happened to the underlying codebase lately. Extension authors may
    want to ignore this API for new stuff and implement own factory or service
    related patterns that may better fit needs.

.. important::

    This chapter is about the "Services API" provided by the core. Don't confuse
    it with casual PHP classes within the directory :file:`Classes/Service` found in many
    extensions - they usually do not use the API mentioned here.

    Classes in the scope of this chapter - directly or indirectly - extend the
    service class :php:`TYPO3\CMS\Core\Service\AbstractService`.

    In comparison, for additional information on what the core usually understands
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
by its type::

   $serviceObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('my_service_type');


The same service can be provided by different extensions.
The service with the highest priority and quality (more on that later)
is chosen automatically for you.


.. _services-introduction-good-reasons:

Two reasons to use the  Services API
====================================


.. _services-introduction-good-reasons-implementation:

1. Freedom of implementation
============================

A service may be implemented multiple times to take into account
different environments like operating systems (Unix, Windows, Mac),
available PHP extensions or other third-party dependencies (other
programming languages, binaries, etc.).

Imagine an extension which could rely on a Perl script for very good
results. Another implementation could exist, that relies only on PHP,
but gives results of lesser quality. With a service you could switch
automatically between the two implementations just by testing the
availability or not of Perl on the server.


.. _services-introduction-good-reasons-extensibility:

2. Extend functionality with extensions
=======================================

Services are able to handle subtypes. Consider the services of type
"auth" which perform both the frontend and backend authentication. They provide
a total of six subtypes, each of which can be overridden independently
by extensions.

The base service class
(:php:`\TYPO3\CMS\Core\Authentication\AuthenticationService`) provided
by extension "core" is extended by both "saltedpasswords" and "rsaauth" extensions
but for different subtypes ("authUserFE" and "authUserBE" for the former,
"processLoginDataBE" and "processLoginDataFE" for the latter).

These overrides do not change the public API of the "auth" service type,
meaning that developers can rely on it without worrying about what other extensions
might be doing.
