.. include:: /Includes.rst.txt
.. index:: Testing; Project
.. _testing-projects:

===============
Project testing
===============

..  contents::

.. _testing-projects-differences:

Differences between project and extension testing
=================================================

**Projects** usually needs to support only one PHP version, Database vendor
and version and TYPO3 core version

Version raises for upgrades are usually prepared on a branch and changed
instead of parallel execution.

Project may have different places for tests

*   local path extension tests `packages/*/Tests/*`
*   global (root) tests `Tests/*`

The Core mono repository is basically a project setup, having local path
extensions in `typo3/sysexts/*` instead of the more known and lived `packages/*`
project folder structure.

.. _testing-projects-structure:

Project structure
=================

We assume a project structure similar to `tf-basics-project <https://github.com/sbuerk/tf-basics-project>`__
here. If you are using another structure, you have to adjust some scripts.

*   :ref:`TYPO3 installation with Composer <t3start:install>` and default paths
*   :ref:`DDEV <t3start:installation-ddev-tutorial>` is used for local development
*   Local extensions and the site package are situated in :path:`packages`

..  directory-tree::
    :caption: Initial directory tree in version control
    :level: 1

    *   :path:`.ddev`
    *   :path:`config`
    *   :path:`packages`
    *   :file:`composer.json`
    *   :file:`composer.lock`

The :file:`composer.json` looks like this:

..  literalinclude:: _ProjectTesting/_composer.json
    :caption: Example project composer.json before testing

..  _testing-projects-installation:

Install testing dependencies
============================

As a bare minimum it is suggested to use

*   One coding style fixer for PHP, for example :composer:`friendsofphp/php-cs-fixer`
*   One static code analyzer for PHP, for example :composer:`phpstan/phpstan`

Depending on the complexity of your project you might need:

*   :composer:`phpunit/phpunit`, if there is any PHP code of a complexity that
    should be tested.
*   Testing of scss, TypeScript or JavaScript (not covered here)
*   Linting of YAML, XML, TypoScript (not covered here)
*   :ref:`Writing acceptance tests <t3coreapi:testing-writing-acceptance>`

You can install all these tools as development dependencies. They will then not
be installed on your production system when Composer is executed with option
`--no-dev` during deployment:

..  code-block:: bash
    :caption: Composer installation **during deployment**

    composer install --no-dev

..  todo: Link to a dedicated php-cs-fixer section once it exists

For TYPO3 project you can use the package :composer:`typo3/coding-standards`
which already requires :composer:`friendsofphp/php-cs-fixer` and a set of
useful configuration and rules. 

..  code-block:: bash
    :caption: Require development dependencies

    composer req --dev typo3/coding-standards

If you want to do Unit or Functional tests on project level you also need the
TYPO3 testing framework:

..  code-block:: bash
    :caption: Require development dependencies

    composer req --dev typo3/coding-standards typo3/testing-framework

.. _testing-projects-configuration:

Test configuration on project level
===================================

We suggest to keep all project level test configuration in a common place that
can be excluded from deployment. The Core uses a folder called :path:`Build` with
one folder per test-type and we will follow that scheme here. If you put
the configuration in other directories, adjust your configuration files
accordingly.

..  _testing-projects-configuration-cs:

Code style tests and fixing
---------------------------

:composer:`typo3/coding-standards` comes with a predefined configuration for
:composer:`friendsofphp/php-cs-fixer`. You can override rules as needed in
your own configuration:

..  literalinclude:: _ProjectTesting/_php-cs-fixer.dist.php
    :caption: Build/php-cs-fixer/.php-cs-fixer.dist.php

It is recommended to also copy the :file:`.editorconfig` from the testing
framework into your main directory so that your IDE applies the same formatting
as the php-cs-fixer.

.. _testing-projects-configuration-phpstan:

PHPstan - Static PHP analysis
-----------------------------

When configuring PHPstan the various places in which PHP files can be found
should be taken into consideration:

..  literalinclude:: _ProjectTesting/_phpstan.neon
    :caption: Build/phpstan/phpstan.neon
    :language: plaintext

It also makes sense to exclude the :file:`ext_emconf.php` and any
:path:`node_modules` directory.

..  _testing-projects-configuration-phpunit:

Unit and Functional test configuration
--------------------------------------

See the chapters :ref:`Unit testing <testing-writing-unit>` and
:ref:`Functional testing <testing-writing-functional>`.

..  _testing-projects-execution:

Running the tests locally
=========================

The tests can be run via PHP on your local machine or with DDEV.

..  _testing-projects-execution-cs:

Run the php-cs-fixer
--------------------

To run the php-cs-fixer you need to configure the path to the configuration
file:

..  code-block:: bash

    vendor/bin/php-cs-fixer fix --config=Build/php-cs-fixer/.php-cs-fixer.dist.php

.. _testing-projects-execution-phpstan:

Run PHPstan
-----------

..  code-block:: bash

    vendor/bin/phpstan --configuration=Build/phpstan/phpstan.neon

Regenerate the baseline:

..  code-block:: bash

    vendor/bin/phpstan \
        --configuration=Build/phpstan/phpstan.neon \
        --generate-baseline=Build/phpstan/phpstan-baseline.neon

..  _testing-projects-execution-phpunit:

Run Unit tests
--------------

As Unit tests need no database or other dependencies you can run them directly
on your host system or DDEV:

..  code-block:: bash

    vendor/bin/phpunit \
        -c Build/phpunit/UnitTests.xml

..  _testing-projects-execution-functional-sqlite:

Run Functional tests using sqlite and DDEV
------------------------------------------

..  code-block:: bash

    ddev exec \
        typo3DatabaseDriver=pdo_sqlite \
        php vendor/bin/phpunit -c Build/phpunit/FunctionalTests.xml

.. _testing-projects-execution-functional-mysqli:

Run Functional tests using mysqli and DDEV
------------------------------------------
..  code-block:: bash

    ddev exec \
        typo3DatabaseDriver='mysqli' \
        typo3DatabaseHost='db' \
        typo3DatabasePort=3306 \
        typo3DatabaseUsername='root' \
        typo3DatabasePassword='root' \
        typo3DatabaseName='func' \
        php vendor/bin/phpunit -c Build/phpunit/FunctionalTests.xml


.. _testing-projects-organization:

Organizing and storing the commands
===================================

There are different solutions to store and execute these command.
For details see :ref:`testing-organization`.
