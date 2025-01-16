..  include:: /Includes.rst.txt
..  index:: Coding guidelines; Static methods
..  _cgl-model-static-methods:
..  _cgl-static-methods:

===============================================
Static Methods, static Classes, Utility Classes
===============================================


Characteristica
===============

*   A utility class MUST contain only static methods.

*   Utility classes MUST NOT have state, no local properties, no DB
    access, … .

*   Utility methods MAY call other utility methods.

*   Utility class methods MUST NOT have dependencies to non static
    methods like other class instances or global variables.

*   Utility class methods MUST have high unit test coverage.

*   Utility class scope MUST be small and domain logic MUST NOT be
    encapsulated in static methods.

*   Utility classes MUST be located in a utility sub folder and MUST end
    with :php:`Utility`, eg. :php:`FoobarUtility`.

*   Static methods MUST be located in utility classes and SHOULD NOT be
    added to other classes, except a specific pattern has a hard
    requirement to a static helper method within its class. All classes
    outside a utility folder MUST be instantiated and handled as object
    instances.

*   Static methods MUST call other static methods of the same class
    using the PHP :php:`self` keyword instead of the class name.


Rationale
=========

Static methods as cross-cutting concern solution have been in the Core
ever since. They are an easy way to extract recurring coding problems
to helper methods.

Static methods however have a list of issues that need to be taken
into consideration before deciding to use them. First, they can not be
extended in a sane way and the Core framework has no way to re-route a
static method call to a different implementation. They are a hard coded
dependency in a system. They can not be easily “mocked away” in unit
tests if a class uses a static method from a different class. They
especially raise issues if a static method keeps state in static
properties, this is similar to a de-facto singleton and it is hard to
reset or manipulate this state later. Static properties can easily
result in side effects to different using systems. Additionally, static
methods tend to become too complex, doing too much at a time and
becoming god methods in long run. Big and complex utility methods doing
too much at a time is a strong sign something else was not modeled
properly at a different place.

The Core has a long history of static utility class misuse and is in an
ongoing effort to model stuff correctly and getting rid of static
utility god classes that happily mix different concerns. Solving some
of these utility methods to proper class structures typically improves
code separation significantly and renders Core parts more flexible and
less error prone.

With this history in mind, Core development is rather sensible when new
static utility classes should be added. During reviews, a heavy
introduction of static classes or methods should raise red lights, it
is likely some abstraction went wrong and the problem domain was not
modeled well enough.

A “good” static method in a utility class can be thought of as if the
code itself is directly embedded within the consuming classes. It is
mostly an extraction of a common programming problem that can not be
abstracted within the class hierarchy since multiple different class
hierarchies have the same challenge. Good static methods contain helper
code like dedicated array manipulations or string operations. This is
why the majority of static utility classes is located within the Core
extension in the Core and other extension have little number of utility
classes.

Good static methods calls are not “mocked away” in unit tests of a
system that calls a static method and are thus indirectly tested
together with the system under test as if the code is directly embedded
within the class. It is important to have good test coverage for the
static method itself, defining the method behaviour especially for
edge cases.


Good Examples
=============

*   :php:`Core/Utility/ArrayUtility`

    *   Clear scope - array manipulation helpers.

    *   Well documented, distinct and short methods doing only one thing at
        a time with decent names and examples.

    *   High test coverage taking care of edge case input output scenarios
        acting as additional documentation of the system.

    *   No further dependencies.

*   :php:`Core/Utility/VersionNumberUtility`

    *   Clear scope - a group of helper methods to process version number
        handling.

    *   Good test coverage defining the edge cases.

    *   Defines how version handling is done in TYPO3 and encapsulates this
        concern well.


Bad Examples
============

*   :php:`Backend/Utility/BackendUtility`

    *   Global access, third party dependencies.

    *   Stateful methods.

    *   No clear concern.

    *   God methods.

*   :php:`Core/Utility/MailUtility`

    *   Good: Relatively clear focus, but:

    *   Stateful, external dependencies to objects, depends on configuration.

    *   Relatively inflexible.

    *   This should probably “at least” be a service.

*   :php:`Core/Utility/RootlineUtility`

    *   Not static.

    *   Should probably be a dedicated class construct, probably a service is not enough. Why is this not part of a tree structure?


Red Flags
=========

*   :php:`$GLOBALS: Utility` code should not have dependencies to global
    state or global objects.
