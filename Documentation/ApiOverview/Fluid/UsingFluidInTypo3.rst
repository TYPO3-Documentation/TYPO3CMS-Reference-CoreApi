..  include:: /Includes.rst.txt
..  index::
    Fluid; Using Fluid in TYPO3
..  _fluid-usage-in-typo3:

====================
Using Fluid in TYPO3
====================

Here are some examples of how Fluid can be used in TYPO3:

*   Create a template (theme) using a combination of TypoScript
    :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` and Fluid.
    Check out the :ref:`t3sitepackage:start` which walks you through the
    creation of a sitepackage extension.
*   :ref:`adding-your-own-content-elements` in addition to the already existing
    content elements TYPO3 supplies.
*   :ref:`Extbase-based controllers <extbase-controller>` have a default Fluid
    view in :php:`$this->view`.
*   Use Fluid to create emails using the :ref:`TYPO3 Mail API <mail-fluid-email>`.
*   Use Fluid in :ref:`backend modules <backend-modules-template>`, either with or
    without Extbase.
*   Use the :ref:`generic view factory <generic-view-factory>` to create a
    Fluid view.

..  versionchanged:: 14.0
    These classes were marked as deprecated in TYPO3 v13.3 and have been
    removed in v14:

    *   :php:`TYPO3\CMS\Fluid\View\StandaloneView`
    *   :php:`TYPO3\CMS\Fluid\View\TemplateView`
    *   :php:`TYPO3\CMS\Fluid\View\AbstractTemplateView`
    *   :php:`TYPO3\CMS\Extbase\Mvc\View\ViewResolverInterface`
    *   :php:`TYPO3\CMS\Extbase\Mvc\View\GenericViewResolver`

..  _generic-view-factory:

Using the generic view factory (ViewFactoryInterface)
=====================================================

..  versionadded:: 13.3
    Class :php:`TYPO3\CMS\Core\View\ViewFactoryInterface` has been added as a
    generic view factory interface to create views that return an instance of
    :php:`TYPO3\CMS\Core\View\ViewInterface`. This implements the "V" of "MVC"
    in a generic way and is used throughout the TYPO3 core.

You can :ref:`inject <dependency-injection>` an instance of the
:php:`TYPO3\CMS\Core\View\ViewFactoryInterface` to create an instance of a
:php:`TYPO3\CMS\Core\View\ViewInterface` where you need one.

..  note::
    :ref:`Extbase-based controllers <extbase-controller>` create a view
    instance based on this factory by default and which is accessible as
    :php:`$this->view`.

..  literalinclude:: _UsingFluid/_MyController.php
    :caption: EXT:my_extension/Classes/Controller/MyController.php (Not Extbase)

The :php-short:`TYPO3\CMS\Core\View\ViewFactoryInterface` needs an instance of
:php:`\TYPO3\CMS\Core\View\ViewFactoryData`, which is a data object and should
therefore be created via :php:`new`.

Best practices in creating a :php-short:`\TYPO3\CMS\Core\View\ViewFactoryData`
instance:

*   Hand over request of type :php:`\Psr\Http\Message\ServerRequestInterface`
    if possible. See :ref:`getting-typo3-request-object`.
*   Use the tuple `$templateRootPaths`, `$partialRootPaths` and
    `$layoutRootPaths` if possible by providing an array of "base" paths
    like `'EXT:my_extension/Resources/Private/(Templates|Partials|Layouts)'`
*   Avoid using parameter `$templatePathAndFilename`
*   Call `render('path/within/templateRootPath')` without file-ending on the
    returned ViewInterface instance.
