.. include:: /Includes.rst.txt

.. _testing-history:

=======
History
=======

.. note::
    Readers interested in "how to solve things" may easily skip this chapter.


Introduction
============

The TYPO3 Core  development has quite an impressive history on automatic testing. This chapter
outlines some of the important steps the system went through over the years. It may be just
an interesting read but may also explain why things are as they are now.

Next to this chapter, `typo3.com blog <https://typo3.com/blog>`_ picks up the testing topic
once in a while. If a developer reads this who still needs to convince management persons that
testing saves time and money on a project, the series starting with `Serious Software Testing
<https://typo3.com/blog/serious-software-testing-typo3-runs-its-20000th-build>`_ may give some ideas.


2009
====

The `first Core unit test <https://github.com/TYPO3/TYPO3.CMS/commit/5fd947c8a1d7b009a920761ecc25c32889d5ee9a>`_
has been committed in early 2009. The Core was still using SVN as version control system at this point. More
than ten years ago. The tests have later been released with TYPO3 version 4.3 in fall 2009. The system
back then relied on the TYPO3 extension *phpunit*. This TER extension bundled the native `phpunit package
<https://phpunit.de/>`_ and added a TYPO3 backend module on top. It found all extensions that delivered
unit tests, allowed to execute them and showed the result in the module.
This was the first time "green bar feeling" came up: All tests green.


2012
====

This was after TYPO3 4.5 times - a version that carried us for a long time. Several TYPO3 Core
contributors meanwhile added some hundreds of unit tests in various Core extensions. There was an
issue, though: Not too many persons developing the TYPO3 Core  cared about unit tests and executed
them before providing or merging patches. As a result, tests were frequently failing and only a
small group of persons took care and fixed them once in a while. Unit tests and system under test
are symbiotic: If one is changed, the other one needs changes, too. If that does not happen, unit
tests fail.

However, the young project `Travis CI <https://travis-ci.com/>`_ came online and allowed free test
environments for open source projects. The TYPO3 Core  quickly started using that, a first `.travis.yml
<https://github.com/TYPO3/TYPO3.CMS/commit/4302056ce55c34e977b7b8616ddd90e00cdc50b3>`_ has been added
early 2012 and all merged patches executed the test suite. Persons merging patches got feedback on failed
builds and were able to act upon: Either fix the build or revert the patch. The Core Team established an
"always green" rule for Core development.

The Travis CI setup at this point basically created a working instance around the checked out the Core
to run tests: It additionally cloned a helper repository, cloned the phpunit extension, did set up
a database and other stuff, then executed the Core unit tests to result with "good" or "bad".

Until 2018, this first .travis.yml file went through more than 100 changes.


2013
====

With frequent test execution via Travis CI more and more developers working on the Core were
forced to run tests locally to debug tests or add new ones. We slowly got an idea in which
situations unit tests are helpful and when they are not.

One flaw in our unit test system became more pressing, though: The phpunit extension that we
relied on has been designed to run tests in the backend context of TYPO3 as a module. The unit
tests were executed with all the state the backend created to run modules. This was troublesome
since lots of unit tests now directly or indirectly relied on this state, too. And worse, this state
changed depending on the developers local test system - other extensions that hooked into the
system could lead to failing unit tests. With this system, tests tend to execute fine locally but
then broke on Travis CI or on some other persons development system. Test execution has at this
point already been done via CLI by most developers, and the unit test bootstrap basically created a
full TYPO3 backend context similar to the GUI based phpunit extension.

Moreover, we had many tests that somehow changed global state and then influenced other tests.
This part lead to the situation that a test worked if executed as single test but failed if
executed together with all others - or vice versa.

We ultimately learned at this time that managing system state is an essential part of the Core
framework. And so we started refactoring: The Core bootstrap has been hacked into manageable
pieces that could be called by the unit test bootstrap in small steps. The tests started to
become "real" unit tests that test only one small piece of code at a time.

With improving the unit tests and their bootstrap it also became clear that we needed a second
type of tests that do the opposite of unit testing: We wanted to test not only a single isolated
fraction of code, we also wanted to test the collaboration of bigger framework parts that includes
many classes and database operations. In short: functional testing.

With our learning's from unit tests however it was clear that functional test execution needed to be
executed in a well defined and isolated environment to be reliable: We could not just execute them in the
context of the local developers system. Moreover, we had to isolate tests from each other: PHP is designed
to work on a per-request basis. A cli or web request comes in, the system bootstraps, does the job,
then dies. The next request does a new bootstrap from scratch. This simplifies things a lot for
developers since they don't need to take care of request overlapping state and don't need to take
care too much about consumed memory. And if a single request dies in the middle of the execution,
the next one still may happily work and successfully do its job. This characteristic of a scripting
language can be a huge advantage over other server-side languages. And TYPO3 uses this a lot: If a request
is finished in TYPO3 context, the system is "tainted" and can't be used for a second request again.

To handle this situation we came up with a functional bootstrap that creates standalone TYPO3 instances
per test file. The system sets up a new TYPO3 instance for each test file in an own folder in typo3temp,
links over source code from the main system, creates configuration files in this instance, creates
a dedicated database and initializes it with all tables needed by extensions loaded in this instance.
To then handle the isolation of single requests, each functional test runs as a new forked process that
does not carry any information from another test run. Doing all this was expensive, but at least the
functional test were so stable that we had very little trouble with tests that execute fine on one
system but fail on another one. Additionally, running functional tests could never destroy the main instance.


2014
====

Next to tons of detail changes, two main steps happened in 2014.

First, the unit test isolation has been finished. The initiative `standalone unit test
<https://wiki.typo3.org/Blueprints/StandaloneUnitTests>`_ changed the unit test bootstrap to execute
only a very basic part of the system. Instance specific configuration files like *LocalConfiguration.php*
were no longer read, no database connection established, the global backend user and language objects were
no longer set up and so on. In the end, not much more than the class auto loading is initialized. To reach
this, many tests had to improve their mocking of dependencies and had to specify the exact state they needed.
With this being done, side effects between tests reduced a lot and a dedicated unit test runner executing
tests in random order was added to find situations were test isolation was still not perfect.
Nowadays unit testing is pretty stable on all machines that execute them due to these works. With nearly
ten thousand tests in place it is rather seldom that a test fails on one machine and is successful
on another. And if that happens, the root cause is often a detail down below in PHP itself that has not been
perfectly aligned during test bootstrap - for instance a missing locale or some detail php.ini setting.

Second, the test execution was changed to use a composer based setup instead of cloning things on
its own. This was at TYPO3 6.2 times when composer was first introduced in TYPO3 world - testing was
one of the first usages. In this process we were able to ditch the TYPO3 specific extension based
flavor of phpunit and switched to the native version instead. This turned out to be a wise decision
since TYPO3 Core  testing now no longer relied on development of a third party TER extension but could
use the native testing stack directly and for instance pick up new versions quickly.


2015
====

Functional testing gained a lot of traction: The *DataHandler* and various related classes in the
TYPO3 Core  are the most crucial and at the same time complex part of the framework. All the language,
multi-site, workspace and inline handling is nifty and it's hard to change code in this area without
breaking something. This is still an issue and improving this situation is a mid- to long-term goal.
So we decided to use functional tests to specify what the DataHandler does in which situations. There
are hundreds of tests that play through complex scenarios, example: "Add some fixture pages and
content, call DataHandler to create a localized version in a workspace, call DataHandler to merge that
workspace content into live, verify database content is as expected, set up a basic frontend, call
frontend as see if expected content is rendered." Nowadays, if changing DataHandler code, functional
tests can tell precisely if a change in this area is ok or not. As a result, we don't see many
regressions in this area anymore.

Adding so many functional tests has a drawback, though: The needed isolation and expensive functional
test setup is rather slow. Executing the functional test suite means creating tens of thousands of
database tables. While unit testing is quick (a decent machine handles our ten thousand unit tests
in thirty seconds), executing a thousand functional tests can take an hour or more. This can be
improved by setting up a database in a memory driven ram disk and some other tricks, but still,
functional test execution is clearly not a super charged turbo.

Additionally, we had to increase the test isolation even more: There are test scenarios that execute
both backend and frontend functionality. This is hard in TYPO3: A backend request is a backend
request and it can't be used as a frontend request at the same time. Extension developers may know
this: In TYPO3 it's hard to do frontend requests from within the backend or from cli - extensions
like *solr* or *direct_mail* struggle at this point, too and need to find some solution working
around this. In functional testing, a test scenario that does a frontend request thus forks
processes twice: First, the backend part is executed as standalone process as explained above,
which then forks another process to execute the frontend request. As a result, only hard-boiled Core
developers tend to work on such functional tests: They are slow, hard to debug and complex to set up.


2016
====

In early 2016, Core developers added another type of testing: Acceptance tests. Those tests use a
browser to actually click around in the backend to verify various parts of the system. For instance,
TYPO3 Core  had a history of breaking the installation procedure once in a while: Most Core developers
set up a local development system once and then never or only seldom see the installation procedure
again. If code is changed that breaks the installer, this may go through not noticed. Acceptance testing
put an end to this: There are tests to install a fresh TYPO3, log in to the backend,
install the *introduction* extension and then verify the frontend works. The installer never hard broke
again since that. Other acceptance tests nowadays use the *styleguide* extension to click through some
complex backend scenarios, verify the backend throws no javascript errors and so on.

We however quickly learned that acceptance testing is fragile: Unit and functional testing has been
stabilized very well meanwhile - they do not break at arbitrary places. Acceptance testing however is
more complex: A web server is needed, some system to pilot the browser is needed, single clicks may
run into timeouts if the system is loaded, pages are sometimes not fully loaded before the next click
is performed. Additionally the TYPO3 backend still relies on iframes for all main modules, which again
does not simplify things. It took the Core development two further years to stabilize this well enough so
acceptance tests could be executed often without throwing false positives at various places. In the end
acceptance testing is another great leap forward to ensure major parts of the TYPO3 Core  do work as
expected.

Another thing became more and more pressing in 2016: The automatic testing via Travis CI started to show
drawbacks. We continued adding lots of tests and test suites over the years and executing everything
after each code merge took an increasing amount of time. Even with all sorts of tricks, Travis CI was
busy for more than half an hour to go through the suite, merging more than two patches per hour thus
added to a queue. There were Core code sprints were Travis reported green or red on a just
merged patch only half a day later. We tried to pay the service for more processing power, but payed plans
do not work with Travis CI for open source repositories (maybe they changed that restriction meanwhile).
We also knew that the amount of tests will increase and thus lead to even longer run times. Additionally,
Travis CI was configured to only test patches that were actually merged into the git main branches. So
we always only knew *after* a merge if the test suite stays green. But we wanted to know if the test
suite is green *before* merging a patch. Enabling Travis CI to test each and every patch set that is
pushed to the review system was out of question due to the long run times, though.

So we looked for alternatives. Luckily, the TYPO3 GmbH was founded in 2016 and got a open source license
by `atlassian <https://atlassian.com/>`_ for their main products. Atlassian has an own continuous
integration solution called bamboo. This CI allows adding "remote agents" that pick up single jobs
to run them. It's possible to scale by just adding more agents. We thus split the time consuming test
tasks into single parts and execute them in parallel on many agents at the same time. This also allowed
us to execute the test suite *before* merging patches: If pushing a patch set to the review system, the
bamboo based testing immediately picks up the new patch version and runs the entire suite, a result
is reported a couple of minutes later. So, this is all about throwing enough hardware at the testing
issue: The TYPO3 GmbH has a deal with the `Leibniz Rechenzentrum <https://lrz.de>`_ who grant us hardware
on one of their clusters to perform the tests.


2017
====

To the end of TYPO3 Core  v8 development the bootstrap, helper and set up code to execute Core
tests has been extracted from the Core to an own repository, the `typo3/testing-framework
<https://github.com/TYPO3/testing-framework>`_. This allowed re-using this package within
extensions to execute own tests. It however took that repository another major Core version
to mature well enough to easily do that. Writing and executing tests for TYPO3 extensions is
possible for a long time already, but extension authors were mostly on their own in finding a
suitable solution to do that. This chapter may put an end to this confusion.


2018
====

Since 2016, the TYPO3 Core  test setup went through further changes and improvements: Various test
details were added that checked the integrity of the system. TYPO3 v8 switched to doctrine so we
started executing the functional tests on meanwhile four different database systems, a nighly test
setup has been established that checks even more system permutations and software dependencies and
much more.

As another important step, the Core developers worked on the functional test isolation again in
TYPO3 v9: As explained above, the functional tests forked processes twice if frontend testing was
involved. With TYPO3 v9 however, the TYPO3 Core  bootstrap has been heavily improved,
with having a special eye on system state encapsulation: Next to the incredible PSR-15 works in
this area, two further API's have been established: :ref:`Context <context-api>` and
:ref:`Environment <Environment>`. Remember each functional tests case runs in an own instance within
typo3temp? TYPO3 Core  always had the PHP constant *PATH_site* that contained the path to the document
root. With having test cases in different locations, this constant would have to change. But it
can't, its constant and PHP luckily does not allow redefining constants. The environment API
of TYPO3 Core  v9 however is an object that is initialized during Core bootstrap. Next to some other
details, it also contains the path to the document root. Adding this class allowed us to ditch the
usage of PATH_site in the entire Core. This removed the main blocker to execute many functional test
suites in one PHP process. After solving another series of hidden state of the framework, the functional
test setup could finally be changed to not fork new processes for each and every test anymore. So now,
we can proof that one TYPO3 backend instance can handle many backend requests in one process - we are
sure our framework state is encapsulated well enough to allow such things. This change in the TYPO3
Core and dropping the process isolation for functional backend tests significantly simplified working
with functional tests now and debugging is much easier and improved Core code at the same time. This
pattern repeated often over the years: The test suites show quite well which parts of the Core need
attention. Working in these areas in turn improves the Core for everyone and allows usages that
have not been possible before.

In late 2018 another thing has been established: The *runTests.sh* script allows Core developers
to easily execute tests within a container based environment that takes care of all the nasty
system dependency problems. The test setup for some test suites is far from trivial: Acceptance
tests need a web server, chrome and selenium, functional tests need different database systems
that at best run in RAM, and so forth. Not too many Core developers went through all that to
actually run and develop tests locally. The script now hides away all that complexity and creates a
well defined and simple to use environment to run the tests, the only dependencies are recent docker
and docker-compose versions.


2019
====

The above milestones show that efforts in the Core testing area have positive effects on
Core and extension code and allow system usages that have not been possible before.

There are some further hard nuts we have to crack, though: For example, while the process isolation
for functional backend tests has been dropped in 2018, the tests still fork processes to execute
frontend scenarios. This is still ugly. It shows that calling a TYPO3 frontend from within the
backend context or from cli is still not easily possible. As a goal, a developer in such a situation
would usually want to do this: Preserve the current framework state, create a PSR-7 request for the
frontend, fire it, get a PSR-7 response object back, reset the framework state and then further work
with the response object. Lots of details to allow this are in place since TYPO3 v9 already, with only
some missing details: For instance, there is that nasty constant *TYPO3_MODE* that is set to
"FE" in a frontend call and "BE" in a backend call. So yeah, this constant is not constant. It is
one of the main blockers that prevents us from dropping the backend/frontend functional test
isolation. So, this constant *must* fall, and this will be one of the things that will be hopefully
resolved with TYPO3 v10. As soon as this last process isolation is dropped from the functional
test setup, extension authors will know that executing a frontend request from within the backend
must be easily possible. We're looking forward to that - it will be one of the last steps to finally
manage framework state in a good way and maybe we can rewrite this documentation section soon.


2020
====

The pending milestone of 2019 has been achieved in late 2020: The core functional tests no longer
spawn PHP processes to execute frontend requests. A PSR-7 sub request is initiated with core v11
instead.

This is quite an achievement: It is the proof that core framework state is encapsulated
well enough to finally execute a frontend request from within a backend request or CLI. As one
major pre-condition, the broken constant TYPO3_MODE is finally gone (deprecated and unused in core).
Further core versions can drop that constant and extensions will have to drop their usage, too.
So with v12, TYPO3_MODE will be gone, and TYPO3 can create cool features from this. So again, the
core testing paved the way for new opportunities and TYPO3 usages.
