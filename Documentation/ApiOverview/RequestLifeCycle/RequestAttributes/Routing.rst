..  include:: /Includes.rst.txt

..  index::
    Request attribute; Routing
..  _typo3-request-attribute-routing:

=======
Routing
=======

.. contents::
   :depth: 1
   :local:

Frontend
========

The :php:`routing` frontend request attribute provides routing information in
the object :php:`\TYPO3\CMS\Core\Routing\PageArguments`. If you want to know the
current page ID or retrieve the query parameters this attribute is your friend.

Example:

..  code-block:: php

    /** @var \Psr\Http\Message\ServerRequestInterface $request */
    $pageArguments = $request->getAttribute('routing');
    $pageId = $pageArguments->getPageId();


API
---

..  include:: /CodeSnippets/Manual/Entity/PageArguments.rst.txt


..  _typo3-request-attribute-routing-backend:

Backend
=======

The :php:`routing` backend request attribute provides routing information in
the object :php:`\TYPO3\CMS\Backend\Routing\RouteResult`.

Example:

..  code-block:: php

    /** @var \Psr\Http\Message\ServerRequestInterface $request */
    $routing = $request->getAttribute('routing');
    $arguments = $routing->getArguments()

..  seealso::
    :ref:`backend-routing-dynamic-parts`

API
---

..  include:: /CodeSnippets/Manual/Entity/RouteResult.rst.txt
