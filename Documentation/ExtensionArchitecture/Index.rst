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

        Learn about extensions in TYPO3, the important concepts behind them and
        the difference between local and system extensions. Learn about Extbase
        - the MVC basis for extension development.

    ..  card:: :ref:`File structure <extension-files-locations>`

        Learn about reserved file and directory names in extensions
        and about file naming conventions.

        This chapter should also help you find your way around
        automatically generated or example extensions and sitepackages.

    ..  card:: :ref:`Site package <site-package>`

        A site package is a custom TYPO3 extension containing files that
        together provide a site "theme".


    ..  card:: :ref:`Extension kickstarters <extension-concepts>`

        Learn about tools to create a new extension or add
        functionality to an existing extension.

    ..  card:: :ref:`Howto <extension-howto>`

        Kickstart your own extension or sitepackage. Explains how
        to publish an extension. Contains howtos for creating a frontend plugin,
        a backend module and extending existing TCA.


    ..  card:: :ref:`Extbase <extbase>`

        Extbase is a framework for creating TYPO3 frontend plugins
        and TYPO3 backend modules.


    ..  card:: :ref:`Best practises and conventions <extension-Best-practises>`

        Explains how to choose an extension key, naming conventions
        and how to best use configuration files
        (:ref:`ext_localconf.php <ext-localconf-php>` and
        :ref:`ext_tables.php <ext-tables-php>`)


    ..  card:: :ref:`Tutorials <extension-tutorials>`

        Contains tutorials for learning about extension development in TYPO3.

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
