:navigation-title: View

..  include:: /Includes.rst.txt
..  index:: Extbase; View
..  _extbase-view:

============
Extbase view
============

The result of an action or a chain of actions is usually a view where output,
most often as HTML is displayed to the user.

The action, located in the controller returns a :php:`ResponseInterface`
(:php:`Psr\Http\Message\ResponseInterface`)
which contains the result of the view. The view, property :php:`$view` of type
:php:`ViewInterface` (:php:`TYPO3Fluid\Fluid\View\ViewInterface`).

In the most common case it is sufficient to just set some variables on the
:php:`$view` and return :php:`$this->htmlResponse()`:

.. literalinclude:: /CodeSnippets/Extbase/View/HtmlResponse.php
   :caption: Class T3docs\\BlogExample\\Controller\\BlogController
   :emphasize-lines: 18

Read more in the section :ref:`extbase_responses`.

..  _extbase-view-configuration:

View configuration
===================

The view can be configured with TypoScript:

.. literalinclude:: /CodeSnippets/Extbase/View/TypoScript.typoscript
   :caption: EXT:blog_example/Configuration/TypoScript/setup.typoscript

..  _extbase-responses:

Responses
==========

..  _extbase-response-html:

HTML response
--------------

In the most common case it is sufficient to just set some variables on the
:php:`$view` and return :php:`$this->htmlResponse()`. The Fluid templates
will then configure the rendering:

.. literalinclude:: /CodeSnippets/Extbase/View/HtmlResponse.php
   :caption: Class T3docs\\BlogExample\\Controller\\BlogController
   :emphasize-lines: 18

It is also possible to directly pass a HTML string to the function
:php:`htmlResponse()`. This way other templating engines but Fluid can be used:

.. literalinclude:: /CodeSnippets/Extbase/View/HtmlResponseCustom.php
   :caption: Class T3docs\\BlogExample\\Controller\\BlogController
   :emphasize-lines: 10

..  attention::
    **Never** directly pass user input to the response without proper escaping.
    See :ref:`security-xss`.

..  _extbase-response-json:

JSON response
--------------

Similar to the method :php:`$this->htmlResponse()` there is a method
:php:`$this->jsonResponse()`. In case you are using it you have to make sure
the view renders valid JSON.

Rendering JSON by Fluid is in most cases not a good option. Fluid uses special
signs that are needed in JSON etc. So in most cases the :php:`jsonResponse()`
is used to directly output a json string:

.. literalinclude:: /CodeSnippets/Extbase/View/JsonResponseCustom.php
   :caption: Class T3docs\\BlogExample\\Controller\\BlogController
   :emphasize-lines: 9

It is also possible to use the JSON response together with a special view class
the :php:`JsonView` (:php:`TYPO3\CMS\Extbase\Mvc\View\JsonView`).

..  _extbase-response-format:

Response in a different format
-------------------------------

If you need any output format but HTML or JSON, build the response object
using :php:`$responseFactory` implementing the
:php:`ResponseFactoryInterface`:

.. literalinclude:: /CodeSnippets/Extbase/View/CustomResponse.php
   :caption: Class T3docs\\BlogExample\\Controller\\PostController
   :emphasize-lines: 17,18,19
