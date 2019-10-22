.. include:: ../Includes.txt

.. _testing-writing-functional:

========================
Writing functional tests
========================

Introduction
============

Functional testing in TYPO3 world is basically the opposite of unit testing: Instead
of looking at rather small, isolated pieces of code, functional testing looks at
bigger scenarios with many involved dependencies. A typical scenario creates a full
instance with some extensions, puts some rows into the database and calls an entry method,
for instance a controller action. That method triggers dependent logic that changes
data. The tests end with comparing the changed data or output is identical to some
expected data.

This chapter goes into details on functional testing and how the `typo3/testing-framework`
helps with setting up, running and verifying scenarios.


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
create :file:`LocalConfiguration.php`, load extensions, populate the database with tables
needed by the extensions and to link or copy additional fixture files around and finally
bootstrap a basic TYPO3 backend. :php:`setUp()` is called before each test, so each single
test is isolated from other tests, even within one test case. There is only one optimization
step: The instance between single tests of one test case is not fully created from scratch,
but the existing instance is just cleaned up (all database tables truncated). This is a measure
to speed up execution, but still, the general thinking is that each test stands for it's own
and should not have side effects on other tests.

The :php:`TYPO3\TestingFramework\Core\Functional\FunctionalTestCase` contains a series
of class properties. Most of them are designed to be overwritten by single test cases,
they tell :php:`setUp()` what to do. For instance, there is a property to specify which
extensions should be active for the given scenario. Everyone looking or creating
functional tests should have a look at these properties: The are well documented and
contain examples how to use. These properties are the key to instruct `typo3/testing-framework`
what to do.

The "external dependencies" like credentials for the database are submitted as environment
variables. If using the recommended docker based setup to execute tests, these details
are taken care off by the :file:`runTests.sh` and :file:`docker-compose.yml` files. See
the :ref:`styleguide example <testing-extensions-styleguide>` for details on how this is
set up and used. Executing the functional tests on different databases is handled by these
and it is possible to run one tests on different databases by calling :file:`runTests.sh`
with the according options to do this. The above chapter :ref:`Extension testing
<testing-extensions>` is about executing tests and setting up the runtime, while this
chapter is about writing tests and setting up the scenario.


Simple Example
==============

At the time of this writing, TYPO3 core contains more than 2600 functional tests, so
there are plenty of test files to look at to learn about writing functional tests. Do not
hesitate looking around, there is plenty to discover.

As a starter, let's have a look at a basic scenario from the styleguide example again::

    <?php
    namespace TYPO3\CMS\Styleguide\Tests\Functional\TcaDataGenerator;

    use TYPO3\CMS\Core\Core\Bootstrap;
    use TYPO3\CMS\Styleguide\TcaDataGenerator\Generator;
    use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

    /**
     * Test case
     */
    class GeneratorTest extends FunctionalTestCase
    {
        /**
         * @var array Have styleguide loaded
         */
        protected $testExtensionsToLoad = [
            'typo3conf/ext/styleguide',
        ];

        /**
         * @test
         * @group not-mssql
         */
        public function generatorCreatesBasicRecord()
        {
            ...
        }
    }

That's the basic setup needed for a functional test: Extend :php:`FunctionalTestCase`,
declare extension styleguide should be loaded and have a first test.


Extending setUp
===============

Note :php:`setUp()` is not overridden in this case. If you override it, remember to always
call :php:`parent::setUp()` before doing own stuff. An example can be found in
:php:`TYPO3\CMS\Backend\Tests\Functional\Domain\Repository\LocalizationLocalizationRepositoryTest`::

    <?php
    declare(strict_types = 1);
    namespace TYPO3\CMS\Backend\Tests\Functional\Domain\Repository\Localization;

    use TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository;
    use TYPO3\CMS\Core\Core\Bootstrap;
    use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

    /**
     * Test case
     */
    class LocalizationRepositoryTest extends FunctionalTestCase
    {
        /**
         * @var LocalizationRepository
         */
        protected $subject;

        /**
         * Sets up this test case.
         */
        protected function setUp(): void
        {
            parent::setUp();

            $this->setUpBackendUserFromFixture(1);
            Bootstrap::initializeLanguageObject();

            $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3/sysext/backend/Tests/Functional/Domain/Repository/Localization/Fixtures/DefaultPagesAndContent.csv');

            $this->subject = new LocalizationRepository();
        }

        ...
    }

The above example overrides :php:`setUp()` to first call :php:`parent::setUp()`. This is
critically important to do, if not done the entire test instance set up is not triggered.
After calling parent, various things needed by all tests of this scenario are added: A database
fixtures is loaded, a backend user is added, the language object is initialized
and an instance of the system under test is parked as :php:`$this->subject` within the class.


Loaded extensions
=================

The :php:`FunctionalTestCase` has a couple of defaults and properties to specify the set of
loaded extensions of a test case: First, there is a set of default core extensions that are
always loaded. Those should be `require` or at least `require-dev` dependencies in a
:file:`composer.json` file, too: `core`, `backend`, `frontend`, `extbase`, `install` and
`recordlist`.

Apart from that default list, it is possible to load additional core extensions, an extension
that wants to test if it works well together with workspaces, would for example specify
the workspaces extension as additional to-load extension::

    protected $coreExtensionsToLoad = [
        'workspaces',
    ];

Furthermore, non-core extensions and fixture extensions can be loaded for any given test case::

    protected $testExtensionsToLoad = [
        'typo3conf/ext/some_extension/Tests/Functional/Fixtures/Extensions/test_extension',
        'typo3conf/ext/base_extension',
    ];

In this case the fictive extension `some_extension` comes with an own fixture extension that should
be loaded, and another `base_extension` should be loaded. These extensions will be linked into
`typo3conf/ext` of the test case instance.

The functional test bootstrap links all extensions to either `typo3/sysext` for core extensions or
`typo3conf/ext` for non-core extensions, creates a :file:`PackageStates.php` and then uses the
database schema analyzer to create all database tables specified in the :file:`ext_tables.sql` files.


Database fixtures
=================

To populate the test database tables with rows to prepare any gives scenario, the helper method
:php:`$this->importCSVDataSet()` can be used. Note it is not possible to inject a fully prepared
database, for instance it is not possible to provide a full `.sqlite` database and work on this
in the test case. Instead, database rows should be provided as `.csv` files to be loaded into
the database using :php:`$this->importCSVDataSet()`. An example file could look like this:

.. code-block:: php

    "pages",,,,,,,,,
    ,"uid","pid","sorting","deleted","t3_origuid","title",,,
    ,1,0,256,0,0,"Connected mode",,,
    "sys_language",,,,,,,,,
    ,"uid","pid","hidden","title","flag",,,,
    ,1,0,0,"Dansk","dk",,,,
    ,2,0,0,"Deutsch","de",,,,
    "tt_content",,,,,,,,,
    ,"uid","pid","sorting","deleted","sys_language_uid","l18n_parent","l10n_source","t3_origuid","header"
    ,297,1,256,0,0,0,0,0,"Regular Element #1"

This file defines one row for the `pages` table, two rows for the `sys_language` table
and finally one `tt_content` row. So one `.csv` file can contain rows of multiple tables.

There is a similar method called :php:`$this->importDataSet()` that allows loading database
rows defined as XML instead of CSV, too.

In general, the methods need the absolute path to the fixture file to load them. However some
keywords are allowed::

    // Load a xml file relative to test case file
    $this->importDataSet(__DIR__ . '/../Fixtures/pages.xml');
    // Load a xml file of some extension
    $this->importDataSet('EXT:frontend/Tests/Functional/Fixtures/pages-title-tag.xml');
    // Load a xml file provided by the typo3/testing-framework package
    $this->importDataSet('PACKAGE:typo3/testing-framework/Resources/Core/Functional/Fixtures/pages.xml');


Asserting database
==================

A test that triggered some data munging in the database probably wants to test if the final
state of some rows in the database is as expected after the job is done. The helper method
:php:`assertCSVDataSet()` helps to do that. As in the `.csv` example above, it needs the
absolute path to some CSV file that can contain rows of multiple tables. The methods will
then look up the according rows in the database and compare their values with the fields
provided in the CSV files. If they are not identical, the test will fail and output a table
which field values did not match.


Loading files
=============

If the system under test works on files, those can be provided by the test setup, too. As
example, one may want to check if an image has been properly sized down. The image to work
on can be linked into the test instance::

    /**
     * @var array
     */
    protected $pathsToLinkInTestInstance = [
        'typo3/sysext/impexp/Tests/Functional/Fixtures/Folders/fileadmin/user_upload/typo3_image2.jpg' => 'fileadmin/user_upload/typo3_image2.jpg',
    ];

It is also possible to *copy* the files to the test instance instead of only linking it
using :php:`$pathsToProvideInTestInstance`.


Setting TYPO3_CONF_VARS
=======================

A default :file:`LocalConfiguration.php` file of the instance is created by the default :php:`setUp()`.
It contains the database credentials and everything else to end up with a working TYPO3 instance.

If extensions need additional settings in :file:`LocalConfiguration.php`, the property
:php:`$configurationToUseInTestInstance` can be used to specify these::

    protected $configurationToUseInTestInstance = [
        'MAIL' => [
            'transport' => \Symfony\Component\Mailer\Transport\NullTransport::class
        ]
    ];


Frontend tests
==============

.. note::

    Frontend functional testing is currently still a subject to change and the core did
    not fully settle in this area, yet. The docs below outline only the bare minimum to
    set up and execute these tests and core usages are hard to explain here in detail
    since most of them work with additional abstracts and set up tricks.

To prepare a frontend test, the system can be instructed to load a set of :file:`.typoscript`
files for a working frontend::

    $this->setUpFrontendRootPage(1, ['EXT:fluid_test/Configuration/TypoScript/Basic.ts']);

This instructs the system to load the :file:`Basic.ts` as typoscript file for the frontend
page with uid 1.

A frontend request can be executed calling :php:`$this->executeFrontendRequest()`. It will
return a Response object to be further worked on, for instance it is possible to verify
if the body :php:`->getBody()` contains some string.
