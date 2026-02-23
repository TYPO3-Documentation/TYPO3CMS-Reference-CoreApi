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


..  _fluid-syntax-viewhelpers-import-namespaces:

ViewHelper namespaces
=====================

..  _defining-global-fluid-namespaces:

Defining global Fluid namespaces
--------------------------------

..  versionadded:: 14.1

The extension-level configuration file :file:`Configuration/Fluid/Namespaces.php`
can be utilized to register and extend global Fluid namespaces. Previously,
the configuration :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']`
was used. 

For example, we can define two global namespaces with the identifiers
'myext' and 'mycmp': 

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Fluid/Namespaces.php

    <?php

    return [
        'myext' => ['MyVendor\\MyExtension\\ViewHelpers'],
        'mycmp' => ['MyVendor\\MyExtension\\Components'],
    ];

Assuming you have defined a Fluid component in 
`EXT:my_extension/Resources/Private/Components/Button/Button.fluid.html`
then you can access the Button component via 

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeOtherTemplate.fluid.html

    <mycmp:button title="{title}" teaser="{teaser}" />

It is possible to override one or more ViewHelpers of another extension. This is 
realized by TYPO3 reading and merging `Configuration/Fluid/Namespaces.php` 
files from all loaded extensions in the usual loading order. The 
loading order can be manipulated by declaring dependencies in `composer.json`
and possibly `ext_emconf.php`. In other words, if an extension registers a
namespace that has already been registered by another extension, these 
namespaces will be merged by Fluid.

Example (extension2 depends on extension1):

..  code-block:: php
    :caption: EXT:my_extension1/Configuration/Fluid/Namespaces.php

    <?php

    return [
        'myext' => ['MyVendor\\MyExtension1\\ViewHelpers'],
    ];

..  code-block:: php
    :caption: EXT:my_extension2/Configuration/Fluid/Namespaces.php

    <?php

    return [
        'myext' => ['MyVendor\\MyExtension2\\ViewHelpers'],
    ];

Resulting namespace definition:

..  code-block:: php

    [
        'myext' => [
            'MyVendor\\MyExtension1\\ViewHelpers',
            'MyVendor\\MyExtension2\\ViewHelpers',
        ],
    ];

The processing order is in reverse order, which means that 
:html:`<myext:demo />` would first check for
`EXT:my_extension2/Classes/ViewHelpers/DemoViewHelper.php`, and would
fall back to `EXT:my_extension1/Classes/ViewHelpers/DemoViewHelper.php`.

.. _importing-fluid-namespaces-locally:

Importing Fluid namespaces locally 
----------------------------------

Like previously, imagine you already have defined a Fluid component in 
`EXT:my_extension/Resources/Private/Components/Button/Button.fluid.html`. 
Instead of defining the Fluid namespace globally you can specify 
the Fluid namespace like:

..  code-block:: html
    :emphasize-lines: 2
    :caption: EXT:my_extension/Resources/Private/Templates/SomeOtherTemplate.fluid.html

    <html
        xmlns:my="http://typo3.org/ns/MyVendor/MyExtension/Components"
        data-namespace-typo3-fluid="true"
    >

    <my:button title="{title}" teaser="{teaser}"/>

In this example the namespace is called 'my'. 
For further information visit the
`ViewHelper namespaces <https://docs.typo3.org/permalink/fluid:viewhelper-namespaces-syntax>`_
in Fluid explained. 
 

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
