:navigation-title: Environment variables

..  include:: /Includes.rst.txt
..  index::
    Site handling; Environment variables
    %env(BASE_DOMAIN)%
..  _sitehandling-using-env-vars:

=====================================================
Using environment variables in the site configuration
=====================================================

Environment variables in the site configuration allows setting placeholders for
configuration options that get replaced by environment variables specific to the
current environment.

The format for environment variables is :yaml:`%env(ENV_NAME)%`. Environment
variables may be used to replace complete values or parts of a value.

..  note::
    TYPO3 does not provide a loader for :file:`.env` files - you have to take
    care of loading them yourself. Common options include setting environment
    configuration via server configuration or using `vlucas/phpdotenv`_ or
    `symfony/dotenv`_.

..  _vlucas/phpdotenv: https://github.com/vlucas/phpdotenv
..  _symfony/dotenv: https://github.com/symfony/dotenv


..  _sitehandling-using-env-vars-examples:

Examples: Environment variables in the base and in conditions
=============================================================

..  code-block:: yaml

    base: 'https://%env(BASE_DOMAIN)%/'

When using environment variables in conditions, make sure to quote them
correctly:

..  code-block:: yaml

    condition: '"%env(my_env)%" == "my_comparison_string"'

..  _sitehandling-using-env-vars-empty:

Empty environment variables
===========================

..  versionchanged:: 14.3.11
    :changelog: important-110913-1792506655

    Before, a site configuration that could not be loaded stopped the
    frontend and the backend of all sites.

An environment variable that is empty resolves to an empty string. In the
example above, the base then becomes `https:///`, which is not a valid URL.
TYPO3 skips such a site and reports it as invalid. All other sites keep
working. The module :guilabel:`Site Management > Sites` lists the site under
"Failing site configurations", with the error.

To check the site configuration, for example during deployment, use the
console command
`site:validate <https://docs.typo3.org/permalink/t3coreapi:console-command-site-validate>`_:

..  code-block:: bash

    # Validate all sites
    vendor/bin/typo3 site:validate

    # Validate the site with the identifier "main"
    vendor/bin/typo3 site:validate main

The command fails with a non-zero exit code if a site is invalid. It resolves
the environment variables from the environment of the command. This
environment can differ from the one of the web server, so set the same
variables for the command.
