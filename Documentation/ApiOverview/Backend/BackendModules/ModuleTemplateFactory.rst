.. include:: /Includes.rst.txt
.. index:: Backend modules; ModuleTemplateFactory
.. _ModuleTemplateFactory:

=====================
ModuleTemplateFactory
=====================

The template module factory should be used by backend controllers to create a
:php:`\TYPO3\CMS\Backend\Template\ModuleTemplate.`

..  include:: _ModuleTemplateFactory.rst.txt


.. _ModuleTemplateFactory-examples:

Example: Initialize module template
===================================

.. seealso::
    :ref:`Create a backend module with Core functionality <t3coreapi:backend-modules-template-without-extbase>`
    and :ref:`Create a backend module with Extbase <t3coreapi:backend-modules-template>`.

In many backend modules all actions should have the same module header.
So it is useful to initialize the backend module template in a function commonly
used by all actions:

..  literalinclude:: _BackendModuleController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/BackendModuleController.php
