.. include:: ../../../Includes.txt


.. _cli-mode:

==================================
TYPO3 CMS Shell Scripts (CLI Mode)
==================================

Besides the backend, it is also possible to run some TYPO3 CMS
scripts from the command line. This makes it possible - for
example - to set up cronjobs. There are two ways to register
CLI scripts:

#. Using the TYPO3 command-line dispatcher based on Symfony Commands.
#. Creating an Extbase command controller (`deprecated since TYPO3 v9 <https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.4/Deprecation-85977-ExtbaseCommandControllersAndCliAnnotation.html>`_).


.. _cli-mode-dispatcher:

1. The Command-line Dispatcher (Symfony)
========================================

TYPO3 uses Symfony commands to provide an easy to use, well-documented API for
writing CLI commands.

Creating a new Symfony Command in Your Extension
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
    protected function configure()
    {
        $this->setDescription('Show entries from the sys_log database table of the last 24 hours.');
        $this->setHelp('Prints a list of recent sys_log entries.' . LF . 'If you want to get more detailed information, use the --verbose option.');
    }


The :php:`execute` method contains the logic you want to execute when executing the command.

A detailed description and an example can be found at `the Symfony Command Documentation <https://symfony.com/doc/current/console.html>`_.


.. _cli-mode-command-controllers:

2. Extbase Command Controllers
==============================

.. warning::

   Extbase command controllers are deprecated since TYPO3 v9. Use symfony commands as
   outlined above.

Creating an Extbase Command Controller
--------------------------------------

First of all, the command controller must be registered in an extension's
:file:`ext_localconf.php` file (example taken from the "lang" system
extension):

.. code-block:: php

     // Register language update command controller
     $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \TYPO3\CMS\Lang\Command\LanguageCommandController::class;

The class itself must extend the :code:`\TYPO3\CMS\Extbase\Mvc\Controller\CommandController`
class. Each action that should be available from the command line must
be named following the pattern "[action name]Command". The PHPdoc information
will be shown as help text on the command line.

Some commands need to be flexible and therefore need some arguments which may be optional or required.
To make an argument optional, provide a default value.

You can define them the following way:

.. code-block:: php

   /**
    * @param int $required
    * @param bool $optional
    */
   public function argumentsCommand($required, $optional = false)
   {

   }


Example
~~~~~~~

Here's an extract from the command controller class of the "lang"
extension:

.. note::

   This command controller no longer exists in the TYPO3 core in TYPO3 9.

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

Calling an Extbase Command Controller From the Command Line
-----------------------------------------------------------

This command would be called by using:

.. code-block:: shell

     $ /path/to/php bin/typo3 extbase language:update fr

which would update translation packages for the French language.

Show help:

.. code-block:: shell

   $ /path/to/php bin/typo3 extbase help language:update