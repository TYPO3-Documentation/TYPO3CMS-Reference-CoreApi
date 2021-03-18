.. include:: /Includes.rst.txt
.. index:: Testing; FAQ
.. _testing-faq:

===
FAQ
===

Introduction
============

The Core took some decisions regarding testing that may not be obvious at first sight. This
chapter tries to answer some of the most frequent asked ones.


Why do you docker everything?
=============================

Executing tests in a containerized environment like docker has significant advantages over
local execution. It takes away all the demanding setup needs of additional services like
selenium, various database systems, different php versions in parallel on the same system and
so on. It also creates a well defined environment that is identical for everyone: Extension
authors rely on the same system dependencies as the Core does, local test execution is identical
to what the continuous integration system bamboo does. All dependencies and setup details are open
sourced and available for everyone. Even Travis CI is forced to create the exact same environment
in our examples, and it plays well with other dockerized solutions like `ddev <https://www.drud.com/>`_.
In short: Using docker creates stable an easy to replay results.


Docker consumes too much hard disk
==================================

Yes. If using docker often and in various scenarios, it does not tend to be exactly economical
when it comes to hard disk consumption. There are various maintenance commands that help, though:
First, `runTests.sh -u` updates local typo3gmbh containers and removes old ones. This may help.
Additionally, it is a good idea to check which local containers exist using `docker images` and
remove obsolete ones once in a while using `docker rmi`. Also, some container setups tend to create
many docker volumes and don't remove them after use. The command `docker volume list` gives an overview,
and a (use with care, you have a backup right?) `docker volume prune` helps removing unused volumes.


Why do you need runTests.sh?
============================

The script `runTests.sh` is a wrapper around docker-compose. While docker and docker-compose are
great software, this stack has its own type of issues. In the end, runTests.sh just creates a `.env`
file read by docker-compose to work around a couple of things. For instance, all tests mount the
local git checkout of Core or an extension into one or multiple containers. Executing tests then
may write files to that volume. These files should be written with the same local user that starts
the tests, otherwise local files are created with permissions a local user may not be able to delete again.
Specifying the user that runs a container is however not possible in docker directly and a `long standing issue
<https://github.com/docker/compose/issues/2380>`_ about that is still not resolved. There are further
issues which runTests.sh hides away. The goal was to have a dead simple mechanism to
execute tests. runTests.sh does that.

Additionally, wrapping details in runTests.sh gives the Core the opportunity to change docker-compose
details without affecting the outer caller API: We can change things on docker level, adapt the script
and nothing changes on the consuming side. This detail is pretty convenient since it reduces the
risk of breaking consuming scripts like other CI systems.


Is a generic runTests.sh available?
===================================

No. Maybe later. The script runTests.sh is pretty young. It did not mature enough to make it generally
available for example within the typo3/testing-framework to be used by extensions directly. At the moment
each extension should maintain its own copy of :file:`runTests.sh` and :file:`docker-compose.yml`
files on its own and adapt it to its extension specific needs. We'll see how this evolves and maybe
deliver some more generic solution later.


Why don't you use runTests.sh in bamboo?
========================================

For TYPO3 Core testing, bamboo has its own specification in :file:`Build/bamboo/src/main/java/core/PreMergeSpec.java`
(and a similar nightly setup in :file:`Build/bamboo/src/main/java/core/NightlySpec.java`) and uses
an own docker-compose file in :file:`Build/testing-docker/bamboo/docker-compose.yml`. The main reason
for that is the bamboo agents are not local processes on the given hardware directly, but are also
executed in docker containers to have many of them in parallel on one host.

The bamboo agents are "stupid" and only contain the java agent but don't know about PHP versions or
further services. To execute single test jobs, they start new "sibling" containers and call commands in them.
For instance, they start an ad hoc postgres, a redis and a memcached container, then start a PHP 7.3 container
assigned to the same network and run the functional test suite. With multiple agents on one host (to make good
use of many CPU's on one hardware system), these per-agent specific ad-hoc networks and volume mounts need to be
separated from each other. This requires some additional setup efforts runTests.sh does not reflect. Additionally,
the ram disk, responsible shell user and home directory setup is different to speed up single runs and to
efficiently cache network related stuff on the local host filesystem without agents colliding with each other.

So while bamboo and local test execution use the same underlying containers, the network, local cache and volume
mounts are different and this forces us to separate that from the local "one thing at a time" tailored script called
runTests.sh.


Why do you not use native PHP on Travis CI?
===========================================

The documentation about extension and project testing using Travis CI sets up an environment that
is identical to the local testing with the same containers used locally. This circumvents
the PHP versions that Travis comes with and again runs everything in docker containers. It would
also possible be to use the native Travis environments. This however requires additional
fiddling and more knowledge of the testing internals, especially when it comes to functional and
acceptance testing. Extension authors may very well decide to do that, but a setup like that is
out of scope of this document. Torturing Travis CI to fetch and run the docker containers all the
time is more time consuming but simplifies the setup a lot. And it gives stable results: If it fails
on Travis, it will fail locally, too.


Functional tests set up own instances in typo3temp?
===================================================

Yes. This is how it works. The functional (and acceptance) bootstrap create new, isolated instances
within your project root's public directory (usually :file:`.Build/Web`) in :file:`typo3temp/var/tests`
for each execution. Maybe later we make this path configurable and locate it elsewhere, but for the
time being it is how it is.


Can I provide more hardware for bamboo?
=======================================

Yes and no. We indeed consume quite some hardware to keep the TYPO3 Core  testing at a decent speed
and we are always looking for more. Under normal operation, we currently consume 64 CPU's and
half a terabyte of RAM. This is something. However, it is not trivial to help us: With the current
system, we need root access to the host, a host needs 8 hardware CPU's with 64 GB of RAM, the
system needs to be stable and always available, it needs to be wired into the TYPO3 GmbH internal
VPN, we need a decent network connection and we need to trust the system. You probably do not
want to load systems like that with additional tasks since the system load can grow quite high if the
agent cluster is busy. If you can comply with this, please mail to the TYPO3 GmbH for details, it is highly appreciated! In the future our system demands may
hopefully shrink, maybe we're able to establish more dynamic scaling using kubernetes for instance, but
we're not there yet.


Testing is slow on macOS
========================

Yes. macOS has issues at least in this area. We're sorry. It is how it is. There are various
issues that have not been solved in a satisfiable way when it comes to mounting bigger local
directories as docker container volumes. github is full of issues with mac users complaining
about poor docker performance. There may be some tricks to speed that up in our tiny TYPO3
testing world and we're open to persons having a look at this to reduce pain for mac users.
Other than that, there is little we can do. Eventually, maybe macOS gets its name spacing,
file system layers and containerization right in the future? Windows is better and quicker in
this area by now. Let that sink in. Please keep us posted.


Can i run tests with Windows?
=============================

Well. Maybe. We've had some successful reports using runTests.sh with `WSL: Windows Subsystem for Linux
<https://docs.microsoft.com/en-us/windows/wsl/install-win10>`_ but we did not get too much information
and experience on this, yet. Please go ahead, push patches for Core runTests.sh or the docker-compose.yml
files and improve this documentation with hints about Windows. We already know there are some details
to take care of, a starter can be found in a Core patch `commit message
<https://review.typo3.org/#/c/58750/3//COMMIT_MSG>`_.
