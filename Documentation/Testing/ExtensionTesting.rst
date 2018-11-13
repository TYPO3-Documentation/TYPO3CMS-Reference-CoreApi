.. include:: ../Includes.txt

.. _testing-extensions:

=================
Extension testing
=================

Introduction
============

Extension authors want to test their extension code, too. This is great and the TYPO3 core
tries to support this. This chapter goes into details how extension authors can set up
automatic extension testing. We'll do that with two examples. Both embed the given extension
in a TYPO3 instance and run tests within this environment, both examples also configure
Travis CI to execute tests. We'll use docker containers for test execution again and use
an extension specific runTests.sh script piloting test setup and execution.


Scope
=====

Let us talk about some boundaries and what this documentation does *not* do, first.

* This documentation assumes an extension is tested with only one major core version. It
  does not support extension testing with multiple target core versions. Extensions that
  support multiple core versions at the same time in the same branch are *not* scope of this document.
  The core team encourages extension developers to have dedicated core branches
  per core version. This has various advantages, it is for instance easy to create deprecation
  free extensions this way.

  Your mileage may vary. That's ok. If you need test setups for an extension that supports
  multiple major core versions at the same time, you may however run into trouble if using
  the `typo3/testing-framework <https://github.com/TYPO3/testing-framework>`_ package. The
  development of that package is closely bound to core development and has a relatively high
  development speed. It does contain breaking patches per major core versions, but it should
  not contain breaking patches for existing major core branches. If you now set up testing
  using typo3/testing-framework with TYPO3 core version 9, it should not break within v9
  lifetime. But it probably will break if you upgrade to version 10 later and may need adaption
  in extension code or setup procedures.

  If you are looking for test setups that support multiple core versions at once,
  `nimut/testing-framework <https://github.com/Nimut/testing-framework>`_ may better suit your
  needs. This is however out of scope of this document.

* This documentation relies on TYPO3 core version 9 (and up). It is very well possible to
  run tests using older core versions and various extensions do that for years already. This
  is however out of scope of this document.

* We assume a composer based setup. Extensions should nowadays provide a :file:`composer.json`
  file anyway and using composer for extension testing is quite convenient.

* Similar to core testing, this documentation relies an docker and docker-compose. See the
  :ref:`core testing requirements <testing-core-dependencies>` for more details.

* We assume extension code is located at github and automatic testing is done using Travis CI.
  The integration of Travis CI into github is dead simple. If your extension code is elsewhere
  or a different CI should be used, you need to figure out details on your own but may very well
  use this document as inspiration since the strategies may be similar.


General strategy
================

TYPO3 extensions usually do not work without some TYPO3 core extensions. Extensions embed into
TYPO3 core, so depending on what an extension does, a series of core extensions is required to
successfully execute extension tests.

If a project needs some TYPO3 extension, it typically adds the extension using `composer require`
to its own root composer.json file. The extension`s composer.json then specifies some details, for
instance which PHP class namespaces it provides and where those can be found. This properly
integrates the extension into the project and the project then "knows" location of extension
classes.

If we want to test extension code directly, we do a similar change: We turn the :file:`composer.json`
file of the extension into a `root composer.json file <https://getcomposer.org/doc/04-schema.md#root-package>`_.
That file then serves two needs at the same time: It is used by projects that require the extension
as dependency, and it is used as root composer.json to specify dependencies turning the extension
into a project on its own for testing. The latter allows us to basically set up a full TYPO3
environment in some sub folder of the extension and execute the tests within this sub folder.


Testing enetcache
=================

The extension `enetcache <https://github.com/lolli42/enetcache>`_ is a tiny extension that helps
with frontend plugin based caches. It is available as composer package and TER extension for quite
some time already and is loosely maintained to keep up with current core versions. At the time of this
writing, it has three branches:

* `1.2` compatible with core v7, released to TER as 1.x.y

* `2` compatible with core v8, released to TER as 2.x.y

* `master` compatible with core v9, released to TER as 3.x.y

Branch master will be branched later as `3` when core version 10 gains traction. This document
focuses on the master / core v9 compatible branch. The extension comes with a couple of unit tests
in `Tests/Unit`, we want to run these locally and in travis-ci, along with some PHP linting to verify
there is no fatal PHP error. We'll test that extension with both PHP 7.2 and PHP 7.3 - the two PHP
versions current TYPO3 core v9 supports as well at the time of this writing.

Starting point
--------------

As outlined in the general strategy, we need to extend the existing :file:`composer.json` file by
adding some root composer.json specific things. This does not harm the functionality of the existing
composer.json properties if the extension is a project dependency and not used as root composer.json:
Root properties are ignored in composer if the file is not used as root project file, see the
notes "root-only" of the `composer documentation <https://getcomposer.org/doc/04-schema.md>`_ for details.

Here is how the composer.json file looked like before we added a test setup:

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
        "typo3/cms-core": "^9.5"
      },
      "autoload": {
        "psr-4": {
          "Lolli\\Enetcache\\": "Classes"
        }
      },
      "replace": {
        "enetcache": "self.version",
        "typo3-ter/enetcache": "self.version"
      },
      "extra": {
        "branch-alias": {
          "dev-master": "2.x-dev"
        },
        "typo3/cms": {
          "cms-package-dir": "{$vendor-dir}/typo3/cms",
        }
      }
    }

This is a typical composer.json file without much fanciness: It's a `typo3-cms-extension`, some
author and license information, a "I need at least 9.5.0 of cms-core" dependency, and a
"hey autoloader, find class names starting with :php:`Lolli\Enetcache` in the Classes/ directory" specification.

The extension already contains some unit tests that extend form typo3/testing-framework`s base
unit test class in directory :file:`Tests/Unit/Hooks` (stripped)::

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

Preparing composer.json
-----------------------

Now let's add things to put these tests into action. First, we add a series of properties to :file:`composer.json`
to add root composer.json details, turning the extension into a project at the same time:

.. code-block:: json
    :emphasize-lines: 18-24, 30-34, 39-43, 50-51

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
        "typo3/cms-core": "^9.5"
      },
      "config": {
        "vendor-dir": ".Build/vendor",
        "bin-dir": ".Build/bin"
      },
      "require-dev": {
        "typo3/testing-framework": "^4.11.1"
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
      "replace": {
        "enetcache": "self.version",
        "typo3-ter/enetcache": "self.version"
      },
      "scripts": {
        "post-autoload-dump": [
          "TYPO3\\TestingFramework\\Composer\\ExtensionTestEnvironment::prepare"
        ]
      },
      "extra": {
        "branch-alias": {
          "dev-master": "2.x-dev"
        },
        "typo3/cms": {
          "cms-package-dir": "{$vendor-dir}/typo3/cms",
          "web-dir": ".Build/Web",
          "extension-key": "enetcache"
        }
      }
    }

Note all added properties are only used within root composer.json files, they are ignored if the
extension is loaded as dependency in a project. Have a look at details: We specify `.Build` as
build directory. This is where our TYPO3 instance will be set up. We add `typo3/testing-framework`
in a v9 compatible version as `require-dev` dependency. We add a `autoload-dev` to tell composer
that test classes are found in the `Tests` directory. Easy. In the `scripts` section we add a composer
hook. This one is interesting. That class of the testing framework links the main directory as
extension `.Build/Web/typo3conf/ext/enetcache` in our extension specific TYPO3 instance. It needs the
two additional properties `web-dir` and `extension-key` to do that.

Now, before we start playing around with this setup, we instruct `git` to ignore runtime
on-the-fly files. The :file:`.gitignore` looks like this::

    .Build/
    .idea/
    Build/testing-docker/.env
    composer.lock

We ignore the entire `.Build` directory, these are on-the-fly files that do not belong to the extension
functionality. We also ignore the `.idea` directory - this is a directory where PhpStorm parks its stuff.
We also ignore `Build/testing-docker/.env` - this is a test runtime file created by `runTests.sh` later.
And we ignore the `composer.lock` file: We don't hard nail our dependency versions and a
`composer install` will later always fetch for instance the youngest core dependencies marked as
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
      - Installing typo3/cms-composer-installers (v2.2.1): Loading from cache
      ...
      - Installing typo3/testing-framework (4.11.1): Loading from cache
    ...
    Writing lock file
    Generating autoload files
    Generating class alias map file
    Inserting class alias loader into main autoload.php file
    > TYPO3\TestingFramework\Composer\ExtensionTestEnvironment::prepare
    lolli@apoc /var/www/local/git/enetcache $

To clean up any mess created at this point, we can always `rm -r .Build/ composer.lock` later and
call `composer install` again. We now have a basic TYPO3 instance in `.Build/` folder to execute
our tests in:

.. code-block:: shell

    lolli@apoc /var/www/local/git/enetcache $ cd .Build/
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls
    bin  vendor  Web
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls Web/
    index.php  typo3  typo3conf
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls Web/typo3/sysext/
    backend  core  extbase  fluid  frontend  recordlist
    lolli@apoc /var/www/local/git/enetcache/.Build $ ls -l Web/typo3conf/ext/
    total 0
    lrwxrwxrwx 1 lolli www-data 29 Nov  5 14:19 enetcache -> /var/www/local/git/enetcache/

The package `typo3/testing-framework` that we added as `require-dev` dependency has some basic core
extensions set as dependency, we end up with the core extensions `backend`, `core`, `extbase`,
`fluid`, `frontend` and `recordlist` in `.Build/Web/typo3/sysext`. Additionally, the
:php:`ExtensionTestEnvironment` hook linked our git root checkout as extension into `.Build/Web/typo3conf/ext`.

So yep, that's a full TYPO3 instance. It is not installed, there is no database, but that is good
enough for unit testing!

runTests.sh and docker-compose.yml
----------------------------------

Next we need the setup to actually run tests. These are the two files `Build/Scripts/runTests.sh
<https://github.com/lolli42/enetcache/blob/master/Build/Scripts/runTests.sh>`_ and `Build/testing-docker/
docker-compose.yml <https://github.com/lolli42/enetcache/blob/master/Build/testing-docker/docker-compose.yml>`_.

These files are simplified rip-off versions of similar files from the TYPO3 core: `core Build/Scripts/runTests.sh
<https://github.com/TYPO3/TYPO3.CMS/blob/master/Build/Scripts/runTests.sh>`_ and `core Build/testing-docker/local/
docker-compose.yml <https://github.com/TYPO3/TYPO3.CMS/tree/master/Build/testing-docker/local>`_. You can
copy + paste these files from extensions like enetcache or styleguide to your own extension, but should then look
through the files and adapt to your needs (for instance search for the word "enetcache" in runTests.sh if you
copy from there).

Let's run the tests:

.. code-block:: shell

    lolli@apoc /var/www/local/git/enetcache $ Build/Scripts/runTests.sh
    Creating network "local_default" with the default driver
    PHP 7.2.11-3+ubuntu18.04.1+deb.sury.org+1 (cli) (built: Oct 25 2018 06:44:08) ( NTS )
    PHPUnit 7.1.5 by Sebastian Bergmann and contributors.

    .....SS                                                             7 / 7 (100%)

    Time: 84 ms, Memory: 12.00MB

    OK, but incomplete, skipped, or risky tests!
    Tests: 7, Assertions: 56, Skipped: 2.
    Removing local_unit_run_1 ... done
    Removing network local_default

Done. That's it. Execution of your extension`s unit tests. The :file:`runTests.sh` file of enetcache comes
with some additional goodies, for example it is possible to execute `composer install` from within a container
using `Build/Scripts/runTests.sh -s composerInstall`, it is possible to execute unit tests with PHP 7.3 instead
of 7.2 (option `-p 7.3`). This is available for PHP linting, too (`-s lint`). Similar to :ref:`core test execution
<testing-core-examples>` it is possible to break point tests using xdebug (`-x` option), typo3gmbh containers
can be updated using `runTests.sh -u`, verbose output is available with `-v` and a help is available
with `runTests.sh -h`. Have a look around.

Travis CI
---------

With basic testing in place we want execution of tests whenever something is merged to the repository and if
people create pull requests for our happy little extension to make sure our carefully crafted test setup actually
works all the time. We'll use the continuous integration service `Travis CI <https://travis-ci.org/>`_ to take care of
that. It's free for open source projects. So, log in to travis using your github account. After login, the
user settings page will list all your github repositories and travis-ci can be enabled with one click for single
repositories. All we need is a :file:`.travis.yml` file in the `root directory
<https://github.com/lolli42/enetcache/blob/master/.travis.yml>`_ of our extension telling travis-ci what
exactly should be done:

.. code-block:: yaml

    language: php

    php:
      - 7.2
      - 7.3

    sudo: true

    cache:
      directories:
        - $HOME/.composer/cache

    before_script:
      - Build/Scripts/runTests.sh -s composerInstall -p $TRAVIS_PHP_VERSION

    script:
      - >
        echo "Running composer validate"
        Build/Scripts/runTests.sh -s composerValidate -p $TRAVIS_PHP_VERSION
      - >
        echo "Running unit tests";
        Build/Scripts/runTests.sh -s unit -p $TRAVIS_PHP_VERSION
      - >
        echo "Running php lint";
        Build/Scripts/runTests.sh -s lint -p $TRAVIS_PHP_VERSION

In case of enetcache, we let Travis CI test the extension with the two PHP versions 7.2 and 7.3. Travis exposes
the current version as variable `$TRAVIS_PHP_VERSION`, so we use that to feed it to `runTests.sh`. We instruct
Travis to always `composer install` first, then run the test suites `composer validate`, the unit testing
and the PHP linting. It's possible to see executed test runs `online <https://travis-ci.org/lolli42/enetcache>`_.
Green :) Maybe it's now time to add the `travis-ci status badge <https://docs.travis-ci.com/user/status-images/>`_
to our README.md file.

Note we again use :file:`runTests.sh` to actually run tests. So the environment our tests are executed in is
identical to our local environment. It's all dockerized. We don't care about the PHP versions travis-ci loaded
and installed for us too much. Travis CI needs the setting `sudo: true` to allow starting own containers, though.

Travis CI comes with tons of further options and possibilities. If you for instance want to run multiple jobs
in parallel check out `Travis' Build Stages feature <https://docs.travis-ci.com/user/build-stages/>`_.


.. _testing-extensions-styleguide:

Testing styleguide
==================

The above enetcache extension is an example for a casual in-the-wild extension that has rather low testing
needs: It just comes with a couple of unit tests. Executing these and maybe adding PHP linting is good to go.
More ambitious testing needs slightly more effort, though. As example, we pick the `styleguide
<https://github.com/TYPO3/styleguide>`_ extension. This extension is developed "core near", core itself
uses styleguide to test various FormEngine details with acceptance tests, and if developing core, that
extension is installed as dependency by default. However, styleguide is just a casual extension: It is released
to composer's `packagist.org <https://packagist.org/packages/typo3/cms-styleguide>`_ and can be loaded as
dependency (or require-dev dependency) in any project.

The styleguide extension follows the core branching principle, too: At the time of this writing, it's "master"
branch is dedicated to be compatible with core version 9. This will change later if core v10 gains traction,
and there are branches compatible with older core versions.

In comparison to enetcache, styleguide comes with additional test suites: It has functional and
acceptance tests! Our goal is to run the functional tests with different database platforms, and to
execute the acceptance tests. Both locally and on travis-ci and with different PHP versions.

Basic setup
-----------

The setup is similar to what has been outlined in detail with enetcache above: We add properties to the
`composer.json <https://github.com/TYPO3/styleguide/blob/master/composer.json>`_ file to make it a valid
root composer.json defining a project. The `require-dev` section is a bit longer since we additionally
need `codeception <https://codeception.com/>`_ to run acceptance tests, and specify a couple of additional
core extensions for a basic TYPO3 instance. We additionally add an `app-dir` directive in the extra section.

Next, we have another iteration of `runTests.sh <https://github.com/TYPO3/styleguide/blob/master/Build/Scripts/runTests.sh>`_
and `docker-compose.yml <https://github.com/TYPO3/styleguide/blob/master/Build/testing-docker/docker-compose.yml>`_ that are
quite a bit longer than the versions of enetcache to handle the functional and acceptance tests setups, too.

With this in place we can already run unit tests:

.. code-block:: shell

    git clone git@github.com:TYPO3/styleguide.git
    cd styleguide
    Build/Scripts/runTests.sh -s composerInstall
    # Run unit tests
    Build/Scripts/runTests.sh
    # ... OK (1 test, 4 assertions)

Functional testing
------------------

At the time of this writing, there is only a single functional test, but this one is important since
it tests a crucial functionality of styleguide: The extension comes with tons of different TCA scenarios
to show all sorts of database relation and field possibilities of TYPO3. To simplify testing, some happy
little code can generate a page tree and demo data for all of these scenarios. Codewise, this is a huge
section of the extension and it uses quite some core API to do its job. And yes, the generator breaks
once in a while. A perfect scenario for a `functional test!
<https://github.com/TYPO3/styleguide/blob/master/Tests/Functional/TcaDataGenerator/GeneratorTest.php>`_
(slightly stripped)::

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
            $count = $queryBuilder->count('uid')
                ->from('tx_styleguide_elements_basic')
                ->execute()
                ->fetchColumn(0);
            $this->assertEquals(0, $count);

            $generator = new Generator();
            $generator->create();

            // Verify there is at least one tx_styleguide_elements_basic record now
            $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_styleguide_elements_basic');
            $queryBuilder->getRestrictions()->removeAll();
            $count = $queryBuilder->count('uid')
                ->from('tx_styleguide_elements_basic')
                ->execute()
                ->fetchColumn(0);
            $this->assertGreaterThan(0, $count);
        }
    }

Ah, shame on us! The data generator does not work well if executed using mssql as DBMS. It is thus marked as
`@group not-mssql` at the moment. We need to fix that at some point. The rest is rather straight forward:
We extend from :php:`TYPO3\TestingFramework\Core\Functional\FunctionalTestCase`, instruct it to actually load
the styleguide extension (:php:`$testExtensionsToLoad`), need some additional magic for the DataHandler, then
call :php:`$generator->create();` and verify it created at least one record in one of our database tables.
That's it. It executes fine using runTests.sh:

.. code-block:: shell

    lolli@apoc /var/www/local/git/styleguide $ Build/Scripts/runTests.sh -s functional
    Creating network "local_default" with the default driver
    Creating local_mariadb10_1 ... done
    Waiting for database start...
    Database is up
    PHP 7.2.11-3+ubuntu18.04.1+deb.sury.org+1 (cli) (built: Oct 25 2018 06:44:08) ( NTS )
    PHPUnit 7.1.5 by Sebastian Bergmann and contributors.

    ..                                                                  2 / 2 (100%)

    Time: 5.23 seconds, Memory: 28.00MB

    OK (2 tests, 3 assertions)
    Stopping local_mariadb10_1 ... done
    Removing local_functional_mariadb10_run_1 ... done
    Removing local_mariadb10_1                ... done
    Removing network local_default
    lolli@apoc /var/www/local/git/styleguide $

The cool thing about this test is that it actually triggers quite some functionality below. It does tons of
database inserts and updates and uses the core DataHandler for various details. If something goes wrong in
this entire area, it would throw some exception, the functional test would recognize this and fail. But if
its green, we know that a rather huge part of that extension works fine.

If looking at details - for instance if we try to fix the mssql issue - runTests.sh can be called with `-x`
again for xdebug break pointing. Also, the functional test execution becomes a bit funny: We are creating
a TYPO3 test instance within `.Build/` folder anyway. But the functional test setup again creates instances
for the single tests cases. The code that is actually executed is thus located somewhere in a sub folder
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

This can be confusing at first, but it starts making total sense if you get used to it. Promised ;)
Also, the docker-compose.yml file contains a setup to start needed databases for the functional tests
and runTests.sh is tuned to call the different scenarios.

Acceptance testing
------------------

Not enough! The styleguide extension adds a module to the TYPO3 backend to the Topbar > Help section.
Next to other things, this module adds buttons to create and delete the demo
data that has been functional tested above already. To verify this works in the backend as well, styleguide
comes with some straight acceptance tests in `Tests/Acceptance/Backend/ModuleCest
<https://github.com/TYPO3/styleguide/blob/master/Tests/Acceptance/Backend/ModuleCest.php>`_::

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

These are three tests: One verifies the backend module can be called, one creates demo data, the last
one deletes demo data again. The codeception setup needs a bit more attention to setup, though. The entry point
is the main `codeception.yml file <https://github.com/TYPO3/styleguide/blob/master/Tests/codeception.yml>`_
extended by the `backend suite <https://github.com/TYPO3/styleguide/blob/master/Tests/Acceptance/Backend.suite.yml>`_,
a `backend tester <https://github.com/TYPO3/styleguide/blob/master/Tests/Acceptance/Support/BackendTester.php>`_ and
a `codeception bootstrap extension
<https://github.com/TYPO3/styleguide/blob/master/Tests/Acceptance/Support/Extension/BackendStyleguideEnvironment.php>`_
that instructs the basic typo3/testing-framework acceptance bootstrap to load the styleguide extension and
have some database fixtures included to easily log in to the backend. Additionally, the runTests.sh and
docker-compose.yml files take care of adding selenium-chrome and a web server to actually execute the tests:

.. code-block:: shell

    lolli@apoc /var/www/local/git/styleguide $ Build/Scripts/runTests.sh -s acceptance
    Creating network "local_default" with the default driver
    Creating local_chrome_1    ... done
    Creating local_web_1       ... done
    Creating local_mariadb10_1 ... done
    Waiting for database start...
    Database is up
    Codeception PHP Testing Framework v2.5.1
    Powered by PHPUnit 7.1.5 by Sebastian Bergmann and contributors.
    Running with seed:


      Generating BackendTesterActions...

    TYPO3\CMS\Styleguide\Tests\Acceptance\Support.Backend Tests (3) -------------------------------------------------------
    Modules: WebDriver, \TYPO3\TestingFramework\Core\Acceptance\Helper\Acceptance, \TYPO3\TestingFramework\Core\Acceptance\Helper\Login, Asserts
    -----------------------------------------------------------------------------------------------------------------------
    ⏺ Recording ⏺ step-by-step screenshots will be saved to /var/www/local/git/styleguide/Tests/../.Build/Web/typo3temp/var/tests/AcceptanceReports/
    Directory Format: record_5be078fb43f86_{filename}_{testname} ----

      Database Connection: {"Connections":{"Default":{"driver":"mysqli","dbname":"func_test_at","host":"mariadb10","user":"root","password":"funcp"}}}
      Loaded Extensions: ["core","extbase","fluid","backend","about","install","frontend","recordlist","typo3conf/ext/styleguide"]
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

travis-ci
---------

Now we want all this stuff automatically checked using travis-ci:

.. code-block:: yaml

    language: php

    php:
      - 7.2
      - 7.3

    sudo: true

    cache:
      directories:
        - $HOME/.composer/cache

    notifications:
      email:
        recipients:
          - lolli@schwarzbu.ch
        on_success: change
        on_failure: change

    before_script:
      - Build/Scripts/runTests.sh -s composerInstall -p $TRAVIS_PHP_VERSION

    script:
      - >
        echo "Running composer validate"
        Build/Scripts/runTests.sh -s composerValidate -p $TRAVIS_PHP_VERSION
      - >
        echo "Running unit tests";
        Build/Scripts/runTests.sh -s unit -p $TRAVIS_PHP_VERSION
      - >
        echo "Running php lint";
        Build/Scripts/runTests.sh -s lint -p $TRAVIS_PHP_VERSION
      - >
        echo "Running functional tests with mariadb";
        Build/Scripts/runTests.sh -s functional -d mariadb -p $TRAVIS_PHP_VERSION
      - >
        if [ ${TRAVIS_PHP_VERSION} = "7.2" ]; then
          echo "Running functional tests with mssql";
          Build/Scripts/runTests.sh -s functional -d mssql -p $TRAVIS_PHP_VERSION;
        else
          echo "Running functional tests with mssql not supported with PHP 7.3 yet";
        fi
      - >
        echo "Running functional tests with postgres";
        Build/Scripts/runTests.sh -s functional -d postgres -p $TRAVIS_PHP_VERSION
      - >
        echo "Running functional tests with sqlite";
        Build/Scripts/runTests.sh -s functional -d sqlite -p $TRAVIS_PHP_VERSION
      - >
        echo "Running acceptance tests";
        Build/Scripts/runTests.sh -s acceptance -p $TRAVIS_PHP_VERSION

This is similar to the enetcache example, but does some more: The functional tests are executed
with four different DBMS (mariadb, mssql, postgres, sqlite), and the acceptance tests are executed, too.
This setup takes some minutes to finish on travis-ci. But hey, `it's green <https://travis-ci.org/TYPO3/styleguide>`_!
