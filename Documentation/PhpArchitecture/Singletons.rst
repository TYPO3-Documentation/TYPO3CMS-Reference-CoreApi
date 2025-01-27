.. include:: /Includes.rst.txt

.. _cgl-singletons:

==========
Singletons
==========

This chapter is largely obsolete in modern TYPO3 programming where
:ref:`services <cgl-services>` are used correctly: Stateless services
should be "shared", meaning the service container creates a single instance and
injects that instance into all other services that require it. These services
are referred to as "singletons".

TYPO3 has an old way of designating a class as a singleton: Classes that
implement :php-short:`\TYPO3\CMS\Core\SingletonInterface`. This approach
dates back to a time before TYPO3 offered a comprehensive
:ref:`dependency injection <Dependency-Injection>` solution. The interface
is still considered when injecting such a service and when creating an instance
via :php:`GeneralUtility::makeInstance()`.

Example:

..  code-block:: php
    :caption: EXT:some_extension/Classes/MySingletonService.php

    namespace Vendor\SomeExtension;

    class MySingletonClass implements \TYPO3\CMS\Core\SingletonInterface
    {
        // …
    }

:php:`SingletonInterface` has no methods to implement. Services implementing the
interface are automatically declared :ref:`public <What-to-make-public>`.

Due to the overlap with "shared services", TYPO3 core development is gradually reducing
the number of classes that implement :php:`SingletonInterface`. This process often
involves transforming service classes into stateless services, using dependency injection
in service consumers, and updating tests to avoid reliance on the test-related method
:php:`GeneralUtility::addSingletonInstance()`. It is a gradual transition that requires
time.

Extension developers should also refrain from using :php:`SingletonInterface`: New code
should not depend on it, and existing code be refactored to eliminate its usage over
time.
