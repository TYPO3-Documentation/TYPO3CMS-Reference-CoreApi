:navigation-title: Console tools
..  include:: /Includes.rst.txt
..  index:: Site handling; CLI tools
..  _sitehandling-cliTools:

===========================
CLI tools for site handling
===========================

Two :ref:`CLI commands <symfony-console-commands>` are available:

*   `site:list`
*   `site:show`


List all configured sites
=========================

The following command will list all configured sites with their identifier, root
page, base URL, languages, locales and a flag whether or not the site is
enabled.

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 site:list

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 site:list


Show configuration for one site
===============================

The show command needs an :ref:`identifier of a configured site
<sitehandling-basics-site-identifier>` which must be provided after the command
name. The command will output the complete configuration for the site in YAML
syntax.

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 site:show <identifier>

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 site:show <identifier>
