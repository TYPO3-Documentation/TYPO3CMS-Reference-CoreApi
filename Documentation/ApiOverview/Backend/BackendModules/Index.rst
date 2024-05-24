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
    :ref:`backend-modules-configuration <Backend module configuration>`.

..  note:: This section is currently (Mai 2024) work in progress.

This chapter describes the API that can be used to create custom backend modules
in extensions. See the following chapter for a tutorial on :ref:`how to create
custom backend modules <backend-modules-how-to>`.

.. container:: row m-0 p-0

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Backend GUI <backend-gui>`

         .. container:: card-body

            Describes the graphical user interface structure of a backend module
            and defines how the different parts are called.


   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Backend module configuration <backend-modules-configuration>`

         .. container:: card-body

            Howto register custom modules provided by extensions.


   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Toplevel modules <backend-modules-toplevel-module>`

         .. container:: card-body

            Lists all toplevel modules available by default and explains how to
            register custom toplevel modules.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`ModuleProviderAPI <backend-module-interface>`

         .. container:: card-body

            The :php:`ModuleProvider` API, allows extension authors to work with the
            registered modules.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`BeforeModuleCreationEvent <BeforeModuleCreationEvent>`

         .. container:: card-body

            The PSR-14 :ref:`BeforeModuleCreationEvent` allows extension authors
            to manipulate the module configuration before it is used to create and
            register the module.


   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Button components <button-components>`

         .. container:: card-body

            The menu button bar of a backend module can hold various components.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Override backend templates <t3tsconfig:pagetemplates>`

         .. container:: card-body

            Backend templates can be overridden via page TSconfig. But you
            should be careful: backend templates are mostly not API and can
            break on updates.

..  toctree::
    :glob:

    */Index
    *
