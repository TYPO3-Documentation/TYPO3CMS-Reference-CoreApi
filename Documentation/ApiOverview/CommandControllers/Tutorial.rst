.. include:: /Includes.rst.txt

.. _console-command-tutorial:

========
Tutorial
========

Create a console command from scratch
=====================================

A console command is always situated in an Extension. If you want to create
one, :ref:`kickstart a custom extension <extension-kickstart>` or use your
sitepackage extension.

Creating a basic command
========================

The extension kickstarter ":ref:`Make <extension-make>`" offers a convenient
console command that creates a new command in an extension of your choice:
:ref:`Create a new console command with "Make" <extension-make-console-command>`.
You can use "Make" to create a console command even if your extension was
created by different means.

This command can be found in the
`Examples extension <https://github.com/TYPO3-Documentation/t3docs-examples>`.

1. Register the command
-----------------------

Register via DI in :file:`Configuration/Services.yaml` by adding the service
definition for your class as tag :yaml:`console.command`:

..  code-block:: yaml
    :caption: EXT:some_extension/Configuration/Services.yaml
    :linenos:
    :emphasize-lines: 12-16

    services:
      _defaults:
        autowire: true
        autoconfigure: true
        public: false

      T3docs\Examples\:
        resource: '../Classes/*'
        exclude: '../Classes/Domain/Model/*'

      T3docs\Examples\Command\DoSomethingCommand:
        tags:
          - name: console.command
            command: 'examples:dosomething'
            description: 'A command that does nothing and always succeeds.'
            schedulable: true

..  note::
    Despite using :file:`autoconfigure: true` the commands
    have to be explicitly defined in :file:`Configuration/Services.yaml`. The
    description is mandatory.

2. Create the command class
---------------------------

Create a class called :php:`DoThingsCommand` extending
:php:`\Symfony\Component\Console\Command\Command`.

..  include:: /CodeSnippets/Tutorials/Command/Classes/DoSomethingCommand.rst.txt

The following two methods should be overridden by your class:

:php:`configure()`
    As the name would suggest, allows to configure the command.
    The method allows to add a help text and/or define arguments.

:php:`execute()`
    Contains the logic when executing the command. Should return
    :php:`Command::SUCCESS` or :php:`Command::FAILURE`.

.. seealso::

   A detailed description and an example can be found in
   `the Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_.

3. Run the command
------------------

The above example can be run via command line:

.. tabs::

   .. group-tab:: Composer-based installation

      .. code-block:: bash

         vendor/bin/typo3 example:dothings

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3 someextension:dothings

The command will return without a message as it does nothing but stating it
succeeded.

..  note::
    If a newly created or changed command is not found, clear the cache:

    .. code-block:: bash

        vendor/bin/typo3 cache:flush


Create a command with arguments and interaction
===============================================

Passing arguments
-----------------

Since a command extends :php:`Symfony\Component\Console\Command\Command`,
it is possible to define arguments (ordered) and options (unordered) using the Symfony
command API. This is explained in depth on the following Symfony Documentation page:

..  seealso::

    *   `Symfony: Console Input (Arguments & Options) <https://symfony.com/doc/current/console/input.html>`__


Add an optional argument and an optional option to your command:

..  include:: /CodeSnippets/Tutorials/Command/Classes/CreateWizardCommandConfiguration.rst.txt

This command takes one optional argument :php:`wizardName` and one optional option,
which can be passed on the command line:

.. tabs::

   .. group-tab:: Composer-based installation

      .. code-block:: bash

         vendor/bin/typo3 examples:createwizard [-b] [wizardName]

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3 examples:createwizard [-b] [wizardName]


This argument can be retrieved with :php:`$input->getArgument()`, the options with
:php:`$input->getOption()`, for example:

..  include:: /CodeSnippets/Tutorials/Command/Classes/CreateWizardCommandExecute.rst.txt

User interaction on the console
-------------------------------

You can create a :php:`SymfonyStyle` console user interface from the
:php:`$input` and :php:`$output` parameters to the :php:`execute()` function:

.. code-block:: php
    :caption: EXT:examples/Classes/Command/CreateWizardCommand.php

    use Symfony\Component\Console\Style\SymfonyStyle;

    final class CreateWizardCommand extends Command
    {
        protected function execute(
            InputInterface $input,
            OutputInterface $output
        ): int {
            $io = new SymfonyStyle($input, $output);
            // do some user interaction
            return Command::SUCCESS;
        }
    }

The :php:`$io` variable can then be used to generate output and prompt for
input:

..  include:: /CodeSnippets/Tutorials/Command/Classes/CreateWizardCommandIo.rst.txt

Dependency injection in console commands
========================================

You can use :ref:`dependency injection (DI) <Dependency-Injection>` in console
commands by constructor injection or method injection:

..  include:: /CodeSnippets/Tutorials/Command/Classes/DependencyInjection.rst.txt

Initialize backend user
=======================

A backend user can be initialized with this call inside :php:`execute()` method:

..  code-block:: php
    :caption: EXT:some_extension/Classes/Command/DoBackendRelatedThingsCommand.php
    :emphasize-lines: 7

    use TYPO3\CMS\Core\Core\Bootstrap;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    final class DoBackendRelatedThingsCommand extends Command
    {
        protected function execute(InputInterface $input, OutputInterface $output): int
        {
            Bootstrap::initializeBackendAuthentication();
            // Do backend related stuff

            return Command::SUCCESS;
        }
    }

This is necessary when using :ref:`DataHandler <datahandler-basics>`
or other backend permission handling related tasks.

More information
================

*   See implementation of existing command controllers in the Core:
    :file:`typo3/sysext/*/Classes/Command`
*   `Symfony Command Documentation <https://symfony.com/doc/current/console.html>`__
*   `Symfony Commands: Console Input (Arguments &
    Options) <https://symfony.com/doc/current/console/input.html>`__
