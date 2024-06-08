:navigation-title: Running
..  include:: /Includes.rst.txt
..  _testing-unit-run:

==================
Running Unit tests
==================

..  _testing-unit-run-install:

Install phpunit and the TYPO3 testing framework
===============================================

I order to run unit tests within an extension or project you can require
phpunit and the testing framework via Composer as development dependency:

..  code-block:: bash

    composer require --dev \
      "typo3/testing-framework":"^8.0.9" \
      "phpunit/phpunit":"^10.5"

Which versions to use depends on the PHP and TYPO3 versions to be supported.

The following matrix can help you to choose the correct versions.

================== ================ =================================== ==========
 testing-framework  TYPO3            PHP                                 PHPUnit
================== ================ =================================== ==========
 8.x.x              v12, v13 (main)  8.1, 8.2, 8.3 (8.4)                 ^10, ^11
 7.x.x              v11, v12         7.4, 8.0, 8.1, 8.2, 8.3 (8.4)       ^9, ^10
 6.x.x              v10, v11         7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3   ^8, ^9
================== ================ =================================== ==========

Testing framework <= 6.x no longer maintained.

..  _testing-unit-run-configure:

Provide configuration files for unit tests
==========================================

The TYPO3 testing framework comes with a predefined unit test configuration and
a bootstrapping file. You should copy these files into your project so you
can adjust them as needed:

Copy the files `vendor/typo3/testing-framework/Resources/Core/Build/UnitTests.xml
<https://github.com/TYPO3/testing-framework/blob/main/Resources/Core/Build/UnitTests.xml>`__
and `vendor/typo3/testing-framework/Resources/Core/Build/UnitTestsBootstrap.php
<https://github.com/TYPO3/testing-framework/blob/main/Resources/Core/Build/UnitTestsBootstrap.php>`__

Open file :file:`UnitTests.xml` and adjust the paths to the path or paths where
the unit tests are stored. By convention many extensions store them in the
directory :path:`Tests/Unit` and subdirectories thereof:

..  code-block:: diff
    :caption: UnitTests.xml for extension testing

    <testsuites>
        <testsuite name="Unit tests">
    -        <directory>../../../../../../typo3/sysext/*/Tests/Unit/</directory>
    +        <directory>../../Tests/Unit/</directory>
        </testsuite>
    </testsuites>

If you are testing in a project you will probably have a directory from where
local extensions like site packages and client-specific extensions are installed
you should then also include them:

..  code-block:: diff
    :caption: UnitTests.xml for project testing

    <testsuites>
        <testsuite name="Unit tests">
    -        <directory>../../../../../../typo3/sysext/*/Tests/Unit/</directory>
    +        <directory>../../Tests/Unit/</directory>
    +        <directory>../../packages/*/Tests/Unit/</directory>
        </testsuite>
    </testsuites>

Run the unit tests on your system or with DDEV
==============================================

If you have the required PHP version installed on your system, you can run the
unit tests directly:

..  code-block:: bash

    php vendor/bin/phpunit -c Build/phpunit/UnitTests.xml

Or you can run them on ddev:

..  code-block:: bash

    ddev exec php vendor/bin/phpunit -c Build/phpunit/UnitTests.xml

If you are using DDEV, you can also create a `custom command <https://ddev.readthedocs.io/en/stable/users/extend/custom-commands/#custom-commands>`__
so you can run these tests again and again.

If you want to only run a specific test case (test class) or test (method in a
test class) you can use the filter option:

..  code-block:: bash

    php vendor/bin/phpunit -c Build/phpunit/UnitTests.xml --filter "MyTest"

You can of course define a
`Composer script <https://getcomposer.org/doc/articles/scripts.md>` as well.

Run the unit tests with runTests.sh
===================================

If you are using a :file:`runTests.sh` like the one used by the :t3ext:`blog_example`
you can run the tests with:

..  code-block:: bash

    Build/Script/runTests.sh -s unit

It is also possible to choose the PHP version to run the tests with:

..  code-block:: bash

    Build/Script/runTests.sh -s unit -p 8.2

You can start by copying the
`runTests.sh of blog_example <https://github.com/TYPO3-Documentation/blog_example/blob/main/Build/Scripts/runTests.sh>`__
and adjust it to your needs.

..  todo: once we have a chapter about the runTests.sh, link it from here.
