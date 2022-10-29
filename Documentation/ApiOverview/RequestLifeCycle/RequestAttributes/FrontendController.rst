..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend controller
..  _typo3-request-attribute-frontend-controller:

===================
Frontend controller
===================

The :php:`frontend.controller` frontend request attribute provides access to the
:php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` object.

Example:

..  code-block:: php

    $frontendController = $request->getAttribute('frontend.controller');
    $rootline = $frontendController->rootline;

..  important::
    In former TYPO3 versions you have to retrieve the
    :php:`TypoScriptFrontendController` via the global variable
    :php:`$GLOBALS['TSFE']`. This should be avoided now, instead use the request
    attribute.
