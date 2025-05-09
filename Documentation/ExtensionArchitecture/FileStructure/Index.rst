.. include:: /Includes.rst.txt
.. index:: Extension development; File name conventions
.. _extension-files-locations:
.. _extension-reserved-folders-legacy:

==============
File structure
==============

Lists reserved file and directory names within an extension. Also
lists file names that are used in a certain way by convention.

This chapter should also help you to find your way around in
extensions and sitepackages that where automatically generated or
that you downloaded as an example.

The following folders and files can typically be found in a TYPO3 extension:

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

1. A directory named by the *extension key* (which is a worldwide unique
   identification string for the extension), usually located in :file:`typo3conf/ext`
   for local extensions, or :file:`typo3/sysext` for system extensions.

2. Standard files with reserved names for configuration related to TYPO3
   (of which most are optional, see list below)

3. Any number of additional files for the extension functionality itself.

.. index:: Extension development; Reserved file names
.. _extension-reserved-filenames:

Reserved file names
===================

Most of these files are not required, except of :file:`ext_emconf.php`
in :ref:`Classic mode installations not based on Composer <classic-installation>`
and :file:`composer.json <extension-composer-json>` in :ref:`Composer installations <t3start:install>`
installations.

.. note::
   It is recommended to keep :file:`ext_emconf.php` and :file:`composer.json <extension-composer-json>` in
   any public extension that is published to TYPO3 Extension Repository (TER), and
   to ensure optimal compatibility with Composer installations and legacy
   installations.

Do not introduce your own files in the root directory of
extensions with the name prefix :file:`ext_`, because that is reserved.

.. _extension-reserved-folders:

Reserved Folders
================

In the early days, every extension author baked his own bread when it came to
file locations of PHP classes, public web resources and templates.

With the rise of Extbase, a generally accepted structure for file
locations inside of extensions has been established. If extension authors
stick to this and the other Coding Guidelines, the system helps in various ways. For instance, if putting
PHP classes into the :file:`Classes/` folder and using appropriate namespaces for the classes,
the system will be able to autoload these files.

Extension kickstarters like the :composer:`friendsoftypo3/extension-builder`
will create the correct structure for you.

.. toctree::
   :titlesonly:
   :glob:
   :hidden:

   */Index
   *
