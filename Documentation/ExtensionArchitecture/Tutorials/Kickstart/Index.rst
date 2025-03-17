:navigation-title: Kickstart
.. include:: /Includes.rst.txt
.. index::
   Extension development; Kickstart
   Extension development; Builder
.. _tutorial-extension-builder:
.. _extension-kickstart:

======================
Kickstart an extension
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

    ..  card:: :ref:`Use b13/make to create an extension <extension-make-kickstart>`

        Install :composer:`b13/make` as dev dependency and use it to quickly
        create a new extension. It can also support you in creating console
        commands, backend controllers, middlewares, and event handlers. It
        creates no unnecessary files as opposed to some of the other automatic
        extension generators.

    ..  card:: :ref:`Kickstart a TYPO3 extension with "Make" <extension-make>`

        "Make" can be used to quickly create an extension with a few
        basic commands on the console. "Make" can also be used to
        kickstart functionality like console command (CLI), backend
        controllers and event listeners. It does not offer to kickstart
        a site package or an Extbase extension.

    ..  card:: :ref:`Site package builder <extension-sitepackage-builder>`

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
