:navigation-title: Custom Commands

..  include:: /Includes.rst.txt
..  _writing-custom-commands:

=======================
Writing custom commands
=======================

TYPO3 uses the Symfony Console component to define and execute command-line
interface (CLI) commands. Custom commands allow extension developers to
provide their own functionality for use on the command line or in the TYPO3
scheduler.

..  seealso::

    *   For a step-by-step guide, see:
        :ref:`Tutorial: Create a console command <console-command-tutorial>`.

..  contents:: Table of contents

..  _writing-custom-symfony-console-command:

The custom command class
========================

To implement a console command in TYPO3 extend the
:php:`\Symfony\Component\Console\Command\Command` class.

..  seealso::

    Console commands in TYPO3 are based on the same technology as
    commands in Symfony. Find more information about
    `Commands in the Symfony documentation <https://symfony.com/doc/current/console.html>`_.

..  _console-command-tutorial-registration-services:

Console command registration
============================

There are two ways that a console command can be registered: you can use the
PHP Attribute AsCommand or register the command in your :file:`Services.yaml`:

..  _console-command-tutorial-registration-attribute:

PHP attribute `AsCommand`
-------------------------

CLI commands can be registered by setting the attribute
:php:`\Symfony\Component\Console\Attribute\AsCommand` in the command class.
When using this attribute there is no need to register the command in
:file:`Services.yaml`.

..  code-block:: php

    #[AsCommand(
        name: 'examples:dosomething',
        description: 'A command that does nothing and always succeeds.',
        aliases: ['examples:dosomethingalias'],
    )]


The following parameters are available:

`name`
    The name under which the command is available.

`description`
    Gives a short description. It will be displayed in the list of commands and
    the help information for the command.

`hidden`
    Hide the command from the command list by setting :yaml:`hidden` to
    :yaml:`true`.

`alias`
    A command can be made available under a different name. Set to :yaml:`true`
    if your command name is an alias.

If you want to set a command as `non-schedulable  <console-command-tutorial-registration-tag>`_
it has to be registered via tag not attribute.

..  _console-command-tutorial-registration-tag:

Tag `console.command` in the `Services.yaml`
--------------------------------------------

You can register the command in :file:`Configuration/Services.yaml` by adding the service
definition of your class as a tag :yaml:`console.command`:

..  code-block:: yaml
    :caption: packages/my_extension/Configuration/Services.yaml

    services:
      # ...

      MyVendor\MyExtension\Command\DoSomethingCommand:
        tags:
          - name: console.command
            command: 'examples:dosomething'
            description: 'A command that does nothing and always succeeds.'
            // To hide it from the scheduler:
            schedulable: false
          # Also an alias for the command can be configured
          - name: console.command
            command: 'examples:dosomethingalias'
            alias: true

..  note::
    Despite using :file:`autoconfigure: true` the commands
    have to be explicitly defined in :file:`Configuration/Services.yaml` or
    use the PHP attribute :php:`#[AsCommand]`.

..  _deactivating-the-command-in-scheduler:
..  _schedulable:

Making a command non-schedulable
================================

..  versionadded:: 14.0
    The PHP attribute :php:`#[AsNonSchedulableCommand]` has been introduced to
    mark a command as non-schedulable.

    To provide support for both TYPO3 v14 and v13 continue to register your
    command in :file:`Services.yaml` (see
    `Tag console.command in the Services.yaml <https://docs.typo3.org/permalink/t3coreapi:console-command-tutorial-registration-tag>`_).

A command can be set as disabled for the scheduler by using the
:php:`#[AsNonSchedulableCommand]` attribute:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Commands/MyImportCommand.php

    use Symfony\Component\Console\Attribute\AsCommand;
    use Symfony\Component\Console\Command\Command;
    use TYPO3\CMS\Core\Attribute\AsNonSchedulableCommand;

    #[AsCommand('myextension:import', 'Import data from external source')]
    #[AsNonSchedulableCommand]
    final class MyImportCommand extends Command
    {
        // ...
    }

..  _writing-custom-symfony-console-command-context:

Context of a command: No request, no site, no user
==================================================

Commands are called from the console / command line and not through a web
request. Therefore, when the code of your custom command is run by default there
is no `ServerRequest <https://docs.typo3.org/permalink/t3coreapi:typo3-request>`_
available, no backend or frontend user logged in and a request is called without
context of a site or page.

For that reason Site Settings, TypoScript and TSconfig are not loaded by default,
Extbase repositories cannot be used without taking precautions and there are many
more limitations.

..  _writing-custom-commands-extbase:

Extbase limitations in CLI context
----------------------------------

..  attention::

    It is not recommended to use :ref:`Extbase <extbase>` repositories in a
    CLI context.

Extbase relies on frontend :ref:`TypoScript <t3tsref:start>`,  and features such as
:ref:`request-based TypoScript conditions <t3tsref:condition-function-request>`
may not behave as expected.

Instead, use the :ref:`Query Builder <database-query-builder>` or
:ref:`DataHandler <datahandler-basics>` when implementing custom commands.

..  _writing-custom-commands-backend-authentication:

Using the DataHandler in CLI commands
-------------------------------------

When using the :ref:`DataHandler <datahandler-basics>` in a CLI command,
backend user authentication is required. For more information see:
:ref:`dataHandler-cli-command`.

..  _writing-custom-commands-backend-user:

Initialize backend user
-----------------------

A backend user can be initialized inside the :php:`execute()` method as follows:

..  literalinclude:: _Tutorial/_DoBackendRelatedThingsCommand.php
    :caption: packages/my_extension/Classes/Command/DoBackendRelatedThingsCommand.php
    :emphasize-lines: 20

This is necessary when using the :ref:`DataHandler <datahandler-basics>`
or other backend permission-handling-related tasks.

..  _console-command-tutorial-fe-request:
..  _console-command-tutorial-fe-request-example:

Simulating a frontend request in TYPO3 Commands
-----------------------------------------------

Executing a TYPO3 command in the CLI does not trigger a frontend (web)
request. This means that several request attributes required for link generation
via Fluid or TypoScript are missing by default. While setting the `site`
attribute in the request is a first step, it does not fully replicate the
frontend behavior.

..  seealso::
    See chapter :ref:`frontend-requests-simulation`.

A minimal request configuration may be sufficient for
generating simple links or using `FluidEmail <https://docs.typo3.org/permalink/t3coreapi:mail-fluid-email>`_:

..  literalinclude:: _Tutorial/_SendFluidMailCommand.php
    :caption: packages/my_extension/Classes/Command/DoBackendRelatedThingsCommand.php

..  note::
    Simulating a frontend request in CLI is possible but requires
    all bootstrapping steps to be manually carried out. While basic functionality,
    such as link generation, can work with a minimal setup, complex
    TypoScript-based link modifications, access restrictions, and
    context-aware rendering require additional configuration and may still
    behave differently from a real web request.


..  _writing-custom-commands-interaction:

Create a command with arguments and interaction
===============================================

..  _writing-custom-commands-arguments:

Passing arguments
-----------------

Since a command extends :php:`Symfony\Component\Console\Command\Command`,
it is possible to define arguments (ordered) and options (unordered) using the Symfony
command API. This is explained in depth on the following Symfony Documentation page:

..  seealso::

    *   `Symfony: Console Input (Arguments & Options) <https://symfony.com/doc/current/console/input.html>`__

Both arguments and properties can be registered in a command implementation by
overriding the `configure()` method. You can call methods `addArgument()` and
`addOption()` to register them.

This argument can be retrieved with :php:`$input->getArgument()`, the options with
:php:`$input->getOption()`, for example:

..  literalinclude:: _Tutorial/_CreateWizardCommand.php
    :caption: packages/my_extension/Classes/Command/SendFluidMailCommand.php

..  _writing-custom-commands-user-interaction:

User interaction on the console
-------------------------------

You can create a :php:`SymfonyStyle` console user interface using the
:php:`$input` and :php:`$output` parameters of the :php:`execute()` function:

..  literalinclude:: _Tutorial/_CrazyCalculatorCommand.php
    :caption: packages/my_extension/Classes/Command/CrazyCalculatorCommand.php

The :php:`$io` variable can be used to generate output and prompt for
input.

..  _writing-custom-commands-dependencyInjection:

Dependency injection in console commands
========================================

You can use :ref:`dependency injection (DI) <Dependency-Injection>` in console
commands via constructor injection or method injection.

..  literalinclude:: _Tutorial/_MeowInformationCommand.php
    :caption: packages/my_extension/Classes/Command/MeowInformationCommand.php
    :emphasize-lines: 12-13

..  _writing-custom-commands-more:

More about Symfony console commands
===================================

*   See implementation of existing command controllers in the Core:
    :file:`typo3/sysext/*/Classes/Command`
*   `Symfony Command Documentation <https://symfony.com/doc/current/console.html>`__
*   `Symfony Commands: Console Input (Arguments & Options) <https://symfony.com/doc/current/console/input.html>`__
