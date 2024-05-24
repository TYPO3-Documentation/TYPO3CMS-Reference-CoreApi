.. include:: /Includes.rst.txt
.. index:: Backend modules; How to
.. _backend-modules-how-to:

===============
Backend modules
===============

TYPO3 CMS offers a number of ways to attach custom functionality to the
backend. They are described in this chapter.

.. container:: row m-0 p-0

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Create a module with Extbase <backend-modules-extbase>`

         .. container:: card-body

            Explains how to create a module with Extbase and Fluid. This is
            the preferred method if extensive data modeling is involved.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Create a module with Core functionality <backend-modules-template-without-extbase>`

         .. container:: card-body

            Explains how to create a module without Extbase. Fluid can still be
            used, however there are some limitations. This is the preferred way
            if no extensive data modelling is needed.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Tutorials <backend-modules-tutorials>`

         .. container:: card-body

            A video series from Susanne Moog demonstrating how to register
            and style a TYPO3 backend module.

..  toctree::
    :hidden:
    :titlesonly:

    ModuleConfiguration
    CreateModule
    CreateModuleWithExtbase
    Tutorials
