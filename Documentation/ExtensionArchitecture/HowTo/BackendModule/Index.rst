.. include:: /Includes.rst.txt
.. index:: Backend modules; How to
.. _backend-modules-how-to:

===============
Backend modules
===============

TYPO3 CMS offers a number of ways to attach custom functionality to the
backend. They are described in this chapter.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Backend module API <backend-modules>`

        See the API about classes and configuration for backend modules.

    ..  card:: :ref:`Backend module configuration examples <backend-modules-configuration-examples>`

        Howto register custom modules provided by extensions.

    ..  card:: :ref:`Create a module with Extbase <backend-modules-extbase>`

        Explains how to create a module with Extbase and Fluid. This is
        the preferred method if extensive data modeling is involved.

    ..  card:: :ref:`Create a module with Core functionality <backend-modules-template-without-extbase>`

        Explains how to create a module without Extbase. Fluid can still be
        used, however there are some limitations. This is the preferred way
        if no extensive data modelling is needed.

    ..  card:: :ref:`Security Considerations <backend-modules-security>`

        Explores web application security considerations when
        developing custom modules for the backend user interface.

    ..  card:: :ref:`Tutorials <backend-modules-tutorials>`

        A video series from Susanne Moog demonstrating how to register
        and style a TYPO3 backend module.

..  toctree::
    :hidden:
    :titlesonly:

    ModuleConfiguration
    CreateModule
    CreateModuleWithExtbase
    SecurityConsiderations
    Tutorials
