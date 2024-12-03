..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend user
..  _typo3-request-attribute-frontend-user:

=============
Frontend user
=============

The :php:`frontend.user` frontend request attribute provides the
:php:`\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication` object.

Example:

..  code-block:: php

    use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
    
    /** @var FrontendUserAuthentication $frontendUserAuthentification */
    $frontendUserAuthentification = $request->getAttribute('frontend.user');
    $frontendUserAuthentification->fetchGroupData($request);
