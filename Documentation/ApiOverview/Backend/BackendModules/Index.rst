..  include:: /Includes.rst.txt
..  index:: ! Backend modules
..  index:: Backend modules; API
..  _backend-modules-api:
..  _backend-modules:

===================
Backend modules API
===================

..  versionchanged:: 12.0
    Registration of backend modules was changed with version 12. Read more:
    :ref:`Backend module configuration <backend-modules-configuration>`.

This chapter describes the API that can be used to create custom backend modules
in extensions. See the following chapter for a tutorial on :ref:`how to create
custom backend modules <backend-modules-how-to>`.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Backend GUI <backend-gui>`

        Describes the graphical user interface structure of a backend module
        and defines how the different parts are called.


    ..  card:: :ref:`Backend module configuration <backend-modules-configuration>`

        Howto register custom modules provided by extensions.


    ..  card:: :ref:`Toplevel modules <backend-modules-toplevel-module>`

        Lists all toplevel modules available by default and explains how to
        register custom toplevel modules.

    ..  card:: :ref:`ModuleProviderAPI <backend-module-interface>`

        The :php:`ModuleProvider` API, allows extension authors to work with the
        registered modules.

    ..  card:: :ref:`BeforeModuleCreationEvent <BeforeModuleCreationEvent>`

        The PSR-14 :ref:`BeforeModuleCreationEvent` allows extension authors
        to manipulate the module configuration before it is used to create and
        register the module.


    ..  card:: :ref:`Button components <button-components>`

        The menu button bar of a backend module can hold various components.

    ..  card:: :ref:`Override backend templates <t3tsref:pagetemplates>`

        Backend templates can be overridden via page TSconfig. But you
        should be careful: backend templates are mostly not API and can
        break on updates.

    ..  card:: :ref:`Tutorial and how to <backend-modules-how-to>`

        Learn how to create a backend module step-by-step.

..  toctree::
    :glob:
    :titlesonly:

    */Index
    *
