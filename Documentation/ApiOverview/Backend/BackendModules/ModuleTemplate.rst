..  include:: /Includes.rst.txt
.. index:: Backend modules; ModuleTemplateFactory
.. _ModuleTemplate:

==============
ModuleTemplate
==============

Backend controllers should use :ref:`ModuleTemplateFactory::create() <ModuleTemplateFactory>`
to create instances of a :php:`\TYPO3\CMS\Backend\Template\ModuleTemplate`.

..  include:: _ModuleTemplate.rst.txt


.. _ModuleTemplate-examples:

Example: Initialize module template
===================================

.. seealso::
    :ref:`Create a backend module with Core functionality <t3coreapi:backend-modules-template-without-extbase>`
    and :ref:`Create a backend module with Extbase <t3coreapi:backend-modules-template>`.

API functions of the ModuleTemplate can be used to add buttons to the button bar

..  literalinclude:: _BackendModuleController_ModuleTemplate.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/BackendModuleController.php

Example: Set flash message queue and modify the doc header
==========================================================

The following example is extracted from the example Extbase extension
`blog_example <>`

..  include:: InitializeModuleTemplate.rst.txt
