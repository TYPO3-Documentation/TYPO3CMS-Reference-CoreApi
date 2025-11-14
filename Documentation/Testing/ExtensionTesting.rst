..  include:: /Includes.rst.txt
..  index:: pair: Testing; Extensions
..  _testing-extensions:

=================
Extension testing
=================

When developing TYPO3 extensions, testing can greatly improve the code quality.

In theory you can test your extension like any other PHP application
and extensions. There are however some conventions that make contribution and
collaboration easier. And there are some tools that should make your life
maintaining an extension easier.

Which tools to use and which rules to apply is highly opinionated. However,
having automatic tests is better than no automatic tests, no matter the strategy
you follow.

The following test strategies should be applied to improve your code quality.

..  contents:: Table of contents

..  tip::
    Using the extension kickstarter (:composer:`friendsoftypo3/kickstarter`) you
    can create a testing environment for your extension using the command
    `vendor/bin/typo3 make:testenv`.

..  _testing-extensions-composer:

Composer install / update before running extensions tests
=========================================================

If you used :composer:`friendsoftypo3/kickstarter` to create your testing
environment all packages are listed in the :file:`composer.json` section
`require-dev`. You must therefore run `composer update` with dev dependencies
using the correct PHP version. The :file:`runTests.sh` script created by the
kickstarter contains a script to do that:

..  code-block:: bash

    Build/Scripts/runTests.sh -s composerUpdate

If you want to test on a version different to the default PHP version:

..  code-block:: bash

    Build/Scripts/runTests.sh -s composerUpdate -p 8.4

..  _testing-extensions-linting:

Linting
=======

A linting test ensures that the syntax of the language used is correct.

In TYPO3 extensions the following languages are commonly linted:

*   PHP in the supported versions
*   TypoScript
*   YAML
*   JavaScript / TypeScript

Depending on your extension, any other file format can be linted
too, if there is tooling for that (for example validating XML files
against a XSD schema).

If you used the :composer:`friendsoftypo3/kickstarter` to create your testing
environment you can run the linting with:

..  code-block:: bash

    Build/Scripts/runTests.sh -s lint

..  _testing-extensions-cgl:

Coding guidelines (CGL)
=======================

If more than one person is working on code, coding guideline are a must-have.
No matter which tool you use or which rules you choose to apply, it is important
that the rules can be applied automatically.

Common tools to help with applying coding guidelines are
`PHP-CS-Fixer <https://github.com/PHP-CS-Fixer/PHP-CS-Fixer>`__ and
`PHP_CodeSniffer <https://github.com/squizlabs/PHP_CodeSniffer>`__.

You can find more information in the :ref:`Coding guidelines <t3coreapi:cgl>`
section.

If you used the :composer:`friendsoftypo3/kickstarter` to create your testing
environment you can run the CGL tests with:

..  code-block:: bash

    Build/Scripts/runTests.sh -s cgl

..  _testing-extensions-static:

Static code analysis (PHPStan / Psalm)
======================================

Static code analysis tools are highly recommended to be used with PHP. The most
common tools used are `PHPStan <https://phpstan.org>`__ and `Psalm
<https://psalm.dev>`__. No matter the tool you use or the
rules and levels you apply: You should use one.

There are also static code analysis tools for TypeScript and JavaScript.

If you used the :composer:`friendsoftypo3/kickstarter` to create your testing
environment you can run static code analysis tests, using `phpstan`:

..  code-block:: bash

    Build/Scripts/runTests.sh -s phpstan

..  _testing-extensions-unit:

Unit tests (PHPUnit!)
====================

Unit tests are executing the code to be tested and define input and their
expected outcome. They are run on an isolated classes or methods.
All relations and services such as database calls, API and curl call **must**
be mocked. Not full instance setup is available. Therefore
:ref:`Dependency injection <Dependency-Injection>`, the database,
configurations and settings and everything done during
:ref:`Bootstrapping <bootstrapping>` is not available.

..  note::

    Rule of thumb: Unit tests are isolated tests not using real services.

See also :ref:`Writing unit tests <testing-writing-unit>`

If you used the :composer:`friendsoftypo3/kickstarter` to create your testing
environment you can run unit tests like this:

..  code-block:: bash

    Build/Scripts/runTests.sh -s unit

To run a specific test isolated use:

..  code-block:: bash

    Build/Scripts/runTests.sh -s unit -- Tests/Unit/Service/MyServiceTest.php

..  _testing-extensions-functional:

Functional tests
================

Functional tests, like Unit tests, also execute the code to be tested.
Functional test execute the test code within a fully composed TYPO3
instance (non-composer mode) with configured extensions and configuration,
having full :ref:`dependency <Dependency-Injection>` and extension logic
on board and Database backend available.

For this, the
`TYPO3 Testing Framework <https://github.com/TYPO3/testing-framework>`__
is highly recommended, and performs task like filling the database with
test data (using fixtures) and activating specific Core or third party
extensions (and yours). And, if needed, a backend or frontend user can be
logged in.

A functional test will then test the output of a method or if a method changes
certain other things like the database or the file system. It can also
test more complex functionality of your extension that depends on the
TYPO3 environment being present.

See also :ref:`Writing functional tests <testing-writing-functional>`

If you used the :composer:`friendsoftypo3/kickstarter` to create your testing
environment you can run unit tests like this:

..  code-block:: bash

    Build/Scripts/runTests.sh -s functional

To run a specific test isolated use:

..  code-block:: bash

    Build/Scripts/runTests.sh -s functional -- Tests/Functional/Service/MyServiceTest.php

It is possible to run the tests using different database systems and or PHP
versions. Before you run the tests with a different PHP version, do a
`composerUpdate` with the same version to ensure that composer has been run
with the correct PHP version.

..  code-block:: bash

    Build/Scripts/runTests.sh -s composerUpdate -p 8.4
    Build/Scripts/runTests.sh -s functional -p 8.4 -d postgres

..  _testing-extensions-acceptance:

Acceptance tests
================

Acceptance testing in the TYPO3 world is about piloting (remote controlling) a
browser to click through a frontend generated by TYPO3 or clicking through
scenarios in the TYPO3 backend.

See also :ref:`Writing acceptance tests <testing-writing-acceptance>`

..  _testing-extensions-organization:

Organizing and storing the commands
===================================

There are different solutions to store and execute these commands as some are
quite long. For details see :ref:`testing-organization`.
