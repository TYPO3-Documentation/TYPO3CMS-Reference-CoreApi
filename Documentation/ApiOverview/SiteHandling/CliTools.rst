.. include:: /Includes.rst.txt
.. index:: Site handling; CLI tools
.. _sitehandling-cliTools:

===========================
CLI tools for site handling
===========================

Two CLI commands are available:

* site:list
* site:show

The list command can be executed via `typo3/sysext/core/bin/typo3 site:list` and will list all configured sites
with their configured Identifier, root page, base URL, languages, locales and a flag whether or not the site is enabled.

The show command can be executed via `typo3/sysext/core/bin/typo3 site:show <identifier>`.
It needs an identifier of a configured site which must be provided after the command name.
The command will output the complete configuration for the site in the YAML syntax.
