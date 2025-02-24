:navigation-title: Backend Users
..  include:: /Includes.rst.txt
..  _backend-user-api:

================
Backend user API
================

In TYPO3, **backend users (BE users)** are responsible for managing content,
settings, and administration tasks within the backend. They are stored in the
:sql:`be_users` database table and authenticated via the
`Backend user object <https://docs.typo3.org/permalink/t3coreapi:be-user>`_
stored in the global variable :php:`$GLOBALS['BE_USER']`
(class :php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`).

..  seealso::
    *   How to create and manage backend users:
        `Backend user management <https://docs.typo3.org/permalink/t3coreapi:user-management>`_.
    *   `Security Guide: Users and access privileges <https://docs.typo3.org/permalink/t3coreapi:security-access-privileges>`_.
    *   `Backend user object <https://docs.typo3.org/permalink/t3coreapi:be-user>`_
    *   `Access control in the backend (users and groups) <https://docs.typo3.org/permalink/t3coreapi:access>`_
    *   `User settings configuration <https://docs.typo3.org/permalink/t3coreapi:user-settings>`_
    *   `Be.security.ifAuthenticated ViewHelper <f:be.security.ifAuthenticated> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-be-security-ifauthenticated>`_
    *   `Be.security.ifHasRole ViewHelper <f:be.security.ifHasRole> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-be-security-ifhasrole>`_
    *   `TypoScript condition [backend.user.isLoggedIn] <https://docs.typo3.org/permalink/t3tsref:condition-backend-user-isloggedin>`_
