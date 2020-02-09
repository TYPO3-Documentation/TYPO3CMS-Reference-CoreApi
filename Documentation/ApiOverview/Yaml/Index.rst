.. include:: ../../Includes.txt

.. _yaml:

=============
YAML in TYPO3
=============

YAML is used in TYPO3 for various configurations; most notable are site configuration (see :ref:`sitehandling`)
and EXT:form configuration (see :ref:`form:introduction`).

YamlFileLoader
==============

TYPO3 is using a custom YAML loader for handling YAML in TYPO3 based on the Symfony YAML package. It's located at
:php:`\TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader` and can be used when YAML parsing is required.

The TYPO3 Core YAML resolves environment variables. Resolving of variables in the loader can be enabled or
disabled via flags. For example, when editing the site configuration through the backend interface the resolving
of environment variables needs to be disabled to be able to add environment configuration through
the interface.

The format for environment variables is :yaml:`%env(ENV_NAME)%`. Environment variables may be used to replace
complete values or parts of a value.

The YAML Loader class has two flags: :yaml:`PROCESS_PLACEHOLDERS` and :yaml:`PROCESS_IMPORTS`.

* :yaml:`PROCESS_PLACEHOLDERS` decides whether or not placeholders (`%abc%`) will be resolved.
* :yaml:`PROCESS_IMPORTS` decides whether or not imports (`imports` key) will be resolved.

Use the method :php:`YamlFileLoader::load()`
to make use of the loader in your extensions::

   use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;

   // ...

   YamlFileLoader::load(string $fileName, int $flags = self::PROCESS_PLACEHOLDERS | self::PROCESS_IMPORTS)

Configuration files can make use of import functionality to reference to the contents of different files.

Examples:

.. code-block:: yaml

   imports:
     - { resource: "EXT:rte_ckeditor/Configuration/RTE/Processing.yaml" }
     - { resource: "misc/my_options.yaml" }
     - { resource: "../path/to/something/within/the/project-folder/generic.yaml" }
