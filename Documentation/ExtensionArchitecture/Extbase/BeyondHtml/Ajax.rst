:navigation-title: AJAX with fetch()

..  include:: /Includes.rst.txt
..  index::
    pair: Extbase; AJAX
    pair: Extbase; fetch
..  _extbase-beyond-html-ajax:

=================================
Loading Extbase data with fetch()
=================================

A page does not have to contain all of its data when it leaves the server. A
script in the browser can request data later, with the
`Fetch API <https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API>`_, and
update part of the page without reloading it. This technique is commonly called
:abbr:`AJAX (Asynchronous JavaScript and XML)`, although the data is usually
JSON today.

An Extbase action can answer such a request. This page builds a small example
from end to end: an action that returns JSON, a URL for it, and a script that
displays the result.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-beyond-html-ajax-example:

Showing live data in a cached Extbase list
==========================================

The conference list of the example site is cached, as a list should be. Each
conference also shows how many seats are left, and that number changes with
every registration. Rendering it into the cached list would show outdated
numbers. Making the whole list non-cacheable would render it on every request
for the sake of one number per conference.

The list therefore stays cached, and a script loads the numbers separately.
Four pieces work together: a plugin with an action that returns the numbers as
JSON, a page type that delivers them at their own URL, the list template that
tells the script where to find them, and the script itself.


..  _extbase-beyond-html-ajax-action:

An Extbase action that returns JSON for a script
================================================

The plugin is only configured, not registered as a content element: no editor
places it on a page, the page type renders it. Its action is listed as
non-cacheable, so the numbers are current on every request:

..  literalinclude:: _snippets/_ext_localconf_seats.php
    :caption: EXT:my_extension/ext_localconf.php

The action collects the numbers and renders them with
:ref:`JsonView <extbase-beyond-html-jsonview>`:

..  literalinclude:: _snippets/_ConferenceSeatsController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceSeatsController.php

:php:`findUpcoming()` stands for the repository method the list uses, and
:php:`getSeatsLeft()` for a model method that computes the free seats. The
action builds a small array per conference with exactly the two values the
script needs, and renders a single variable, so the response is a bare JSON
array:

..  code-block:: json
    :caption: Response of seatsAction()

    [
        {"uid": 12, "seatsLeft": 4},
        {"uid": 15, "seatsLeft": 0}
    ]


..  _extbase-beyond-html-ajax-url:

Giving the Extbase JSON action its own URL with a page type
===========================================================

A plugin on a regular page cannot deliver the JSON on its own, see
:ref:`Delivering the JSON of an Extbase action at its own URL
<extbase-beyond-html-jsonview-delivery>`. A
:ref:`typeNum page type <extbase-beyond-html-page-type>` that renders only the
plugin gives it a URL:

..  literalinclude:: _snippets/_setup_seats.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

The page type renders the plugin directly, without a content element, so the
plugin takes its storage folder from TypoScript, see
:ref:`Rendering the plugin without a content element
<extbase-beyond-html-page-type-plugin-only>`. The response carries the content
type :php:`application/json` that :php:`jsonResponse()` set, so the
:typoscript:`PAGE` object needs no header configuration.

A `PageType decorator <https://docs.typo3.org/permalink/t3coreapi:routing-pagetype-decorator>`_
can map the page type to a suffix such as :file:`seats.json`, as the
:ref:`feed example <extbase-beyond-html-page-type-plugin>` does. The script
does not depend on it, because it receives the URL from the page.


..  _extbase-beyond-html-ajax-template:

Passing the URL of the Extbase JSON action to a script
======================================================

The list template writes the URL into a `data-` attribute, so the script does
not have to build it. :html:`f:uri.page` with a :html:`pageType` links the
current page in its current language, with the page type of the seats plugin.
Each conference carries its uid, and an empty, hidden placeholder for the
number:

..  literalinclude:: _snippets/_ListSeats.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

The :ref:`f:asset.script <t3viewhelper:typo3-fluid-asset-script>` ViewHelper
adds the script to the page once, however often the template is rendered.

The URL is the same for every visitor, so it is part of the cached list. Only
the response behind it changes.


..  _extbase-beyond-html-ajax-script:

Fetching and displaying Extbase JSON data with JavaScript
=========================================================

The script requests the URL, reads the JSON, and fills in the number for every
conference it finds in the list:

..  literalinclude:: _snippets/_conference-seats.js
    :caption: EXT:my_extension/Resources/Public/JavaScript/conference-seats.js

*   :js:`fetch()` sends a `GET` request to the URL from the
    `data- attribute <https://developer.mozilla.org/en-US/docs/Web/HTML/How_to/Use_data_attributes>`_
    and returns a promise for the response.
*   :js:`response.ok` is true for a status code between 200 and 299. Any other
    status leaves the placeholders hidden.
*   :js:`response.json()` parses the body into JavaScript values, here the
    array the action returned.
*   The script shows a placeholder only after it has filled in the number.

Requests from :js:`fetch()` to the same site send the visitor's cookies by
default, so the action sees the same frontend user as the page, and the page
type applies the same access restrictions as the page.

The list works without the script as well. If the script does not run or the
request fails, the visitor sees the list without the numbers, which is what
`progressive enhancement <https://developer.mozilla.org/en-US/docs/Glossary/Progressive_Enhancement>`_
means.


..  _extbase-beyond-html-ajax-caching:

Caching the JSON response of an Extbase action
==============================================

Because the action is non-cacheable, the plugin is rendered as a
:ref:`USER_INT object <extbase-caching-noncacheable-userint>`. TYPO3 caches
the page type with a placeholder and runs the action on every request. The
content type of the action still reaches every response, including those
whose page comes from the cache.

Every request still runs the frontend: TYPO3 resolves the site and the page,
checks access, and loads the TypoScript, mostly from caches. For one request
per page view that is acceptable. A script that polls every few seconds, or
many scripts on one page, multiply that cost.

Data that changes rarely does not need a non-cacheable action. Leave the action
cacheable, and the page type delivers the JSON from the page cache like any
other page. Use :ref:`cache tags <extbase-caching-cachetags>` to clear it when
the data changes.


..  _extbase-beyond-html-ajax-errors:

Answering a script with an error status from an Extbase action
==============================================================

The status code of the action's response reaches the browser when it is 300
or higher. An action that has to report an error, for example because a
requested record does not exist, returns a response with such a status:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceSeatsController.php (excerpt)

    return $this->jsonResponse(json_encode(
        ['error' => 'Conference not found'],
        JSON_THROW_ON_ERROR,
    ))->withStatus(404);

Status codes below 300, such as `201 Created` or `204 No Content`, do not
reach the browser: TYPO3 answers with `200 OK`.

An error status also makes the plugin non-cacheable for that request, so an
error is never stored in the page cache.


..  _extbase-beyond-html-ajax-next:

Next steps after loading Extbase data with fetch()
==================================================

The action in this example used :ref:`JsonView <extbase-beyond-html-jsonview>`
to render its data, which explains in more detail which variables end up in the
JSON and how to shape it. :ref:`Ways to deliver non-HTML output from TYPO3
<extbase-beyond-html-options>` compares the page type used here with the other
options, such as answering in a middleware before any page is rendered.
