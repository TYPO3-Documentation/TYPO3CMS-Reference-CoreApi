.. include:: /Includes.rst.txt

.. _console-command-tutorial:

========
Tutorial
========

Create a console command from scratch
=====================================

A console command is always situated in an extension. If you want to create
one, :ref:`kickstart a custom extension <extension-kickstart>` or use your
sitepackage extension.

.. _console-command-tutorial-create:

Creating a basic command
========================

The extension kickstarter ":ref:`Make <extension-make>`" offers a convenient
console command that creates a new command in an extension of your choice:
:ref:`Create a new console command with "Make" <extension-make-console-command>`.
You can use "Make" to create a console command even if your extension was
created by different means.

This command can be found in the
`Examples extension <https://github.com/TYPO3-Documentation/t3docs-examples>`__.

.. _console-command-tutorial-registration-services:

1. Register the command
-----------------------

..  note::
    The Symfony PHP attribute :php:`\Symfony\Component\Console\Attribute\AsCommand`
    registers console commands.
    See the section :ref:`console-command-tutorial-registration-attribute`
    for more details.

Register the command in :file:`Configuration/Services.yaml` by adding the service
definition for your class as tag :yaml:`console.command`:

..  code-block:: yaml
    :caption: EXT:examples/Configuration/Services.yaml
    :emphasize-lines: 11-15

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
          # Also an alias for the command can be configured
          - name: console.command
            command: 'examples:dosomethingalias'
            alias: true

The following attributes are available:

:yaml:`command`
    The name under which the command is available.

:yaml:`description`
    Give a short description. It will be displayed in the list of commands and
    the help information of the command.

.. _deactivating-the-command-in-scheduler:
.. _schedulable:

:yaml:`schedulable`
    By default, a command can be used in the :doc:`scheduler
    <ext_scheduler:Index>`, too. This can be disabled by setting
    :yaml:`schedulable` to :yaml:`false`.

:yaml:`hidden`
    A command can be hidden from the command list by setting :yaml:`hidden` to
    :yaml:`true`.

:yaml:`alias`
    A command can be made available under a different name. Set to :yaml:`true`,
    if your command name is an alias.

..  note::
    Despite using :file:`autoconfigure: true` the commands
    have to be explicitly defined in :file:`Configuration/Services.yaml`. It
    is recommended to always supply a description, otherwise there is
    an empty space in the list of commands.

2. Create the command class
---------------------------

Create a class called :php:`DoSomethingCommand` extending
:php:`\Symfony\Component\Console\Command\Command`.

..  include:: /CodeSnippets/Tutorials/Command/Classes/DoSomethingCommand.rst.txt

The following two methods should be overridden by your class:

:php:`configure()`
    As the name would suggest, allows to configure the command.
    The method allows to add a help text and/or define arguments and options.

:php:`execute()`
    Contains the logic when executing the command. Must
    return an integer. It is considered best practice to
    return the constants
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

         vendor/bin/typo3 examples:dosomething

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3 examples:dosomething

The command will return without a message as it does nothing but stating it
succeeded.

..  note::
    If a newly created or changed command is not found, clear the cache:

    .. code-block:: bash

        vendor/bin/typo3 cache:flush


..  _console-command-tutorial-registration-attribute:

Use the PHP attribute to register commands
==========================================

CLI commands can be registered by setting the attribute
:php:`\Symfony\Component\Console\Attribute\AsCommand` on the command class.
When using this attribute there is no need to register the command in the
:file:`Services.yaml` file.

..  note::
    Only the parameters `command`, `description`, `aliases` and `hidden` are
    available. In order to overwrite the parameter `schedulable` use the
    registration via
    :ref:`Services.yaml <console-command-tutorial-registration-services>`.
    By default, `schedulable` is true.

The :ref:`example above <console-command-tutorial-create>` can also be
registered this way:

..  literalinclude:: _Tutorial/_DoSomethingCommandViaAttribute.php
    :language: php
    :caption: EXT:my_extension/Classes/Command/MyCommand.php


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
    :emphasize-lines: 9

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


..  _console-command-tutorial-fe-request:

Initialize a frontend request in a console command
==================================================

If you want to use Extbase repositories within the command, or for example
`Send a FluidEmail <https://docs.typo3.org/permalink/t3coreapi:mail-fluid-email>`_
you will need a valid frontend request.

A frontend request can be initialized with this call inside :php:`execute()`
method:

..  literalinclude:: _Tutorial/_InitializeRequest.php
    :caption: packages/my_extension/Classes/Command/DoBackendRelatedThingsCommand.php

..  note::
    Creating a request this way is using *internal* functionality and subject to
    change without notice.

    See the forge issue: https://forge.typo3.org/issues/105554

More information
================

*   See implementation of existing command controllers in the Core:
    :file:`typo3/sysext/*/Classes/Command`
*   `Symfony Command Documentation <https://symfony.com/doc/current/console.html>`__
*   `Symfony Commands: Console Input (Arguments &
    Options) <https://symfony.com/doc/current/console/input.html>`__
