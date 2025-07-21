.. include:: /Includes.rst.txt
.. index::
   Extension development; Make
.. _extension-make-console-command:

============================
Create a new console command
============================

The "Make" extension can be used to create a new :ref:`console
command <symfony-console-commands>`:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 make:command

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 make:command

You will be prompted with a list of installed extensions. If your newly created
extension is missing, check if you installed it properly.

`Enter the command name to execute on CLI [myextension:dosomething]:`
    This name will be used to call the command later on. It should be
    prefixed with your extensions name without special signs. It is considered
    best practise to use the same name as for the controller, in lowercase.

`Should the command be schedulable? (yes/no) [no]:`
    If you want the command to be available in the backend in module
    :guilabel:`System > Scheduler` choose `yes`. If it should be only callable
    from the console, for example if it prompts for input, choose `no`.

Have a look at the created files
================================

The following files will be created or changed:

..  code-block:: none
    :caption: Page tree of directory :file:`src/extensions`

    $ tree src/extensions
    └── my-test
        ├── Classes
        |   └── Command (*)
        |   |   └── DoSomethingCommand.php (*)
        ├── Configuration
        |   └── Services.yaml (*)
        ├── composer.json
        └── ext_emconf.php

Call the new command
====================

After a new console command was created you have to delete the cache for it to
be available, then you can call it from the command line:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 cache:flush
            vendor/bin/typo3 myextension:dosomething

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 cache:flush
            typo3/sysext/core/bin/typo3 myextension:dosomething

Next steps
==========

You can now follow the :ref:`console command tutorial <console-command-tutorial>`
and learn how to use arguments, user interaction, etc.
