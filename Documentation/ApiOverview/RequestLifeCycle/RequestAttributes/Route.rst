..  include:: /Includes.rst.txt

..  index::
    Request attribute; Route
..  _typo3-request-attribute-route:

=====
Route
=====

The :php:`route` backend request attribute provides routing information in
the object :php:`\TYPO3\CMS\Backend\Routing\Route`.

Example:

..  code-block:: php

    $route = $request->getAttribute('route');
    $moduleConfiguration = $route->getOption('moduleConfiguration');


API
===

..  include:: /CodeSnippets/Manual/Entity/Route.rst.txt
