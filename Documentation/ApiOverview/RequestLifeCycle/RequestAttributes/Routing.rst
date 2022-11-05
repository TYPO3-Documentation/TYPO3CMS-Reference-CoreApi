..  include:: /Includes.rst.txt

..  index::
    Request attribute; Routing
..  _typo3-request-attribute-routing:

=======
Routing
=======

The :php:`routing` frontend request attribute provides routing information in
the object :php:`\TYPO3\CMS\Core\Routing\PageArguments`. If you want to know the
current page ID or retrieve the query parameters this attribute is your friend.

Example:

..  code-block:: php

    $pageArguments = $request->getAttribute('routing');
    $pageId = $pageArguments->getPageId();


API
===

..  include:: /CodeSnippets/Manual/Entity/PageArguments.rst.txt
