:navigation-title: Running

..  include:: /Includes.rst.txt
..  _testing-functional-run:

========================
Running functional tests
========================

Functional tests execute test cases within a fully initialized TYPO3 instance.
Unlike unit tests, functional tests interact with the TYPO3 framework, service
container, and an active database connection.

Before running functional tests, ensure that the TYPO3 testing framework
(:composer:`typo3/testing-framework`) and PHPUnit (:composer:`phpunit/phpunit`)
are installed as Composer development dependencies. For version compatibility
between TYPO3, PHP, and the testing framework, see
:ref:`Install PHPUnit and the TYPO3 testing framework <testing-unit-run-install>`.

..  _testing-functional-run-kickstarter:

Quick setup with extension kickstarter
======================================

If you are developing a TYPO3 extension, the fastest way to set up the test
environment is using the Extension Kickstarter
(:composer:`friendsoftypo3/kickstarter`):

..  code-block:: bash

    composer require --dev friendsoftypo3/kickstarter
    vendor/bin/typo3 make:testenv [extension_key]

The command generates:

*   :file:`Build/phpunit/FunctionalTests.xml` and
    :file:`Build/phpunit/FunctionalTestsBootstrap.php`
*   :file:`Build/phpunit/UnitTests.xml` and
    :file:`Build/phpunit/UnitTestsBootstrap.php`
*   :file:`Build/Scripts/runTests.sh` (the containerized test runner)
*   Standard configuration files for coding guidelines and static analysis
    (such as :file:`.php-cs-fixer.dist.php` and :file:`phpstan.neon`)
*   Enriches :file:`composer.json` with the necessary `require-dev` and
    `autoload-dev` definitions

For more information, see :ref:`testing-extensions`.

..  _testing-functional-run-configure:

Provide configuration files for functional tests
================================================

If you set up testing manually or need to customize an existing configuration,
the TYPO3 testing framework provides template files:

*   `vendor/typo3/testing-framework/Resources/Core/Build/FunctionalTests.xml
    <https://github.com/TYPO3/testing-framework/blob/main/Resources/Core/Build/FunctionalTests.xml>`__
*   `vendor/typo3/testing-framework/Resources/Core/Build/FunctionalTestsBootstrap.php
    <https://github.com/TYPO3/testing-framework/blob/main/Resources/Core/Build/FunctionalTestsBootstrap.php>`__

Copy these files into your project under :path:`Build/phpunit/`.

Open :file:`FunctionalTests.xml` and adjust the path in the `<testsuite>`
definition to point to your functional test directory. Because the configuration
file is located two directory levels deep in :path:`Build/phpunit/`, use `../../`
to navigate back to the root directory. By convention, functional tests reside
in :path:`Tests/Functional/`:

..  code-block:: diff
    :caption: FunctionalTests.xml for extension testing

    <testsuites>
        <testsuite name="Functional tests">
    -        <directory>../../../../../../typo3/sysext/*/Tests/Functional/</directory>
    +        <directory>../../Tests/Functional/</directory>
        </testsuite>
    </testsuites>

For testing within a full project with local extensions in :path:`packages/`:

..  code-block:: diff
    :caption: FunctionalTests.xml for project testing

    <testsuites>
        <testsuite name="Functional tests">
    -        <directory>../../../../../../typo3/sysext/*/Tests/Functional/</directory>
    +        <directory>../../Tests/Functional/</directory>
    +        <directory>../../packages/*/Tests/Functional/</directory>
        </testsuite>
    </testsuites>

The bootstrap file :file:`FunctionalTestsBootstrap.php` instantiates
:php:`\TYPO3\TestingFramework\Core\Testbase`, resolves paths, and ensures the
temporary directories :path:`typo3temp/var/tests` and
:path:`typo3temp/var/transient` exist before executing test suites.

..  _testing-functional-run-runtests:

Run functional tests with runTests.sh
=====================================

The recommended and standardized approach for running tests across TYPO3
extensions is :file:`Build/Scripts/runTests.sh`. It starts dedicated Docker
containers with all required dependencies and manages database containers
automatically.

When using :file:`runTests.sh`, you do not need to configure database
credentials or set environment variables manually. The script takes care of
starting the database service (SQLite, MariaDB, or PostgreSQL) and injecting all
necessary configuration variables into the test environment.

Run all functional tests using the default database (SQLite):

..  code-block:: bash

    Build/Scripts/runTests.sh -s functional

Run tests against a specific database system:

..  code-block:: bash

    Build/Scripts/runTests.sh -s functional -d mariadb
    Build/Scripts/runTests.sh -s functional -d postgres

Run tests with a specific PHP version:

..  code-block:: bash

    Build/Scripts/runTests.sh -s functional -p 8.4

Run a single test file:

..  code-block:: bash

    Build/Scripts/runTests.sh -s functional -- Tests/Functional/Domain/Repository/MyRepositoryTest.php

For more details on :file:`runTests.sh` options and workflows, see
:ref:`testing-organization`.

..  _testing-functional-run-ddev:

Run functional tests on the host system or with DDEV
====================================================

If you choose not to use :file:`runTests.sh` and execute PHPUnit directly on
your host system or inside DDEV, you must provide the database connection
details yourself via environment variables.

Functional tests create the database schema based on the TCA configuration and
complementary :file:`ext_tables.sql` definitions of all loaded extensions, and
truncate database tables between tests. Without :file:`runTests.sh` managing
the environment, the test bootstrap requires the following environment
variables:

`typo3DatabaseDriver`
    Specifies the database driver:

    *   `pdo_sqlite`: Uses an SQLite file database. This is the simplest driver
        for local execution because it requires no database server setup or
        credentials. SQLite creates database files on the fly in
        :path:`typo3temp/var/tests/functional-sqlite-dbs/`.
    *   `mysqli`: Connects to a MySQL or MariaDB database server.
    *   `pdo_pgsql`: Connects to a PostgreSQL database server.

If using `mysqli` or `pdo_pgsql`, the following additional connection
variables must be supplied:

*   `typo3DatabaseHost` (e.g. `127.0.0.1` or `db`)
*   `typo3DatabasePort` (e.g. `3306`)
*   `typo3DatabaseUsername`
*   `typo3DatabasePassword`
*   `typo3DatabaseName`

These variables can either be passed inline when executing PHPUnit, or defined
in the `<php>` section of :file:`Build/phpunit/FunctionalTests.xml`:

..  code-block:: xml
    :caption: Build/phpunit/FunctionalTests.xml (excerpt)

    <php>
        <ini name="display_errors" value="1"/>
        <env name="TYPO3_CONTEXT" value="Testing"/>
        <env name="typo3DatabaseDriver" value="pdo_sqlite"/>
    </php>

Running with SQLite on DDEV:

..  code-block:: bash

    ddev exec typo3DatabaseDriver=pdo_sqlite php vendor/bin/phpunit -c Build/phpunit/FunctionalTests.xml

Running with MariaDB or MySQL on DDEV:

..  code-block:: bash

    ddev exec \
        typo3DatabaseDriver=mysqli \
        typo3DatabaseHost=db \
        typo3DatabasePort=3306 \
        typo3DatabaseUsername=db \
        typo3DatabasePassword=db \
        typo3DatabaseName=db_test \
        php vendor/bin/phpunit -c Build/phpunit/FunctionalTests.xml

To run a single test method or test case, use the `--filter` option:

..  code-block:: bash

    ddev exec typo3DatabaseDriver=pdo_sqlite php vendor/bin/phpunit -c Build/phpunit/FunctionalTests.xml --filter "MyFunctionalTest"
