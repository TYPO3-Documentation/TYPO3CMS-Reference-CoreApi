..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend controller
..  _typo3-request-attribute-frontend-controller:

===================
Frontend controller
===================

..  deprecated:: 13.4
    The class :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`
    and its global instance :php:`$GLOBALS['TSFE']` have been marked as
    deprecated. The class will be removed with TYPO3 v14.

    Use the :ref:`frontend.page.information <typo3-request-attribute-frontend-page-information>`
    request attribute for page-related properties.

The :php:`frontend.controller` frontend request attribute provides access to the
:php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` object.

Example:

..  code-block:: php

    $frontendController = $request->getAttribute('frontend.controller');
    $rootline = $frontendController->rootLine;  // Mind the capital "L"

..  attention::
    In former TYPO3 versions you have to retrieve the
    :php:`TypoScriptFrontendController` via the global variable
    :php:`$GLOBALS['TSFE']`. This should be avoided now, instead use the request
    attribute.
