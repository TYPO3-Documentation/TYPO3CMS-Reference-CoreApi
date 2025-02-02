.. include:: /Includes.rst.txt
.. _testing-tutorial-enetcache:

=================
Testing enetcache
=================

..  contents:: Table of contents

.. _testing-tutorial-enetcache-introduction:

Introduction
============

As an extension author, it is likely that you may want to test your extension during its development.
This chapter details how extension authors can set up automatic extension testing. We'll do that with
two examples. Both embed the given extension in a TYPO3 instance and run tests within this environment,
both examples also configure GitHub Actions to execute tests. We'll use Docker containers for test execution again and use
an extension specific :file:`runTests.sh` script for executing test setup and execution.

.. _testing-tutorial-enetcache-scope:

Scope
=====

About this chapter and what it does *not* cover, first.

* This documentation assumes an extension is tested with only one major Core version. It
  does not support extension testing with multiple target Core versions (though that is
  possible).
  The Core Team encourages extension developers to have dedicated Core branches
  per Core version. This has various advantages, it is for instance easy to create deprecation
  free extensions this way.

* We assume a Composer based setup. Extensions should provide a :file:`composer.json <extension-composer-json>`
  file anyway and using Composer for extension testing is quite convenient.

* Similar to Core testing, this documentation relies on docker and docker-compose. See the
  :ref:`Core testing requirements <t3contribute:testing-core-dependencies>` for more details.

* We assume your extensions code is located within github and automatic testing is carried out using GitHub Actions.
  The integration of GitHub Actions into github is easy to set up with plenty of documentation already available.
  If your extensions code is located elsewhere or a different CI is used, this chapter may still be of use
  in helping you build a general understanding of the testing process.

.. _testing-tutorial-enetcache-strategy:

General strategy
================

Third party extensions often rely on TYPO3 Core extensions to add key functionality.

If a project needs a TYPO3 extension, it will add the required extension using `composer require`
to its own root composer.json file. The extensions composer.json then specifies additional detail, for
instance which PHP class namespaces it provides and where they can be found. This properly
integrates the extension into the project and the project then "knows" the location of extension
classes.

If we want to test extension code directly, we do a similar change: We turn the :file:`composer.json <extension-composer-json>`
file of the extension into a `root composer.json file <https://getcomposer.org/doc/04-schema.md#root-package>`_.
That file then serves two needs at the same time: It is used by projects that require the extension
as a dependency and it is used as the root composer.json to specify dependencies turning the extension
into a project on its own for testing. The latter allows us to set up a full TYPO3
environment in a sub folder of the extension and execute the tests within this sub folder.

.. _testing-tutorial-enetcache-testing:

Testing enetcache
=================

The extension `enetcache <https://github.com/lolli42/enetcache>`_ is a small extension that helps
with frontend plugin based caches. It has been available as Composer package and a TER extension for quite
some time and is loosely maintained to keep up with current Core versions.

The following is based on the current (May, 2023) main branch of enetcache,
later versions may be structured differently.

This main branch:

*   supports TYPO3 v11 and TYPO3 v12
*   requires typo3/testing-framework v7 (which supports v11 and v12)

Older versions of this extension were structured differently, each branch of
the extension supported only one TYPO3 version:

* `1.2` compatible with Core v7, released to TER as 1.x.y

* `2` compatible with Core v8, released to TER as 2.x.y

* `master` compatible with Core v9, released to TER as 3.x.y

On this page, we focus on testing one TYPO3 version at a time though it is
possible to support and test 2 TYPO3 versions in one branch with the
typo3/testing-framework and enetcache does this. But, for the sake of simplicity
we describe the simpler use case here.

The enetcache extension comes with a couple of unit tests
in `Tests/Unit`, we want to run these locally and by GitHub Actions, along with
some PHP linting to verify there is no fatal PHP error.

.. _testing-tutorial-enetcache-start:

Starting point
--------------

As outlined in the general strategy, we need to extend the existing :file:`composer.json <extension-composer-json>` file by
adding some root composer.json specific things. This does not harm the functionality of the existing
composer.json properties if the extension is a project dependency and not used as root composer.json:
Root properties are ignored in Composer if the file is not used as root project file, see the
notes "root-only" of the `Composer documentation <https://getcomposer.org/doc/04-schema.md>`_ for details.

This is how the composer.json file looks before we add a test setup:

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

This is a typical composer.json file without any complexity: It's a `typo3-cms-extension`, with an
author and a license. We are stating that "I need at least 13.0.0 of cms-core" and we tell the autoloader
"find all class names starting with :php:`Lolli\Enetcache` in the Classes/ directory".

The extension already contains some unit tests that extend `typo3/testing-framework`'s base
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

Now let's add our properties to put these tests into action. First, we add a series of properties
to :file:`composer.json <extension-composer-json>`
to add root :file:`composer.json` details, turning the extension into a project at the same time:

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

Note all added properties are only used within our root :file:`composer.json` files, they are ignored if the
extension is loaded as a dependency in our project. Note: We specify `.Build` as
build directory. This is where our TYPO3 instance will be set up. We add `typo3/testing-framework`
in a v13 compatible version as `require-dev` dependency. We add a `autoload-dev` to tell composer
that test classes are found in the :file:`Tests/` directory.

Now, before we start playing around with this setup, we instruct `git` to ignore runtime
on-the-fly files. The :file:`.gitignore` looks like this:

.. code-block:: none
   :caption: .gitignore

   .Build/
   .idea/
   Build/testing-docker/.env
   composer.lock

We ignore the entire `.Build` directory, these are on-the-fly files that do not belong to the extension
functionality. We also ignore the `.idea` directory - this is a directory where PhpStorm stores its settings.
We also ignore `Build/testing-docker/.env` - this is a test runtime file created by :file:`runTests.sh` later.
And we ignore the `composer.lock` file: We don't specify our dependency versions and a
`composer install` will later always fetch for instance the youngest Core dependencies marked as
compatible in our `composer.json` file.

Let's clone that repository and call `composer install` (stripped):

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

To clean up any errors created at this point, we can always run `rm -r .Build/ composer.lock` later and
call `composer install` again. We now have a basic TYPO3 instance in our `.Build/` folder to execute
our tests in:

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

The package `typo3/testing-framework` that we added as `require-dev` dependency has some basic Core
extensions set as dependency, we end up with the Core extensions `backend`, `core`, `extbase`,
`fluid` and `frontend` in `.Build/Web/typo3/sysext`.

We now have a full TYPO3 instance. It is not installed, there is no database, but we are now at the point
to begin unit testing!

.. _testing-tutorial-enetcache-runtests:

runTests.sh and docker-compose.yml
----------------------------------

Next we need to setup our tests. These are the two files we need: `Build/Scripts/runTests.sh
<https://github.com/lolli42/enetcache/blob/master/Build/Scripts/runTests.sh>`_ and `Build/testing-docker/
docker-compose.yml <https://github.com/lolli42/enetcache/blob/master/Build/testing-docker/docker-compose.yml>`_.

These files are re-purposed from TYPO3's Core: `core Build/Scripts/runTests.sh
<https://github.com/typo3/typo3/blob/main/Build/Scripts/runTests.sh>`_ and `core Build/testing-docker/local/
docker-compose.yml <https://github.com/typo3/typo3/tree/main/Build/testing-docker/local/docker-compose.yml>`_. You can
copy and paste these files from extensions like enetcache or styleguide to your own extension, but you should then look
through the files and adapt to your needs, for example.

*  search for the word "enetcache" in runTests.sh and replace it with
   your extension key.
*  You may want to change the `PHP_VERSION` in runTests.sh to your minimally
   supported PHP version. (You can also specify the version on the command line
   using runTests.sh with -p.)

Let's run the unit tests:

.. code-block:: shell
    :caption: command line

    Build/Scripts/runTests.sh

You may now see something similar to this:

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

Use -h to see all options:

.. code-block:: shell

   enetcache> Build/Scripts/runTests.sh -h

On some versions of MacOS you might get the following error message when executing :file:`runTests.sh`:

.. code-block:: shell

    $ ./Build/Scripts/runTests.sh
    readlink: illegal option -- f
    usage: readlink [-n] [file ...]
    Creating network "local_default" with the default driver
    ERROR: Cannot create container for service unit: invalid volume specification: '.:.:rw':
    invalid mount config for type "volume": invalid mount path: '.' mount path must be absolute
    Removing network local_default

To solve this issue follow the steps described `here <https://biercoff.com/fixing-readlink-illegal-option-f-error-on-a-mac/>`_ to install greadlink which supports the needed --f option.

Rather than changing the :file:`runTests.sh` to then use `greadlink` and thus risk breaking your automated testing via GitHub Actions consider symlinking your readlink executable to the newly installed greadlink with the following command as mentioned in the comments:

.. code-block:: shell

   ln -s "$(which greadlink)" "$(dirname "$(which greadlink)")/readlink"

The :file:`runTests.sh` file of enetcache comes with some additional features,
for example:

*   it is possible to execute `composer update` from within a container
    using `Build/Scripts/runTests.sh -s composerUpdate`
*   it is possible to execute unit tests with a several different PHP versions
    (with the `-p` option). This is available for PHP linting, too (`-s lint`).
*   Similar to :ref:`Core test execution <t3contribute:testing-core-examples>` it is possible
    to break point tests using xdebug (`-x` option)
*   typo3gmbh containers can be updated using `runTests.sh -u`
*   verbose output is available with `-v`
*   help is available with `runTests.sh -h`

.. index:: Testing; Github Actions

.. _testing-tutorial-enetcache-github:

Github Actions
--------------

With basic testing in place we now want automatic execution of tests whenever something is merged to the repository and if
people create pull requests for our extension, we want to make sure our carefully crafted test setup actually
works. We'll use the CI service of Github Actions to take care of
that. It's free for open source projects.
In order to tell the CI what to do, create a new workflow file in `.github/workflows/ci.yml <https://github.com/lolli42/enetcache/blob/master/.github/workflows/ci.yml>`__

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

In case of enetcache, we let Github Actions test the extension with the several PHP versions.
Each of these PHP Versions will also be tested with the highest and lowest compatible dependencies (defined in `strategy.matrix.minMax`).
All defined steps run on the same checkout, so we will see six test runs in total, one per PHP version with each minMax property.
Each run will do a separate checkout, `composer install` first, then all the test and linting jobs we defined.
It's possible to see executed test runs `online <https://github.com/lolli42/enetcache/actions>`_.
Green :)
Note we again use :file:`runTests.sh` to actually run tests. So the environment our tests are executed in is
identical to our local environment. It's all dockerized. The environment provided by Github Actions is only used
to set up the docker environment.


.. _testing-extensions-styleguide:

Testing styleguide
==================

The above enetcache extension is an example for a common extension that has few testing
needs: It just comes with a couple of unit and functional tests. Executing these and maybe adding PHP linting is recommended.
More ambitious testing needs additional effort. As an example, we pick the `styleguide
<https://github.com/TYPO3/styleguide>`_ extension. This extension is developed "core-near", Core itself
uses styleguide to test various FormEngine details with acceptance tests and if developing Core, that
extension is installed as a dependency by default. However, styleguide is just a casual extension: It is released
to composer's `packagist.org <https://packagist.org/packages/typo3/cms-styleguide>`_ and can be loaded as
dependency (or require-dev dependency) in any project.

The styleguide extension follows the Core branching principle, too: At the time of this writing, its `main`
branch is dedicated to be compatible with Core version 13. There are branches compatible with older Core versions, too.

In comparison to enetcache, styleguide comes with additional test suites: It has functional and
acceptance tests! Our goal is to run the functional tests with different database platforms, and to
execute the acceptance tests. Both locally and by GitHub Actions and with different PHP versions.

.. _testing-tutorial-enetcache-setup:

Basic setup
-----------

The setup is similar to what has been outlined in detail with enetcache above: We add properties to the
`composer.json <https://github.com/TYPO3/styleguide/blob/main/composer.json>`_ file to make it a valid
root composer.json defining a project. The `require-dev` section is a bit longer as we also
need `codeception <https://codeception.com/>`_ to run acceptance tests and specify a couple of additional
Core extensions for a basic TYPO3 instance. We additionally add an `app-dir` directive in the extra section.

Next, we have another iteration of `runTests.sh <https://github.com/TYPO3/styleguide/blob/main/Build/Scripts/runTests.sh>`_
and `docker-compose.yml <https://github.com/TYPO3/styleguide/blob/main/Build/testing-docker/docker-compose.yml>`_ that are
longer than the versions of enetcache to handle the functional and acceptance tests setups, too.

With this in place we can run unit tests:

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

At the time writing, there is only a single functional test, but this one is important as
it tests crucial functionality within styleguide: The extension comes with several different TCA scenarios
to show all sorts of database relation and field possibilities supported within TYPO3. To simplify testing,
code can generate a page tree and demo data for all of these scenarios. Codewise, this is a huge
section of the extension and it uses quite some Core API to do its job. And yes, the generator breaks
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

Ah, shame on us! The data generator does not work well if executed using MSSQL as our DBMS. It is thus marked as
`@group not-mssql` at the moment. We need to fix that at some point. The rest is rather straight forward:
We extend from :php:`TYPO3\TestingFramework\Core\Functional\FunctionalTestCase`, instruct it to load
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

The good thing about this test is that it actually triggers quite some functionality below. It does tons of
database inserts and updates and uses the Core DataHandler for various details. If something goes wrong in
this entire area, it would throw an exception, the functional test would recognize this and fail. But if
its green, we know that a large parts of that extension are working correctly.

If looking at details - for instance if we try to fix the MSSQL issue - :file:`runTests.sh` can be called with `-x`
again for xdebug break pointing. Also, the functional test execution becomes a bit funny: We are creating
a TYPO3 test instance within `.Build/` folder anyway. But the functional test setup again creates instances
for the single tests cases. The code that is actually executed is now located in a sub folder
of `typo3temp/` of `.Build/`, in this test case it is `functional-9ad521a`:

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
Also, the :file:`docker-compose.yml` file contains a setup to start needed databases for the functional tests
and :file:`runTests.sh` is tuned to call the different scenarios.

.. _testing-tutorial-enetcache-acceptance:

Acceptance testing
------------------

Not enough! The styleguide extension adds a module to the TYPO3 backend to the Topbar > Help section.
Next to other things, this module adds buttons to create and delete the demo
data that has been functional tested above already. To verify this works in the backend as well, styleguide
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

There are three tests: One verifies the backend module can be called, one creates demo data, the last
one deletes demo data again. The codeception setup needs a bit more attention to setup, though. The entry point
is the main `codeception.yml file <https://github.com/TYPO3/styleguide/blob/main/Tests/codeception.yml>`_
extended by the `backend suite <https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Backend.suite.yml>`_,
a `backend tester <https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Support/BackendTester.php>`_ and
a `codeception bootstrap extension
<https://github.com/TYPO3/styleguide/blob/main/Tests/Acceptance/Support/Extension/BackendStyleguideEnvironment.php>`_
that instructs the basic `typo3/testing-framework` acceptance bootstrap to load the styleguide extension and
have some database fixtures included to easily log in to the backend. Additionally, the :file:`runTests.sh` and
:file:`docker-compose.yml` files take care of adding selenium-chrome and a web server to actually execute the tests:

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

Ok, this setup is a bit more effort, but we end up with a browser automatically clicking things in
an ad-hoc TYPO3 instance to verify this extension can perform its job. If something goes wrong, screenshots
of the failed run can be found in :file:`.Build/Web/typo3temp/var/tests/AcceptanceReports/`.

.. _testing-tutorial-enetcache-github2:

Github Actions
--------------

Now we want all of this automatically checked using Github Actions. As before, we define the jobs in `.github/workflows/tests.yml <https://github.com/TYPO3/styleguide/blob/main/.github/workflows/tests.yml>`__:

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

This is similar to the enetcache example, but does some more: The functional tests are executed
with three different DBMS (MariaDB, Postgres, sqlite), and the acceptance tests are executed, too.
This setup takes some time to complete on Github Actions. But, `it's green <https://github.com/TYPO3/styleguide/actions>`_!
