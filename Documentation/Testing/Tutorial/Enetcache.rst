.. include:: /Includes.rst.txt
.. _testing-tutorial-enetcache:

=================
Testing enetcache
=================

..  contents:: Table of contents

.. _testing-tutorial-enetcache-introduction:

Introduction
============

If you are an extension author, it is likely that you will want to test your extension during development.
This chapter describes how extension authors can set up automated extension testing. We will use
two examples which demonstrate how an extension can be embedded
in a TYPO3 instance to run tests in a TYPO3 environment and
how to configure GitHub Actions to run tests. Tests are run using Docker
containers and an extension-specific :file:`runTests.sh`.

.. _testing-tutorial-enetcache-scope:

Scope
=====

About this chapter and what it does *not* cover.

* This documentation assumes the extension is being tested against only one major Core version. It
  does not support extension testing with multiple target Core versions (though that is
  possible).
  The Core Team encourages extension developers to have a dedicated Core branch
  for each Core version. This has various advantages, for instance, it is easy
  to create deprecation-free extensions.

* We assume a Composer based setup. Extensions should already have a
  :file:`composer.json <extension-composer-json>` file and using Composer for
  extension testing is quite convenient.

* As with Core testing, this testing described here relies on docker and docker-compose. See
  :ref:`Core testing requirements <t3contribute:testing-core-dependencies>` for more details.

* We assume your extension code is on github and that automated testing
  is carried out by GitHub Actions. GitHub Actions
  are easy to set up and plenty of documentation is available.
  If your extension code is located elsewhere or uses a different CI, this
  chapter may still be of use to help you build a general understanding of
  the testing process.

.. _testing-tutorial-enetcache-strategy:

General strategy
================

Third party extensions often rely on TYPO3 Core extensions to add key functionality.

If a project needs a TYPO3 extension, it adds the extension to its own root
composer.json file using `composer require`. The extension composer.json contains details
such as which PHP class namespaces it provides and where these can be found. This
integrates the extension into the project so that the project "knows" the location
of the extension classes.

To test extension code, we do something similar by integrating the test environment
and the extension. We turn the extension :file:`composer.json <extension-composer-json>`
file into a `root composer.json file <https://getcomposer.org/doc/04-schema.md#root-package>`_.
The file then serves two needs: it is used by projects that require the extension
as a dependency and it is used as a root composer.json to specify dependencies.
This turns the extension into a project of its own, allowing us to set up a full TYPO3
environment in a subfolder of the extension and execute tests inside this subfolder.

.. _testing-tutorial-enetcache-testing:

Testing enetcache
=================

`enetcache <https://github.com/lolli42/enetcache>`_ is a small extension that helps
with frontend-plugin-based caches. It has been available as a Composer package and a TER extension for quite
some time and is loosely maintained to keep up with current Core versions.

The following is based on the current (May, 2023) main branch of enetcache.
Later versions may be structured differently.

The main branch:

*   supports TYPO3 v11 and TYPO3 v12
*   requires typo3/testing-framework v7 (which supports v11 and v12)

Older versions of this extension were structured differently. Each branch of
the extension supported only one TYPO3 version:

* `1.2` compatible with Core v7, released to TER as 1.x.y

* `2` compatible with Core v8, released to TER as 2.x.y

* `master` compatible with Core v9, released to TER as 3.x.y

Here we focus on testing one TYPO3 version at a time, though it is
possible to support and test two TYPO3 versions in one branch with the
typo3/testing-framework - and enetcache does this. For the sake of simplicity
we describe the simpler use case here.

The enetcache extension comes with some unit tests
in `Tests/Unit`. We will run these locally and use GitHub Actions, along with
some PHP linting to verify that there is no fatal PHP error.

.. _testing-tutorial-enetcache-start:

Starting point
--------------

As outlined in the general strategy, we need to edit the existing
:file:`composer.json <extension-composer-json>` file to turn it into a root
composer.json. This will not harm the functionality of the existing
composer.json properties if the extension is a project dependency and not used as a root composer.json.
If a file is not used as a root project file, Composer ignores root properties. See
notes "root-only" of the `Composer documentation <https://getcomposer.org/doc/04-schema.md>`_ for details.

This is the composer.json file before adding a test setup:

.. code-block:: json

    {
      "name": "lolli/enetcache",
      "type": "typo3-cms-extension",
      "description": "Enetcache cache extension",
      "homepage": "https://github.com/lolli42/enetcache",
      "authors": [
        {
          "name": "Christian Kuhn",
          "role": "Developer"
        }
      ],
      "license": [
        "GPL-2.0-or-later"
      ],
      "require": {
        "typo3/cms-core": "^13"
      },
      "autoload": {
        "psr-4": {
          "Lolli\\Enetcache\\": "Classes"
        }
      },
      "extra": {
        "branch-alias": {
          "dev-master": "2.x-dev"
        }
      }
    }

This is a typical, simple composer.json file. It is a `typo3-cms-extension`, with an
author and a license. We specify that "I need at least 13.0.0 of cms-core" and we tell the autoloader
to "find all class names starting with :php:`Lolli\Enetcache` in the Classes/ directory".

The extension contains unit tests that extend the `typo3/testing-framework` base
unit test class in directory :file:`Tests/Unit/Hooks` (stripped):

.. code-block:: php
   :caption: E

    <?php
    namespace Lolli\Enetcache\Tests\Unit\Hooks;

    use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

    class DataHandlerFlushByTagHookTest extends UnitTestCase
    {
        /**
         * @test
         */
        public function findReferencedDatabaseEntriesReturnsEmptyArrayForTcaWithoutRelations()
        {
            // some unit test code
        }
    }

.. _testing-tutorial-enetcache-composer-json:

Preparing composer.json
-----------------------

Now let's add our properties. First, we add a series of properties
to :file:`composer.json <extension-composer-json>`
which are root :file:`composer.json` properties, turning the extension into a project:

.. code-block:: json
    :linenos:
    :emphasize-lines: 18-24, 30-34, 42

    {
      "name": "lolli/enetcache",
      "type": "typo3-cms-extension",
      "description": "Enetcache cache extension",
      "homepage": "https://github.com/lolli42/enetcache",
      "authors": [
        {
          "name": "Christian Kuhn",
          "role": "Developer"
        }
      ],
      "license": [
        "GPL-2.0-or-later"
      ],
      "require": {
        "typo3/cms-core": "^13"
      },
      "config": {
        "vendor-dir": ".Build/vendor",
        "bin-dir": ".Build/bin"
      },
      "require-dev": {
        "typo3/testing-framework": "^8"
      },
      "autoload": {
        "psr-4": {
          "Lolli\\Enetcache\\": "Classes"
        }
      },
      "autoload-dev": {
        "psr-4": {
          "Lolli\\Enetcache\\Tests\\": "Tests"
        }
      },
      "extra": {
        "branch-alias": {
          "dev-master": "2.x-dev"
        },
        "typo3/cms": {
          "extension-key": "enetcache",
          "web-dir": ".Build/Web"
        }
      }
    }

Note that the added properties are only in our root :file:`composer.json` file, they are ignored if the
extension is loaded as a dependency in our project. `.Build` is the
build directory. This is where our TYPO3 instance will be set up. We add `typo3/testing-framework`
(in a v13 compatible version) as a `require-dev` dependency. We add `autoload-dev` to tell composer
that there are test classes in the :file:`Tests/` directory.

Now, before we start playing around with this setup, we instruct `git` to ignore runtime
on-the-fly files. The :file:`.gitignore` file looks like this:

.. code-block:: none
   :caption: .gitignore

   .Build/
   .idea/
   Build/testing-docker/.env
   composer.lock

In :file:`.gitignore` we ignore the `.Build` directory as these are on-the-fly
files that do not belong to the extension functionality. We also ignore the
`.idea` directory where PhpStorm stores its settings.
We also ignore `Build/testing-docker/.env` - this is a test runtime file that
will be created later by :file:`runTests.sh`.
And we ignore the `composer.lock` file - we don't specify our dependency versions and
`composer install` will always fetch the youngest Core dependencies marked as
compatible in our `composer.json` file.

Let's clone the repository and run `composer install` (stripped):

.. code-block:: shell
    :emphasize-lines: 1, 10, 11

    lolli@apoc /var/www/local/git $ git clone git@github.com:lolli42/enetcache.git
    Cloning into 'enetcache'...
    X11 forwarding request failed on channel 0
    remote: Enumerating objects: 76, done.
    remote: Counting objects: 100% (76/76), done.
    remote: Compressing objects: 100% (50/50), done.
    remote: Total 952 (delta 34), reused 52 (delta 18), pack-reused 876
    Receiving objects: 100% (952/952), 604.38 KiB | 1.48 MiB/s, done.
    Resolving deltas: 100% (537/537), done.
    lolli@apoc /var/www/local/git $ cd enetcache/
    lolli@apoc /var/www/local/git/enetcache $ composer install
    Loading composer repositories with package information
    Updating dependencies (including require-dev)
    Package operations: 75 installs, 0 updates, 0 removals
      - Installing typo3/cms-composer-installers ...
      ...
      - Installing typo3/testing-framework ...
    ...
    Writing lock file
    Generating autoload files
    Generating class alias map file
    Inserting class alias loader into main autoload.php file
    lolli@apoc /var/www/local/git/enetcache $

To clean up any errors, we can always run `rm -r .Build/ composer.lock` and
call `composer install` again. In our `.Build/` folder we now have a basic
TYPO3 instance to execute our tests in:

.. code-block:: shell

    lolli@apoc /var/www/local/git/enetcache $ cd .Build/
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls
    bin  vendor  Web
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls Web/
    index.php  typo3  typo3conf
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls Web/typo3/sysext/
    backend  Core  Extbase  fluid  frontend
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls -l Web/typo3conf/ext/
    total 0
    lrwxrwxrwx 1 lolli www-data 29 Nov  5 14:19 enetcache -> /var/www/local/git/enetcache/

The package `typo3/testing-framework` that we added as a `require-dev` dependency has some basic Core
extensions set as dependencies. We end up with the Core extensions `backend`, `core`, `extbase`,
`fluid` and `frontend` in `.Build/Web/typo3/sysext`.

We now have a full TYPO3 instance. It is not installed and there is no database,
but we are now at the point where we can begin unit testing!

.. _testing-tutorial-enetcache-runtests:

runTests.sh and docker-compose.yml
----------------------------------

Next, we need to setup our tests. The two files we need are: `Build/Scripts/runTests.sh
<https://github.com/lolli42/enetcache/blob/master/Build/Scripts/runTests.sh>`_ and `Build/testing-docker/
docker-compose.yml <https://github.com/lolli42/enetcache/blob/master/Build/testing-docker/docker-compose.yml>`_.

These files are re-purposed from Core files `core Build/Scripts/runTests.sh
<https://github.com/typo3/typo3/blob/main/Build/Scripts/runTests.sh>`_ and `core Build/testing-docker/local/
docker-compose.yml <https://github.com/typo3/typo3/tree/main/Build/testing-docker/local/docker-compose.yml>`_. You can
copy and paste these files from extensions like enetcache or styleguide into your
own extension, but you may need to adapt them to your needs:

*  search for the word "enetcache" in runTests.sh and replace it with
   your extension key.
*  you may need to change the `PHP_VERSION` in runTests.sh to your minimally
   supported PHP version. (You can also specify the version on the command line
   using runTests.sh with -p.)

Let's run the unit tests:

.. code-block:: shell
    :caption: command line

    Build/Scripts/runTests.sh

You should now see something similar to this:

.. code-block:: text

    Creating network "local_default" with the default driver
    PHP 8.2.6 (cli) (built: May 13 2023 01:04:28) (NTS)
    PHPUnit 10.2.0 by Sebastian Bergmann and contributors.

    Runtime:       PHP 8.2.6
    Configuration: /var/www/mysite/typo3conf/ext/styleguide/Build/UnitTests.xml

    .                                                                   1 / 1 (100%)

    Time: 00:00.007, Memory: 12.00 MB

    OK (1 test, 5 assertions)
    Removing local_unit_run_1f529b0fb49d ... done
    Removing network local_default


If there is no test output, try changing the verbosity when you run runTests.sh:

.. code-block:: shell

   enetcache> Build/Scripts/runTests.sh -v

Use -h to see all the options:

.. code-block:: shell

   enetcache> Build/Scripts/runTests.sh -h

On some versions of MacOS :file:`runTests.sh` might produce the following error:

.. code-block:: shell

    $ ./Build/Scripts/runTests.sh
    readlink: illegal option -- f
    usage: readlink [-n] [file ...]
    Creating network "local_default" with the default driver
    ERROR: Cannot create container for service unit: invalid volume specification: '.:.:rw':
    invalid mount config for type "volume": invalid mount path: '.' mount path must be absolute
    Removing network local_default

To solve this issue follow the steps described `here <https://biercoff.com/fixing-readlink-illegal-option-f-error-on-a-mac/>`_ to install greadlink which supports the --f option.

Rather than changing the :file:`runTests.sh` to then use `greadlink` and
risk breaking your automated testing with GitHub Actions, consider symlinking
your readlink executable to the greadlink you've just installed using the following
command (as mentioned in the comments):

.. code-block:: shell

   ln -s "$(which greadlink)" "$(dirname "$(which greadlink)")/readlink"

The :file:`runTests.sh` file in enetcache comes with some additional features,
for example:

*   it is possible to execute `composer update` from inside a container
    using `Build/Scripts/runTests.sh -s composerUpdate`
*   it is possible to execute unit tests with different PHP versions
    (with the `-p` option). This is available for PHP linting too (`-s lint`).
*   similar to :ref:`Core test execution <t3contribute:testing-core-examples>`, it is possible
    to set breakpoints on tests using xdebug (`-x` option)
*   typo3gmbh containers can be updated using `runTests.sh -u`
*   verbose output is available with `-v`
*   help is available with `runTests.sh -h`

.. index:: Testing; Github Actions

.. _testing-tutorial-enetcache-github:

Github Actions
--------------

With basic testing in place, we now want automatic execution of tests whenever
something is merged to the repository. If people create pull requests for our
extension, we want to make sure our carefully crafted test setup actually
works. We'll use the Github Actions CI service for that. It's free for open
source projects. In order to tell the CI what to do, create a new workflow file
in `.github/workflows/ci.yml <https://github.com/lolli42/enetcache/blob/master/.github/workflows/ci.yml>`__

.. code-block:: yaml

   name: CI

   on: [push, pull_request]

   jobs:

     testsuite:
       name: all tests
       runs-on: ubuntu-latest
       strategy:
         matrix:
           php: [ '8.1', '8.2' ]
           minMax: [ 'composerInstallMin', 'composerInstallMax' ]
       steps:
         - name: Checkout
           uses: actions/checkout@v2

         - name: Composer
           run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s ${{ matrix.minMax }}

         - name: Composer validate
           run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s composerValidate

         - name: Lint PHP
           run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s lint

         - name: Unit tests
           run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s unit

         - name: Functional tests with mariadb
           run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d mariadb -s functional

         - name: Functional tests with postgres
           run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d postgres -s functional

         - name: Functional tests with sqlite
           run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d sqlite -s functional

We let Github Actions test the enetcache extension with several different PHP versions.
The PHP versions will also be tested with the highest and lowest compatible
dependencies (defined in `strategy.matrix.minMax`). All the steps run on the
same checkout, so we will see six test runs in total, one per PHP version with each minMax property.
Each run will do a separate checkout, `composer install`, then all the test and linting jobs we have defined.
It is possible to see executed test runs `online <https://github.com/lolli42/enetcache/actions>`_.
Green :)
Note we again use :file:`runTests.sh` to run tests. The environment our tests are executed in is
identical to our local environment and it is dockerized. The environment provided by Github Actions is only used
to set up the docker environment.


.. _testing-extensions-styleguide:

Testing styleguide
==================

The enetcache extension is an example of a common extension that has few testing
needs: it only has a couple of unit and functional tests. It is recommended to execute these tests and perhaps add PHP linting.
More ambitious testing is more difficult. We will use the `styleguide
<https://github.com/TYPO3/styleguide>`_ extension as an example. It is a normal extension but it is "core-near" - Core itself
uses the styleguide extension to test the FormEngine (using acceptance tests) and during Core development the
extension is installed as a dependency. The extension is released
to `packagist.org <https://packagist.org/packages/typo3/cms-styleguide>`_ and can be loaded as a
dependency (or require-dev dependency) in any project.

The styleguide extension follows the Core branching principle. At the time
of writing, its `main` branch is compatible with Core version 13.
Other branches are compatible with older Core versions.

Styleguide comes with more test suites than enetcache. It has functional and
acceptance tests! Our goal is to run the functional tests on different database platforms, and to
execute the acceptance tests locally, with GitHub Actions and with different PHP versions.

.. _testing-tutorial-enetcache-setup:

Basic setup
-----------

The setup is similar to enetcache (see above). We add properties to the
`composer.json <https://github.com/TYPO3/styleguide/blob/main/composer.json>`_ file to make it a valid
root composer.json defining a project. The `require-dev` section is a bit longer as we also
need `codeception <https://codeception.com/>`_ to run acceptance tests and we need to specify a couple of additional
Core extensions for the basic TYPO3 instance. We also add an `app-dir` directive in the extra section.

Next, we run another iteration of `runTests.sh <https://github.com/TYPO3/styleguide/blob/main/Build/Scripts/runTests.sh>`_
and `docker-compose.yml <https://github.com/TYPO3/styleguide/blob/main/Build/testing-docker/docker-compose.yml>`_ that is
longer than that for enetcache (to handle the functional and acceptance tests setups).

Now that this is in place we can run unit tests:

.. code-block:: shell

    git clone git@github.com:TYPO3/styleguide.git
    cd styleguide
    Build/Scripts/runTests.sh -s composerUpdate
    # Run unit tests
    Build/Scripts/runTests.sh
    # ... OK (1 test, 4 assertions)

.. _testing-tutorial-enetcache-functional:

Functional testing
------------------

At the time of writing, there is only one functional test, but it is important as
it tests crucial styleguide functionality. The extension comes with several different TCA scenarios
to demonstrate different kinds of database relations and field possibilities. To simplify testing,
the extension itself generates a page tree and demo data for all of these scenarios. Codewise, this is a huge
part of the extension and it uses alot of Core API to do the job. And yes, the generator breaks
once in a while. A perfect scenario for a `functional test!
<https://github.com/TYPO3/styleguide/blob/main/Tests/Functional/TcaDataGenerator/GeneratorTest.php>`_
(slightly stripped):

.. code-block:: php
   :caption: https://github.com/TYPO3/styleguide/blob/main/Tests/Functional/TcaDataGenerator/GeneratorTest.php

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
        * Just a dummy to show that at least one test is actually executed on mssql
        *
        * @test
        */
       public function dummy()
       {
           $this->assertTrue(true);
       }

       /**
        * @test
        * @group not-mssql
        * @todo Generator does not work using mssql DMBS yet ... fix this
        */
       public function generatorCreatesBasicRecord()
       {
           // styleguide generator uses DataHandler for some parts. DataHandler needs an
           // initialized BE user with admin right and the live workspace.
           Bootstrap::initializeBackendUser();
           $GLOBALS['BE_USER']->user['admin'] = 1;
           $GLOBALS['BE_USER']->user['uid'] = 1;
           $GLOBALS['BE_USER']->workspace = 0;
           Bootstrap::initializeLanguageObject();

           // Verify there is no tx_styleguide_elements_basic yet
           $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_styleguide_elements_basic');
           $queryBuilder->getRestrictions()->removeAll();
           $count = (int)$queryBuilder->count('uid')
               ->from('tx_styleguide_elements_basic')
               ->executeQuery()
               ->fetchOne();
           $this->assertEquals(0, $count);

           $generator = new Generator();
           $generator->create();

           // Verify there is at least one tx_styleguide_elements_basic record now
           $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_styleguide_elements_basic');
           $queryBuilder->getRestrictions()->removeAll();
           $count = (int)$queryBuilder->count('uid')
               ->from('tx_styleguide_elements_basic')
               ->executeQuery()
               ->fetchOne();
           $this->assertGreaterThan(0, $count);
       }
   }

Ah, shame on us! The data generator does not work very well if we use MSSQL as our DBMS. It is therefore marked as
`@group not-mssql` at the moment. We will need to fix that at some point. The rest is straight forward -
we extend from :php:`TYPO3\TestingFramework\Core\Functional\FunctionalTestCase`, instruct it to load
the styleguide extension (:php:`$testExtensionsToLoad`), need some additional magic for the DataHandler, then
call :php:`$generator->create();` and verify it created at least one record in one of our database tables.
That's it. It executes fine using :file:`runTests.sh`:

.. code-block:: shell

    lolli@apoc /var/www/local/git/styleguide $ Build/Scripts/runTests.sh -s functional
    Creating network "local_default" with the default driver
    Creating local_mariadb10_1 ... done
    Waiting for database start...
    Database is up
    PHP ...
    PHPUnit ... by Sebastian Bergmann and contributors.

    ..                                                                  2 / 2 (100%)

    Time: 5.23 seconds, Memory: 28.00MB

    OK (2 tests, 3 assertions)
    Stopping local_mariadb10_1 ... done
    Removing local_functional_mariadb10_run_1 ... done
    Removing local_mariadb10_1                ... done
    Removing network local_default
    lolli@apoc /var/www/local/git/styleguide $

The good thing about this test is that it actually triggers some functionality below it. It does tons of
database inserts and updates and uses the Core DataHandler for various tasks. If
something goes wrong, it throws an exception, the functional test would recognize this and fail. But if
it is green, we know that large parts of the extension are working correctly.

If we want to look at the details - for instance if we want to fix the MSSQL
issue - :file:`runTests.sh` can be called with `-x` for xdebug breakpointing.
Also, the functional test execution becomes a bit strange. We are creating
a TYPO3 test instance within the `.Build/` folder anyway. But the functional test
setup creates instances for the single tests cases. The code that is actually executed is now located in sub folder
`typo3temp/` in `.Build/`. In this test case it is `functional-9ad521a`:

.. code-block:: shell

    lolli@apoc /var/www/local/git/styleguide $ ls -l .Build/Web/typo3temp/var/tests/functional-9ad521a/
    total 16
    drwxr-sr-x 4 lolli www-data 4096 Nov  5 17:35 fileadmin
    lrwxrwxrwx 1 lolli www-data   50 Nov  5 17:35 index.php -> /var/www/local/git/styleguide/.Build/Web/index.php
    lrwxrwxrwx 1 lolli www-data   46 Nov  5 17:35 typo3 -> /var/www/local/git/styleguide/.Build/Web/typo3
    drwxr-sr-x 4 lolli www-data 4096 Nov  5 17:35 typo3conf
    lrwxrwxrwx 1 lolli www-data   40 Nov  5 17:35 typo3_src -> /var/www/local/git/styleguide/.Build/Web
    drwxr-sr-x 4 lolli www-data 4096 Nov  5 17:35 typo3temp
    drwxr-sr-x 2 lolli www-data 4096 Nov  5 17:35 uploads

This can be confusing at first, but it starts making sense the more you use it.
Also, the :file:`docker-compose.yml` file contains setup to start databases for the functional tests
and :file:`runTests.sh` is tuned to call the different scenarios.

.. _testing-tutorial-enetcache-acceptance:

Acceptance testing
------------------

You still want more! The styleguide extension adds a module in the TYPO3 backend
to the Topbar > Help section. Among other things, this module adds buttons to create and delete the demo
data that we functionally tested above. To verify this works in the backend, styleguide
comes with some straight acceptance tests in `Tests/Acceptance/Backend/ModuleCest
<https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Backend/ModuleCest.php>`_:

.. code-block:: php
   :caption: https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Backend/ModuleCest.php

    <?php
    declare(strict_types = 1);
    namespace TYPO3\CMS\Styleguide\Tests\Acceptance\Backend;

    use TYPO3\CMS\Styleguide\Tests\Acceptance\Support\BackendTester;
    use TYPO3\TestingFramework\Core\Acceptance\Helper\Topbar;

    /**
     * Tests the styleguide backend module can be loaded
     */
    class ModuleCest
    {
        /**
         * Selector for the module container in the topbar
         *
         * @var string
         */
        public static $topBarModuleSelector = '#typo3-cms-backend-backend-toolbaritems-helptoolbaritem';

        /**
         * @param BackendTester $I
         */
        public function _before(BackendTester $I)
        {
            $I->useExistingSession('admin');
        }

        /**
         * @param BackendTester $I
         */
        public function styleguideInTopbarHelpCanBeCalled(BackendTester $I)
        {
            $I->click(Topbar::$dropdownToggleSelector, self::$topBarModuleSelector);
            $I->canSee('Styleguide', self::$topBarModuleSelector);
            $I->click('Styleguide', self::$topBarModuleSelector);
            $I->switchToContentFrame();
            $I->see('TYPO3 CMS Backend Styleguide', 'h1');
        }

        /**
         * @depends styleguideInTopbarHelpCanBeCalled
         * @param BackendTester $I
         */
        public function creatingDemoDataWorks(BackendTester $I)
        {
            $I->click(Topbar::$dropdownToggleSelector, self::$topBarModuleSelector);
            $I->canSee('Styleguide', self::$topBarModuleSelector);
            $I->click('Styleguide', self::$topBarModuleSelector);
            $I->switchToContentFrame();
            $I->see('TYPO3 CMS Backend Styleguide', 'h1');
            $I->click('TCA / Records');
            $I->waitForText('TCA test records');
            $I->click('Create styleguide page tree with data');
            $I->waitForText('A page tree with styleguide TCA test records was created.', 300);
        }

        /**
         * @depends creatingDemoDataWorks
         * @param BackendTester $I
         */
        public function deletingDemoDataWorks(BackendTester $I)
        {
            $I->click(Topbar::$dropdownToggleSelector, self::$topBarModuleSelector);
            $I->canSee('Styleguide', self::$topBarModuleSelector);
            $I->click('Styleguide', self::$topBarModuleSelector);
            $I->switchToContentFrame();
            $I->see('TYPO3 CMS Backend Styleguide', 'h1');
            $I->click('TCA / Records');
            $I->waitForText('TCA test records');
            $I->click('Delete styleguide page tree and all styleguide data records');
            $I->waitForText('The styleguide page tree and all styleguide records were deleted.', 300);
        }
    }

There are three tests. One verifies that the backend module can be called, one
creates demo data and one deletes the demo data. The codeception setup needs more setup. The entry point
is the main `codeception.yml file <https://github.com/TYPO3/styleguide/blob/main/Tests/codeception.yml>`_
extended by the `backend suite <https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Backend.suite.yml>`_,
a `backend tester <https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Support/BackendTester.php>`_ and
a `codeception bootstrap extension
<https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Support/Extension/BackendStyleguideEnvironment.php>`_
that instructs the basic `typo3/testing-framework` acceptance bootstrap to load the styleguide extension and
some database fixtures to easily log in to the backend. In addition, the :file:`runTests.sh` and
:file:`docker-compose.yml` files take care of adding selenium-chrome and a web
server to execute the tests:

.. code-block:: shell

    lolli@apoc /var/www/local/git/styleguide $ Build/Scripts/runTests.sh -s acceptance
    Creating network "local_default" with the default driver
    Creating local_chrome_1    ... done
    Creating local_web_1       ... done
    Creating local_mariadb10_1 ... done
    Waiting for database start...
    Database is up
    Codeception PHP Testing Framework ...
    Powered by PHPUnit ... by Sebastian Bergmann and contributors.
    Running with seed:


      Generating BackendTesterActions...

    TYPO3\CMS\Styleguide\Tests\Acceptance\Support.Backend Tests (3) -------------------------------------------------------
    Modules: WebDriver, \TYPO3\TestingFramework\Core\Acceptance\Helper\Acceptance, \TYPO3\TestingFramework\Core\Acceptance\Helper\Login, Asserts
    -----------------------------------------------------------------------------------------------------------------------
    ⏺ Recording ⏺ step-by-step screenshots will be saved to /var/www/local/git/styleguide/Tests/../.Build/Web/typo3temp/var/tests/AcceptanceReports/
    Directory Format: record_5be078fb43f86_{filename}_{testname} ----

      Database Connection: {"Connections":{"Default":{"driver":"mysqli","dbname":"func_test_at","host":"mariadb10","user":"root","password":"funcp"}}}
      Loaded Extensions: ["core","extbase","fluid","backend","about","install","frontend","typo3conf/ext/styleguide"]
    ModuleCest: Styleguide in topbar help can be called

    ...

    Time: 27.89 seconds, Memory: 28.00MB

    OK (3 tests, 6 assertions)
    Stopping local_mariadb10_1 ... done
    Stopping local_chrome_1    ... done
    Stopping local_web_1       ... done
    Removing local_acceptance_backend_mariadb10_run_1 ... done
    Removing local_mariadb10_1                        ... done
    Removing local_chrome_1                           ... done
    Removing local_web_1                              ... done
    Removing network local_default

Ok, this setup took a bit more effort, but we end up with a browser automatically clicking things in
an ad-hoc TYPO3 instance to verify that this extension can perform its job. If something goes wrong, screenshots
of the failed run can be found in :file:`.Build/Web/typo3temp/var/tests/AcceptanceReports/`.

.. _testing-tutorial-enetcache-github2:

Github Actions
--------------

Now we want all of this checked automatically by Github Actions. As before, we
define the jobs in `.github/workflows/tests.yml <https://github.com/TYPO3/styleguide/blob/main/.github/workflows/tests.yml>`__:

.. code-block:: yaml

    name: tests

    on:
      push:
      pull_request:
      schedule:
        - cron:  '42 5 * * *'

    jobs:
      testsuite:
        name: all tests
        runs-on: ubuntu-20.04
        strategy:
          # This prevents cancellation of matrix job runs, if one or more already failed
          # and let the remaining matrix jobs be executed anyway.
          fail-fast: false
          matrix:
            php: [ '8.1', '8.2' ]
        steps:
          - name: Checkout
            uses: actions/checkout@v3

          - name: Install dependencies
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s composerUpdate

          - name: Composer validate
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s composerValidate

          - name: Lint PHP
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s lint

          - name: CGL
            run: Build/Scripts/runTests.sh -n -p ${{ matrix.php }} -s cgl

          - name: phpstan
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s phpstan -e "--error-format=github"

          - name: Unit Tests
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -s unit

          - name: Functional Tests with mariadb and mysqli
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d mariadb -a mysqli -s functional

          - name: Functional Tests with mariadb and pdo_mysql
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d mariadb -a pdo_mysql -s functional

          - name: Functional Tests with mysql and mysqli
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d mysql -a mysqli -s functional

          - name: Functional Tests with mysql and pdo_mysql
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d mysql -a pdo_mysql -s functional

          - name: Functional Tests with postgres
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d postgres -s functional

          - name: Functional Tests with sqlite
            run: Build/Scripts/runTests.sh -p ${{ matrix.php }} -d sqlite -s functional

          - name: Build CSS
            run: Build/Scripts/runTests.sh -s buildCss

This is similar to the enetcache example but does more. The functional tests are executed
with three different DBMS (MariaDB, Postgres, sqlite), and the acceptance tests are executed as well.
This will take some time to complete on Github Actions - but `it's green <https://github.com/TYPO3/styleguide/actions>`_!
