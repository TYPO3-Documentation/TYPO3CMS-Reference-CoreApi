:navigation-title: Session Data

..  include:: /Includes.rst.txt
..  index:: Sessions; Data
..  _session-data:

============
Session data
============

In the TYPO3 frontend, data can be stored in the current user session.

The actual location where the data will be stored is determined by the
`Session storage configuration <https://docs.typo3.org/permalink/t3coreapi:session-storage>`_.

You can use the following methods in
:php-short:`\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication`:

:php:`FrontendUserAuthentication::getKey($type, $key)`
    Loads data from the session.
:php:`FrontendUserAuthentication::setKey($type, $key, $data)`
    Saves data to the session as a string.
:php:`FrontendUserAuthentication::storeSessionData()`
    Writes session data so it is available in the next request.

..  _session-data-example-multi-step:

Example: Save shopping basket into user session
===============================================

Let us assume we have an Extbase Controller for a shopping basket. We want to
preserve the data the user enters before closing the browser
window. This should also work for non logged-in users.

We can use :php:`$this->request->getAttribute('frontend.user')`
to create a frontend user on the fly if none exists.

If no `Frontend user <https://docs.typo3.org/permalink/t3coreapi:frontend-user-api>`_
is currently logged in, an anonymous frontend user will be created on the fly.

In the browser of the current user a session cookie will be set linking
them to the anonymous frontend user.

..  literalinclude:: _codesnippets/_ShoppingCartController.php
    :caption: packages/my_extension/Classes/Controller/ShoppingCartController.php
