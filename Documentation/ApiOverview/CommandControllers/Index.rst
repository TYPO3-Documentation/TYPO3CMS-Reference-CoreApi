.. include:: /Includes.rst.txt

.. _cli-mode:
.. _cli-mode-dispatcher:
.. _cli-mode-command-controllers:
.. _symfony-console-commands:

==============================
Symfony Console Commands (cli)
==============================

It is possible to run TYPO3 CMS scripts from the command line.
This functionality can be used to set up cronjobs, for example.

TYPO3 uses Symfony commands API for writing CLI (command line interface) commands.
These commands can also be run from the TYPO3 :ref:`scheduler <symfony-console-commands-scheduler>`.

.. deprecated:: 10
    :doc:`t3core:Changelog/10.3/Deprecation-89139-ConsoleCommandsConfigurationFormatCommandsPhp`

.. versionadded:: 10
    :doc:`t3core:Changelog/10.3/Feature-89139-AddDependencyInjectionSupportForConsoleCommands`

Creating a new Command in Extensions
====================================

.. rst-class:: bignums-xxl

#. Register Commands

   Commands can be registered via :ref:`DependencyInjection`.
   Detailed information can be read on the corresponding Symfony component
   documentation: https://symfony.com/doc/current/console/commands_as_services.html.
   E.g. how to setup aliases via :file:`Services.yaml`,
   or how to use dependency injection in commands.

   The following example will add a command named ``yourext:dothings``.

   Register via DI in :file:`Configuration/Services.yaml` by adding the service definition for your class::

     services:

       Vendor\Extension\Command\DoThingsCommand:
         tags:
           - name: 'console.command'
             command: 'yourext:dothings'
             description: 'An example description for a command'
             # not required, defaults to false
             hidden: false

   .. note::

      Despite using :file:`autoconfigure: true` the commands
      have to be explicitly defined in :file:`Services.yaml` for TYPO3s custom command processing
      by adding the tag including the command name, the command to execute and a description.


#. Create the corresponding class file: :file:`Classes/Command/DoThingsCommand.php`

   Symfony commands should extend the class :php:`\Symfony\Component\Console\Command\Command`.

   The command should implement at least a :php:`configure()` and an :php:`execute()` method.

   :php:`configure()`
      As the name would suggest allows to configure the command.
      Allows to add a help text and / or define arguments.

   :php:`execute()`
      Contains the logic when executing the command.

.. seealso::

   A detailed description and an example can be found in
   `the Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_.

Command Class
-------------

Example taken from :php:`ListSysLogCommand` in the Core and simplified::

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Style\SymfonyStyle;

    class DoThingsCommand extends Command
    {
        /**
         * Configure the command by defining the name, options and arguments
         */
        protected function configure()
        {
            $this->setHelp('Prints a list of recent sys_log entries.' . LF . 'If you want to get more detailed information, use the --verbose option.');
        }

        /**
         * Executes the command for showing sys_log entries
         *
         * @param InputInterface $input
         * @param OutputInterface $output
         * @return int error code
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $io = new SymfonyStyle($input, $output);
            $io->title($this->getDescription());

            // ...
            $io->writeln('Write something');
            return Command::SUCCESS;
        }
    }

Return value
------------

.. versionchanged:: 10

   `It is now mandatory to return a value <https://symfony.com/blog/new-in-symfony-5-1-misc-improvements-part-1>`__
   in :php:`execute()`. Since TYPO3 version 10 (and `symfony/console` version 5),
   using :php:`execute()` without return will result in an exception.

The return type is :php:`int`, :php:`Command::SUCCESS` or :php:`Command::FAILURE`
can be used.

Passing Arguments
-----------------

Since your command is inherited from :php:`Symfony\Component\Console\Command\Command`,
it is possible to define arguments (ordered) and options (unordered) using the Symfony
command API. This is explained in depth on the following Symfony Documentation page:

.. seealso::

   * `Symfony: Console Input (Arguments & Options) <https://symfony.com/doc/current/console/input.html>`__


Add an optional argument and an optional option to your command::

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setDescription('Run content importer. Without arguments all available wizards will be run.')
            ->addArgument(
                'wizardName',
                InputArgument::OPTIONAL,
                'Here is a description for your argument'
            )
            ->addOption(
               'brute-force',
               'b',
               InputOption::VALUE_OPTIONAL,
               'Some optional option for your wizard(s). You can use --brute-force or -b when running command'
           );
    }


This command takes one optional argument :php:`wizardName` and one optional option,
which can be passed on the command line:

.. code-block:: bash

   vendor/bin/typo3 yourext:dothings [-b] [wizardName]


This argument can be retrieved with :php:`$input->getArgument()`, the options with
:php:`$input->getOption()`, for example::

   protected function execute(InputInterface $input, OutputInterface $output)
   {
      // ...

      if ($input->getArgument('wizardName')) {

         // ...

      }

      if ($input->getOption('brute-force')) {

      // ...

      }


.. _deactivating-the-command-in-scheduler:
.. _schedulable:

Deactivating the Command in Scheduler
-------------------------------------

By default, the command can be used in the scheduler too.
This can be disabled by setting ``schedulable`` to ``false`` in :file:`Configuration/Services.yaml`::

   services:
     _defaults:
       autowire: true
       autoconfigure: true
       public: false

     Vendor\Extension\:
       resource: '../Classes/*'

     Vendor\Extension\Command\DoThingsCommand:
       tags:
         - name: 'console.command'
           command: 'yourext:dothings'
           schedulable: false


Or inside :file:`Configuration/Commands.php`.
Deprecated since v10 and will be removed in v11::

   return [
       'yourext:dothings' => [
           'class' => \Vendor\Extension\Command\DoThingsCommand::class,
           'schedulable' => false,
       ],
   ];

Hide a command
--------------

A command can be hidden from the command list by setting :yaml:`hidden` to :yaml:`true`
in the :file:`Services.yaml` file:

.. code-block:: yaml

    # Configuration/Services.yaml
    services:
      My\Namespace\Command\ExampleCommand:
        tags:
          - name: 'console.command'
            command: 'my:example'
            description: 'An example command that demonstrates some stuff'
            hidden: true

Initialize backend user
-----------------------

A backend user can be initialized with this call inside :php:`execute()` method::

   Bootstrap::initializeBackendAuthentication();

This is necessary when using :ref:`DataHandler  <datahandler-basics>`
or other backend permission handling related tasks.

.. _symfony-console-commands-cli:

Running the Command From the Command Line
=========================================

The above example can be run via command line:

.. code-block:: bash

   vendor/bin/typo3 yourext:dothings

Show help for the command:

.. code-block:: bash

   vendor/bin/typo3 yourext:dothings -h

.. tip::

   If you installed TYPO3 without Composer, the path for the executable
   is :file:`typo3/sysext/core/bin/typo3`.


.. _symfony-console-commands-scheduler:

Running the Command From the Scheduler
======================================

By default, it is possible to run the command from the :ref:`TYPO3 scheduler
<sched:start>` as well. For this select the task :guilabel:`Execute console commands`
followed by your command in the :guilabel:`Schedulable Command` field.

.. note::
   You need to save and reopen the task to define command arguments.

In order to prevent commands from being set up as Scheduler tasks,
see :ref:`deactivating-the-command-in-scheduler`.

More information
================

* see existing command controllers in the Core: :file:`typo3/sysext/*/Classes/Command`
* `Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_
* `Symfony Commands: Console Input (Arguments & Options) <https://symfony.com/doc/current/console/input.html>`__
