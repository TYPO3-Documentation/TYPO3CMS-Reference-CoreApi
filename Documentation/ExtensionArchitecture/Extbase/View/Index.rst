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

:ref:`Fluid <t3coreapi:fluid>` is the
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

:php:`$this->settings` is the :typoscript:`settings` slice of the full Extbase
configuration array. How that array is assembled — and how :typoscript:`view`,
:typoscript:`persistence`, and :typoscript:`settings` relate to TypoScript paths
and FlexForm overrides — is covered in the registration chapters:
:ref:`extbase-registration-frontend-plugin-configuration-assembly` and
:ref:`extbase-registration-backend-module-configuration-assembly`.


..  _extbase-view-assign-shared:

Assigning variables needed in every action
------------------------------------------

If a variable must be available in every action of a controller — for example
the current site object or a global configuration value — override
:php:`initializeAction()` and assign it once there instead of repeating the
call in each action method:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Core\Site\Entity\Site;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ConferenceRepository $conferenceRepository,
        ) {}

        #[\Override]
        protected function initializeAction(): void
        {
            /** @var Site $site */
            $site = $this->request->getAttribute('site');
            $this->view->assign('siteSettings', $site->getSettings()->all());
        }

        public function listAction(): ResponseInterface
        {
            $this->view->assign('conferences', $this->conferenceRepository->findAll());
            return $this->htmlResponse();
        }

        public function showAction(Conference $conference): ResponseInterface
        {
            $this->view->assign('conference', $conference);
            return $this->htmlResponse();
        }
    }

If a variable is only needed in one or two actions, assign it directly inside
those action methods — :php:`initializeAction()` is not required.


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
:ref:`f:for <t3viewhelper:typo3fluid-fluid-for>` to
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

Add paths via TypoScript to extend or override the default resolution. Use the
plugin-specific path :typoscript:`plugin.tx_myextension_myplugin` to target one
plugin, or :typoscript:`plugin.tx_myextension` (no plugin suffix) to set
defaults for every plugin of the extension:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension_conferencelist.view {
        templateRootPaths.10 = EXT:my_extension/Resources/Private/Templates/
        layoutRootPaths.10 = EXT:my_extension/Resources/Private/Layouts/
        partialRootPaths.10 = EXT:my_extension/Resources/Private/Partials/
    }

Fluid searches from the highest key downward, so the path at key
:typoscript:`10` above takes precedence over a default at key :typoscript:`0`.

**Finding the TypoScript object path for a plugin:** open the TYPO3 backend,
navigate to the site or page containing the plugin, and open
:guilabel:`Site Management > TypoScript`. The Active TypoScript module shows
the computed TypoScript tree including all registered plugin objects. See
:ref:`extbase-registration-frontend-plugin-configuration-assembly` for how the
extension-wide and plugin-specific paths are merged.


..  _extbase-view-third-party-override:

Overriding Fluid templates from a third-party extension
=======================================================

To replace a template provided by an extension you do not control, add the
override paths to your own extension or site package. Never modify a
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

:ref:`ViewHelpers <t3viewhelper:start>`
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
    <time datetime="{conference.conferenceDate -> f:format.date(format: 'Y-m-d')}">
        {conference.conferenceDate -> f:format.date(format: 'd.m.Y')}
    </time>

Commonly used ViewHelpers (with links to their full reference) are:

*   :ref:`f:for <t3viewhelper:typo3fluid-fluid-for>`
    — iterate over arrays and :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`
    collections.
*   :ref:`f:if <t3viewhelper:typo3fluid-fluid-if>`
    — conditional output.
*   :ref:`f:link.action <t3viewhelper:typo3-fluid-link-action>`
    — generate links to controller actions.
*   :ref:`f:uri.action <t3viewhelper:typo3-fluid-uri-action>`
    — generate action URIs for use inside attributes.
*   :ref:`f:format.date <t3viewhelper:typo3-fluid-format-date>`
    — format date objects and timestamps.
*   :ref:`f:flashMessages <t3viewhelper:typo3-fluid-flashmessages>`
    — render flash messages added by the controller.
*   :ref:`f:form <t3viewhelper:typo3-fluid-form>`
    — build forms with automatic ``__trustedProperties`` token generation.
*   :ref:`f:translate <t3viewhelper:typo3-fluid-translate>`
    — render localised labels from :file:`locallang.xlf`.
*   :ref:`f:debug <t3viewhelper:typo3-fluid-debug>`
    — dump a variable's type and value during development; remove before
    deploying to production. By default output is prepended to the page top;
    use :html:`inline="1"` to render it in place. For deeper introspection of
    Extbase objects and lazy-loaded relations, the community extension
    `includekrexx <https://extensions.typo3.org/extension/includekrexx>`_
    provides a richer debug output than :html:`f:debug`.

For the complete reference of all built-in ViewHelpers, see the
:ref:`ViewHelper reference <t3viewhelper:start>`.

To write your own ViewHelper, see
:ref:`Creating custom ViewHelpers <t3coreapi:fluid-custom-viewhelper>`.

For reusable template fragments with a typed argument contract, Fluid v4
introduced :ref:`Fluid Components <t3coreapi:using-fluid-components>`
as an alternative to both partials and custom ViewHelpers. Components are
pure Fluid templates — no PHP class required — with typed, named arguments
declared via :html:`<f:argument>`. They are the right choice for
:abbr:`UI (User Interface)` building blocks such as buttons, cards, or form
field wrappers that need to be reused across templates.

Custom ViewHelpers are the right choice when logic cannot be expressed in
Fluid alone, or when access to the rendering context is needed — for example
ViewHelpers like :html:`f:form.textfield` that must locate a parent
:html:`f:form` tag. Components do not have access to the parent rendering
context and must not be used in those situations.


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
