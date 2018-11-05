.. include:: ../Includes.txt

.. _testing-projects:

===============
Project testing
===============

Introduction
============

Testing entire projects is somehow different from core and extension testing. As a developer
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

So here is the setup:

Acceptance testing
==================

There has been one `main patch
<https://github.com/benjaminkott/site-introduction/commit/841d86e72f34982827af66f3015b53b127f1dc2f>`_ adding
acceptance testing to the site-introduction repository.

Our goal is to run some acceptance tests against the current website that has been
set up using ddev and execute this via travis-ci on each run.

The solution is to add the basic selenium-chrome container as additional ddev container, add
codeception as require-dev dependency, add some codeception actor, a test and a basic codeception.yml
file. Tests are then executed within the container to the locally running ddev setup.

travis-ci needs some more love: travis comes with rather outdated docker versions by default that
are not compatible with ddev, so :file:`.travis.yml` first updates docker and docker-compose, then
installs ddev, sets up the instance and executes the tests. Ready to rumble.
