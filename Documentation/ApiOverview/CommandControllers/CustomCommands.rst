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

For a step-by-step guide, see:
:ref:`Tutorial: Create a console command <console-command-tutorial>`

..  todo: Improve this in a follow up, especially what should go here and what in the tutorial

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

Backend authentication
----------------------

When using the :ref:`DataHandler <datahandler-basics>` in a CLI command,
backend user authentication is required. For more information, refer to:
:ref:`dataHandler-cli-command`.
