..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend user
..  _typo3-request-attribute-frontend-user:

=============
Frontend user
=============

The :php:`frontend.user` frontend request attribute provides the
:php:`\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication` object.

The topic is described in depth in chapter 
`Authentication <https://docs.typo3.org/permalink/t3coreapi:authentication>`_.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Service/MyService.php

    use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

    public function doSomethingToFrontendUser(ServerRequestInterface $request): void
    {
        /** @var FrontendUserAuthentication $frontendUserAuthentification */
        $frontendUserAuthentification = $request->getAttribute('frontend.user');
        $frontendUserAuthentification->fetchGroupData($request);
        // do something
    }

..  tip::
    The frontend user id and groups are available from the
    `User aspect <https://docs.typo3.org/permalink/t3coreapi:context_api_aspects_user>`_.
