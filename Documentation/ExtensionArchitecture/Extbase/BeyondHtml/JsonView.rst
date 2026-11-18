:navigation-title: JsonView

..  include:: /Includes.rst.txt
..  index::
    pair: Extbase; JsonView
    pair: Extbase; JSON
..  _extbase-beyond-html-jsonview:
..  _extbase-view-jsonview:
..  _extbase-response-json:

=======================================
Rendering JSON with JsonView in Extbase
=======================================

:php:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` renders the variables an action
assigns as :abbr:`JSON (JavaScript Object Notation)` instead of passing them to
a Fluid template. The action keeps the usual pattern: it assigns variables to
the view and returns a response, and the view decides what the output looks
like.

This page shows how an action switches to
:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView`, which variables end up in
the output, and how to shape the data. Where the JSON is delivered is a
separate question, see
:ref:`Beyond HTML delivery <extbase-beyond-html>`.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-jsonview-switch:

Switching an Extbase action to JsonView
=======================================

Extbase creates the view of an action itself. The protected property
:php:`$defaultViewObjectName` of
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController` decides which
view that is: Fluid when it is :php:`null`, the default, or
:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` when it is set to
:php:`JsonView::class`.

Setting the property in an
:ref:`initializeXxxAction() method <extbase-controller-action-initialize>`
switches one action and leaves the others of the controller with Fluid.
Extbase calls this method before it creates the view:

..  literalinclude:: _snippets/_ConferenceControllerJsonView.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php
    :visible-lines: 18-21

The action then assigns its variables, names the ones to render with
:php:`setVariablesToRender()`, and returns :php:`$this->jsonResponse()`, which
renders the view and sets the content type `application/json`:

..  literalinclude:: _snippets/_ConferenceControllerJsonView.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php
    :visible-lines: 23-40

A controller whose actions all answer with JSON sets the property once in its
constructor instead, as the backend controllers of the extension manager in
the TYPO3 Core do.

:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` is the only view class
besides Fluid that Extbase accepts in :php:`$defaultViewObjectName`. Any other
class name raises an exception. An action that needs a different view creates
it itself, for example with the
:ref:`view factory <generic-view-factory>`, and passes the rendered
string to the response.


..  _extbase-beyond-html-jsonview-variables:

Choosing the variables JsonView renders
=======================================

:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` renders only the variables
named in :php:`setVariablesToRender()`. Everything else assigned to the view,
including the :php:`settings` that Extbase assigns to every view, stays out of
the output. Without a call to :php:`setVariablesToRender()`, the view renders
a variable called `value` and nothing else, so an action that forgets the call
returns `null`.

The number of variables decides the shape of the JSON:

*   **Several variables** are rendered as a JSON object with one member per
    variable. The action above returns:

    ..  code-block:: json
        :caption: Response of upcomingAction()

        {
            "conferences": [
                {
                    "uid": 12,
                    "title": "Developer Days",
                    "conferenceDate": "2027-03-18T09:00:00+01:00"
                }
            ],
            "total": 1
        }

*   **A single variable** is rendered as its value alone, without a key. With
    :php:`setVariablesToRender(['conferences'])`, the same action would return
    the bare JSON array of conferences.

A PHP list becomes a JSON array, and an array with string keys becomes a JSON
object.


..  _extbase-beyond-html-jsonview-shape:

Shaping the JSON output of an Extbase action in PHP
===================================================

:php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` converts what it receives as
follows:

*   Arrays are converted element by element.
*   Dates, that is objects implementing
    `DateTimeInterface <https://www.php.net/manual/en/class.datetimeinterface.php>`_,
    become strings in the
    `ISO 8601 <https://en.wikipedia.org/wiki/ISO_8601>`_ format with time zone
    offset, as shown above.
*   Other objects, such as domain models, become JSON objects with one member
    per readable property: each public property, and each property that has a
    public getter. Only properties holding a scalar value are included.
    A property that holds an object or an array, such as a relation to another
    model, is left out without an error.

Assigning domain models directly is therefore rarely what an endpoint needs.
Every readable property becomes public, including fields such as :php:`pid`
that the client has no use for and fields the model only keeps for internal
purposes. At the same time the relations are missing.

Build the data the client needs in the action instead, as an array or as a
:ref:`data transfer object (DTO) <extbase-domain-dto>` with exactly the fields
to publish, the way the example above does. The output then shows at one
glance what the endpoint exposes, a new property on the model does not appear
in the JSON unnoticed, and related data is included by reading it explicitly,
for example the name of a conference's location.


..  _extbase-beyond-html-jsonview-without:

Returning JSON from an Extbase action without JsonView
======================================================

When the action builds an array anyway, encoding it directly is just as short.
:php:`$this->jsonResponse()` accepts the JSON string and uses it as the body,
so no view configuration is needed:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php (excerpt)

    public function countAction(): ResponseInterface
    {
        return $this->jsonResponse(json_encode(
            ['count' => $this->conferenceRepository->countAll()],
            JSON_THROW_ON_ERROR,
        ));
    }

Extbase still prepares the default view for such an action, but it is never
rendered. :php-short:`\TYPO3\CMS\Extbase\Mvc\View\JsonView` is the better fit
when the action should stay with the usual assign-and-render pattern, and when
the output contains dates that should be formatted consistently.


..  _extbase-beyond-html-jsonview-delivery:

Delivering the JSON of an Extbase action at its own URL
=======================================================

:php:`$this->jsonResponse()` sets the content type of the action's response.
For a plugin rendered on a regular page, Extbase does not replace the page with
that response: the JSON is inserted into the page HTML, and its content type
becomes the content type of the whole page, see the pitfall
:ref:`An action returning JSON breaks the page <extbase-appendix-pitfalls-json-on-html-page>`.

The JSON therefore needs a URL of its own, for example a
:ref:`typeNum page type <extbase-beyond-html-page-type>` that renders only the
plugin. :ref:`Loading Extbase data with fetch() <extbase-beyond-html-ajax>`
shows the complete path from the action to a script that displays the data,
and :ref:`Ways to deliver non-HTML output from TYPO3
<extbase-beyond-html-options>` compares the other options.

In a headless setup, the JSON of the action becomes part of the JSON of the
page that contains the plugin, see :ref:`Letting an Extbase plugin answer with
JsonView <extbase-beyond-html-headless-extbase-plugins-jsonview>`.
