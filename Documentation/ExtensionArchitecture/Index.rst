.. include:: /Includes.rst.txt
.. index:: ! Extension development
.. _extension-architecture:
.. _extension-development:

=====================
Extension development
=====================

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Concepts <extension-concepts>`

        Learn about the concept of extensions
        in TYPO3, the difference between system extensions and local
        extensions. Learn about Extbase as an MVC basis for extension
        development.

    ..  card:: :ref:`File structure <extension-files-locations>`

        Lists reserved file and directory names within an extension. Also
        lists file names that are used in a certain way by convention.

        This chapter should also help you to find your way around in
        extensions and sitepackages that were automatically generated or
        that you downloaded as an example.

    ..  card:: :ref:`Site package <site-package>`

        A site package is a custom TYPO3 extension that contains files regarding the
        theme of a site.


    ..  card:: :ref:`Extension kickstarters <extension-concepts>`

        Learn about tools that help you to create a new Extension or add
        functionality to an existing extension.

    ..  card:: :ref:`Howto <extension-howto>`

        Helps you kickstart your own extension or sitepackage. Explains how
        to publish an extension. Contains howto for different situations
        like creating a frontend plugin, a backend module or to extend
        existing TCA.


    ..  card:: :ref:`Extbase <extbase>`

        Extbase is an extension framework to create TYPO3 frontend plugins
        and TYPO3 backend modules.


    ..  card:: :ref:`Best practises and conventions <extension-Best-practises>`

        Explains how to pick an extensions key, how things should be named
        and how to best use configuration files
        (:ref:`ext_localconf.php <ext-localconf-php>` and
        :ref:`ext_tables.php <ext-tables-php>`)


    ..  card:: :ref:`Tutorials <extension-tutorials>`

        Contains tutorials on extension development in TYPO3.

..  toctree::
    :hidden:
    :titlesonly:

    Concepts/Index
    FileStructure/Index
    SitePackage/Index
    Kickstarter/Index
    HowTo/Index
    Extbase/Index
    BestPractises/Index
    Tutorials/Index
