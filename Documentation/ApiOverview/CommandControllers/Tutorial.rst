:navigation-title: Tutorial

..  include:: /Includes.rst.txt
..  _console-command-tutorial:

===============================================
Tutorial: Create a console command from scratch
===============================================

A console command is always situated in an extension. If you want to create
one, :ref:`kickstart a custom extension <extension-kickstart>` or use your
site package extension.

..  contents:: Table of contents

..  _console-command-tutorial-create:

Creating a basic command
========================

In this section we create an empty command skeleton. Without parameters or user
interaction.

..  seealso::
    *   :ref:`Create a new console command with "Make" <extension-make-console-command>`.

Create a class called :php:`DoSomethingCommand` extending
:php:`\Symfony\Component\Console\Command\Command`.

..  literalinclude:: _Tutorial/_DoSomethingCommandViaAttribute.php
    :language: php
    :caption: EXT:my_extension/Classes/Command/MyCommand.php

The following two methods should be overridden by your class:

:php:`configure()`
    As the name would suggest, allows to configure the command.
    The method allows to add a help text and/or define arguments and options.

:php:`execute()`
    Contains the logic when executing the command. Must
    return an integer. It is considered best practice to
    return the constants
    :php:`Command::SUCCESS` or :php:`Command::FAILURE`.

The above example can be run via command line. If a newly created or changed
command is not found, clear the cache first:

..  tabs::

    ..  group-tab:: Composer mode

        ..  code-block:: bash

            vendor/bin/typo3 cache:flush
            vendor/bin/typo3 examples:dosomething

    ..  group-tab:: Classic mode

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 cache:flush
            typo3/sysext/core/bin/typo3 examples:dosomething

The command will return without a message as it does nothing but stating it
succeeded.

..  _console-command-tutorial-example:

Example console command implementations
=======================================

..  _console-command-tutorial-parameters:

A command with parameters and arguments
---------------------------------------

..  literalinclude:: _Tutorial/_CreateWizardCommand.php
    :caption: packages/my_extension/Classes/Command/SendFluidMailCommand.php

This command takes one optional argument :php:`wizardName` and one optional option,
which can be passed on the command line:

..  tabs::

   ..  group-tab:: Composer mode

      ..  code-block:: bash

         vendor/bin/typo3 examples:createwizard [-b] [wizardName]

   ..  group-tab:: Classic mode

      ..  code-block:: bash

         typo3/sysext/core/bin/typo3 examples:createwizard [-b] [wizardName]


..  _console-command-tutorial-fluidmail:

Sending a FluidMail via command
-------------------------------

..  literalinclude:: _Tutorial/_SendFluidMailCommand.php
    :caption: packages/my_extension/Classes/Command/SendFluidMailCommand.php
