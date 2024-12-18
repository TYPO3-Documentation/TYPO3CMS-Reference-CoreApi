:navigation-title: Functional tests

..  include:: /Includes.rst.txt
..  index:: ! Testing; Functional
..  _testing-writing-functional:

===================================================
Functional testing with the TYPO3 testing framework
===================================================

..  contents:: Sections on this page

..  toctree:: Subchapters
    :maxdepth: 1
    :titlesonly:

    Introduction

..  _testing-writing-functional-example-simple:

Simple Example
==============

At the time of this writing, TYPO3 Core  contains more than 2600 functional tests, so
there are plenty of test files to look at to learn about writing functional tests. Do not
hesitate looking around, there is plenty to discover.

As a starter, let's have a look at a basic scenario from the styleguide example again:

..  literalinclude:: _FunctionalTests/_GeneratorTest.php
    :language: php
    :caption: EXT:styleguide/Tests/Functional/TcaDataGenerator/GeneratorTest.php

That's the basic setup needed for a functional test: Extend :php:`FunctionalTestCase`,
declare extension styleguide should be loaded and have a first test.

..  _testing-writing-functional-setup:

Extending setUp
===============

Note :php:`setUp()` is not overridden in this case. If you override it, remember to always
call :php:`parent::setUp()` before doing own stuff. An example can be found in
:php:`TYPO3\CMS\Backend\Tests\Functional\Domain\Repository\Localization\LocalizationRepositoryTest`:

..  literalinclude:: _FunctionalTests/_LocalizationRepositoryTest.php
    :language: php
    :caption: typo3/sysext/backend/Tests/Functional/Domain/Repository/Localization/LocalizationRepositoryTest.php

The above example overrides :php:`setUp()` to first call :php:`parent::setUp()`. This is
critically important to do, if not done the entire test instance set up is not triggered.
After calling parent, various things needed by all tests of this scenario are added: A database
fixture is loaded, a backend user is added, the language object is initialized
and an instance of the system under test is parked as :php:`$this->subject` within the class.

..  _testing-writing-functional-load-extensions:

Loaded extensions
=================

The :php:`FunctionalTestCase` has a couple of defaults and properties to specify the set of
loaded extensions of a test case: First, there is a set of default Core extensions that are
always loaded. Those should be `require` or at least `require-dev` dependencies in a
:file:`composer.json` file, too: `core`, `backend`, `frontend`, `extbase` and `install`.

Apart from that default list, it is possible to load additional Core extensions: An extension
that wants to test if it works well together with workspaces, would for example specify
the workspaces extension as additional to-load extension:

..  literalinclude:: _FunctionalTests/_SomeTest.php
    :language: php
    :caption: EXT:my_extension/Tests/Functional/SomeTest.php

Furthermore, third party extensions and fixture extensions can be loaded for
any given test case:

..  literalinclude:: _FunctionalTests/_SomeTestExtensions.php
    :language: php
    :caption: EXT:my_extension/Tests/Functional/SomeTestExtensions.php

In this case the fictional extension `some_extension` comes with an own fixture extension that should
be loaded, and another `base_extension` should be loaded. These extensions will be linked into
`typo3conf/ext` of the test case instance.

The functional test bootstrap links all extensions to either `typo3/sysext` for Core extensions or
`typo3conf/ext` for third party extensions, creates a :file:`PackageStates.php` and then uses the
database schema analyzer to create all database tables specified in the :file:`ext_tables.sql` files.

..  _testing-writing-functional-fixtures:

Database fixtures
=================

To populate the test database tables with rows to prepare any given scenario, the helper method
:php:`$this->importCSVDataSet()` can be used. Note it is not possible to inject a fully prepared
database, for instance it is not possible to provide a full `.sqlite` database and work on this
in the test case. Instead, database rows should be provided as `.csv` files to be loaded into
the database using :php:`$this->importCSVDataSet()`. An example file could look like this:

..  literalinclude:: _FunctionalTests/_Fixture.csv
    :language: plaintext
    :caption: A CSV data set

This file defines one row for the `pages` table
and one `tt_content` row. So one `.csv` file can contain rows of multiple tables.

..  note::
    If you need to define a :php:`null` value within CSV files, you need to use the special value `"\NULL"`.

..  versionchanged:: Testing Framework 8
    There was a similar method called :php:`$this->importDataSet()` that allowed
    loading database rows defined as XML instead of CSV. It was deprecated
    in testing framework 7 and removed with 8.

In general, the methods need the absolute path to the fixture file to load them. However some
keywords are allowed:

..  literalinclude:: _FunctionalTests/_SomeTestImportDataSet.php
    :language: php
    :caption: EXT:some_extension/Tests/Functional/SomeTestImportDataSet.php

..  _testing-writing-functional-assert-database:

Asserting database
==================

A test that triggered some data munging in the database probably wants to test if the final
state of some rows in the database is as expected after the job is done. The helper method
:php:`assertCSVDataSet()` helps to do that. As in the `.csv` example above, it needs the
absolute path to some CSV file that can contain rows of multiple tables. The methods will
then look up the according rows in the database and compare their values with the fields
provided in the CSV files. If they are not identical, the test will fail and output a table
which field values did not match.

..  _testing-writing-functional-load-files:

Loading files
=============

If the system under test works on files, those can be provided by the test setup, too. As
example, one may want to check if an image has been properly sized down. The image to work
on can be linked into the test instance:

..  literalinclude:: _FunctionalTests/_SomeTestFiles.php
    :language: php
    :caption: EXT:my_extension/Tests/Functional/SomeTestFiles.php

It is also possible to *copy* the files to the test instance instead of only linking it
using :php:`$pathsToProvideInTestInstance`.

..  _testing-writing-functional-TYPO3_CONF_VARS:

Setting TYPO3_CONF_VARS
=======================

A default :file:`config/system/settings.php` file of the instance is created by the default :php:`setUp()`.
It contains the database credentials and everything else to end up with a working TYPO3 instance.

If extensions need additional settings in :file:`config/system/settings.php`, the property
:php:`$configurationToUseInTestInstance` can be used to specify these:

..  literalinclude:: _FunctionalTests/_SomeTestConfiguration.php
    :language: php
    :caption: EXT:my_extension/Tests/Functional/SomeTestConfiguration.php

..  _testing-writing-functional-frontend:

Frontend tests
==============

To prepare a frontend test, the system can be instructed to load a set of
:file:`.typoscript` files for a working frontend:

..  literalinclude:: _FunctionalTests/_SomeTestFrontend.php
    :language: php
    :caption: EXT:my_extension/Tests/Functional/SomeTestFrontend.php

This instructs the system to load the :file:`Basic.typoscript` as TypoScript
file for the frontend page with uid 1.

A frontend request can be executed calling :php:`$this->executeFrontendRequest()`. It will
return a Response object to be further worked on, for instance it is possible to verify
if the body :php:`->getBody()` contains some string.
