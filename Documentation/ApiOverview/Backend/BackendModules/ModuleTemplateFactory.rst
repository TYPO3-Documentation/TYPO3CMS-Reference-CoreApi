..  include:: /Includes.rst.txt
..  index:: Backend modules; ModuleTemplateFactory
..  _moduletemplatefactory:

=======================
`ModuleTemplateFactory`
=======================

The template module factory should be used by backend controllers to create a
:php:api:`\TYPO3\CMS\Backend\Template\ModuleTemplate`.

..  contents:: Table of contents

..  _moduletemplatefactory-api:

`ModuleTemplateFactory` API
===========================

..  include:: _ModuleTemplateFactory.rst.txt

..  _moduletemplatefactory-examples:

Example: initialize module template
===================================

..  seealso::
    :ref:`Create a backend module with Core functionality <t3coreapi:backend-modules-template-without-extbase>`
    and :ref:`Rendering in an Extbase backend module controller <t3coreapi:extbase-registration-backend-module-template>`.

In many backend modules all actions should have the same module header.
So it is useful to initialize the backend module template in a function commonly
used by all actions:

..  literalinclude:: _BackendModuleController.php
    :caption: EXT:my_extension/Classes/Controller/BackendModuleController.php

An Extbase controller can do the same in :php:`initializeAction()`, which
Extbase calls before every action. See :ref:`Setting up an Extbase module
controller in initializeAction() <t3coreapi:extbase-backend-module-no-page-tree-initialize>`.
