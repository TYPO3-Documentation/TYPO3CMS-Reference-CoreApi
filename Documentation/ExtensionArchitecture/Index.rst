.. include:: /Includes.rst.txt
.. index:: ! Extension development
.. _extension-architecture:
.. _extension-development:

=====================
Extension development
=====================

.. container:: row m-0 p-0

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Concepts <extension-concepts>`

         .. container:: card-body

            Learn about the concept of extensions
            in TYPO3, the difference between system extension and local
            extensions. Learn about Extbase as an MVC basis for extension
            development.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`File structure <extension-files-locations>`

         .. container:: card-body

            Lists reserved file and directory names within and extension. Also
            lists file names that are used in a certain way by convention.

            This chapter should also help you to find your way around in
            extensions and sitepackages that where automatically generated or
            that you downloaded as an example.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Howto <extension-howto>`

         .. container:: card-body

            Helps you kickstart your own extension or sitepackage. Explains how
            to publish an extension. Contains howto for different situations
            like creating a frontend plugin, a backend module or to extend
            existing TCA.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Extbase <extbase>`

         .. container:: card-body

            Extbase is an extension framework to create TYPO3 frontend plugins
            and TYPO3 backend modules.

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Best practises and conventions <extension-Best-practises>`

         .. container:: card-body

            Explains how to pick an extensions key, how things should be named
            and how to best use configuration files
            (:ref:`ext_localconf.php <ext-localconf-php>` and
            :ref:`ext_tables.php <ext-tables-php>`)

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: :ref:`Tutorials <extension-tutorials>`

         .. container:: card-body

            Contains tutorials on extension development in TYPO3.

.. toctree::
   :hidden:
   :titlesonly:

   Concepts/Index
   FileStructure/Index
   HowTo/Index
   Extbase/Index
   BestPractises/Index
   Tutorials/Index
