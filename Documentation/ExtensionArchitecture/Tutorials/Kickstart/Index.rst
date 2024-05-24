:navigation-title: Kickstart
.. include:: /Includes.rst.txt
.. index::
   Extension development; Kickstart
   Extension development; Builder
.. _tutorial-extension-builder:
.. _extension-kickstart:

======================
Kickstart an Extension
======================

There are different options to kickstart an extension. Here are some
tutorials for common options:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: Create an extension from scratch

                *   Create a directory with the extension name
                *   Create the :ref:`files-composer-json` file
                *   Create the :ref:`ext_emconf-php` file for legacy installations and extensions to be uploaded to TER

    ..  card:: :ref:`Kickstart a TYPO3 extension with "Make" <extension-make>`

                "Make" can be used to quickly create an extension with a few
                basic commands on the console. "Make" can also be used to
                kickstart functionality like console command (CLI), backend
                controllers and event listeners. It does not offer to kickstart
                a sitepackage or an Extbase extension.

    ..  card:: :ref:`Sitepackage Builder <extension-sitepackage-builder>`

                The `Sitepackage Builder <https://www.sitepackagebuilder.com/>`__
                can be used to conveniently create an extension containing the
                sitepackage (theme) of a site. It can also be used to kickstart
                an arbitrary extension by removing unneeded files.

    ..  card:: :doc:`Extension Builder <friendsoftypo3/extension-builder:Index>`

                The Extension Builder helps you to develop a TYPO3 extension
                based on the domain-driven MVC framework :ref:`Extbase <extbase>`
                and the templating engine :ref:`Fluid <fluid>`.


..  toctree::
    :titlesonly:
    :glob:

    */Index
