:navigation-title: Authentication & Users
..  include:: /Includes.rst.txt
..  index:: Authentication
..  _authentication:

==========================================
Authentication: Backend and frontend users
==========================================

In TYPO3, there are two distinct user types:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Backend user <backend-user-api>`

        These users can log into the TYPO3 backend to manage content and configure
        settings based on their assigned permissions.

    ..  card:: :ref:`Frontend user <frontend-user-api>`

        These users can log into the TYPO3 frontend to access restricted content
        that is not publicly available.

The following topics are of interest when you are working with backend or
frontend users in TYPO3:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Authentication services <authentication-service>`

        Authentication services in TYPO3 manage user verification, allowing
        flexible and customizable login methods for secure access control.

    ..  card:: :ref:`Multi-factor authentication <multi-factor-authentication>`

        Enhance your TYPO3 security with Multi-Factor Authentication (MFA),
        adding an extra layer of protection beyond passwords for safer logins.

    ..  card:: `User session management <https://docs.typo3.org/permalink/t3coreapi:session-management>`_

        The user session contains all  information for logged in backend and
        frontend users, as well as anonymous visitors without login. It can be
        used to store session data like a shopping basket.

    ..  card:: `Password policies <https://docs.typo3.org/permalink/t3coreapi:password-policies>`_

        The password policy validator is used to validate passwords against
        configurable password policies.

..  toctree:: Subpages
    :glob:
    :titlesonly:
    :hidden:

    BackendUsers/Index
    FrontendUsers/Index
    AuthenticationService/Index
    PasswordPolicies/Index
    MultiFactorAuthentication/Index
    */Index
