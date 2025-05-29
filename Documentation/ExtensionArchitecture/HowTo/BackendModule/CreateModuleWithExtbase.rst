:navigation-title: Extbase controller
.. include:: /Includes.rst.txt

.. _backend-modules-extbase:
.. _backend-modules-template:

====================================
Create a backend module with Extbase
====================================

.. tip::

   If you don't want to do extensive data modeling templates can be written
   :ref:`without Extbase. <backend-modules-template-without-extbase>`

See also the :ref:`Backend module API <backend-modules>`.

Backend modules can be written using the Extbase/Fluid combination.

The factory :php:`TYPO3\CMS\Backend\Template\ModuleTemplateFactory` can be used
to retrieve the :php:`\TYPO3\CMS\Backend\Template\ModuleTemplate`
class which is - more or less - the old backend module template,
cleaned up and refreshed. This class performs a number of basic
operations for backend modules, like loading base JS libraries,
loading stylesheets, managing a flash message queue and - in general -
performing all kind of necessary setups.

To access these resources, inject the
:php:`TYPO3\CMS\Backend\Template\ModuleTemplateFactory` into your backend module
controller:

..  code-block:: php

    use TYPO3\CMS\Backend\Attribute\AsController;
    use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    #[AsController]
    final class MyController extends ActionController
    {
        public function __construct(
            protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        ) {
        }
   }

..  versionadded:: 12.1/12.4.9
    A backend controller can be tagged with the
    :php:`\TYPO3\CMS\Backend\Attribute\AsController` attribute. This way, the
    :ref:`registration of the controller <backend-modules-template-without-extbase-manual-tagging>`
    in the :file:`Configuration/Services.yaml` file is no longer necessary.

    ..  note::
        Until TYPO3 v12.4.8 the attribute was named
        :php:`\TYPO3\CMS\Backend\Attribute\Controller` and has been renamed to
        :php:`AsController` with TYPO3 v12.4.9. Both work with TYPO3 v12 and v13,
        but developers should use :php:`#[AsController]` for upwards compatibility,
        since :php:`#[Controller]` has been deprecated with TYPO3 v13.


After that you can add titles, menus and buttons using :php:`ModuleTemplate`:

.. code-block:: php

    // use Psr\Http\Message\ResponseInterface
    public function myAction(): ResponseInterface
    {
        $this->view->assign('someVar', 'someContent');
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

        // Example of adding a page-shortcut button
        $routeIdentifier = 'web_examples'; // array-key of the module-configuration
        $buttonBar = $moduleTemplate->getDocHeaderComponent()->getButtonBar();
        $shortcutButton = $buttonBar->makeShortcutButton()->setDisplayName('Shortcut to my action')->setRouteIdentifier($routeIdentifier);
        $shortcutButton->setArguments(['controller' => 'MyController', 'action' => 'my']);
        $buttonBar->addButton($shortcutButton, ButtonBar::BUTTON_POSITION_RIGHT);
        // Adding title, menus and more buttons using $moduleTemplate ...

        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
    }

..  seealso::
    :ref:`dropdown-button-components`


Using this :php:`ModuleTemplate` class, the Fluid templates for
your module need only take care of the actual content of your module.
TYPO3 even comes with a default Fluid layout, that can easily be used:

.. code-block:: html
	<f:layout name="Module" />

and the actual Template needs to render the title and the content only.
For example, here is an extract of the "Index" action template of
the "beuser" extension:

.. code-block:: html
   :caption: typo3/sysext/beuser/Resources/Private/Templates/BackendUser/List.html

   <html
      xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
      xmlns:core="http://typo3.org/ns/TYPO3/CMS/Core/ViewHelpers"
      xmlns:be="http://typo3.org/ns/TYPO3/CMS/Backend/ViewHelpers"
      data-namespace-typo3-fluid="true">

      <f:layout name="Module" />

      <f:section name="Content">
          <h1><f:translate key="backendUserListing" /></h1>
          ...
      </f:section>

   </html>


The best resources for learning is to look at existing modules
from TYPO3 CMS. With the information given here, you should be
able to find your way around the code.
