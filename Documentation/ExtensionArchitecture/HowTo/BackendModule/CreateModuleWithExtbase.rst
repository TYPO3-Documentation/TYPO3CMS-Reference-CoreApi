:navigation-title: Extbase controller

..  include:: /Includes.rst.txt

..  _backend-modules-extbase:
..  _backend-modules-template:

====================================
Create a backend module with Extbase
====================================

..  tip::

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

..  literalinclude:: _MyController.php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

..  note::
    A backend controller should be tagged with the
    :php:`\TYPO3\CMS\Backend\Attribute\AsController` (php:`#[AsController]`) attribute.

..  versionchanged:: 14.0
    The class alias for :php:`\TYPO3\CMS\Backend\Attribute\Controller` has been
    removed. :php:`\TYPO3\CMS\Backend\Attribute\AsController` is still in place.

After that you can add titles, menus and buttons using :php:`ModuleTemplate`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php (excerpt)

    // use Psr\Http\Message\ResponseInterface
    public function showAction(): ResponseInterface
    {
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

        // Example of assigning variables to the view
        $moduleTemplate->assign('someVar', 'someContent');

        // Example of naming what the bookmark button points to.
        // The route identifier is the array key of the module configuration.
        // The controller is its alias, the class name without the suffix.
        $moduleTemplate->getDocHeaderComponent()->setShortcutContext(
            routeIdentifier: 'web_examples',
            displayName: 'Conference details',
            arguments: ['controller' => 'Conference', 'action' => 'show'],
        );
        // Adding title, menus and more buttons using $moduleTemplate ...

        return $moduleTemplate->renderResponse('Conference/Show');
    }

..  versionchanged:: 14.0
    :changelog: feature-108008-1762896168

    The bookmark button is added automatically.

..  seealso::
    *   :ref:`Reload and bookmark buttons
        <docheadercomponent-automatic-buttons>`
    *   :ref:`Dropdown button components <dropdown-button-components>`


Using this :php:`ModuleTemplate` class, the Fluid templates for
your module need only take care of the actual content of your module.
TYPO3 even comes with a default Fluid layout, that can be used:

..  code-block:: html

    <f:layout name="Module" />

and the actual Template needs to render the title and the content only.
For example, here is an extract of the "Index" action template of
the "beuser" extension:

..  code-block:: html
    :caption: typo3/sysext/beuser/Resources/Private/Templates/BackendUser/List.fluid.html

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
