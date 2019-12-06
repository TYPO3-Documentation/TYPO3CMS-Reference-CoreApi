.. include:: ../../Includes.txt


.. _cli-mode:
.. _cli-mode-dispatcher:
.. _cli-mode-command-controllers:

==================================
Command Line Dispatcher (Symfony)
==================================

It is possible to run some TYPO3 CMS scripts from the
command line. This makes it possible - for example -
to set up cronjobs.

TYPO3 uses Symfony commands to provide an easy to use, well-documented API for
writing CLI (command line interface) commands.


Creating a new Symfony Command in Your Extension
------------------------------------------------

.. rst-class:: bignums-xxl

#. Add :file:`Configuration/Commands.php` to your extension

   TYPO3 looks in this file for configured commands. It should
   return a simple array with the command name and class.

   For example to add a command named **yourext:dothings**::

       return [
           'yourext:dothings' => [
               'class' => \Vendor\Extension\Command\DoThingsCommand::class
           ],
       ];

   By default, the command can be used in the scheduler too. You can deactivate
   this by setting `schedulable` to `false`::

      return [
          'yourext:dothings' => [
              'class' => \Vendor\Extension\Command\DoThingsCommand::class,
              'schedulable' => false,
          ]
      ];


#. Create the corresponding class file: :file:`Classes/Command/DoThingsCommand.php`

   Symfony commands should extend the class :php:`Symfony\Component\Console\Command\Command`.

   The command should implement at least a :php:`configure` and an :php:`execute` method.


   **configure()** as the name would suggest allows to configure the command.
   Via :php:`configure()`, a description or a help text can be added, or mandatory and optional arguments and parameters defined.

   A simple example can be found in the :php:`ListSysLogCommand`:

   .. code-block:: php

       /**
        * Configure the command by defining the name, options and arguments
        */
       protected function configure()
       {
           $this->setDescription('Show entries from the sys_log database table of the last 24 hours.');
           $this->setHelp('Prints a list of recent sys_log entries.' . LF . 'If you want to get more detailed information, use the --verbose option.');
       }



   **execute()** contains the logic you want to execute when executing the command.

.. seealso::

   A detailed description and an example can be found in `the Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_.

Running the Command From the Command Line
-----------------------------------------

The above example can be run via command line:

.. code-block:: bash

   bin/typo3 yourext:dothings


Running the Command From the Scheduler
--------------------------------------

By default, it is possible to run the command from the
`TYPO3 scheduler <https://docs.typo3.org/c/typo3/cms-scheduler/master/en-us/>`__ as well
if (`schedulable` is not set to false).

In the backend: :guilabel:`SYSTEM > Scheduler`

<<<<<<< HEAD
=======
By default, it is possible to run the command from the `TYPO3 scheduler
<sched:start>`__ as well, if not deactivated see:
:ref:`deactivating-the-command-in-scheduler`.
>>>>>>> 55518010... Changes for migrating "Adding your own Content Elements"
