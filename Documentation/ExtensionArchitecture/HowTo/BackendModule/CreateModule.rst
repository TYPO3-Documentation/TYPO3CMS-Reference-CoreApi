:navigation-title: Plain controller
.. include:: /Includes.rst.txt

.. _backend-modules-template-without-extbase:

===============================================
Create a backend module with Core functionality
===============================================

This page covers the backend template view, using only Core functionality
without Extbase. See also the :ref:`Backend module API <backend-modules>`.

.. tip::

   If you want to do extensive data modeling, you may want to
   use :ref:`Extbase templating <backend-modules-template>`.
   If you are building  a simple backend module, it makes sense to work without Extbase.

Basic controller
================

When creating a controller without Extbase an instance of :php:`ModuleTemplate`
is required to return the rendered template:

..  include:: _ModuleConfiguration/_AdminModuleControllerConstruct.rst.txt

..  note::
    A backend controller should be tagged with the
    :php:`\TYPO3\CMS\Backend\Attribute\AsController` (:php:`#[AsController]`) attribute.

..  _backend-modules-template-without-extbase-manual-tagging:

If the controller is not tagged with the :php:`\TYPO3\CMS\Backend\Attribute\AsController`
attribute, it must be registered in :file:`Configuration/Services.yaml`
with the `backend.controller` tag for dependency injection to work:

..  code-block:: yaml
    :caption: EXT:examples/Configuration/Services.yaml
    :emphasize-lines: 11-12

    services:
      _defaults:
        autowire: true
        autoconfigure: true
        public: false

      T3docs\Examples\:
        resource: '../Classes/*'
        exclude: '../Classes/Domain/Model/*'

      T3docs\Examples\Controller\AdminModuleController:
        tags: ['backend.controller']


Main entry point
================

The :php:`handleRequest()` method is the main entry point which triggers only the allowed actions.
This makes it possible to include e.g. Javascript for all actions in the controller.

..  include:: _ModuleConfiguration/_AdminModuleControllerHandleRequest.rst.txt

Actions
=======

Now create an example :php:`debugAction()` and assign variables to your view
as you would normally do.

..  include:: _ModuleConfiguration/_AdminModuleControllerDebugAction.rst.txt

..  _backend-modules-template-without-extbase-docheader:

The DocHeader
=============

To add a DocHeader button use :php:`$view->getDocHeaderComponent()->getButtonBar()`
and :php:`makeLinkButton()` to create the button. Finally, use :php:`addButton()` to add it.

..  include:: _ModuleConfiguration/_AdminModuleControllerSetUpDocHeader.rst.txt

..  seealso::
    :ref:`button-components`


Template example
================

..  include:: _ModuleConfiguration/_DebugHtml.rst.txt

.. note:: Some Fluid tags do not work in non-Extbase context such as
   :html:`<f:form>`.
