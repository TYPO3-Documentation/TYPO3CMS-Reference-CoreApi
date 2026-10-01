..  include:: /Includes.rst.txt
..  index:: Backend modules; ModuleTemplate
..  _moduletemplate:

================
`ModuleTemplate`
================

Backend controllers should use :ref:`ModuleTemplateFactory::create() <moduletemplatefactory>`
to create instances of a :php:`\TYPO3\CMS\Backend\Template\ModuleTemplate`.

API functions of the :php:`ModuleTemplate` can be used to add buttons to
the button bar. It also implements the :php:`\TYPO3\CMS\Core\View\ViewInterface`
so values can be assigned to it in the actions.

..  include:: _ModuleTemplate.rst.txt

..  _moduletemplate-examples:

Example: create and use a `ModuleTemplate` in an Extbase controller
===================================================================

..  literalinclude:: /ApiOverview/Backend/BackendModules/_InitializeModuleTemplate.php
    :caption: Class MyVendor\\MyExtension\\Controller\\BackendController
