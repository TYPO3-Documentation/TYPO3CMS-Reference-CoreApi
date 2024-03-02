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

..  container:: row m-0 p-0

    ..  container:: col-md-6 pl-0 pr-3 py-3 m-0

        ..  container:: card px-0 h-100

            ..  rst-class:: card-header h3

                ..  rubric:: Create an extension from scratch

            ..  container:: card-body

                *   Create a directory with the extension name
                *   Create the :ref:`files-composer-json` file
                *   Create the :ref:`ext_emconf-php` file for legacy installations and extensions to be uploaded to TER

    ..  container:: col-md-6 pl-0 pr-3 py-3 m-0

        ..  container:: card px-0 h-100

            ..  rst-class:: card-header h3

                ..  rubric:: :ref:`Kickstart a TYPO3 extension with "Make" <extension-make>`

            ..  container:: card-body

                "Make" can be used to quickly create an extension with a few
                basic commands on the console. "Make" can also be used to
                kickstart functionality like console command (CLI), backend
                controllers and event listeners. It does not offer to kickstart
                a sitepackage or an Extbase extension.

    ..  container:: col-md-6 pl-0 pr-3 py-3 m-0

        ..  container:: card px-0 h-100

            ..  rst-class:: card-header h3

                ..  rubric:: :ref:`Sitepackage Builder <extension-sitepackage-builder>`

            ..  container:: card-body

                The `Sitepackage Builder <https://www.sitepackagebuilder.com/>`__
                can be used to conveniently create an extension containing the
                sitepackage (theme) of a site. It can also be used to kickstart
                an arbitrary extension by removing unneeded files.

    ..  container:: col-md-6 pl-0 pr-3 py-3 m-0

        ..  container:: card px-0 h-100

            ..  rst-class:: card-header h3

                ..  rubric:: :doc:`Extension Builder <ext_ext_builder:Index>`

            ..  container:: card-body

                The Extension Builder helps you to develop a TYPO3 extension
                based on the domain-driven MVC framework :ref:`Extbase <extbase>`
                and the templating engine :ref:`Fluid <fluid>`.


..  toctree::
    :titlesonly:
    :glob:

    */Index
