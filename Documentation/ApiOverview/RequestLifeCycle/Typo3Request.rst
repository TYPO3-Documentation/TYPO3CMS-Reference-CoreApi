..  include:: /Includes.rst.txt
..  index::
    Request handling; request object
    $GLOBALS; TYPO3_REQUEST
..  _typo3-request:

====================
TYPO3 request object
====================

The TYPO3 request object is an implementation of the PSR-7 based
`\Psr\Http\Message\ServerRequestInterface` containing TYPO3-specific attributes.

The request object is passed to controllers. The attributes can be retrieved via

..  code-block:: php

    // Get all available attributes
    $allAttributes = $request->getAttributes();

    // Get only a specific attribute
    $site = $request->getAttribute('site');

The request object is also available as a global variable in
:php:`$GLOBALS['TYPO3_REQUEST']`. This is a workaround for the Core which has to
access the server parameters at places where :php:`$request` is not available.
So, while this object is globally available during any HTTP request, it is
considered bad practice to use this global object, if the request is accessible
in another, official way. The global object is scheduled to vanish at a later
point once the code has been refactored enough to not rely on it anymore.


..  todo:
    Add information on how to retrieve the request object from different
    scenarios (Extbase controller, data processor, USER function, backend
    controller, etc, and global variable as last resort).


The following attributes are available in **frontend** context:

..  toctree::
    :titlesonly:

    RequestAttributes/ApplicationType
    RequestAttributes/FrontendController
    RequestAttributes/FrontendUser
    RequestAttributes/Language
    RequestAttributes/NormalizedParams
    RequestAttributes/Routing
    RequestAttributes/Site

The following attributes are available in **backend** context:

..  toctree::
    :titlesonly:

    RequestAttributes/ApplicationType
    RequestAttributes/NormalizedParams
    RequestAttributes/Route
    RequestAttributes/Site
    RequestAttributes/Target
