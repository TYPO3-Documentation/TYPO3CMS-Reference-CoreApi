..  include:: /Includes.rst.txt

..  index::
    Request attribute; Site
..  _typo3-request-attribute-site:

====
Site
====

The :php:`site` request attribute hold information about the current
site in the object :php:`\TYPO3\CMS\Core\Site\Entity\Site`.
It is available in frontend and backend context.

Example:

..  code-block:: php

    $site = $request->getAttribute('site');
    $siteConfiguration = $site->getConfiguration();

..  note::
    In backend context the attribute can hold a
    :php:`\TYPO3\CMS\Core\Site\Entity\NullSite` object when the module does not
    provide a page tree or no page in the page tree is selected.


API
===

..  include:: /CodeSnippets/Manual/Entity/Site.rst.txt
