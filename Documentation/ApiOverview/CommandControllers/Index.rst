.. include:: ../../Includes.txt


.. _cli-mode:
.. _cli-mode-dispatcher:
.. _cli-mode-command-controllers:

==============================
Symfony Console Commands (cli)
==============================

It is possible to run some TYPO3 CMS scripts from the
command line. This makes it possible - for example -
to set up cronjobs.

TYPO3 uses Symfony commands to provide an easy to use, well-documented API for
writing CLI (command line interface) commands.

.. note::

   TYPO3 supports Symfony Console commands natively since TYPO3 v8.

   Extbase Command Controllers are deprecated since v9.4.

Creating a new Symfony Command in Your Extension
================================================

.. rst-class:: bignums-xxl

#. Add :file:`Configuration/Commands.php` to your extension

   TYPO3 looks in this file for configured commands. It should
   return a simple array with the command name and class.

   For example to add a command named `yourext:dothings`::

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
      Allows to add a description or a help text, or mandatory and optional
      arguments and parameters defined.

   :php:`execute()`
      Contains the logic when executing the command.


.. seealso::

   A detailed description and an example can be found in
   `the Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_.


Command Class
-------------

Example taken from :php:`ListSysLogCommand` in the core and simplified::


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


.. _deactivating-the-command-in-scheduler:

Deactivating the Command in Scheduler
-------------------------------------

By default, the command can be used in the scheduler too. You can deactivate
this by setting `schedulable` to `false` in :file:`Configuration/Commands.php`::

   return [
       'yourext:dothings' => [
           'class' => \Vendor\Extension\Command\DoThingsCommand::class,
           'schedulable' => false,
       ],
   ];


Initialize Backend User
-----------------------

If anything related to :ref:`DataHandler  <datahandler-basics>` and backend
permission handling is necessary, you should call this initialization
method once in your :php:`execute()` function::

   Bootstrap::initializeBackendAuthentication();


Running the Command From the Command Line
=========================================


The above example can be run via command line:

.. code-block:: bash

   vendor/bin/typo3 yourext:dothings


Show help for the command:

.. code-block:: bash

   vendor/bin/typo3 help yourext:dothings

.. tip::

   If you installed TYPO3 without Composer, the path for the executable
   is :file:`typo3/sysext/core/bin/typo3`.


Running the Command From the Scheduler
======================================

.. note::

   Running Symfony Console Commands via the scheduler is possible since TYPO3 v9.0.
   The `schedulable` option is available since v9.4.

By default, it is possible to run the command from the `TYPO3 scheduler
<sched:start>`__ as well, if not deactivated see:
:ref:`deactivating-the-command-in-scheduler`.
