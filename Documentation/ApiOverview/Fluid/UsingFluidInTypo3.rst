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

..  contents::
    :local:

..  _fluid-syntax-viewhelpers-import-namespaces:

ViewHelper namespaces
=====================

..  _defining-global-fluid-namespaces:

Defining global Fluid namespaces
--------------------------------

..  versionadded:: 14.1

The extension-level configuration file :file:`Configuration/Fluid/Namespaces.php`
registers and extends global Fluid namespaces. Previously,
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

It is possible to override ViewHelpers that are in another extension. This is
done by TYPO3 reading and merging :file:`Configuration/Fluid/Namespaces.php`
files in loaded extensions in the usual loading order. Loading order can
be changed by declaring dependencies in :file:`composer.json`
(and possibly :file:`ext_emconf.php`). In other words, if an extension registers a
namespace that has already been registered by another extension, Fluid will merge
the namespaces.

Example (my_extension2 depends on my_extension1):

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

This results in namespace definition:

..  code-block:: php

    [
        'myext' => [
            'MyVendor\\MyExtension1\\ViewHelpers',
            'MyVendor\\MyExtension2\\ViewHelpers',
        ],
    ];

The processing order is in reverse, which means that
:html:`<myext:demo />` would first check for
`EXT:my_extension2/Classes/ViewHelpers/DemoViewHelper.php`, and then
fall back to `EXT:my_extension1/Classes/ViewHelpers/DemoViewHelper.php`.

.. _importing-fluid-namespaces-locally:

Importing Fluid namespaces locally
----------------------------------

Say you have defined a Fluid component in
`EXT:my_extension/Resources/Private/Components/Button/Button.fluid.html`.
Instead of defining the Fluid namespace globally you can specify
the Fluid namespace like this:

..  code-block:: html
    :emphasize-lines: 2
    :caption: EXT:my_extension/Resources/Private/Templates/SomeOtherTemplate.fluid.html

    <html
        xmlns:my="http://typo3.org/ns/MyVendor/MyExtension/Components"
        data-namespace-typo3-fluid="true"
    >

    <my:button title="{title}" teaser="{teaser}"/>

The namespace here is 'my'. For further information visit
`ViewHelper namespaces <https://docs.typo3.org/permalink/fluid:viewhelper-namespaces-syntax>`_
in Fluid explained.

.. _using_fluid_components:

Using Fluid components
======================

.. _description_fluid_components:

Description
-----------

With version 4.3 the concept of components was introduced into Fluid.

.. _what_is_fluid_components:

Introduction to Fluid components
--------------------------------

The typical look of a component is like a normal Fluid template, except
that it defines all of its arguments with the
`Argument ViewHelper <f:argument> <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-argument>`_.
The `Slot ViewHelper <f:slot> <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-slot>`_
can be used to receive other HTML content. With the Slot ViewHelper it is possible to nest components.

Example: How you could define a Fluid component

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Components/Molecule/TeaserCard/TeaserCard.fluid.html

    <html
        xmlns:my="http://typo3.org/ns/MyVendor/MyExtension/Components"
        data-namespace-typo3-fluid="true"
    >

    <f:argument name="title" type="string" />
    <f:argument name="link" type="string" />
    <f:argument name="icon" type="string" optional="{true}" />

    <a href="{link}" class="teaserCard">
        <f:if condition="{icon}">
            <my:atom.icon identifier="{icon}">
        </f:if>
        <div class="teaserCard__title">{title}</div>
        <div class="teaserCard__content"><f:slot /></div>
    </a>

The example also demonstrates that components can (and should) use other components, in this
case :html:`<my:atom.icon>`.
Depending on the use case, it might also make sense to pass the output of one component
to another component via a slot:

..  code-block:: html

    <html
        xmlns:my="http://typo3.org/ns/MyVendor/MyExtension/Components"
        data-namespace-typo3-fluid="true"
    >

    <my:molecule.teaserCard
        title="TYPO3"
        link="https://typo3.org/"
        icon="typo3"
    >
        <my:atom.text>{content}</my:atom.text>
    </my:molecule.teaserCard>

You can learn more about components in
`Defining Components <https://docs.typo3.org/permalink/fluid:components-definition>`_. Note
that this is part of the documentation of Fluid Standalone, which means that it doesn't mention
TYPO3 specifics.

.. _register_fluid_components:

Registering component collections
---------------------------------

In order to use Fluid components, register a component collection
within the file :file:`Configuration/Fluid/ComponentCollections.php` 

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Fluid/ComponentCollections.php

    <?php

    return [
        'MyVendor\\MyExtension\\Components' => [
            'templatePaths' => [
                10 => 'EXT:my_extension/Resources/Private/Components',
            ],
        ],
    ];

in which you define the path where your Fluid components can be found.
Components in these collections can then be used in any Fluid template.

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Template.fluid.html

    <html
        xmlns:my="http://typo3.org/ns/MyVendor/MyExtension/Components"
        data-namespace-typo3-fluid="true"
    >

    <my:organism.header.navigation />

Note that, by default, component collections use a folder structure that
requires a separate directory per component. 
That means, for example, imagine you defined a navigation Fluid component. 
Then the file
:file:`EXT:my_extension/Resources/Private/Components/Organism/Header/Navigation/Navigation.fluid.html`
should be stored in path `my_extension/Resources/Private/Components/Organism/Header/Navigation`. 

All arguments that are passed to a component need to be defined with 
:html:`<f:argument>` in the component template, for example 
:file:`Navigation.fluid.html`. 

It is possible to adjust these configurations per collection:

*   using `templateNamePattern` allows you to use a different folder structure, 
    available variables are `{path}` and `{name}`. For example, 
    with :html:`<my:organism.header.navigation>`, `{path}` would be
    `Organism/Header` and `{name}` would be `Navigation`.
*   setting `additionalArgumentsAllowed` to `true` allows passing undefined arguments
    to components.

Here is an example where these configurations are used.

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Fluid/ComponentCollections.php

    <?php

    return [
        'MyVendor\\MyExtension\\Components' => [
            'templatePaths' => [
                10 => 'EXT:my_extension/Resources/Private/Components',
            ],
            'templateNamePattern' => '{path}/{name}',
            'additionalArgumentsAllowed' => true,
        ],
    ];

Using this example :html:`<my:organism.header.navigation />` would point to
:file:`EXT:my_extension/Resources/Private/Components/Organism/Header/Navigation.fluid.html`
(note the missing :file:`Navigation` folder).

It is possible to influence certain aspects of Fluid components using PSR-14 events,
see `PSR-14 events for Fluid components <https://docs.typo3.org/permalink/changelog:feature-108508-1765987847>`_.

.. _history_fluid_components:

History of Fluid components
---------------------------

In TYPO3 v13 it is possible to use components in TYPO3 projects by creating a custom
:php:`ComponentCollection` class that essentially connects a folder of template files
to a Fluid ViewHelper namespace. Using that class it is also possible to use an
alternative folder structure for a component collection and to allow
arbitrary arguments to components within that collection.

.. _migration_co-existence_fluid_components:

Migration and co-existence with class-based collections
-------------------------------------------------------

Since TYPO3 v14 you should use the configuration-based component collections over 
the class-based. A configuration-based component collection is a collection defined
by the configuration file :file:`ComponentCollections.php`. In contrast to that, a 
class-based component required custom PHP code in TYPO3 v13, see 
`Fluid components in Fluid explained <https://docs.typo3.org/permalink/fluid:components-setup>`_.
Most use cases can easily be migrated to the configuration-based approach, since 
they usually just consist of boilerplate code around the configuration options.

In fact, you can use both component collection types side by side. For more 
advanced use cases, it might still be best to ship a custom class to define
a component collection. Since the configuration-based approach is not available in TYPO3 v13, 
it is possible to ship both variants to provide backwards-compatibility: 
if a specific component collection is
defined both via class and via configuration, in TYPO3 v13 the class will be used,
while in TYPO3 v14 the configuration will be used and the class will be ignored completely.

.. _extending_component-collections_fluid_components:

Extending component collections from other extensions
-----------------------------------------------------

It is possible to extend the configuration of other extensions using the
introduced configuration file. This allows integrators to merge their own set of
components into an existing component collection:

..  code-block:: php
    :caption: EXT:vendor_extension/Configuration/Fluid/ComponentCollections.php

    <?php

    return [
        'SomeVendor\\VendorExtension\\Components' => [
            'templatePaths' => [
                10 => 'EXT:vendor_extension/Resources/Private/Components',
            ],
        ],
    ];

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Fluid/ComponentCollections.php

    <?php

    return [
        'SomeVendor\\VendorExtension\\Components' => [
            'templatePaths' => [
                1765990741 => 'EXT:my_extension/Resources/Private/Extensions/VendorExtension/Components',
            ],
        ],
    ];

For template paths, the familiar rule applies: they will be sorted by their
keys and will be processed in reverse order. In this example, if `my_extension`
defines a component that already exists in `vendor_extension`, it will override
the original component in `vendor_extension`.

.. _psr_14_events_fluid_components:

PSR-14 events for Fluid components
----------------------------------

There are three new PSR-14 events to influence the processing and rendering of
Fluid components that can be registered using the new configuration file.
(see `Feature: #108508 - Fluid components integration <https://docs.typo3.org/permalink/changelog:feature-108508-1765987901>`_).

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
