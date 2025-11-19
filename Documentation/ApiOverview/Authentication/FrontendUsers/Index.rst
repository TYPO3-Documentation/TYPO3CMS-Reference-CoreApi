:navigation-title: Frontend Users
..  include:: /Includes.rst.txt
..  _frontend-user-api:

=================
Frontend user API
=================

In TYPO3, **frontend users (FE users)** are responsible for accessing restricted
content and personalized areas of a TYPO3 website. They are stored in the
:sql:`fe_users` database table
and authenticated via the `frontend.user request attribute <https://docs.typo3.org/permalink/t3coreapi:typo3-request-attribute-frontend-user>`_
(class :php:`\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication`).

The frontend user id and groups are available from the
`User aspect (Context API) <https://docs.typo3.org/permalink/t3coreapi:context-api-aspects-user>`_.

The :composer:`typo3/cms-felogin` system extension contains a plugin that can
be added to a page so that frontend users can log in and out. It also
has a password-forgotten workflow.

The TYPO3 Core does not provide a plugin to register frontend users. There are
multiple third-party extensions available in the TER, for example
:composer:`evoweb/sf-register`.

..  seealso::
    *   `frontend.user request attribute <https://docs.typo3.org/permalink/t3coreapi:typo3-request-attribute-frontend-user>`_
    *   `User aspect (Context API) <https://docs.typo3.org/permalink/t3coreapi:context-api-aspects-user>`_
    *   `User session management <https://docs.typo3.org/permalink/t3coreapi:session-management>`_
    *   `Database restriction builder: FrontendGroupRestriction <https://docs.typo3.org/permalink/t3coreapi:database-restriction-builder>`_
    *   `Editor's Tutorial: Frontend login <https://docs.typo3.org/permalink/t3editors:frontend-login>`_
    *   :ref:`$GLOBALS['TCA'][$table]['ctrl']['enablecolumns']['fe_group'] <t3tca:confval-ctrl-enablecolumns>`
    *   `Security.ifAuthenticated ViewHelper <f:security.ifAuthenticated> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-security-ifauthenticated>`_
    *   `Security.ifHasRole ViewHelper <f:security.ifHasRole> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-security-ifhasrole>`_
    *   `TypoScript condition [frontend.user.isLoggedIn] <https://docs.typo3.org/permalink/t3tsref:condition-frontend-user-isloggedin>`_
    *   `TypoScript: Get the username field of the current frontend user <https://docs.typo3.org/permalink/t3tsref:data-type-gettext-tsfe-example>`_
