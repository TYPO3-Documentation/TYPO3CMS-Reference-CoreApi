.. include:: ../Includes.txt

.. _testing-writing-unit:

==================
Writing unit tests
==================

Introduction
============

This chapter goes into details about writing and maintaining unit tests in the TYPO3
world. Core developers over the years gained quite some knowledge and experience on
this topic, this section outlines some best practices and goes into details about
some of the TYPO3 specific unit testing details that have been put on top of the native
phpunit stack: At the time of this writing the TYPO3 core contains about ten thousand
unit tests - many of them are good, some are bad and we're constantly improving
details. Unit testing is a great playground for interested contributors, and most
extension developers probably learn something useful from reading this section, too.

Note this chapter is not a full "How to write unit tests" documentation: It contains
some examples, but mostly goes into details of the additions typo3/testing-framework
puts on top.

Furthermore, this documentation is a general guide. There can be reasons to violate them.
These are no hard rules to always follow.


When to unit tests
==================

It depends on the code you're writing if unit testing that specific code is useful or not.
There are certain areas that scream to be unit tested: You're writing a method that does some PHP
array munging or sorting, juggling keys and values around? Unit test this! You're
writing something that involves date calculations? No way to get that right without unit
testing! You're throwing a regex at some string? The unit test data provider should already
exist before you start with implementing the method!

In general, whenever a rather small piece of code does some dedicated munging on a rather
small set of data, unit testing this isolated piece is helpful. It's a healthy developer
attitude to assume any written code is broken. Isolating that code and throwing unit tests at
it will proof its broken. Promised. Add edge cases to your unit test data provider, feed
it with whatever you can think of and continue doing that until your code survives all that.
Depending on your use case, develop `test-driven
<https://en.wikipedia.org/wiki/Test-driven_development>`_: Test first, fail, fix, refactor, next iteration.

Good to-be-unit-tested code does usually not contain much state, sometimes it's static.
:ref:`Services <cgl-services>` or :ref:`utilities <cgl-model-static-methods>` are often good
targets for unit testing, sometimes some detail method of a class that has not been extracted
to an own class, too.


When not to unit tests
======================

Simply put: Do not unit test "glue code". There are persons proclaiming "100% unit test coverage".
This does not make sense. As an extension developer working on top of framework functionality, it
usually does not make sense to unit test glue code. What is glue code? Well, code
that fetches things from one underlying part and feeds it to some other part: Code that "glues"
framework functionality together.

Good examples are often extbase MVC controller actions: A typical controller usually does not do much
more than fetching some objects from a repository just to assign them to the view. There is no benefit in
adding a unit test for this: A unit test can't do much more than verifying some specific framework
methods are actually called. It thus needs to mock the object dependencies to only verify some
method is hit with some argument. This is tiresome to set up and you're then testing a trivial
part of your controller: Looking at the controller clearly shows the underlying method *is* called.
Why bother?

Another example are extbase models: Most extbase model properties consist of a protected property,
a getter and a setter method. This is near no-brainer code, and many developers auto-generate
getters and setters by an IDE anyway. Unit testing this code leads to broken tests with each trivial
change of the model class. That's tiresome and likely some waste of time. Concentrate unit testing
efforts on stuff that does data munging magic as outlined above! One of your model getters initializes
some object storage, then sorts and filters objects? *That* can be helpful if unit tested, your filter
code is otherwise most likely broken. Add unit tests to proof it's not.

A much better way of testing glue code are functional tests: Set up a proper scenario in your
database, then call your controller that will use your repository and models, then verify your
view returns something useful. With adding a functional test for this you can kill many
birds with one stone. This has many more benefits than trying to unit test glue code.

A good sign that your unit test would be more useful if it is turned into a functional test is if
the unit tests needs lots of lines of code to mock dependencies, just to test something using
:php:`->shouldBeCalled()` on some mock to verify on some dependency is actually called. Go ahead and
read some unit tests provided by the core: We're sure you'll find a bad unit test that could be improved
by creating a functional test from it.


Unit test conventions
=====================

TYPO3 unit testing means using the `phpunit <https://phpunit.de/>`_ testing framework. TYPO3 comes with
as basic `UnitTests.xml <https://github.com/TYPO3/testing-framework/blob/master/Resources/Core/Build/UnitTests.xml>`_
file that can be used by core and extensions. This references a phpunit `bootstrap file
<https://github.com/TYPO3/testing-framework/blob/master/Resources/Core/Build/UnitTestsBootstrap.php>`_ so
phpunit does find our main classes. Apart from that, there are little conventions: Tests for some "system under test"
class in the :file:`Classes/` folder should be located at the same position within the :file:`Test/Unit`
folder having the additional suffix :file:`Test.php` to the system under test file name. The class of the
test file should extend the basic unit test abstract :php:`TYPO3\TestingFramework\Core\Unit\UnitTestCase`. Single
tests should be named starting with the method that is tested plus some explaining suffix and should
be annotated with :php:`@test`.

Example for a system under test located at :file:`typo3/sysext/core/Utility/ArrayUtility.php` (stripped)::

    <?php
    namespace TYPO3\CMS\Core\Utility;
    class ArrayUtility
    {

        ...

        public static function filterByValueRecursive($needle = '', array $haystack = [])
        {
            // System under test code
        }
    }

The test file is located at :file:`typo3/sysext/core/Tests/Unit/Utility/ArrayUtilityTest.php` (stripped)::

    <?php
    namespace TYPO3\CMS\Core\Tests\Unit\Utility;
    use TYPO3\CMS\Core\Utility\ArrayUtility;
    use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
    class ArrayUtilityTest extends UnitTestCase
    {

        ...

        /**
         * @test
         * @dataProvider filterByValueRecursive
         */
        public function filterByValueRecursiveCorrectlyFiltersArray($needle, $haystack, $expectedResult)
        {
            // Unit test code
        }

This way it is easy to find unit tests for any given file. Note PhpStorm understands this structure and
can jump from a file to the according test file by hitting `CTRL+Shift+T`.


Keep it simple
==============

This is an importing rule in testing: Keep tests as simple as possible! Tests should be easy
to write, understand, read and refactor. There is no point in complex and overly abstracted
tests. Those are pain to work with. The basic guides are: No loops, no additional class
inheritance, no additional helper methods if not really needed, no additional state. As simple
example, there is often no point in creating an instance of the subject in :php:`setUp()` just to
park it as in property. It is easier to read to just have a :php:`$subject = new MyClass()`
call in each test at the appropriate place. Test classes are often much longer than the
system under test. That is ok. It's better if a single test is very simple and to copy over
lines from one to the other test over and over again than trying to abstract that away.
Keep tests as simple as possible to read and don't use fancy abstraction features.


Extending UnitTestCase
======================

Extending a unit test from class :php:`TYPO3\TestingFramework\Core\Unit\UnitTestCase` of the
:php:`typo3/testing-framework` package instead of the native phpunit class :php:`PHPUnit\Framework\TestCase`
adds some functionality on top of phpunit:

* Environment backup: If a unit test has to fiddle with the :ref:`Environment <Environment>` class, setting
  property :php:`$backupEnvironment` to :php:`true` instructs the unit test to reset the state after each call.

* If a system under test creates instances of classes implementing :php:`SingletonInterface`, setting
  property :php:`$resetSingletonInstances` to :php:`true` instructs the unit test to reset internal
  :php:`GeneralUtility` scope after each test. :php:`tearDown()` will fail if there are dangling singletons,
  otherwise.

* Adding files or directories to array property :php:`$testFilesToDelete` instructs the test to delete
  certain files or entire directories that have been created by unit tests. This property is useful
  to keep the system clean.

* A generic :php:`tearDown()` method: That method is designed to test for TYPO3 specific global state changes
  and to let a unit test fail if it does not take care of these. For instance, if a unit tests add a singleton
  class to the system but does not declare that singletons should be flushed, the system will recognize this
  and let the according test fail. This is a great help for test developers to not run into side effects
  between unit tests. It is usually not needed to override this method, but if you do, call :php:`parent::tearDown()`
  at the end of the inherited method to have the parent method kick in!

* A :php:`getAccessibleMock()` method: This method can be useful if a protected method of the system under test
  class needs to be accessed. It also allows to "mock-away" other methods, but keep the method that is tested.
  Note this method should *not* be used if just a full class dependency needs to be mocked. Use prophecy (see below)
  to do this instead. If you find yourself using that method, it's often a hint that something in the
  system under test is broken and should be modelled differently. So, don't use that blindly and consider
  extracting the system under test to a utility or a service. But yes, there are situations when :php:`getAccessibleMock()`
  can be very helpful to get things done.


General hints
=============

* Creating an instance of the system under test should be done with :php:`new` in the unit test and
  not using :php:`GeneralUtility::makeInstance()`.

* Only use :php:`getAccessibleMock()` if parts of the system under test class itself needs to be
  mocked. Never use it for an object that is created by the system under test itself.

* Since TYPO3 v9, unit tests are by default configured to fail if a notice level PHP error is triggered.
  This has been used in the core to slowly make the framework notice free. Extension authors may fall
  into a trap here: First, the unit test code itself, or the system under test may trigger notices.
  Developers should fix that. But, TYPO3 v9 is not yet fully notice free, and it may happen a core
  dependency triggers a notice that in turn lets the extensions unit test fail. At best, the extension
  developer pushes a patch to the core to fix that notice. Another solution is to mock the dependency
  away, which may however not be desired or possible - especially with static dependencies.


A casual data provider
======================

This is one of the most common use cases in unit testing: Some to-test method ("system under test") takes
some argument and a unit tests feeds it with a series of input arguments to verify output is as expected.
Data providers are used quite often for this and we encourage developers to do so, too. An example test
from :php:`ArrayUtilityTest`::

    /**
     * Data provider for removeByPathRemovesCorrectPath
     */
    public function removeByPathRemovesCorrectPathDataProvider()
    {
        return [
            'single value' => [
                [
                    'foo' => [
                        'toRemove' => 42,
                        'keep' => 23
                    ],
                ],
                'foo/toRemove',
                [
                    'foo' => [
                        'keep' => 23,
                    ],
                ],
            ],
            'whole array' => [
                [
                    'foo' => [
                        'bar' => 42
                    ],
                ],
                'foo',
                [],
            ],
            'sub array' => [
                [
                    'foo' => [
                        'keep' => 23,
                        'toRemove' => [
                            'foo' => 'bar',
                        ],
                    ],
                ],
                'foo/toRemove',
                [
                    'foo' => [
                        'keep' => 23,
                    ],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider removeByPathRemovesCorrectPathDataProvider
     * @param array $array
     * @param string $path
     * @param array $expectedResult
     */
    public function removeByPathRemovesCorrectPath(array $array, $path, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            ArrayUtility::removeByPath($array, $path)
        );
    }

Some hints on this: Try to give the single data sets good names, here "single value", "whole array" and "sub array".
This helps to find a broken data set in the code, it forces the test writer to think about what they are feeding
to the test and it helps avoiding duplicate sets. Additionally, put the data provider directly before the according
test and name it "test name" + "DataProvider". Data providers are often not used in multiple tests, so that should
almost always work.


Mocking
=======

Unit tests should test one thing at a time, often one method only. If the system under test has dependencies
like additional objects, they should be usually "mocked away". A simple example is this, taken from
:php:`TYPO3\CMS\Backend\Tests\Unit\Controller\FormInlineAjaxControllerTest`::

    /**
     * @test
     */
    public function createActionThrowsExceptionIfContextIsEmpty(): void
    {
        $requestProphecy = $this->prophesize(ServerRequestInterface::class);
        $requestProphecy->getParsedBody()->shouldBeCalled()->willReturn(
            [
                'ajax' => [
                    'context' => '',
                ],
            ]
        );
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(1489751361);
        (new FormInlineAjaxController())->createAction($requestProphecy->reveal());
    }

`Prophecy <https://github.com/phpspec/prophecy>`_ is a nice mocking framework bundled into phpunit
by default. Many people prefer it nowadays over phpunit's own mock framework based on :php:`->getMock()`
and we encourage to use prophecy: Prophecy code is often easier to read and the separation of
the dummy object that is given to the system under test, the "revelation", and the object prophecy
is quite handy. Prophecy is quite some fun to use, go ahead and play around with it.

The above case is pretty straight since the mocked dependency is hand over as argument to
the system under test. If the system under test however creates an instance of the to-mock
dependency on its own - typically using :php:`GeneralUtility::makeInstance()`, the mock instance
can be manually registered for makeInstance::

    GeneralUtility::addInstance(IconFactory::class, $iconFactoryProphecy->reveal());

This works well for prototypes. :php:`addInstance()` adds objects to a LiFo, multiple instances
of the same class can be stacked. The generic :php:`->tearDown()` later confirms the stack is
empty to avoid side effects on other tests. Singleton instances can be registered in a
similar way::

    GeneralUtility::setSingletonInstance(EnvironmentService::class, $environmentServiceMock);

If adding singletons, make sure to set the property :php:`protected $resetSingletonInstances = true;`,
otherwise :php:`->tearDown()` will detect a dangling singleton and let's the unit test fail
to avoid side effects on other tests.


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
core tries to slowly improve these areas over time and indeed BackendUtility is shrinking
each version.


Exception handling
==================

Code should throw exceptions if something goes wrong. See :ref:`working with exceptions
<cgl-working-with-exceptions>` for some general guides on proper exception handling.
Exceptions are often very easy to unit test and testing them can be beneficial. Let's take
a simple example, this is from :php:`TYPO3\CMS\Core\Cache\Tests\Unit\CacheManagerTest`
and tests both the exception class and the exception code::

    /**
     * @test
     */
    public function flushCachesInGroupThrowsExceptionForNonExistingGroup()
    {
        $this->expectException(NoSuchCacheGroupException::class);
        $this->expectExceptionCode(1390334120);
        $subject = new CacheManager();
        $subject->flushCachesInGroup('nonExistingGroup');
    }

