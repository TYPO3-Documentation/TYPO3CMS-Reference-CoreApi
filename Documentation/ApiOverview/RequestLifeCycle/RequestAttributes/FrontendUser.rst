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

..  literalinclude:: _MyServiceUsingFrontendUser.php
    :caption: EXT:my_extension/Classes/Service/MyService.php

..  tip::
    The frontend user id and groups are available from the
    `User aspect <https://docs.typo3.org/permalink/t3coreapi:context-api-aspects-user>`_.
