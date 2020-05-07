.. include:: ../../Includes.txt

.. _cli-mode:
.. _cli-mode-dispatcher:
.. _cli-mode-command-controllers:
.. _symfony-console-commands:

==============================
Symfony Console Commands (cli)
==============================

It is possible to run TYPO3 CMS scripts from the command line.
This makes it possible to set up cronjobs.

TYPO3 uses Symfony commands API for writing CLI (command line interface) commands.
These commands can also be run from the TYPO3 :ref:`scheduler <symfony-console-commands-scheduler>`.

.. versionadded:: 8
   :doc:`t3core:Changelog/8.0/Feature-73042-IntroduceNativeSupportForSymfonyConsole`

.. deprecated:: 9
    :doc:`t3core:Changelog/9.4/Deprecation-85977-ExtbaseCommandControllersAndCliAnnotation`

.. deprecated:: 10
    :doc:`t3core:Changelog/10.3/Deprecation-89139-ConsoleCommandsConfigurationFormatCommandsPhp`

.. versionadded:: 10
    :doc:`t3core:Changelog/10.3/Feature-89139-AddDependencyInjectionSupportForConsoleCommands`

Creating a new Command in Extensions
====================================

.. rst-class:: bignums-xxl

#. Register Commands

   Commands can be registered via :ref:`DependencyInjection` or a PHP file.
   Detailed information can be read on the corresponding Symfony component
   documentation: https://symfony.com/doc/current/console/commands_as_services.html.
   E.g. how to setup aliases via :file:`Services.yaml`,
   or how to use dependency injection in commands.

   The following example will add a command named ``yourext:dothings``.

   Register via DI in :file:`Configuration/Services.yaml`::

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

   Or register :file:`Configuration/Commands.php`.
   Deprecated since v10 and will be removed in v11::

       return [
           'yourext:dothings' => [
               'class' => \Vendor\Extension\Command\DoThingsCommand::class,
           ],
       ];

#. Create the corresponding class file: :file:`Classes/Command/DoThingsCommand.php`

   Symfony commands should extend the class :php:`\Symfony\Component\Console\Command\Command`.

   The command should implement at least a :php:`configure()` and an :php:`execute()` method.

   :php:`configure()`
      As the name would suggest allows to configure the command.
      Allows to add a description or a help text,
      or mandatory and optional arguments and parameters defined.

   :php:`execute()`
      Contains the logic when executing the command.

.. seealso::

   A detailed description and an example can be found in
   `the Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_.

Command Class
-------------

Example taken from :php:`ListSysLogCommand` in the core and simplified::

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
            $this->setDescription('Show entries from the sys_log database table of the last 24 hours.');
            $this->setHelp('Prints a list of recent sys_log entries.' . LF . 'If you want to get more detailed information, use the --verbose option.');
        }

        /**
         * Executes the command for showing sys_log entries
         *
         * @param InputInterface $input
         * @param OutputInterface $output
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $io = new SymfonyStyle($input, $output);
            $io->title($this->getDescription());

            // ...
            $io->writeln('Write something');
        }
    }

Passing Arguments
-----------------

:php:`\TYPO3\CMS\Install\Command\UpgradeWizardRunCommand`::

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setDescription('Run upgrade wizard. Without arguments all available wizards will be run.')
            ->addArgument(
                'wizardName',
                InputArgument::OPTIONAL
            )->setHelp(
                'This command allows running upgrade wizards on CLI. To run a single wizard add the ' .
                'identifier of the wizard as argument. The identifier of the wizard is the name it is ' .
                'registered with in ext_localconf.'
            );
    }


This command takes one optional argument `wizardName`, which can be passed on the command line:

.. code-block:: bash

   vendor/bin/typo3 upgrade:run [wizardName]

.. _symfony-console-commands-scheduler:
.. _deactivating-the-command-in-scheduler:
.. _schedulable:

Deactivating the Command in Scheduler
-------------------------------------

.. versionadded:: 9
   :doc:`t3core:Changelog/9.0/Feature-79462-IntroduceSchedulerTaskToExecuteConsoleCommand`

.. versionadded:: 9
   :doc:`t3core:Changelog/9.4/Feature-85991-ExcludeSymfonyCommandsFromScheduler`

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

Initialize Backend User
-----------------------

Backend user can be initialized with this call inside :php:`execute()` method::

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

   vendor/bin/typo3 help yourext:dothings

If TYPO3 is installed without Composer,
the path for the executable is :file:`typo3/sysext/core/bin/typo3`.
