.. include:: ../../../Includes.txt


.. _cli-mode:

TYPO3 CMS shell scripts (CLI mode)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Besides the backend, it is also possible to run some TYPO3 CMS
scripts from the command line. This makes it possible - for
example - to set up cronjobs. There are two ways to register
CLI scripts:

- using the :file:`TYPO3` command-line dispatcher based on Symfony Commands.

- creating an Extbase command controller.


.. _cli-mode-dispatcher:

The command-line dispatcher
"""""""""""""""""""""""""""

TYPO3 uses Symfony commands to provide an easy to use, well-documented API for
writing CLI commands.

Creating a new Symfony command in your extension
------------------------------------------------

Symfony commands should extend the class :php:`Symfony\Component\Console\Command\Command`.

TYPO3 looks in a file :file:`Commands.php` in the :file:`Configuration` folder of extensions for configured commands.
The :file:`Commands.php` file returns a simple array with the command name and class.

For example to add a command which can be called via :code:`bin/typo3 yourext:dothings` add the following:

.. code-block:: php

    return [
        'yourext:dothings' => [
            'class' => \Vendor\Extension\Command\DoThingsCommand::class
        ],
    ];

The command should implement at least a :php:`configure` and an :php:`execute` method.

:php:`configure` as the name would suggest allows to configure the command.
Via :php:`configure` a description or a help text can be added, or mandatory and optional arguments and parameters defined.

A simple example can be found in the :php:`ListSysLogCommand`:

.. code-block:: php

    /**
     * Configure the command by defining the name, options and arguments
     */
    public function configure()
    {
        $this->setDescription('Show entries from the sys_log database table of the last 24 hours.');
        $this->setHelp('Prints a list of recent sys_log entries.' . LF . 'If you want to get more detailed information, use the --verbose option.');
    }


The :php:`execute` method contains the logic you want to execute when executing the command.

A detailed description and an example can be found at `the Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_.


.. _cli-mode-command-controllers:

Extbase command controllers
"""""""""""""""""""""""""""

.. note::

   If you do not need Extbase in your command it is recommended to directly use
   a Symfony command (see above).

First of all, the command controller must be registered in an extension's
:file:`ext_localconf.php` file (example taken from the "lang" system
extension):

.. code-block:: php

     // Register language update command controller
     $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \TYPO3\CMS\Lang\Command\LanguageCommandController::class;

The class itself must extend the :code:`\TYPO3\CMS\Extbase\Mvc\Controller\CommandController`
class. Each action that should be available from the command line must
be named following the pattern "[action name]Command". The PHPdoc information
is directly used as help text (description of the action, what arguments it
takes).

Here's an extract from the command controller class of the "lang"
extension:

.. code-block:: php

     /**
      * Language command controller updates translation packages
      */
     class LanguageCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
     {
         // ...

         /**
          * Update language file for each extension
          *
          * @param string $localesToUpdate Comma separated list of locales that needs to be updated
          * @return void
          */
         public function updateCommand($localesToUpdate = '')
         {
             // ...
         }
     }

This command would be called by using:

.. code-block:: shell

     $ /path/to/php bin/typo3 extbase language:update fr

which would update translation packages for the French language.
