..  include:: /Includes.rst.txt
..  index:: pair: Coding guidelines; Services
..  _cgl-services:

========
Services
========


Characteristics
===============

*   Services MUST be used as objects, they are never static.
*   Services SHOULD be stateless and shared.
*   Services MAY use their own configuration, but they SHOULD not.
*   Services MAY have dependencies to other services and SHOULD get them
    injected using TYPO3 Core dependency injection.


Rationale
=========

Modern PHP programming primarily involves two types of classes: Services and
data objects (DO).

This distinction has gained significance with the introduction of
:ref:`dependency injection <Dependency-Injection>` in the TYPO3 core.

A well-designed service class comprise of one or more methods that process
data, or just provide a data sink. For example, a
mailer service might take a mail data object to send it. Conversely, service
methods often return new or modified data based on input. A typical example is a
repository service that accepts an identifier (e.g. the uid of a product) and returns
a data object (the product).

Services may depend on other services and should use dependency injection to obtain
these dependencies, typically via :ref:`constructor injection <Constructor-injection>`.

In TYPO3, most classes are service classes unless they function as data objects to
transport data.

Services should be stateless. The result of a service method call should only depend
on the given input arguments and the service should not keep track of previous calls
made. This is an important aspect of well crafted services. It reduces complexity
significantly when a service does not hold data itself: It does not matter
how often or in which context that service may have been called before. It also means
that stateless services can be "shared" and declared :php:`readonly`: They are instantiated
only once and the same instance is injected to all dependent services.

TYPO3 core has historically stateful services that blend service class and data object
characteristics. These stateful services pose issues in a service-oriented architecture:
Injecting a stateful service into a stateless service make the latter stateful, potentially
causing unpredictable behavior based on the prior state of the injected service. A clear
example is the core :php:`DataHandler` class which modifies numerous data properties when
its primary API methods are called. Such instances become "tainted" after use, and should
not be injected but created on-demand using :php:`GeneralUtility::makeInstance()`.

Good Examples
=============

*   :php:`\TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools` has been refactored in
    TYPO3 v13 to be stateless:

    *   A shared and readonly service with a few dependencies
    *   A clear scope with reasonable API methods
    *   No data properties


Bad Examples
============

*   :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`

    *   Far too complex
    *   Heavily stateful


Further Reading
===============

*   http://gorodinski.com/blog/2012/04/14/services-in-domain-driven-design-ddd/
*   https://igor.io/2013/03/31/stateless-services.html
