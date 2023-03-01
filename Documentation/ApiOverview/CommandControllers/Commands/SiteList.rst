.. include:: /Includes.rst.txt

.. _symfony-console-commands-site-list:

=====================================
site:list (List all configured sites)
=====================================

The command will list all configured :ref:`sites <sitehandling>` with their
identifier, root page, base URL, languages, locales and a flag whether or not
the site is enabled.

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 site:list

    ..  group-tab:: Legacy installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 site:list


The command will output, for example:

..  code-block:: none

    All configured sites
    ====================

    +------------+----------+-------------------------+----------------+------------+---------+
    | Identifier | Root PID | Base URL                | Language       | Locale     | Status  |
    +------------+----------+-------------------------+----------------+------------+---------+
    | main       | 1        | https://example.com/    | English (id:0) | en_GB.utf8 | enabled |
    |            |          | https://example.com/de/ | German (id:1)  | de_DE.utf8 | enabled |
    +------------+----------+-------------------------+----------------+------------+---------+
