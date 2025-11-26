.. include:: /Includes.rst.txt
.. index:: Extension development; File name conventions
.. _extension-files-locations:
.. _extension-reserved-folders-legacy:

==============
File structure
==============

This chapter lists the reserved file and directory names in an extension and
file naming conventions.

It should also help you find your way around
automatically-generated or example extensions and sitepackages.

The following folder and file structure is typical for a TYPO3 extension:

..  directory-tree::
    :level: 1
    :show-file-icons: true

    *   :ref:`Classes <extension-classes>`

        *   ...

    *   :ref:`Configuration <extension-configuration-files>`

        *   :ref:`Backend <extension-configuration-backend>`

            *   :ref:`AjaxRoutes.php <extension-configuration-backend-ajaxroutes>`
            *   :ref:`Modules.php <extension-configuration-backend-modules>`
            *   :ref:`Routes.php <extension-configuration-backend-routes>`

        *   :ref:`Extbase <extension-configuration-extbase>`

            *   :ref:`Persistence <extension-configuration-extbase-persistence>`

                *   :ref:`Classes.php <extension-configuration-extbase-persistence-classes>`

        *   :ref:`TCA <extension-configuration-tca>`

            *   :ref:`Overrides <extension-configuration-tca-overrides>`

                *   <tablename>.php
                *   ...

            *   <tablename>.php
            *   ...

        *   :ref:`Sets <extension-configuration-sets>`

            *   <SetIdentifier>

                *   `config.yaml (mandatory) <https://docs.typo3.org/permalink/t3coreapi:extension-configuration-sets-config-yaml>`_
                *   `settings.definitions.yaml <https://docs.typo3.org/permalink/t3coreapi:extension-configuration-sets-settings-definitions-yaml>`_
                *   `setup.typoscript <https://docs.typo3.org/permalink/t3coreapi:extension-configuration-sets-setup-typoscript>`_
                *   ...

        *   :ref:`TsConfig <extension-configuration-tsconfig>`

            *   ...

        *   :ref:`TypoScript <extension-configuration-typoscript>`

            *   ...

            *   constants.typoscript
            *   setup.typoscript

        *   :ref:`extension-configuration-Icons-php`
        *   :ref:`extension-configuration-page_tsconfig`
        *   :ref:`extension-configuration-services-yaml`
        *   :ref:`extension-configuration-user_tsconfig`

    *   :ref:`Documentation <extension-files-documentation>`

        *   ...

    *   :ref:`Resources <extension-files-Resources>`

        *   :ref:`Private <extension-Resources-Private>`

            *   :ref:`Language <extension-Resources-Private-Language>`

                *   ...

            *   Layouts

                *   ...

            *   Partials

                *   ...

            *   Templates

                *   ...

            *   ...

        *   :ref:`Public <extension-Resources-Public>`

            *   ...

    *   :ref:`Tests <extension-files-tests>`

        *   Functional

            *   ...

        *   Unit

            *   ...

        *   ...

    *   :ref:`composer.json <files-composer-json>`
    *   :ref:`ext_emconf.php <ext_emconf-php>`
    *   :ref:`ext_localconf.php <ext-localconf-php>`
    *   :ref:`ext_tables.php <ext-tables-php>`
    *   :ref:`ext_tables.sql <ext_tables-sql>`


.. _extension-files:

Files
=====

An extension consists of:

1. A directory named *extension key* (a worldwide unique
   identification string for the extension), located in :file:`typo3conf/ext`
   for local extensions or :file:`typo3/sysext` for system extensions.

2. Standard files with reserved names for configuration related to TYPO3
   (most are optional, see list below)

3. Additional files for the main extension functionality.

.. index:: Extension development; Reserved file names
.. _extension-reserved-filenames:

Reserved file names
===================

Most of these files are not required, except :file:`ext_emconf.php`
in :ref:`Classic mode installations not based on Composer <classic-installation>`
and :file:`composer.json <extension-composer-json>` in :ref:`Composer installations <t3start:install>`.

..  note::
    It is recommended to keep :file:`ext_emconf.php` and :file:`composer.json <extension-composer-json>` in
    public extensions that are published in the TYPO3 Extension Repository (TER), and
    to ensure compatibility with Composer and legacy installations.

Do not use the prefix :file:`ext_` in your extension names as this is a reserved name.

.. _extension-reserved-folders:

Reserved Folders
================

In the early days, extension authors "baked their own bread" when it came to
PHP class file locations, public web resources and templates.

Since the rise of Extbase, a general structure for file
locations inside extensions has become established. If extension authors
stick to this and the Coding Guidelines, many things become easier. For instance, if you put
your PHP classes into a :file:`Classes/` folder and use appropriate namespaces for the classes,
the system will autoload the files.

Extension kickstarters like the :composer:`friendsoftypo3/extension-builder`
will create the correct structure for you.

.. toctree::
   :titlesonly:
   :glob:
   :hidden:

   */Index
   *
