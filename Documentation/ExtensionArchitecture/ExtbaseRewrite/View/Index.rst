:navigation-title: View

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; View
..  _extbase-view-overview:

=====================
View layer in Extbase
=====================

The view layer converts variables into rendered output such as strings of
HTML or JSON. It knows nothing about HTTP responses; that is
the controller's concern. The controller assigns variables and calls the render
method indirectly via :php:`$this->htmlResponse()` or :php:`$this->jsonResponse()`.

`Fluid <https://docs.typo3.org/permalink/t3coreapi:fluid>`_ is the
recommended template engine. It integrates with Extbase out of the box and
does not require any additional setup. Other template engines such as Blade or Twig can
be integrated via
:php-short:`\TYPO3\CMS\Core\View\ViewFactoryInterface`, but that is outside the
scope of this documentation.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-view-assign:

Assigning variables to the Extbase view
=======================================

Use :php:`$this->view->assign()` to make a value available under the variable name in the
template. :php:`assignMultiple()` assigns several values at once:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ConferenceRepository $conferenceRepository,
        ) {}

        public function listAction(): ResponseInterface
        {
            $this->view->assign('conferences', $this->conferenceRepository->findAll());
            $this->view->assign('title', 'Upcoming conferences');
            return $this->htmlResponse();
        }

        public function showAction(Conference $conference): ResponseInterface
        {
            $this->view->assignMultiple([
                'conference' => $conference,
                'speakers' => $conference->getSpeakers(),
            ]);
            return $this->htmlResponse();
        }
    }

The name passed to :php:`assign()` becomes the variable name in the template, for example
:html:`{conferences}`, :html:`{title}`, and :html:`{conference}` above.

TypoScript settings (:php:`$this->settings`) are automatically available in Fluid
templates under the name :html:`{settings}`. This means they do not need
an explicit assign call.


..  _extbase-view-property-access:

How Fluid accesses object properties and collections
====================================================

If a template variable is an object, Fluid resolves property paths such as
:html:`{conference.title}` in the following order:

*   A public property :php:`$title` directly.
*   A public getter method :php:`getTitle()`.
*   A public method :php:`hasTitle()`.
*   A public method :php:`isTitle()`.

This means :php:`protected` properties with conventional getters work
transparently in templates — :html:`{conference.title}` calls
:php:`getTitle()`.

..  warning::

    If none of the above exist, Fluid renders an empty string without an error or
    exception. A typo in a property name, a missing getter, or a :php:`private`
    property (which is never accessible to Fluid) will produce silent blank
    output. See
    `Template variable renders empty <https://docs.typo3.org/permalink/extbase-appendix-pitfalls-template-empty>`_
    in the common pitfalls list.

Property paths can be chained: :html:`{conference.mainSpeaker.name}` resolves
:php:`getMainSpeaker()` on the conference and then :php:`getName()` on the
result.

**Arrays and ObjectStorage collections** are accessed using
` f:for <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-for>`_ to
iterate, or with an explicit numeric index:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

    <!-- Iterate over a QueryResult, ObjectStorage, or plain PHP array -->
    <f:for each="{conferences}" as="conference">
        <h2>{conference.title}</h2>
    </f:for>

    <!-- Access a specific index (zero-based) -->
    <p>{conferences.0.title}</p>

    <!-- Access a named key of an associative array -->
    <p>{data.headline}</p>

:php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` implements the PHP
`Traversable <https://www.php.net/manual/en/class.traversable.php>`_ interface,
so :html:`f:for` works with it just like with arrays.


..  _extbase-view-templates:

Fluid template file resolution in Extbase
=========================================

Extbase finds a template file by searching through three configurable path lists:
:php:`templateRootPaths`, :php:`layoutRootPaths`, and :php:`partialRootPaths`.
Each list is a numerically keyed array; Fluid searches from the highest key
downward and uses the first match it finds.

**Default paths** are always appended at key :php:`0` if not already present:

*   :file:`EXT:my_extension/Resources/Private/Templates/`
*   :file:`EXT:my_extension/Resources/Private/Layouts/`
*   :file:`EXT:my_extension/Resources/Private/Partials/`

**Template file naming convention:** the file must exist at
:file:`Templates/{ControllerName}/{ActionName}.fluid.html`. The controller
name is the class name without the :php:`Controller` suffix —
:php:`ConferenceController` → :file:`Conference/`. The action name matches the
method name without the :php:`Action` suffix, with the first letter
uppercased — :php:`listAction()` → :file:`List.fluid.html`.

..  note::

    File names are case-sensitive on Linux systems, therefore
    :file:`list.fluid.html` and :file:`List.fluid.html` are different files.
    The convention requires an uppercase first letter.

**Bypassing the naming convention** is possible but discouraged. Passing an
explicit template path to :php:`$this->view->render()` overrides automatic
resolution:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    public function listAction(): ResponseInterface
    {
        $this->view->assign('conferences', $this->conferenceRepository->findAll());
        return $this->htmlResponse(
            $this->view->render('Conference/CustomList')
        );
    }

This bypasses the controller/action convention. Reserve it for rare
situations where one action needs to render a different template, for example
for AJAX variants that share a controller action.


..  _extbase-view-path-override:

Overriding Fluid template paths via TypoScript
==============================================

Add paths via TypoScript to extend or override the default resolution:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension.view {
        templateRootPaths.10 = EXT:my_extension/Resources/Private/Templates/
        layoutRootPaths.10 = EXT:my_extension/Resources/Private/Layouts/
        partialRootPaths.10 = EXT:my_extension/Resources/Private/Partials/
    }

Fluid searches from the highest key downward, so the path at key
:typoscript:`10` above takes precedence over a default at key :typoscript:`0`.

**Finding the TypoScript object path for a plugin:** open the TYPO3 backend,
navigate to the site or page containing the plugin, and open
:guilabel:`Site Management > TypoScript`. The Active TypoScript module shows
the computed TypoScript tree including all the registered plugin objects.
The object path of a plugin is always :typoscript:`plugin.tx_<extensionkey>`,
where the extension key is in lowercase and the underscores are removed.


..  _extbase-view-third-party-override:

Overriding Fluid templates from a third-party extension
=======================================================

To replace a template provided by an extension you do not control, add the
override paths to your own extension or sitepackage. Never modify a
third-party extension directly. Add a path at a key higher than the one used in the
original extension. Most extensions register their paths at key
:typoscript:`10` or leave the default at key :typoscript:`0`. Using key
:typoscript:`20` in your sitepackage is therefore safe in the majority of
cases:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

    plugin.tx_thirdpartyextension.view {
        templateRootPaths.20 = EXT:my_sitepackage/Resources/Private/ThirdParty/Templates/
        partialRootPaths.20 = EXT:my_sitepackage/Resources/Private/ThirdParty/Partials/
    }

Place your overriding template in the same relative path as in the original.
:file:`Conference/List.fluid.html` overrides :file:`Conference/List.fluid.html`
in the third-party extension.

**Key value is the only thing that matters:** TypoScript path arrays are
assembled from all active extensions and resolved by numeric key — the higher
key wins. Load order between extensions does not affect this. Declare the
third-party extension as a dependency in :file:`composer.json` to ensure it is
installed, but not because load order influences template resolution:

..  seealso::

    *   `Template file not found, or wrong template rendered <https://docs.typo3.org/permalink/extbase-appendix-pitfalls-template-not-found>`_
        for common causes and how to debug them.


..  _extbase-view-viewhelpers:

ViewHelpers in Fluid templates
==============================

`ViewHelpers <https://docs.typo3.org/permalink/t3viewhelper:start>`_
are Fluid template functions and tags. They are used for
conditionals, loops, links, formatting, and much more. The built-in ViewHelpers
use the :html:`f:` namespace, which is available in every template without
declaration.

Two equivalent syntaxes exist — tag style and inline style:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

    <!-- Tag style -->
    <f:for each="{conferences}" as="conference">
        <f:if condition="{conference.published}">
            <h2>{conference.title}</h2>
            <p><f:format.date format="d.m.Y">{conference.conferenceDate}</f:format.date></p>
            <f:link.action action="show" arguments="{conference: conference}">
                Details
            </f:link.action>
        </f:if>
    </f:for>

    <!-- Inline style (useful inside HTML attributes) -->
    <a href="{f:uri.action(action: 'show', arguments: '{conference: conference}')}">
        Details
    </a>

Commonly used ViewHelpers (with links to their full reference) are:

*   `f:for <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-for>`_
    — iterate over arrays and :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`
    collections.
*   `f:if <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-if>`_
    — conditional output.
*   `f:link.action <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-link-action>`_
    — generate links to controller actions.
*   `f:uri.action <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-uri-action>`_
    — generate action URIs for use inside attributes.
*   `f:format.date <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-format-date>`_
    — format date objects and timestamps.
*   `f:flashMessages <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-flashmessages>`_
    — render flash messages added by the controller.
*   `f:form <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-form>`_
    — build forms with automatic ``__trustedProperties`` token generation.
*   `f:translate <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-translate>`_
    — render localised labels from :file:`locallang.xlf`.
*   `f:debug <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-debug>`_
    — dump a variable's type and value during development; remove before
    deploying to production. By default output is prepended to the page top;
    use :html:`inline="1"` to render it in place.

For the complete reference of all built-in ViewHelpers, see the
`ViewHelper reference <https://docs.typo3.org/permalink/t3viewhelper:start>`_.

To write your own ViewHelper, see
`Creating custom ViewHelpers <https://docs.typo3.org/permalink/t3coreapi:fluid-custom-viewhelper>`_.


..  _extbase-view-jsonview:

JsonView: rendering JSON responses from Extbase
===============================================

To return :abbr:`JSON (JavaScript Object Notation)` from an action, set
:php:`$this->defaultViewObjectName` to
:php:`\TYPO3\CMS\Extbase\Mvc\View\JsonView::class` and then return
:php:`$this->jsonResponse()`. Extbase will then use
:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` instead of Fluid to render
the response body.

:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` does not expose all assigned
variables by default. Declare which variables to include with
:php:`setVariablesToRender()`, and set which properties of each object are
exposed with :php:`setConfiguration()`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
    use TYPO3\CMS\Extbase\Mvc\View\JsonView;

    class ConferenceController extends ActionController
    {
        protected ?string $defaultViewObjectName = JsonView::class;

        public function listAction(): ResponseInterface
        {
            $this->view->assign('conferences', $this->conferenceRepository->findAll());
            $this->view->setVariablesToRender(['conferences']);
            $this->view->setConfiguration([
                'conferences' => [
                    '_descendAll' => [
                        '_only' => ['title', 'conferenceDate', 'uid'],
                    ],
                ],
            ]);
            return $this->jsonResponse();
        }
    }

The configuration keys are:

*   :php:`_only` — allowlist of property names to include.
*   :php:`_exclude` — denylist of property names to omit.
*   :php:`_descend` — descend into a named sub-object and apply nested
    configuration to it.
*   :php:`_descendAll` — apply the same nested configuration to every element
    of an array or :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`.

For simple cases where the JSON structure can be built explicitly, skip
:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` by passing a string
to :php:`jsonResponse()` directly:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    public function countAction(): ResponseInterface
    {
        return $this->jsonResponse(json_encode([
            'count' => $this->conferenceRepository->countAll(),
        ]));
    }

..  seealso::

    `Registration: frontend plugin <https://docs.typo3.org/permalink/extbase-registration-frontend-plugin>`_
    for how to register a controller action as a cacheable or non-cacheable plugin.
