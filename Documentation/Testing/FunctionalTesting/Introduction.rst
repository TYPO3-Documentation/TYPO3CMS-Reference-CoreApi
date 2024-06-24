:navigation-title: Introduction

..  include:: /Includes.rst.txt
..  _testing-writing-functional-introduction:

================================
Introduction to functional tests
================================

Functional testing in TYPO3 world is basically the opposite of unit testing: Instead
of looking at rather small, isolated pieces of code, functional testing looks at
bigger scenarios with many involved dependencies. A typical scenario creates a full
instance with some extensions, puts some rows into the database and calls an entry method,
for instance a controller action. That method triggers dependent logic that changes
data. The tests end with comparing the changed data or output is identical to some
expected data.

This chapter goes into details on functional testing and how the `typo3/testing-framework <https://github.com/TYPO3/testing-framework>`_
helps with setting up, running and verifying scenarios.

..  _testing-writing-functional-overview:

Overview
========

Functional testing is much about defining the specific scenario that should be set
up by the system and isolating it from other scenarios. The basic thinking is that
a single scenario that involves a set of loaded extensions, maybe some files and
some database rows is a single test case (= one test file), and one or more single
tests are executed using this scenario definition.

Single test cases extend :php:`TYPO3\TestingFramework\Core\Functional\FunctionalTestCase`.
The default implementation of method :php:`setUp()` contains all the main magic to set
up a new TYPO3 instance in a sub folder of the existing system, create a database,
create :file:`config/system/settings.php`, load extensions, populate the database with tables
needed by the extensions and to link or copy additional fixture files around and finally
bootstrap a basic TYPO3 backend. :php:`setUp()` is called before each test, so each single
test is isolated from other tests, even within one test case. There is only one optimization
step: The instance between single tests of one test case is not fully created from scratch,
but the existing instance is just cleaned up (all database tables truncated). This is a measure
to speed up execution, but still, the general thinking is that each test stands for its own
and should not have side effects on other tests.

The :php:`TYPO3\TestingFramework\Core\Functional\FunctionalTestCase` contains a series
of class properties. Most of them are designed to be overwritten by single test cases,
they tell :php:`setUp()` what to do. For instance, there is a property to specify which
extensions should be active for the given scenario. Everyone looking or creating
functional tests should have a look at these properties: They are well documented and
contain examples how to use. These properties are the key to instruct `typo3/testing-framework`
what to do.

The "external dependencies" like credentials for the database are submitted as environment
variables. If using the recommended docker based setup to execute tests, these details
are taken care off by the :file:`runTests.sh`. See
the :ref:`styleguide example <testing-extensions-styleguide>` for details on how this is
set up and used, and check out :ref:`testing-organization` for details on test runners.
Executing the functional tests on different databases is handled by these
and it is possible to run one test on different databases by calling :file:`runTests.sh`
with the according options to do this. The above chapter :ref:`Extension testing
<testing-extensions>` is about executing tests and setting up the runtime, while this
chapter is about writing tests and setting up the scenario.
