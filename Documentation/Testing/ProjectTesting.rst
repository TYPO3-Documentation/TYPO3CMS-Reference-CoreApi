.. include:: /Includes.rst.txt
.. index:: Testing; Project
.. _testing-projects:

===============
Project testing
===============

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
how project testing could work: We set up have some "site" repository based on `ddev
<https://www.drud.com/what-is-ddev/>`_ and add basic acceptance testing to it, executed
using travis-ci.

This is thought as an inspiration you may want to adapt for your project.


Project site-introduction
=========================

The `site-introduction <https://github.com/benjaminkott/site-introduction>`_ TYPO3 project is a
straight ddev based setup that aims to simplify handling the `introduction
<https://github.com/FriendsOfTYPO3/introduction>`_ extension. It delivers everything needed
to have a working introduction based project, to manage content and export it for new
introduction extension releases.

Since we're lazy and like well defined but simply working environments, this project is
based on ddev. The repository is a simple project setup that defines a working
TYPO3 instance. And we want to make sure we do not break main parts if we fiddle with it.
Just like any other projects wants.

The quick start for an own site based on this repository boils down to these commands, with
more details mentioned in `README.md <https://github.com/benjaminkott/site-introduction/blob/master/README.md>`_:

.. code-block:: shell

    lolli@apoc /var/www/local $ git clone git@github.com:benjaminkott/site-introduction.git
    lolli@apoc /var/www/local $ cd site-introduction
    lolli@apoc /var/www/local/site-introduction $ ddev start
    lolli@apoc /var/www/local/site-introduction $ ddev import-db --src=./data/db.sql
    lolli@apoc /var/www/local/site-introduction $ ddev import-files --src=./assets

This will start various containers: A database, a phpmyadmin instance, and a web server. If all
goes well, the instance is reachable on `localhost <http://introduction.ddev.local>`_.

.. index:: Testing; Acceptance

Local acceptance testing
========================

There has been one `main patch
<https://github.com/benjaminkott/site-introduction/commit/841d86e72f34982827af66f3015b53b127f1dc2f>`_ adding
acceptance testing to the site-introduction repository.

The goal is to run some acceptance tests against the current website that has been
set up using ddev and execute this via travis-ci on each run.

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

Next, after adding codeception as require-dev dependency in :file:`composer.json`, we need a
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
                url: http://introduction.ddev.local
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
the website is reachable as `http://introduction.ddev.local`, it enables some codeception plugins
and specifies a couple of logging details. The `codeception documentation <https://codeception.com/>`_
goes into details about these.

Now we need a simple first test is added as :file:`Tests/Acceptance/Frontend/FrontendPagesCest.php`::

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

Ah, and we need a "Tester" in the `Support directory <https://github.com/benjaminkott/site-introduction/tree/master/Tests/Acceptance/Support>`_.

That's it. We can now execute the acceptance test suite by executing a command in the
ddev PHP container:

.. code-block:: shell

    lolli@apoc /var/www/local/site-introduction $ ddev exec ../bin/codecept run acceptance -d -c ../Tests/codeception.yml
    Codeception PHP Testing Framework v2.5.1
    Powered by PHPUnit 7.1.5 by Sebastian Bergmann and contributors.
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
      [GET] http://introduction.ddev.local/
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

.. index:: Testing; Travis CI

Travis CI
=========

Travis CI needs slightly more love: Travis comes with rather outdated docker versions by default that
are not compatible with ddev, so our :file:`.travis.yml` first updates docker and docker-compose, then
installs ddev, sets up the instance and executes the tests. Ready to rumble:

.. code-block:: yaml

    language: php

    php:
      - 7.2

    sudo: true

    before_install:
      # Update docker
      - curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
      - sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
      - sudo apt-get update
      - sudo apt-get -y -o Dpkg::Options::="--force-confnew" install docker-ce
      # Update docker-compose
      - sudo rm /usr/local/bin/docker-compose
      - curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-`uname -s`-`uname -m` > docker-compose
      - chmod +x docker-compose
      - sudo mv docker-compose /usr/local/bin
      # Install ddev
      - curl -L https://raw.githubusercontent.com/drud/ddev/master/scripts/install_ddev.sh | sudo bash
      # ddev should not ask for usage stats
      - ddev config global --instrumentation-opt-in=false

    script:
      - >
        echo "Running acceptance tests";
        ddev start;
        ddev import-db --src=./data/db.sql;
        ddev import-files --src=./assets;
        ddev exec bin/codecept run acceptance -d -c Tests/codeception.yml

A Travis CI run can be found `online <https://travis-ci.org/benjaminkott/site-introduction>`_.


Summary
=======

This chapter is a show case how project testing can be done. Our example projects makes it easy for us since
the ddev setup allows us to fully kickstart the entire instance and then run tests on it. Your project setup
may be probably different, you may want to run tests against some other web endpoint, you may want to trigger
that from within your CI and deployment phase and so on. These setups are out of scope of this document, but
maybe the chapter is a good starting point and you can derive you own solution from it.
