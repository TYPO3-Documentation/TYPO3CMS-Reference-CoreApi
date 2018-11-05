.. include:: ../Includes.txt

.. _testing-core:

============
Core testing
============

Introduction
============

This chapter is mostly about executing TYPO3 core tests locally and getting an idea of the overall
picture and how things play with each other. A full core git checkout comes with everything needed
to run tests in TYPO3 since core version 9. We don't look back to older versions in this chapter
since core development is most likely bound to core master branch - back port details to older
branches are usually handled by core maintainers and often don't affect other core contributors much.

As a disclaimer, the main script :file:`Build/Scripts/runTests.sh` is relatively young. It works best
if executed on a linux based host, it works using macOS (but much slower), and it may work using
Windows (and it's actually quicker than with mac). Not everything in this area is settled yet, though.

Additionally, it *is* possible to execute tests on a local system without using docker. Depending on
which test suite should be executed, developers may set up and configure their environments to achieve
that. We however learned not too many people actually do that as it can become tricky. This
chapter does not talk about test execution outside of :file:`Build/Scripts/runTests.sh`.


.. _testing-core-dependencies:

System dependencies
===================

Many developers fiddled with `docker <https://www.docker.com/>`_ already. As outlined in the
:ref:`history <testing-history>` chapter, test execution needs a well defined, isolated, stable and
reliable environment to run tests and take painful dependencies away from the local development
system for demanding test jobs like "execute some functional test using mssql with xdebug".

So yeah, you need git, docker and docker-compose. In recent versions. The younger the better.
But hey, for test execution alone you don't need PHP at all locally! You can even `composer install`
a core by calling `Build/Script/runTests.sh -s composerInstall` in a container.

If you're using mac, install or update docker to a recent version using the packaging system of
your choice. If using some linux based on ubuntu 18.04 or higher, all should be ok already after
calling `sudo apt-get install git docker docker-compose` once, other / older linux`es should have a
look at the docker homepage to see how to update to a recent version. It usually involves adding some
other package repository and updating / installing using it. Windows can rely on WSL to
have a decent docker version, too.


Quick start
===========

From now on, we expect git, docker and docker-compose are available in recent versions on the local host
system. Executing the basic core unit test suite boils down to:

.. code-block:: shell

    # Initial core clone
    git clone git://git.typo3.org/Packages/TYPO3.CMS.git && cd TYPO3.CMS
    # Install composer dependencies
    Build/Scripts/runTests.sh -s composerInstall
    # Run unit tests
    Build/Scripts/runTests.sh

That's it. You just executed the entire unit test suite. How long did test execution take on your side?
Your local environment is cool if you are below thirty seconds ... ok, let's say two minutes on mac. After
initial core clone and a composer install, other parts of this chapter are about different permutations of
calling `runTests.sh` only.


Overview
========

Ok. What just happened? You cloned a core, composer install`ed dependencies and executed core
unit tests. Let's have a look at more some details: `runTests.sh` is a shell script that figures out
which test suite with which options a user wants to execute, does some error handling for broken
combinations, writes the file `Build/testing-docker/.env` according to its findings and then executes a
couple of `docker-compose` commands to prepare containers, run tests and stop containers.

A core developer doing this for the first time may find `docker-compose` fetching some container images
before party goes on. These are the dependent images needed to execute certain jobs. For instance the
container `typo3gmbh/php72 <https://hub.docker.com/r/typo3gmbh/php72/>`_ may be fetched. It's definition
can be found at `TYPO3 GmbH bitbucket <https://bitbucket.typo3.com/projects/T3COM/repos/bamboo-remote-agent/browse>`_.
These are the exact same containers bamboo based testing is executed in. In bamboo, the combination of
:file:`Build/bamboo/src/main/java/core/PreMergeSpec.java` and :file:`Build/testing-docker/bamboo/docker-compose.yml`
specify what bamboo executes for patches pushed to the review system. On local testing, this is the
combination of :file:`Build/Script/runTests.sh`, :file:`Build/testing-docker/local/.env` (created by
runTests.sh) and :file:`Build/testing-docker/local/docker-compose.yml`.

The cool thing is that runTests.sh can do everything locally that bamboo executes as `pre-merge
<https://bamboo.typo3.com/browse/CORE-GTC>`_ tests, too. It's just that the combinations of tests
and splitting to different jobs is slightly different, for instance bamboo does multiple tests in
the "integration" test at once that are single "check" suites in runTests.sh. But if a patch is
pushed to bamboo and it mumbles about something being broken, it is possible to replay and fix the
failing suite locally to then push an updated patch and hopefully make bamboo happy.


A runTests.sh run
=================

Let's pick a runTests.sh example and have a closer look:

.. code-block:: shell

    lolli@apoc /var/www/local/cms/Web $ Build/Scripts/runTests.sh -s functional typo3/sysext/core/Tests/Functional/Authentication/
    Creating network "local_default" with the default driver
    Creating local_redis4_1       ... done
    Creating local_mariadb10_1    ... done
    Creating local_memcached1-5_1 ... done
    Waiting for database start...
    Database is up
    PHP 7.2.11-3+ubuntu18.04.1+deb.sury.org+1 (cli) (built: Oct 25 2018 06:44:08) ( NTS )
    PHPUnit 7.1.5 by Sebastian Bergmann and contributors.

    .                                                                   1 / 1 (100%)

    Time: 184 ms, Memory: 16.00MB

    OK (1 test, 1 assertion)
    Stopping local_mariadb10_1    ... done
    Stopping local_redis4_1       ... done
    Stopping local_memcached1-5_1 ... done
    Removing local_functional_mariadb10_run_1         ... done
    Removing local_prepare_functional_mariadb10_run_1 ... done
    Removing local_mariadb10_1                        ... done
    Removing local_redis4_1                           ... done
    Removing local_memcached1-5_1                     ... done
    Removing network local_default
    lolli@apoc /var/www/local/cms/Web $ echo $?
    0
    lolli@apoc /var/www/local/cms/Web $


The command asks runTests.sh to execute the "functional" test suite `-s functional` and to not execute all
available tests but only those within `typo3/sysext/core/Tests/Functional/Authentication/`. The script first
starts the containers it needs: A redis, a memcached and a mariadb. All in one network. It then waits until
the mariadb container opens its database port, then starts a PHP 7.2 container and calls phpunit to execute
the tests. phpunit executes only one test in this case that is green. The containers and networks are then
removed again. Note the exit code of runTests.sh (`echo $?`) is identical to the exit code of the phpunit
call: If phpunit reports green, runTests.sh returns 0, and if phpunit is red, the exit code would be non zero.


.. _testing-core-examples:

Examples
========

First and foremost, the most important call is `-h` - the help output. The output below is cut, but
the script returns a handy overview of options. The help output is also returned if given options
are not valid:

.. code-block:: shell

    lolli@apoc /var/www/local/cms/Web $ Build/Scripts/runTests.sh -h
    TYPO3 core test runner. Execute acceptance, unit, functional and other test suites in
    a docker based test environment. Handles execution of single test files, sending
    xdebug information to a local IDE and more.
    ...

Some further examples: The most important tests suites are unit tests, functional tests and acceptance
tests, but there is more:

.. code-block:: shell

    # Execute the unit test suite with PHP 7.3
    Build/Scripts/runTests.sh -s unit -p 7.3

    # Execute some backend acceptance tests
    Build/Scripts/runTests.sh -s acceptance typo3/sysext/core/Tests/Acceptance/Backend/Topbar/

    # Execute some functional tests with PHP 7.3 and postgres DBMS
    Build/Scripts/runTests.sh -s functional -p 7.3 -d postgres typo3/sysext/core/Tests/Functional/Package/

    # Execute the cgl fixer
    Build/Scripts/runTests.sh -s cglGit

As shown there are various combinations available. Just go ahead, read the help output and play around.
There are tons of further test suites to try.

One interesting detail shouldn't be unmentioned: runTests.sh uses `typo3gmbh/phpXY <https://hub.docker.com/r/typo3gmbh/>`_
as main PHP containers. Those are loosely maintained and may be updated. Use the command
`Build/Scripts/runTests.sh -u` once in a while to fetch latest versions of these containers.


Debugging
=========

This is one of the really nice features. To speed up test execution, the PHP extension `xdebug` is
usually not loaded. However, to allow debugging tests and system under tests, it is possible to
activate xdebug and send debug output to a local IDE. We'll use PhpStorm as example how to do that.

Let's verify some PhpStorm debug settings first. Go to File > Settings > Languages & Frameworks > PHP
> Debug. Make sure "Can accept external connections" is enabled, remember the port if it is not the
default port 9000 and maybe raise "Max. simultaneous connections" to two or three. Note remote debugging
may impose a security risk since everyone on the network can send debug streams to your host.

.. figure:: ../Images/PhpstormXdebugSettings.png
    :class: with-shadow
    :alt: Phpstorm debug settings window

Accept changes and enable "Start listening for PHP connections". If you changed settings, turn them
off and on once to read new settings.

.. figure:: ../Images/PhpstormDebugListen.png
    :class: with-shadow
    :alt: Phpstorm with enabled debug listening

Now set a break point in some assignment. Note break points do not work "everywhere", for instance
not on empty lines and not on array assignments. Best bet it to use some straight command. We'll use
a simple test file for now, add a breakpoint and then execute this test. If all goes well, PhpStorm
stops at this line and opens the debug window.

.. figure:: ../Images/PhpstormDebugSession.png
    :class: with-shadow
    :alt: Phpstorm with active debug session

.. code-block:: shell

    Build/Scripts/runTests.sh -x -s functional -p 7.3 -d postgres typo3/sysext/core/Tests/Functional/Package/RuntimeActivatedPackagesTest.php

The important flag here is `-x`! This is available for unit and functional testing. It enables xdebug
in the PHP container and sends all debug information to port 9000 of the host system. If a local Phpstorm
is listening on a non-default port, a different port can be specified with `-y`.

If Phpstorm does *not* break point as expected, some fiddling in this area may be required. First, make
sure "local" debugging works. Set a breakpoint in a local project and see if it works. If it works
locally, the container based debugging should do, too. Next, make sure a proper break point has been set.
Additionally, it may be useful to activate "Break at first line in PHP scripts" in Phpstorm settings. runTests.sh
mounts the local path to the same location within the container, so path mapping is not needed. Phpstorm
also comes with a `guide <https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html>`_ how to set up
debugging properly.