:navigation-title: Unit tests

..  include:: /Includes.rst.txt
..  index::
    ! Testing; Unit
    Unit tests
..  _testing-writing-unit:

=============================================
Unit testing with the TYPO3 testing framework
=============================================

..  contents:: Sections on this page

..  toctree:: Subchapters
    :maxdepth: 1
    :titlesonly:

    Introduction
    Running

..  index:: Unit tests; Conventions
..  _testing-writing-unit-conventions:
..  _cgl-unit-tests:

Unit test conventions
=====================

TYPO3 unit testing means using the `phpunit <https://phpunit.de/>`_ testing
framework. The TYPO3 testing framework comes with
a basic `UnitTests.xml <https://github.com/TYPO3/testing-framework/blob/main/Resources/Core/Build/UnitTests.xml>`_
file that can be used by Core and extensions. This references a phpunit `bootstrap file
<https://github.com/TYPO3/testing-framework/blob/main/Resources/Core/Build/UnitTestsBootstrap.php>`_ so
phpunit does find our main classes. Apart from that, there are little conventions: Tests for some "system under test"
class in the :file:`Classes/` folder should be located at the same position within the :file:`Test/Unit`
folder having the additional suffix :file:`Test.php` to the system under test file name. The class of the
test file should extend the basic unit test abstract :php:`TYPO3\TestingFramework\Core\Unit\UnitTestCase`. Single
tests should be named starting with the method that is tested plus some explaining suffix and should
be annotated with :php:`@test`.

Example for a system under test located at :file:`typo3/sysext/core/Utility/ArrayUtility.php` (stripped):

..  literalinclude:: _UnitTests/_ArrayUtility.php
    :language: php
    :caption: typo3/sysext/core/Utility/ArrayUtility.php (stripped)

The test file is located at :file:`typo3/sysext/core/Tests/Unit/Utility/ArrayUtilityTest.php` (stripped):

..  literalinclude:: _UnitTests/_ArrayUtilityTest.php
    :language: php
    :caption: typo3/sysext/core/Tests/Unit/Utility/ArrayUtilityTest.php  (stripped)

This way it is easy to find unit tests for any given file. Note PhpStorm understands this structure and
can jump from a file to the according test file by hitting `CTRL+Shift+T`.

..  index:: Unit tests; Extending UnitTestCase
..  _testing-writing-unit-extending:

Extending UnitTestCase
======================

Extending a unit test from class :php:`TYPO3\TestingFramework\Core\Unit\UnitTestCase` of the
`typo3/testing-framework` package instead of the native phpunit class :php:`PHPUnit\Framework\TestCase`
adds some functionality on top of phpunit:

*   Environment backup: If a unit test has to fiddle with the :ref:`Environment <Environment>` class, setting
    property :php:`$backupEnvironment` to :php:`true` instructs the unit test to reset the state after each call.

*   If a system under test creates instances of classes implementing :php:`SingletonInterface`, setting
    property :php:`$resetSingletonInstances` to :php:`true` instructs the unit test to reset internal
    :php:`GeneralUtility` scope after each test. :php:`tearDown()` will fail if there are dangling singletons,
    otherwise.

*   Adding files or directories to array property :php:`$testFilesToDelete` instructs the test to delete
    certain files or entire directories that have been created by unit tests. This property is useful
    to keep the system clean.

*   A generic :php:`tearDown()` method: That method is designed to test for TYPO3 specific global state changes
    and to let a unit test fail if it does not take care of these. For instance, if a unit tests add a singleton
    class to the system but does not declare that singletons should be flushed, the system will recognize this
    and let the according test fail. This is a great help for test developers to not run into side effects
    between unit tests. It is usually not needed to override this method, but if you do, call :php:`parent::tearDown()`
    at the end of the inherited method to have the parent method kick in!

*   A :php:`getAccessibleMock()` method: This method can be useful if a protected method of the system under test
    class needs to be accessed. It also allows to "mock-away" other methods, but keep the method that is tested.
    Note this method should *not* be used if just a full class dependency needs to be mocked. Use prophecy (see below)
    to do this instead. If you find yourself using that method, it's often a hint that something in the
    system under test is broken and should be modelled differently. So, don't use that blindly and consider
    extracting the system under test to a utility or a service. But yes, there are situations when :php:`getAccessibleMock()`
    can be very helpful to get things done.


..  _testing-writing-unit-hints:

General hints
=============

*   Creating an instance of the system under test should be done with :php:`new` in the unit test and
    not using :php:`GeneralUtility::makeInstance()`.

*   Only use :php:`getAccessibleMock()` if parts of the system under test class itself needs to be
    mocked. Never use it for an object that is created by the system under test itself.

*   Unit tests are by default configured to fail if a notice level PHP error is triggered.
    This has been used in the Core to slowly make the framework notice free. Extension authors may fall
    into a trap here: First, the unit test code itself, or the system under test may trigger notices.
    Developers should fix that. But it may happen a Core
    dependency triggers a notice that in turn lets the extensions unit test fail. At best, the extension
    developer pushes a patch to the Core to fix that notice. Another solution is to mock the dependency
    away, which may however not be desired or possible - especially with static dependencies.


..  _testing-writing-unit-data-provider:

A casual data provider
======================

This is one of the most common use cases in unit testing: Some to-test method ("system under test") takes
some argument and a unit tests feeds it with a series of input arguments to verify output is as expected.
Data providers are used quite often for this and we encourage developers to do so, too. An example test
from :php:`ArrayUtilityTest`:

..  literalinclude:: _UnitTests/_ArrayUtilityTestDataProvider.php
    :language: php
    :caption: typo3/sysext/core/Tests/Unit/Utility/ArrayUtilityTest.php (excerpts)


Some hints on this: Try to give the single data sets good names, here "single value", "whole array" and "sub array".
This helps to find a broken data set in the code, it forces the test writer to think about what they are feeding
to the test and it helps avoiding duplicate sets. Additionally, put the data provider directly before the according
test and name it "test name" + "DataProvider". Data providers are often not used in multiple tests, so that should
almost always work.

..  index:: Unit tests; Mocking
..  _testing-writing-unit-mocking:

Mocking
=======

Unit tests should test one thing at a time, often one method only.
If the system under test has dependencies
like additional objects, they should be usually "mocked away". A simple example is this, taken from
:php:`TYPO3\CMS\Backend\Tests\Unit\Controller\FormInlineAjaxControllerTest`:

..  literalinclude:: _UnitTests/_FormInlineAjaxControllerTest.php
    :language: php
    :caption: typo3/sysext/backend/Tests/Unit/Controller/FormInlineAjaxControllerTest.php

The above case is pretty straight since the mocked dependency is hand over as argument to
the system under test. If the system under test however creates an instance of the to-mock
dependency on its own - typically using :php:`GeneralUtility::makeInstance()`, the mock instance
can be manually registered for makeInstance:

..  literalinclude:: _UnitTests/_SomeTest.php
    :language: php
    :caption: EXT:my_extension/Tests/Unit/SomeTest.php

This works well for prototypes. :php:`addInstance()` adds objects to a LiFo, multiple instances
of the same class can be stacked. The generic :php:`->tearDown()` later confirms the stack is
empty to avoid side effects on other tests. Singleton instances can be registered in a
similar way:

..  literalinclude:: _UnitTests/_TcaFlexPrepareTest.php
    :language: php
    :caption: typo3/sysext/backend/Tests/Unit/Form/FormDataProvider/TcaFlexPrepareTest.php

..  todo: EnvironmentService has been removed with version 12.0, find another Example here

If adding singletons, make sure to set the property :php:`protected $resetSingletonInstances = true;`,
otherwise :php:`->tearDown()` will detect a dangling singleton and let's the unit test fail
to avoid side effects on other tests.

..  _testing-writing-unit-dependencies:

Static dependencies
===================

If a system under test has a dependency to a static method (typically from a utility class), then
hopefully the static method is a "good" dependency that sticks to the general
:ref:`static method guide <cgl-model-static-methods>`: A "good" static dependency has no state,
triggers no further code that has state. If this is the case, think of this dependency code as
being inlined within the system under test directly. Do not try to mock it away, just test
it along with the system under test.

If however the static method that is called is a "bad" dependency that statically calls further
magic by creating new objects, doing database calls and has own state, this is harder to come by.
One solution is to extract the static method call to an own method, then use :php:`getAccessibleMock()`
to mock that method away. And yeah, that is ugly. Unit tests can quite quickly show which parts
of the framework are not modelled in a good way. A typical case is
:php:`TYPO3\CMS\Backend\Utility\BackendUtility` - trying to unit test systems that have this
class as dependency is often very painful. There is not much developers can do in this case. The
Core tries to slowly improve these areas over time and indeed BackendUtility is shrinking
each version.

..  index:: pair: Unit tests; Exceptions
..  _testing-writing-unit-exception:

Exception handling
==================

Code should throw exceptions if something goes wrong. See :ref:`working with exceptions
<cgl-working-with-exceptions>` for some general guides on proper exception handling.
Exceptions are often very easy to unit test and testing them can be beneficial. Let's take
a simple example, this is from :php:`TYPO3\CMS\Core\Tests\Unit\Cache\CacheManagerTest`
and tests both the exception class and the exception code:

..  literalinclude:: _UnitTests/_OnTheFlyTest.php
    :language: php
    :caption: typo3/sysext/backend/Tests/Unit/Form/FormDataGroup/OnTheFlyTest.php
