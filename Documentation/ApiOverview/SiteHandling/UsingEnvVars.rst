.. include:: /Includes.rst.txt
.. index::
   Site handling; Environment variables
   %env(BASE_DOMAIN)%
.. _sitehandling-using-env-vars:

=====================================================
Using environment variables in the site configuration
=====================================================

Environment Variables in site configuration allows setting placeholders for configuration options
that get replaced by environment variables specific to the current environment.

The format for environment variables is `%env(ENV_NAME)%`. Environment variables may be used to replace
complete values or parts of a value.

Example:

.. code-block:: yaml

    base: 'https://%env(BASE_DOMAIN)%/'

When using environment variables in conditions, make sure to quote them correctly:

.. code-block:: yaml

    condition: '"%env(my_env)%" == "my_comparison_string"'


.. note::

    Since TYPO3 v10.2 it's also possible to use env variables in imports:
    `resource: 'MyFile_%env("foo")%.yaml'`

TYPO3 does not provide a loader for .env files - you have to take care of loading them yourself.
Common options include setting environment configuration via server configuration or
using `vlucas/phpdotenv <https://packagist.org/packages/vlucas/phpdotenv>`_.
