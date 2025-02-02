.. include:: /Includes.rst.txt
.. index:: Testing; Project
.. _testing-tutorial-acceptance:

=======================================
Acceptance testing of site_introduction
=======================================

Introduction
============

Testing entire projects is somehow different from Core and extension testing. As a developer
or maintainer of a specific TYPO3 instance, you probably do not want to test extension details
too much - those should have been tested on an extension level already. And you probably also
do not want to check too many TYPO3 backend details but look for acceptance testing of your
local development, stage and live frontend website instead.

Project testing is thus probably wired into your specific CI and deployment environment. Maybe
you want to automatically fire your acceptance tests as soon as some code has been merged to
your projects develop branch and pushed to a staging system?

Documenting all the different decisions that may have been taken by agencies and other project
developers is way too much for this little document. We thus document only one example
how project testing could work: We have some "site" repository based on `ddev
<https://www.drud.com/what-is-ddev/>`_ and add basic acceptance testing to it, executed
locally and by GitHub Actions.

This is thought as an inspiration you may want to adapt for your project.


Project site-introduction
=========================

The `site-introduction <https://github.com/TYPO3-Documentation/site-introduction>`_ TYPO3 project is a
straight ddev based setup that aims to simplify handling the `introduction
<https://github.com/FriendsOfTYPO3/introduction>`_ extension. It delivers everything needed
to have a working introduction based project, to manage content and export it for new
introduction extension releases.

Since we're lazy and like well defined but simply working environments, this project is
based on ddev. The repository is a simple project setup that defines a working
TYPO3 instance. And we want to make sure we do not break main parts if we fiddle with it.
Just like any other projects wants.

The quick start for an own site based on this repository boils down to these commands, with
more details mentioned in `README.md <https://github.com/TYPO3-Documentation/site-introduction/blob/main/README.md>`_:

.. code-block:: shell

    lolli@apoc /var/www/local $ git clone git@github.com:TYPO3-Documentation/site-introduction.git
    lolli@apoc /var/www/local $ cd site-introduction
    lolli@apoc /var/www/local/site-introduction $ ddev start
    lolli@apoc /var/www/local/site-introduction $ ddev import-db --src=./data/db.sql
    lolli@apoc /var/www/local/site-introduction $ ddev import-files --src=./assets
    lolli@apoc /var/www/local/site-introduction $ ddev composer install

This will start various containers: A database, a phpmyadmin instance, and a web server. If all
goes well, the instance is reachable on :samp:`https://introduction.ddev.site`.

.. index:: Testing; Acceptance

Local acceptance testing
========================

There has been one `main patch
<https://github.com/TYPO3-Documentation/site-introduction/commit/841d86e72f34982827af66f3015b53b127f1dc2f>`_ adding
acceptance testing to the site-introduction repository.

The goal is to run some acceptance tests against the current website that has been
set up using ddev and execute this via GitHub Actions on each run.

The solution is to add the basic selenium-chrome container as additional ddev container, add
codeception as require-dev dependency, add some codeception actor, a test and a basic codeception.yml
file. Tests are then executed within the container to the locally running ddev setup.

Let's have a look at some more details: ddev allows to add further containers to the setup. We did
that for the selenium-chrome container that pilots the acceptance tests as :file:`.ddev/docker-compose.chrome.yaml`:

.. code-block:: yaml

    version: '3.6'
    services:
      selenium:
        container_name: ddev-${DDEV_SITENAME}-chrome
        image: selenium/standalone-chrome:3.12
        environment:
          - VIRTUAL_HOST=$DDEV_HOSTNAME
          - HTTP_EXPOSE=4444
        external_links:
          - ddev-router:$DDEV_HOSTNAME

With this in place and calling `ddev start`, another container with name `ddev-introduction-chrome`
is added to the other containers, running in the same docker network. More information about
setups like these can be found in the `ddev documentation
<https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/>`_.

To execute acceptance tests in this installation you have to activate this file, usually it is now appended
with the suffix `.inactive` and therefore not used when DDEV starts. To activate acceptance tests the file
:file:`.ddev/docker-compose.chrome.yaml.inactive` has to be renamed to :file:`.ddev/docker-compose.chrome.yaml`.
By default acceptance tests are disabled because they slow down other tests significantly.

Next, after adding codeception as require-dev dependency in :file:`composer.json <extension-composer-json>`, we need a
basic :file:`Tests/codeception.yml` file:

.. code-block:: yaml

    namespace: Bk2k\SiteIntroduction\Tests\Acceptance\Support
    suites:
      acceptance:
        actor: AcceptanceTester
        path: .
        modules:
          enabled:
            - Asserts
            - WebDriver:
                url: https://introduction.ddev.site
                browser: chrome
                host: ddev-introduction-chrome
                wait: 1
                window_size: 1280x1024
    extensions:
      enabled:
        - Codeception\Extension\RunFailed
        - Codeception\Extension\Recorder

    paths:
      tests: Acceptance
      output: ../var/log/_output
      data: .
      support: Acceptance/Support

    settings:
      shuffle: false
      lint: true
      colors: true

This tells codeception there is a selenium instance at `ddev-introduction-chrome` with chrome,
the website is reachable as :samp:`https://introduction.ddev.site`, it enables some codeception plugins
and specifies a couple of logging details. The `codeception documentation <https://codeception.com/>`_
goes into details about these.

Now we need a simple first test which is added as :file:`Tests/Acceptance/Frontend/FrontendPagesCest.php`:

.. code-block:: php
   :caption: EXT:site_introduction/Tests/Acceptance/Frontend/FrontendPagesCest.php

    <?php
    declare(strict_types = 1);
    namespace Bk2k\SiteIntroduction\Tests\Acceptance\Frontend;
    use Bk2k\SiteIntroduction\Tests\Acceptance\Support\AcceptanceTester;
    class FrontendPagesCest
    {
        /**
         * @param AcceptanceTester $I
         */
        public function firstPageIsRendered(AcceptanceTester $I)
        {
            $I->amOnPage('/');
            $I->see('Open source, enterprise CMS delivering  content-rich digital experiences on any channel,  any device, in any language');
            $I->click('Customize');
            $I->see('Incredible flexible');
        }
    }

It just calls the homepage of our instance, clicks one of the links and verifies some text is
shown. Straight, but enough to see if the basic instance does work.

Ah, and we need a "Tester" in the `Support directory <https://github.com/TYPO3-Documentation/site-introduction/tree/main/Tests/Acceptance/Support>`_.

That's it. We can now execute the acceptance test suite by executing a command in the
ddev PHP container:

.. code-block:: shell

    lolli@apoc /var/www/local/site-introduction $ ddev exec bin/codecept run acceptance -d -c Tests/codeception.yml
    Codeception PHP Testing Framework v2.5.6
    Powered by PHPUnit 7.5.20 by Sebastian Bergmann and contributors.
    Running with seed:


    Bk2k\SiteIntroduction\Tests\Acceptance\Support.acceptance Tests (1) -------------------------------------------------------------------------------------------------
    Modules: Asserts, WebDriver
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ⏺ Recording ⏺ step-by-step screenshots will be saved to /var/www/html/Tests/../var/log/_output/
    Directory Format: record_5be441bbdc8ed_{filename}_{testname} ----
    FrontendPagesCest: First page is rendered
    Signature: Bk2k\SiteIntroduction\Tests\Acceptance\Frontend\FrontendPagesCest:firstPageIsRendered
    Test: Acceptance/Frontend/FrontendPagesCest.php:firstPageIsRendered
    Scenario --
     I am on page "/"
      [GET] https://introduction.ddev.site/
     I see "Open source, enterprise CMS delivering  content-rich digital experiences on any channel,  any device, in any language"
     I click "Customize"
     I see "Incredible flexible"
     PASSED

    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ⏺ Records saved into: file:///var/www/html/Tests/../var/log/_output/records.html


    Time: 8.46 seconds, Memory: 8.00MB

    OK (1 test, 2 assertions)

    lolli@apoc /var/www/local/site-introduction $

Done: Local test execution of a projects acceptance test!

.. index:: Testing; GitHub Actions

GitHub Actions
==============

With local testing in place, we now want tests to run automatically when something is merged
into the repository, and when people create pull requests for our project, we want to make sure
that our carefully crafted test setup actually works. We're going to use Github's Actions CI
service to get that done. It's free for open source projects.
To tell the CI what to do, create a new workflow file in
`.github/workflows/tests.yml <https://github.com/TYPO3-Documentation/site-introduction/blob/master/.github/workflows/tests.yml>`__

.. code-block:: yaml

   name: tests

   on:
     push:
     pull_request:
     workflow_dispatch:

   jobs:
     testsuite:
       name: all tests
       runs-on: ubuntu-20.04
       steps:
         - name: Checkout
           uses: actions/checkout@v2

         - name: Start DDEV
           uses: jonaseberle/github-action-setup-ddev@v1

         - name: Import database
           run: ddev import-db --src=./data/db.sql

         - name: Import files
           run: ddev import-files --src=./assets

         - name: Install Composer packages
           run: ddev composer install

         - name: Allow public access of var folder
           run: sudo chmod 0777 ./var

         - name: Run acceptance tests
           run: ddev exec bin/codecept run acceptance -d -c Tests/codeception.yml

It's possible to see executed test runs `online <https://github.com/TYPO3-Documentation/site-introduction/actions>`_.
Green :)


Summary
=======

This chapter is a show case how project testing can be done. Our example project makes it easy for us since
the ddev setup allows us to fully kickstart the entire instance and then run tests on it. Your project setup
may be probably different, you may want to run tests against some other web endpoint, you may want to trigger
that from within your CI and deployment phase and so on. These setups are out of scope of this document, but
maybe the chapter is a good starting point and you can derive your own solution from it.
