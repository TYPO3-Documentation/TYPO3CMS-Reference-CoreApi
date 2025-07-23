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

..  _backend-user-api-sudo:

Sudo mode (step-up authentication) for password changes
=======================================================

..  versionadded:: 12.4.32 / 13.4.13
    This functionality was introduced in response to security advisory `TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_
    to mitigate password-change risks.

This mechanism prevents unauthorized password changes if an administrator
session is hijacked or left unattended.

When an administrator edits their own user account or changes the
password of another user via the admin interface, password confirmation
(step-up authentication) is required.

..  figure:: /Images/ManualScreenshots/AdminTools/SudoMode.png
    :alt: Dialog "Verify with user password" with password prompt shown on attempting to change a password.

    Step-up authentication requires the administrator to re-enter their password

..  note::
    This may pose challenges when integrating remote single sign-on (SSO)
    providers, as these typically do not support a dedicated step-up
    authentication process.

    In such cases, you can use the PSR-14 events `SudoModeRequiredEvent <https://docs.typo3.org/permalink/t3coreapi:sudomoderequiredevent>`_
    (triggered before showing the sudo-mode verification dialog) and
    `SudoModeVerifyEvent <https://docs.typo3.org/permalink/t3coreapi:sudomodeverifyevent>`_
    (triggered before actually verifying the submitted password) to adapt the behavior.
