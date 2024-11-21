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

..  note::
    A backend controller should be tagged with the
    :php:`\TYPO3\CMS\Backend\Attribute\AsController` (php:`#[AsController]`) attribute.

..  versionchanged:: 14.0
	The class alias for :php:`\TYPO3\CMS\Backend\Attribute\Controller` has been
	removed. :php:`\TYPO3\CMS\Backend\Attribute\AsController` is still in place.

After that you can add titles, menus and buttons using :php:`ModuleTemplate`:

.. code-block:: php

    // use Psr\Http\Message\ResponseInterface
    public function myAction(): ResponseInterface
    {
        $this->view->assign('someVar', 'someContent');
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        // Adding title, menus, buttons, etc. using $moduleTemplate ...
        return $moduleTemplate->renderResponse('MyController/MyAction');
    }

..  seealso::
    :ref:`dropdown-button-components`


Using this :php:`ModuleTemplate` class, the Fluid templates for
your module need only take care of the actual content of your module.
As such, the Layout may be as simple as (again from "beuser"):

.. code-block:: html
   :caption: typo3/sysext/beuser/Resources/Private/Layouts/Default.html

	<f:render section="Content" />

and the actual Template needs to render the title and the content only.
For example, here is an extract of the "Index" action template of
the "beuser" extension:

.. code-block:: html
   :caption: typo3/sysext/beuser/Resources/Private/Templates/BackendUser/Index.html

   <html
      xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
      xmlns:core="http://typo3.org/ns/TYPO3/CMS/Core/ViewHelpers"
      xmlns:be="http://typo3.org/ns/TYPO3/CMS/Backend/ViewHelpers"
      data-namespace-typo3-fluid="true">

      <f:layout name="Default" />

      <f:section name="Content">
          <h1><f:translate key="backendUserListing" /></h1>
          ...
      </f:section>

   </html>


The best resources for learning is to look at existing modules
from TYPO3 CMS. With the information given here, you should be
able to find your way around the code.
