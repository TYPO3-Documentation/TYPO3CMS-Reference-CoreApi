.. include:: ../../../Includes.txt

.. _ajax-client-side:

=======================
Client-Side Programming
=======================

TYPO3 Core ships an API to send AJAX requests to the server. This API is based on the `fetch API`_, which is implemented
in every modern browser (e.g. Chrome, Safari, Firefox, Edge).

.. note::
   TYPO3 ships jQuery as well, but is considered discouraged for new code.


Prepare a Request
=================

To be able to send a request, the module :js:`TYPO3/CMS/Core/Ajax/AjaxRequest` must be imported. To prepare a request,
create a new instance of :js:`AjaxRequest` per request and pass the url as the constructor argument:

.. code-block:: js

   let request = new AjaxRequest('https://example.com/my-endpoint');

The API offers a method :js:`withQueryString()` which allows to attach a query string to the URL. This comes in handy if
the query string is programmatically generated. The method returns a clone of the :js:`AjaxRequest` object. It's possible
to pass either strings, arrays or objects as an argument.

Example:

.. code-block:: js

   const qs = {
     foo: 'bar',
     bar: {
       baz: ['foo', 'bencer']
     }
   };
   request = request.withQueryArguments(qs);

   // The query string compiles to ?foo=bar&bar[baz][0]=foo&bar[baz][1]=bencer

The method detects whether the URL already contains a query string and appends the new query string in a proper format.

Send a Request
==============

The API offers some methods to actually send the request:

* :js:`get()`
* :js:`post()`
* :js:`put()`
* :js:`delete()`

Each of these methods set the corresponding request method (GET, POST, PUT, DELETE). :js:`post()`, :js:`put()` and
:js:`delete()` accept the following arguments:

.. rst-class:: dl-parameters

data
   :sep:`|` :aspect:`Condition:` required
   :sep:`|` :aspect:`Type:` string | object
   :sep:`|`

   The payload to be sent as body in the request.

init
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` object
   :sep:`|` :aspect:`Default:` '{}'
   :sep:`|`

   Additional `request configuration`_ to be set

The method :js:`get()` accepts the :js:`init` argument only.

Example:

.. code-block:: js

   let promise = request.get();

.. note::
   The API presets the request configuration with :js:`{credentials: 'same-origin', signal: AbortController.signal}`.

The body of the request is automatically converted to a `FormData`_ object, if the submitted payload is an object. To
send a JSON-encoded object instead, set the `Content-Type` header to `application/json`.
If the payload is a string, no conversion will happen, but it's still recommended to set proper headers.

Example:

.. code-block:: js

   const json = {foo: 'bar'};
   let promise = request.post(json, {
     headers: {
       'Content-Type': 'application/json; charset=utf-8'
     }
   });


Handle the Response
===================

In the examples above :js:`promise` is, as the name already spoils, a `Promise`_ object. To fetch the actual response,
we'll make use of :js:`then()`:

.. code-block:: js

   promise.then(async function (response) {
     const responseText = await response.resolve();
     console.log(responseText);
   });

:js:`response` is an object of type :js:`AjaxResponse` shipped by TYPO3 (:js:`TYPO3/CMS/Core/Ajax/AjaxResponse`). The
object is a simple wrapper for the original `Response`_ object. :js:`AjaxResponse` exposes the following methods which
eases the handling with responses:

* :js:`resolve()` - returns the correct response based on the received `Content-Type` header, either plaintext or a JSON object
* :js:`raw()` - returns the original `Response`_ object

Of course a request may fail for various reasons. In such case, a second function may be passed to :js:`then()`, which
handles the exceptional case. The function may receive a :js:`ResponseError` object (:js:`TYPO3/CMS/Core/Ajax/ResponseError`)
which contains the received response.

.. code-block:: js

   promise.then(async function (response) {}, function (error) {
     console.error(`The request failed with ${error.response.status}: ${error.response.statusText}`);
   });

.. hint::
   The fetch API handles responses with faulty statuses like 404 or 500 still as "successful", but sets the response's
   :js:`ok` field to `false`. The AJAX API converts such responses into errors for convenience reasons.


Abort a Request
===============

In some cases it might be necessary to abort a running request. The AJAX API has you covered then, an instance of
`AbortController`_ is attached to each request. To abort the request, just call the :js:`abort()` method:

.. code-block:: js

  request.abort();


.. _`fetch API`: https://developer.mozilla.org/docs/Web/API/Fetch_API
.. _`request configuration`: https://developer.mozilla.org/en-US/docs/Web/API/Request#Properties
.. _`Response`: https://developer.mozilla.org/en-US/docs/Web/API/Response
.. _`Promise`: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise
.. _`FormData`: https://developer.mozilla.org/en-US/docs/Web/API/FormData
.. _`AbortController`: https://developer.mozilla.org/en-US/docs/Web/API/AbortController
