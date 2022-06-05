.. include:: /Includes.rst.txt
.. index:: ! Backend modules
.. index:: Backend modules; API
.. _backend-modules-api:
.. _backend-modules:

===============
Backend modules
===============

TYPO3 CMS offers a number of ways to attach custom functionality to the
backend. They are described in this chapter.

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

            .. rubric:: :ref:`Create a module with Extbase <backend-modules-extbase>`

         .. container:: card-body

            Explains how to create a module with Extbase and Fluid. This is
            the preferred method if extensive data modelling is involved.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Create a module with Core functionality <backend-modules-template-without-extbase>`

         .. container:: card-body

            Explains how to create a module without Extbase. Fluid can still be
            used however there are some limitations. This is the preferred way
            if no extensive data modelling is needed.

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
            to manipulate the module configuration, before it is used to create and
            register the module.


.. toctree::
   :hidden:
   :titlesonly:

   BackendGUI
   CreateModuleWithExtbase
   CreateModule
   ModuleConfiguration
   ToplevelModules
   ModuleProviderAPI
   /ApiOverview/Hooks/Events/Backend/BeforeModuleCreationEvent
