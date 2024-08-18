..  include:: /Includes.rst.txt
..  index:: Testing; Project; Runners; runTests; make; TestRunners
..  _testing-organization:

========================================
Test Runners: Organize and execute tests
========================================

Executing commands to run tests and other toolchain scripts
can be tedious. Sadly there is no "one-fits-all" solution for this.

This chapter tries to explain available options, in summary:

*   Use a bash alias
*   Write a bash script
*   Introduce `custom DDEV commands <https://ddev.readthedocs.io/en/stable/users/extend/custom-commands/#custom-commands>`__
*   Introduce a `Composer script <https://getcomposer.org/doc/articles/scripts.md>`__
*   Create a Makefile
*   Use dedicated tools like `just <https://github.com/casey/just>`__
*   Use the :file:`runTests.sh` script based on the TYPO3-Core
*   Use a customized :file:`runTests.sh` script based on `blog_example`
*   Use a generator

All these commands and tasks are not only run by you as a
developer (or end-user) and your co-workers, but are also
relevant for Continuous Integration (CI),
Continuous Deployment (CD) - for example via GitHub Actions
or GitLab Pipelines.

..  _testing-organization-why:

What are test runners and why do we need them
=============================================

As you can read in the chapters about :ref:`Testing <testing>`, there is a multitude
of available tooling around a project:

*   Unit testing
*   Functional testing
*   Acceptance testing
*   Integration testing
*   Linting
*   Validating
*   Static code analysis
*   Coding guideline (CGL) analysis
*   Rendering documentation
*   Deployment

Each of these tasks or commands are executed on different levels.

First of all, you as a developer want to execute this. You might want to
do this on your host computer. This could be any operating system, each with
their own needed commands (macOS, Windows, Linux/Unix derivates).

And you could also perform this within a virtual
environment (VM) or a isolated container (`Docker <https://docker.com>`__).
Or within an environment/framework
that helps you with that (`DDEV <https://ddev.com>`__).

Then, not only you may want to run the commands, but also co-workers, or
customers/users of your project.

Also, you may want to (and should) automate executing these commands on
a schedule, like with GitHub Actions or GitLab Pipelines, or even locally
with cronjobs. You might want to execute tests locally before you push code
to a Git repository.

As you can see: The ways to execute the tests can very a lot, depending
on the environment. Some commands can only be executed with the proper
PHP and Bash version environment. The tools themselves need to be installed,
and may have dependencies.

All of that leads to one central question:

    Question: How can I execute the commands in a re-usable way for everyone,
    and do not put much effort into "how to do this".

Sadly, the answer is not something you may want to read:

    Answer: You cannot. You may need to use multiple ways, or focus and
    discuss, what suits your needs best.

To pick the right way on running your tests means to talk with the people
involved with your project, most notable the maintainers and your environment.

If everyone working on a project uses the same environment, this can be easy.
But as soon as you are maintaining an OpenSource project and want to welcome
contributors with all kinds of environments, it gets harder. You might even
need to create redundancy for running tests.

The following sections describe each method of running a test with their
advantages and disadvantages, so that you will hopefully be able to make
an informed decision on picking what is best for you.

..  _testing-organization-bash-alias:

Use a bash alias
================

If all people involved are able to use bash (also available in Windows WSL),
you could create an alias for each tool (in your bash/shell profile), for example:

..  code-block:: bash
    :caption: ~/.bash_profile or ~/.zshrc or other

    alias test-project="php vendor/bin/phpunit -c Build/phpunit/UnitTests.xml"
    alias render-docs="docker run --rm --pull always -v ./:/project/ ghcr.io/typo3-documentation/render-guides:latest --no-progress --config=Documentation Documentation"
    alias render-sync="open http://localhost:5174/Documentation-GENERATED-temp/Index.html && docker run --rm -it --pull always -v ./Documentation:/project/Documentation -v ./Documentation-GENERATED-temp:/project/Documentation-GENERATED-temp -p 5174:5173 ghcr.io/garvinhicking/typo3-documentation-browsersync:latest"
    alias render-changelog="docker run --rm --pull always -v ./:/project/ ghcr.io/typo3-documentation/render-guides:latest --no-progress --config=typo3/sysext/core/Documentation typo3/sysext/core/Documentation"
    alias t3-build="Build/Scripts/runTests.sh -s composerInstall ; Build/Scripts/runTests.sh -s clean ; Build/Scripts/runTests.sh -s buildCss ; Build/Scripts/runTests.sh -s buildJavascript"

Advantages:

*   Runs quick and locally
*   Well suited if you are the only one running tests

Disadvantages:

*   Requires all the tooling to be installed locally
*   Cannot be re-used for automated testing on GitHub or GitLab
*   Sharing aliases is cumbersome and requires everyone involved
    to do this in their local environment

..  _testing-organization-bash-script:

Write a bash script
===================

Similar to the bash alias, you can also create a script file for
each of your tasks, like a :file:`execute-phpunit.sh` file:

..  code-block:: bash
    :caption: execute-phpunit.sh

    #!/bin/bash
    composer install && php vendor/bin/phpunit -c Build/phpunit/UnitTests.xml

Simple scripts like these (only containing basic commands) could be
put into the project's Git repository and even be shared to other people
to be executed.

Advantages:

*   Can be shared and re-used
*   Could also be executed on automated environments (as long as all
    dependencies are installed in the environment)
*   Easy to understand
*   Good compatibility because Bash is available cross-platform

Disadvantages:

*   Requires local environment (i.e. proper PHP version)
*   Maintaining compatibility to other operating systems may be hard

..  _testing-organization-ddev:

Introduce custom DDEV commands
==============================

If your project is already utilizing `ddev <https://ddev.com>`__,
you can make use of custom commands delivered with your project's
:file:`.ddev/` configuration infrastructure.

Details for creating these commands can be found in the
`ddev Manual <https://ddev.readthedocs.io/en/stable/users/extend/custom-commands/#custom-commands>`__.

Advantages:

*   Commands can be executed inside the ddev environment with exactly
    the right dependencies and software versions
*   No further local dependency apart from ddev; PHP and other components
    are set within the container already.
*   Can be shared just as easily like your ddev configuration, all people
    involved can use it without further setup.

Disadvantages:

*   Can not be (easily) used for automated deployment due to the ddev dependency.
*   Some tools that depend on docker (for example, the documentation rendering)
    cannot be used easily, because docker-in-docker is a problem. These commands
    might then needed to be run locally, outside the container (commands also allow this)
*   People without ddev cannot execute your commands, even if they could run the
    project itself without ddev. So this would fix your testing on a ddev dependency.

..  _testing-organization-composer:

Introduce a Composer script
===========================

Since most projects involving TYPO3 are already Composer-based, you could
create specific `Composer scripts <https://getcomposer.org/doc/articles/scripts.md>`__
for each task. Composer could also execute specific docker commands.

An example for a large and thorough integration of Composer scripts is
the `TYPO3-documentation/tea <https://github.com/FriendsOfTYPO3/tea>`__ repository,
if you start by inspecting its `composer.json <https://github.com/FriendsOfTYPO3/tea/blob/main/composer.json>`__ file.

Advantages:

*    Integrated into the PHP ecosystem, allows to run both PHP scripts and
     shell commands
*    Commands can be grouped and structured well, dependencies of scripts can
     be configured
*    Can be utilized by everyone running Composer already (both inside and outside
     of containers)
*    Can be easily shared, because the `composer.json` file is already shared to everyone.
*    Can be easily used by automated testing, for example in GitHub Actions and GitLab Pipelines.
*    Available scripts are easily revealed in the Composer help output

Disadvantages:

*    Depends on PHP, so when executed on the host, the environments and dependencies need to match
*    PHP running certain processes (like Docker containers) may introduce memory or other
     timeout limits and problems

..  _testing-organization-makefile:

Create a Makefile
=================

On most systems, a `Makefile <https://www.gnu.org/software/make/manual/make.html>`__ can
be used for scripting and running tasks. The TYPO3 Documentation repositories often
utilize this, because it offers a nice way of listing all available Makefile tasks
and run them on the host computer. Makefiles can also be scripted with variables
and conditions.

Advantages:

*    Makefiles are a well-known standard even outside PHP projects
*    Makefiles can be easily shared and usually executed on both host side and
     within containers
*    Makefiles can also be used for automated testing (GitHub Actions, GitLab Pipelines)
*    Makefiles offer code completion and help texts

Disadvantages:

*    Makefiles are harder to read and write, and using them as a "script runner"
     is frowned upon for "abusing" the original intent of Makefiles (compiling software).
*    Makefiles are considered "legacy" and are not so common within PHP projects

..  _testing-organization-just:

Use dedicated tools like `just`
===============================

As an alternative to `Makefile`, tools like `just <https://github.com/casey/just>`__
are aimed to be script runners, cross-platform compatible.

Advantages:

*   Dedicated tooling, cross-platform execution
*   Modern development and configuration, easily shareable

Disadvantages:

*   Software like this needs to be installed specifically and create
    a dependency. The chosen software might not be maintained in the future
*   Using the software may need training for people involved
*   Using this in automated testing environments require installation


..  _testing-organization-runtests-core:

Use the :file:`runTests.sh` script based on the TYPO3-Core
==========================================================

Because of the need to run tests reliably the same way for everyone,
the TYPO3 core internally uses the script
`runTests.sh <https://github.com/TYPO3/typo3/blob/main/Build/Scripts/runTests.sh>`__.

This is based on the aforementioned :ref:`bash script <testing-organization-bash-script>`.

The script is tailored specifically to running TYPO3 Core tests, which can be
very close to your own needs. All of the commands in the script are executed
using dockerized PHP and other components.

The script also takes care of running database containers, thus making everything
highly adaptable to specific PHP versions and other tooling. The only dependency
to run this locally, is having `docker` (or `podman`) and `bash`.

Because of this,
the script is highly suitable for running matrix-based automated testing with
diverse configurations.

It also offers a very useful `xdebug <https://xdebug.org>`__ integration for tests,
so that you can easily use an IDE to hook into any test execution. The script
is actively used and maintained by the TYPO3 Core team with great care.

Advantages:

*   Close to no dependencies other than `docker` and `bash`
*   Tightly adapted to TYPO3 needs
*   well-maintained
*   very powerful for matrix-based automated testing
*   very adaptable

Disadvantages:

*   Very hard and complex to maintain for people without a good `bash` and `docker`
    knowledge
*   Copy+Paste of the script will require YOU to take over maintaining the script
    in case of bugs, security issues or new tools
*   Stripping down and adapting the file to suit your needs takes some effort

..  _testing-organization-runtests-blog:

Use a customized :file:`runTests.sh` script based on `blog_example`
===================================================================

Because the `runTests.sh` file of the TYPO3 Core may be intimidating,
several TYPO3 projects have already adapted the script and stripped
down to more basic needs.

One example of this is the `TYPO3-Documentation/blog_example <https://github.com/TYPO3-Documentation/blog_example/blob/main/Build/Scripts/runTests.sh>`__
adaption. This script contains the most basic commands to execute
commands:

*   CGL (`runTests.sh -s cgl`)
*   Composer installation (`runTests.sh -s composer ...`)
*   Linting (`runTests.sh -s lint`)
*   Code analysis (`runTests.sh -s phpstan`)
*   Unit tests (`runTests.sh -s unit`)
*   Functional tests (`runTests.sh -s functional`)
*   Rendering documentation (`runTests.sh -s renderDocumentation`)
*   ... and a few more

Advantages:

*   Mostly the same advantages like the "normal" `runTests.sh`
*   A more "real life" example outside the TYPO3 Core on how to
    use the **idea** of the `runTests.sh` script (providing docker-ized
    command execution).
*   Better readable due to clearer focus

Disadvantages:

*   Even though it could be copy+pasted by you, the same disadvantages
    like the "normal" `runTests.sh` apply: Still needs to be maintained
    by you, cannot be included as a "composer dependency"
*   Future changes to the script may be more tailored to the needs of
    `blog-example`.

Sidenote for the daring: An experiment has been made in
`garvinhicking/typo3-tf-runtests <https://github.com/garvinhicking/typo3-tf-runtests>`__
as a "proof of concept" to make the Core's `runTests.sh` file able to run custom commands,
and be utilized as a Composer package. This work will very likely never be implemented,
because the TYPO3 Core is not suited to provide `runTests.sh` as an API due to it's
focus. However, this may be a base for your own experiments on making a script runner
adaptable.

..  _testing-organization-generator:

Use a generator
===============

All the variants described above have the shared disadvantage,
that you yourself as a project maintainer are responsible for
creating the scripts and configuration for any script runner.

Depending on your skillset, this may be a task you are not willing
to take on.

Thus, effort is being made to offer generators that can create
Composer script integration plus helpers, to achieve integrating
a choice of most common tools.

Please check out the work of the `TYPO3 Best Practices Team <https://typo3.org/community/teams/best-practices>`__
for more information on this. If you are interested in helping
this effort, please get in touch.

Advantages:

*   You will not need to maintain configuration and scripts
    yourself
*   You can pick from lists of suggested tooling, and adapt to
    your needs

Disadvantages:

*   This tool is still work in progress (and may not even come to fruition)
*   The generated configuration/commands may be opinionated (just as `runTests.sh`),
    and may not suit your needs
*   Updates to configuration and new tooling will need you to regard this
    as a dependency, and require you to update your command configuration to fix
    bugs or security issues
