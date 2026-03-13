.. include:: /Includes.rst.txt
.. index:: Backend modules; How to
.. _backend-modules-how-to:

===============
Backend modules
===============

TYPO3 CMS has a number of ways of adding custom functionality to the
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

        How to register modules provided by extensions.

    ..  card:: :ref:`Create a module with Extbase <backend-modules-extbase>`

        How to create a module using Extbase and Fluid - the best option if you
        need to do lots of data modelling.

    ..  card:: :ref:`Create a module with Core functionality <backend-modules-template-without-extbase>`

        How to create a module without Extbase (you can still use Fluid
        but with some limitations). The best option if you don't need to do any
        data modelling.

    ..  card:: :ref:`Security Considerations <backend-modules-security>`

        Explores web application security considerations around
        developing modules for the backend user interface.

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
