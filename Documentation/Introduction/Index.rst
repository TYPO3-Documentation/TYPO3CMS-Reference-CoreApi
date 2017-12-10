.. include:: ../Includes.txt


.. _introduction:

Introduction
------------

This document describes the services functionality included in the
TYPO3 CMS core.

The whole services API works as a registry. Services are registered
with a number of parameters, and each service can easily be overridden
by another one with improved features or more specific capabilities,
for example. This can be achieved without having to change the original
code of TYPO3 CMS or of an extension.

Services are simply PHP classes packaged inside an extension.
The usual way to instatiate a class in TYPO3 CMS is:

.. code-block:: php

   $object = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);


Getting a service instance is achieved using a different API. The
PHP class is not directly referenced. Instead a service is identified
by its type:

.. code-block:: php

   $serviceObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('my_service_type');


The same service can be provided by different extensions.
The service with the highest priority and quality (more on that later)
is chosen automatically for you.


.. _introduction-good-reasons:

Two reasons to use services
^^^^^^^^^^^^^^^^^^^^^^^^^^^


.. _introduction-good-reasons-implementation:

1. Freedom of implementation
""""""""""""""""""""""""""""

A service may be implemented multiple times to take into account
different environments like operating systems (Unix, Windows, Mac),
available PHP extensions or other third-party dependencies (other
programming languages, binaries, etc.).

Imagine an extension which could rely on a Perl script for very good
results. Another implementation could exist, that relies only on PHP,
but gives results of lesser quality. With a service you could switch
automatically between the two implementations just by testing the
availability or not of Perl on the server.


.. _introduction-good-reasons-extensibility:

2. Extend functionality with extensions
"""""""""""""""""""""""""""""""""""""""

Services are able to handle subtypes. Consider the services of type
"auth" which perform both the frontend and backend authentication. They provide
a total of six subtypes, each of which can be overridden independently
by extensions.

The base service class (:code:`\TYPO3\CMS\Core\Authentication\AuthenticationService`) provided
by extension "sv" is extended by both "saltedpasswords" and "rsaauth" extensions
but for different subtypes ("authUserFE" and "authUserBE" for the former,
"processLoginDataBE" and "processLoginDataFE" for the latter).

These overrides do not change the public API of the "auth" service type,
meaning that developers can rely on it without worrying about what other extensions
might be doing.
