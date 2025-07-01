:navigation-title: Kickstarters

..  include:: /Includes.rst.txt
..  _tutorial-extension-builder:
..  _extension-kickstart:

======================
Extension kickstarters
======================

There is no "official" tool to create a TYPO3 extension. However there are a
number of community managed tools that you can use.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: `Creating a new extension from scratch <https://docs.typo3.org/permalink/t3coreapi:extension-create-new>`_

        *   Create a directory with the extension name
        *   Create the :ref:`files-composer-json` file
        *   Create the :ref:`ext_emconf-php` file for Classic mode installations and extensions to be uploaded to TER

    ..  card:: :ref:`Kickstart a TYPO3 extension with "Make" <extension-make>`

        "Make" can be used to quickly create an extension with a few
        basic commands on the console. "Make" can also be used to
        kickstart functionality like console command (CLI), backend
        controllers and event listeners. It does not offer to kickstart
        a site package or an Extbase extension.

    ..  card:: :ref:`Extension Kickstarter <ext-kickstarter>`

        The `Site Package Builder <https://get.typo3.org/sitepackage>`__
        can be used to conveniently create an extension containing the
        site package (theme) of a site. It can also be used to kickstart
        an arbitrary extension by removing unneeded files.

    ..  card:: :doc:`Extension Builder <friendsoftypo3/extension-builder:Index>`

        The Extension Builder, :composer:`friendsoftypo3/extension-builder`
        helps you to develop a TYPO3 extension
        based on the domain-driven MVC framework :ref:`Extbase <extbase>`
        and the templating engine :ref:`Fluid <fluid>`.

..  toctree::
    :titlesonly:
    :glob:

    */Index

..  _extension-kickstarters-matrix:
..  _extension-builder:

Extension kickstarter matrix
============================

.. list-table:: Comparison: Kickstarters
   :header-rows: 1

   * - Feature
     - :composer:`stefanfroemken/ext-kickstarter`
     - :composer:`b13/make`
     - :composer:`friendsoftypo3/extension-builder`

   * - GUI available
     - (✅) Still experimental
     - ❌
     - ✅ Web-based GUI (Extbase modeler in TYPO3 backend)

   * - Command line support
     - ✅ CLI commands via `vendor/bin/typo3 make:*`
     - ✅ CLI commands via `vendor/bin/typo3 make:*`
     - ❌ Not directly; uses GUI to generate and export code

   * - Creates extension
     - ✅ Creates new extension skeleton
     - ✅ Creates modern extension skeleton
     - ✅ Generates full Extbase+Fluid extension with GUI modeler

   * - Controller
     - ✅ Extbase or native TYPO3 controller
     - ❌ Not supported
     - ✅ Supports generating controllers and backend modules via modeler

   * - Module
     - ❌ Not supported
     - ✅ Backend controller (Module)
     - ✅ GUI lets you define backend modules based on controllers/actions

   * - Repository
     - ✅ Extbase repository generation
     - ❌ Not supported
     - ✅ Supports defining domain repositories via modeler

   * - Model
     - ✅ Domain model with property mapping
     - ❌ Not supported
     - ✅ Supports domain model generation and inheritance relations

   * - Plugin
     - ✅ Generates plugin + TypoScript
     - ❌ Not supported
     - ✅ Lets you define frontend plugins in GUI

   * - Table
     - ✅ Generates TCA
     - ❌ Not supported
     - ✅ Creates TCA and maps to existing tables via modeler

   * - Event
     - ✅ Creates event class
     - ❌ Not supported
     - ❌ No direct support

   * - Eventlistener
     - ✅ Supported
     - ✅ Supported
     - ❌ Not supported

   * - Typeconverter
     - ✅ Generates Extbase TypeConverter
     - ❌ Not supported
     - ❌ Not supported

   * - Upgrade Wizard
     - ✅ Generates Upgrade Wizard class
     - ❌ Not supported
     - ❌ Not supported

   * - Testing
     - ✅ Adds testing environment
     - ❌ Not supported
     - ✅ Includes PHPUnit tests scaffolding for extension skeleton

   * - Command
     - ❌ Not supported
     - ✅ Generates Symfony Console command
     - ❌ Not supported

   * - Middleware
     - ❌ Not supported
     - ✅ Creates PSR‑15 Middleware
     - ❌ Not supported
