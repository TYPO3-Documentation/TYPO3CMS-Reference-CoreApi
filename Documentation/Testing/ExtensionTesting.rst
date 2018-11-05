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
travis-ci to execute tests. We'll use docker containers for test execution again and use
an extension specific runTests.sh script piloting tests setup and execution.


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

* We assume extension code is located at github and automatic testing is done using travis-ci.
  The integration of travis-ci into github is dead simple. If your extension code is elsewhere
  or a different CI should be used, you need to figure out details on your own but may very well
  use this document as inspiration since the strategies may be similar.

That being said, let's look at a rather simple extension and its testing needs.


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

If we want to test extension code directly, we do a similar step: We turn the :file:`composer.json`
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
"hey autoloader, find class names starting with Lolli\Enetcache in the Classes/ directory" specification.

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

Now let's add things to put that test into action. First, we add a series of properties to :file:`composer.json`
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

We ignore the entire `.Build` directory, these are on-the-fly files that not belong to the extension
functionality. We also ignore the `.idea` directory, this is a directory where PhpStorm parks its stuff.
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

These files are simplified rip-off versions of similar files from the TYPO3 core: `Build/Scripts/runTests.sh
<https://github.com/TYPO3/TYPO3.CMS/blob/master/Build/Scripts/runTests.sh>`_ and `Build/testing-docker/local/
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
can be updated using `runTests.sh -u`, and a help is available with `runTests.sh -h`. Have a look around.

travis-ci
---------

With basic testing in place we want execution of tests whenever something is merged to the repository and if
people create pull requests for our happy little extension to make sure our carefully crafted test setup actually
works all the time. We'll use the continuous integration service `travis-ci <https://travis-ci.org/`_ to take care of
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

In case of enetcache, we lets travis-ci test the extension with the two PHP versions 7.2 and 7.3. Travis exposes
the current version as variable `$TRAVIS_PHP_VERSION`, so we use that to feed it to `runTests.sh`. We instruct
travis-ci to always `composer install` first, then run the test suites `composer validate`, the unit testing
and the PHP linting. It's possible to see executed test runs `online <https://travis-ci.org/lolli42/enetcache>`_.
Green :) Maybe it's now time to add the `travis-ci status badge <https://docs.travis-ci.com/user/status-images/>`_
to our README.md file.