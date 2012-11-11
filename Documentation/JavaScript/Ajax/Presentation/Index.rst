.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _ajax-presentation:

In-depth presentation
^^^^^^^^^^^^^^^^^^^^^


.. _ajax-client:

Client-Side programming
"""""""""""""""""""""""

.. note::
   This paragraph describes obsolete processes using Prototype
   and Scriptaculous


On the client-side we are using the Prototype JS library (located in
typo3/contrib/prototype/prototype.js). If you have used it already,
you know that you can make AJAX calls with AJAX.Request, AJAX.Updater
and AJAX.PeriodicalUpdater. We extended the library and hooked in
these objects, or better: in the callbacks users can define. If an
AJAX request is made to our server-side component (typo3/ajax.php),
everything developers need to do is to call this URL and add a unique,
already registered parameter for their ajaxID. Their defined
"onComplete" and "onSuccess" are only rendered if the X-JSON header is
set to true by the server-side script. If the X-JSON header is set to
false, the Responder checks if there is a callback function named
"onT3Error" and executes it instead of the "onComplete" method. If the
"onT3Error" method is not defined, the default TYPO3 error handler
will be displaying the error in the TYPO3 backend. If the X-JSON
header is set to false, the "onSuccess" callback will not be executed
as well as but an error message will be shown in the notification
area. This behaviour is done automatically with every AJAX call to
"ajax.php" made through Prototype's AJAX classes. This responder is
also only active if "typo3/js/common.js" is added to the base script.

Since TYPO3 4.4, ExtJS is used instead for AJAX calls. TYPO3 even
supports usage of :ref:`Ext.Direct<extdirect>`.


.. _ajax-server:

Server-side programming
"""""""""""""""""""""""

If you look into "typo3/ajax.php", it is only a small dispatcher
script. It checks for an ajaxID in the :code:`$TYPO3_CONF_VARS['BE']['AJAX']`
array and tries to execute the function pointer. The function has two
parameters, where the first (an array) is not used yet. The second
parameter is the TYPO3 AJAX Object (located in
:file:`typo3/classes/typo3ajax.php`) that is used to add the content that
should be returned as the server-response to the Javascript part, or
the error message that should be displayed. The X-JSON header will be
set depending on whether :code:`setError()` was called on this AJAX object.
You can also specify if the object should return the result in a valid
XML object tree, as text/html (default) or as a JSON object, see
below.

The "ajaxID" is a unique identifier and can be used to override the
existing AJAX calls. Therefore you can extend existing AJAX calls that
already exist in the backend by redirecting it to your function. But
be aware of the side-effects of this feature: Other extensions could
overwrite this function as well (similar problem as with XCLASSing or
single inheritance in OOP).

Also, for every TYPO3 request, you will now have a :code:`TYPO3_REQUESTTYPE`
variable that can be used for bitwise comparison. You can now check if
you're in Backend or Frontend or in an valid AJAX request with ::

   if (TYPO3_REQUESTTYPE && TYPO3_REQUESTTYPE_AJAX)

to see if you're calling through the new AJAX interface.


.. _ajax-formats:

Different Content Formats
"""""""""""""""""""""""""

As with every AJAX response you can send it in different response
formats.

- text/html - plain text

- text/xml - strict XML formatting

- application/json - JSON notation

You can also specify the contentFormat in the AJAX object like this::

   $ajaxObj->setContentFormat('json');

For the keyword you can choose between "plain" (default), "xml" and
"json", "jsonbody" and "jsonhead".

Here are the specifics for each format.


.. _ajax-formats-plain:

Plain Text
~~~~~~~~~~

The content array in the backend will be concatenated and returned
uninterpreted.

The result will be available in the transport object as a string
through "xhr.responseText".


.. _ajax-formats-xml:

XML
~~~

The content needs to be valid XML and will be available in javascript
as "xhr.responseXML".


.. _ajax-formats-json:

JSON
~~~~

The content is transformed to JSON using PHP's built-in functions
and is then available in JSON notation
through the second parameter in the onComplete / onSuccess methods,
and additionally in the "responseText" part of the transport object
("xhr.responseText"). If it is set to "jsonbody", only the latter
variable is filled, if "jsonhead" is set, it is only in the second
parameter. This is useful to save traffic and you can use it with
whatever format you like.


