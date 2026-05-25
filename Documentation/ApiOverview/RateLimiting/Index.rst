.. include:: /Includes.rst.txt
.. index:: Rate limiting
.. _rate-limiting:

=============
Rate limiting
=============

..  versionadded:: 14.2
    Previously, the backend and frontend password recovery features, as well as
    the Extbase rate limiting, each created Symfony rate limiter factories
    directly, bypassing TYPO3's factory. All consumers now use the central TYPO3
    factory, which enables a unified admin override mechanism.

The :php:`\TYPO3\CMS\Core\RateLimiter\RateLimiterFactory` is available
to serve as the single entry point for all rate limiting across the system.
A new :php:`\TYPO3\CMS\Core\RateLimiter\RateLimiterFactoryInterface` extends
Symfony's :php:`\Symfony\Component\RateLimiter\RateLimiterFactoryInterface` with
additional convenience methods for request-based and login rate limiting.

Extension developers should type-hint against
:php-short:`\TYPO3\CMS\Core\RateLimiter\RateLimiterFactoryInterface` when
injecting the factory.

..  contents:: Table of Contents
    :depth: 1
    :local:


.. _rate-limiting-typo3-conf-vars:

Overriding the `rateLimiter` via the TYPO3_CONF_VARS
=============================

..  seealso::
    :confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['rateLimiter'] <globals-typo3-conf-vars-sys-rateLimiter>`


.. _rate-limiting-extbase-action:

Example limiter ID for Extbase action
=====================================

The limiter ID for an Extbase action which uses the
:php:`#[\TYPO3\CMS\Extbase\Attribute\RateLimit]` attribute is constructed using
the "slugified" class name and the action method name.

..  literalinclude:: _ExtbaseController.php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

The limiter ID for the action is:
`extbase-myvendor-myextension-controller-mycontroller-dosomethingaction`


.. _rate-limiting-general-purpose:

General-purpose rate limiting
=============================

Extension developers can use the
:php-short:`\TYPO3\CMS\Core\RateLimiter\RateLimiterFactory` for custom rate
limiting needs.

The :php:`createRequestBasedLimiter()` method is the recommended entry point for
request-scoped rate limiting. It automatically extracts the client's remote IP
address from the :ref:`PSR-7 request <typo3-request>` and uses it as the limiter
key:

..  literalinclude:: _MyService.php
    :caption: EXT:my_extension/Classes/RateLimiting/MyService.php

For cases where a custom key is needed (for example, a user ID instead of the
IP address), the :php:`createLimiter()` method accepts an explicit configuration
array and key:

..  code-block:: php

    $limiter = $this->rateLimiterFactory->createLimiter(
        [
            'id' => 'my-extension-action',
            'policy' => 'sliding_window',
            'limit' => 10,
            'interval' => '1 hour',
        ],
        $userId
    );

Pre-configured named services can also be defined in :file:`Services.yaml`,
which are then injectable with the :php:`create()` method from the
:php-short:`\TYPO3\CMS\Core\RateLimiter\RateLimiterFactoryInterface`:

..  literalinclude:: _Services.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions
<dependency-injection-in-extensions>`.
