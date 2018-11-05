.. include:: ../Includes.txt

.. _testing-core:

===
FAQ
===

Introduction
============

The core took some decisions regarding testing that may not be obvious at first sight. This
chapter tries to answer some of the most frequent asked ones.


Why do you docker everything?
=============================

Executing tests in a containerized environment like docker has significant advantages over
local execution. It takes away all the demanding setup needs of additional services like
selenium, various database systems, different php versions in parallel on the same system and
so on. It also creates a well defined environment that is identical for everyone: Extension
authors rely on the same system dependencies as the core does, local test execution is identical
to what the continuous integration system bamboo does, all dependencies and setup details are open
sourced and available for everyone. Even travis-ci is forced to create the exact same environment
in our examples, and it plays well with other dockerized solutions like `ddev <https://www.drud.com/>`_.
In short: Using docker creates stable an easy to replay results.


Why do you need runTests.sh?
============================

The script `runTests.sh` is a wrapper around docker-compose. While docker and docker-compose are
great software, this stack has its own type of issues. In the end, runTests.sh just creates a `.env`
file read by docker-compose to work around a couple of things. For instance, all tests mount the
local git checkout of core or an extension into one or multiple containers. Executing tests then
may write files to that volume. These files should be written with the same local user that starts
the tests, otherwise local files are created with permissions a local user may not be able to delete again.
This is however not possible in docker and a `long standing issue
<https://github.com/docker/compose/issues/2380>`_ about that is still not resolved. There are further
issues which runTests.sh hides away for you. The goal was to have a dead simple mechanism to
execute tests. runTests.sh does that.

Additionally, wrapping details in runTests.sh gives the core the opportunity to change docker-compose
details without affecting the outer caller API: We can change things on docker level, adapt the script
and nothing changes on the consuming side. This detail is pretty convenient since it reduces the
risk of breaking consuming scripts like other CI systems.


Is a generic runTests.sh available?
===================================

No. Maybe later. This scripn runTests.sh is pretty young. It did not mature enough to make it generally
available for example within the typo3/testing-framwork to be used by extensions directly. At the moment
each extension should maintain its own copy of :file:`runTests.sh` and :file:`docker-compose.yml`
files on its own and adapt it to its extension specific needs. We'll see how this evolves and maybe
deliver some more generic solution later.


Why don't you use runTests.sh in bamboo?
========================================

For TYPO3 core testing, bamboo has its own specification in :file:`Build/bamboo/src/main/java/core/PreMergeSpec.java`
(and a similar nightly setup in :file:`Build/bamboo/src/main/java/core/NightlySpec.java`) and uses
an own docker-compose file in :file:`Build/testing-docker/bamboo/docker-compose.yml`. The main reason
for that is the bamboo agents are not local processes on the given hardware directly, but are also
executed in docker containers to have many of them in parallel on one host.

The bamboo agents are "stupid" and only contain the java agent job but don't know about php versions or
further services. To execute single test jobs, they start new "sibling" containers and call commands in them.
For instance, they start an ad hoc postgres, a redis and a memcached container, then start a PHP 7.3 container
assigned to the same network and run the functional test suite. With multiple agents on one host (to make good
use of many CPU's on one hardware system), these per-agent specific ad hoc networks and volume mounts need to be
separated from each other. This requires some additional setup efforts runTests.sh does not reflect. Additionally,
the ram disk, responsible shell user and home directory setup is different to speed up single runs and to
efficiently cache network related things on the local host filesystem without agents colling with each other.

So while bamboo and local test execution use the same underlying containers, the network, local cache  and volume
mounts are different and this forces us to separate that from the local "one thing at a time" tailored script called
runTests.sh.


Can I provide more hardware for bamboo?
=======================================

Yes and no. We indeed consume quite some hardware to keep the TYPO3 core testing at a decent speed
and we are always looking for more. Under normal operation, we currently consume 64 CPU's and
half a terabyte of RAM. This is something. However, it is not trivial to help us: With the current
system, we need root access to the host, a host needs 8 hardware CPU's with 64 GB of RAM, the
system needs to be stable and always available, it needs to be wired into the TYPO3 GmbH internal
vpn network, we need a decent network connection and we need to trust the system. You probably do not
want to load systems like that with additional tasks since the system load can grow quite high if the
agent cluster is busy. If you can comply with this, please mail to `Christian Kuhn
<christian.kuhn@typo3.com>`_ for details, it is highly appreciated! In the future our system demands may
hopefully shrink, maybe we're able to establish more dynamic scaling using kubernetes for instance, but
we're not there yet.


Testing is slow on macOS
========================

Yes. macOS has issues at least in this area. We're sorry. It is how it is. There are various
issues that have not been solved in a satisfiable way when it comes to mounting bigger local
directories as docker container volumes. github is full of issues with mac users complaining
about poor docker performance. There may be some tricks to speed that up in our tiny TYPO3
testing world and we're open to persons having a look at this to reduce pain for mac users.
Other than that, there is little we can do. Eventually, maybe macOS gets it's name spacing,
file system layers and containerization right in the future? Windows is better and quicker in
this area by now. Let that sink in. Please keep us posted.
