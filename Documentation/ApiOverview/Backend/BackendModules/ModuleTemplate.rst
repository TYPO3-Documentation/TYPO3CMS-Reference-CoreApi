..  include:: /Includes.rst.txt
..  index:: Backend modules; ModuleTemplate
..  _ModuleTemplate:

==============
ModuleTemplate
==============

Backend controllers should use :ref:`ModuleTemplateFactory::create() <ModuleTemplateFactory>`
to create instances of a :php:`\TYPO3\CMS\Backend\Template\ModuleTemplate`.

API functions of the :php:`ModuleTemplate` can be used to add buttons to
the button bar. It also implements the :php:`\TYPO3\CMS\Core\View\ViewInterface`
so values can be assigned to it in the actions.

..  include:: _ModuleTemplate.rst.txt

..  _ModuleTemplate-examples:

Example: Create and use a ModuleTemplate in an Extbase Controller
=================================================================

..  include:: _AboutBlogExample.rst.txt

..  include:: _InitializeModuleTemplate.rst.txt
