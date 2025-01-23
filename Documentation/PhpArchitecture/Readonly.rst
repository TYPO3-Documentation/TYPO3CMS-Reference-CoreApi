..  include:: /Includes.rst.txt
..  index:: pair: Coding guidelines; About readonly
..  _php-architecture-readonly:

=====================
About :php:`readonly`
=====================

PHP v8.1 introduced
`readonly properties <https://www.php.net/manual/en/language.oop5.properties.php#language.oop5.properties.readonly-properties>`_
while PHP v8.2 added
`readonly classes <https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.readonly>`_.
:php:`readonly` properties can only be written once - usually in the constructor.

Declaring :ref:`services <cgl-services>` and
:ref:`value objects <cgl-named-arguments-pcpp-value-objects>` as readonly is
beneficial for TYPO3 Core and extensions, offering immutability and clarity
regarding the statelessness of services.

This document discusses the use of readonly within the TYPO3 Core ecosystem,
outlining best practices for TYPO3 extension and Core developers regarding the
adoption and avoidance of this language feature.

..  _php-architecture-readonly-services:

Readonly services
=================

Readonly properties align seamlessly with services using
:ref:`constructor injection <Constructor-injection>`, e.g.:

..  code-block:: php

    final class UserController
    {
        private string $someProperty = 'foo';

        public function __construct(
            private readonly SomeDependency $someDependency,
        ) {}

        // ...
    }

Well designed stateless services with no properties apart from those declared using
`constructor property promotion <https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion>`_
can be declared :php:`readonly` on class level:

..  code-block:: php

    final readonly class UserController
    {
        public function __construct(
            private SomeDependency $someDependency,
        ) {}

        // ...
    }

Declaring properties or - even better - entire service classes readonly is a great
way to clarify possible impact of state within services: If used correctly, readonly
tells developers this service is stateless, shared, and can be used in any
context and as often as needed without side effects from previous usages, and without
influencing possible further usages within the same request. Statelessness
is an important asset of services and readonly helps to sort out this question.

Even when a service class is declared as readonly, ensuring immutability at its level,
it can still become stateful if any of its injected dependencies are stateful. This
undermines the benefits of readonly design, as statefulness in dependencies can
introduce unintended side effects and compromise the stateless nature of the service.
TYPO3 Core strives to avoid such scenarios, particularly for services that are widely
used by extensions. This ensures predictable behavior, minimizes side effects, and
maintains consistency in the broader ecosystem. Developers should carefully analyze
dependencies for statefulness when designing readonly services.

The TYPO3 Core development adopted the readonly feature early, recognizing its
advantages for improving immutability, reducing side effects, and clarifying
service design. However, its use requires careful consideration. The Core merger
team established guidelines to determine when readonly can and should be added,
which also serve as best practices for extension developers:

*   **General Recommendation:** Declaring services or their properties as readonly
    is highly encouraged. Once added, the readonly declaration is rarely removed since
    it aligns with the effort to make services stateless.

*   **Leaf Classes:** Existing services that are "leaf" classes (i.e., not intended
    to be extended by other classes) can have readonly applied to single properties
    or the entire class. This is typically not considered a breaking change, even in
    stable code branches, as it only affects XCLASS extensions, which are not covered
    by TYPO3's backward compatibility promise.

*   **Method Injection:** Services retrieved via :ref:`inject*() methods <method-injection>`
    are not currently declared readonly, as tools like PHPStan expect readonly properties
    to be initialized in the constructor only. This might change in the future, but it is
    not a high priority.

*   **Abstract Classes:** Existing abstract classes that are intended for extension by
    developers should not be declared readonly. Declaring an abstract class readonly
    would force all inheriting classes to also be readonly, which can create compatibility
    issues for extensions that need to support multiple TYPO3 versions. For example,
    Extbase's abstract ActionController will not be declared readonly.

..  _php-architecture-value-objects:

Readonly value objects
======================

Readonly value objects are immutable by design. They align seamlessly with
public constructor property promotion for simplicity:

..  code-block:: php
    :caption: Read only value object using public constructor property promotion

    final readonly class Label
    {
        public function __construct(
            public string $label,
            public string $color = '#ff8700',
            public int $priority = 0,
        ) {}
    }

Immutable objects improve reliability and reduce side effects. TYPO3 Core gradually
adopts immutability for newly created constructs and selectively for existing data
objects. Such :php:`final readonly` data objects must be instantiated using
:ref:`new() <dependency-injection-new>` and :ref:`named arguments <cgl-named-arguments-pcpp-value-objects>`.

..  _php-architecture-summary:

Summary
=======

Readonly properties and classes provide a robust framework for stateless, immutable design
in TYPO3 services and simplifies value objects. While Core development continues adopting
these features, extension developers are encouraged to follow these best practices to
enhance code clarity and maintainability.
