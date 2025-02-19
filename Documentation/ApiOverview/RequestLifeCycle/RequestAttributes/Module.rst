..  include:: /Includes.rst.txt

..  index::
    Request attribute; Module
..  _typo3-request-attribute-module:

======
Module
======

The :php:`module` backend request attribute provides information about the
current backend module in the object :php:`\TYPO3\CMS\Backend\Module\Module`.

Example:

..  code-block:: php

    $module = $request->getAttribute('module');
    $identifier = $route->getIdentifier();


API
===

..  include:: /CodeSnippets/Manual/Entity/Module.rst.txt
