:navigation-title: Session Data

..  include:: /Includes.rst.txt
..  index:: Sessions; Data
..  _session-data:

============
Session data
============

In the TYPO3 frontend you can store data in the session of the current user.

The actual location where the data will be stored is determined by the
`Session storage configuration <https://docs.typo3.org/permalink/t3coreapi:session-storage>`_.

You can use the following methods on
:php-short:`\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication`:

:php:`FrontendUserAuthentication::getKey($type, $key)`
    To load data from the session.
:php:`FrontendUserAuthentication::setKey($type, $key, $data)`
    To save data as string to the session.
:php:`FrontendUserAuthentication::storeSessionData()`
    Writes the session data so it is available in the next request.

..  _session-data-example-multi-step:

Example: Save shopping basket into user session
===============================================

Let us assume we have an Extbase Controller for a shopping basket. We want to
preserve the data the user already entered until the user closes the browser
window. This should also work for not logged-in users.

We can use :php:`$this->request->getAttribute('frontend.user')`
to create a frontend user on the fly if none exists.

If no `Frontend user <https://docs.typo3.org/permalink/t3coreapi:frontend-user-api>`_
is currently logged in, an anonymous frontend user will be created on the fly.

In the browser of the current user a session cookie will be set to connect
them to that anonymous frontend user.

..  literalinclude:: _codesnippets/_ShoppingCartController.php
    :caption: packages/my_extension/Classes/Controller/ShoppingCartController.php
