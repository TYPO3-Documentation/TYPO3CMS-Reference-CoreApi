:navigation-title: Sudo mode

.. include:: /Includes.rst.txt
.. index:: Backend modules; TypoScript
.. _backend-module-sudo:

==================================
Sudo mode in TYPO3 backend modules
==================================

When accessing modules in the :guilabel:`Admin Tools` via backend user interface,
currently logged in backend users have to confirm their user password again
in order to get access to the modules in this section.

As an alternative, it is also possible to use the install
tool password. This is done
in order to mitigate unintended modifications that might occur as result
of for example possible cross-site scripting vulnerabilities in the system.

.. _backend-module-sudo-extensions:

Authentication in for sudo mode in extensions using the auth service
====================================================================

Albeit default local authentication mechanisms are working well, there are
side effects for 3rd party extensions that make use of these `auth` service
chains as well - such as multi-factor authentication or single sign-on handling.

As an alternative, it is possible to confirm actions using the Install Tool
password, instead of confirming with user's password (which might be handled
with separate remote services).

Services that extend authentication with custom additional factors (2FA/MFA)
are advised to intercept only valid login requests instead of all `authUser`
invocations.

..  literalinclude:: _SudoMode/_MyAuthenticationService.php
    :caption: EXT:my_extension/Classes/Authentication/MyAuthenticationService.php

.. _backend-module-sudo-modules:

Custom backend modules requiring the sudo mode
==============================================

..  versionadded:: 12.4
    With TYPO3 v12.4 sudo mode has been changed to a generic configuration for
    backend routes (and implicitly modules).

In general, the configuration for a particular route or module looks like this:

..  code-block:: diff

    + 'sudoMode' => [
    +     'group' => 'individual-group-name',
    +     'lifetime' => AccessLifetime::veryShort,
    + ],

*   `group` (optional): if given, grants access to other objects of the same `group`
    without having to verify sudo mode again for a the given lifetime. Example:
    Admin Tool modules :guilabel:`Maintainance` and :guilabel:`Settings` are configured with the same
    `systemMaintainer` group - having access to one (after sudo mode verification)
    grants access to the other automatically.
*   `lifetime`: enum value of :php:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessLifetime`,
    defining the lifetime of a sudo mode verification, afterwards users have to go through
    the process again - cases are `veryShort` (5 minutes), `short` (10 minutes),
    `medium` (15 minutes), `long` (30 minutes), `veryLong` (60 minutes)


For backend routes declared via :file:`Configuration/Backend/Routes.php`, the
relevant configuration would look like this:

..  literalinclude:: /ApiOverview/Backend/_BackendRouting/_sudo_routes.php
    :caption: EXT:my_extension/Configuration/Backend/Routes.php

For backend modules declared via :file:`Configuration/Backend/Modules.php`, the
relevant configuration would look like this:

..  literalinclude:: /ApiOverview/Backend/BackendModules/ModuleConfiguration/_ModuleConfiguration/_sudo_modules.php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

.. _backend-module-sudo-modules-process:

Process in a nutshell
---------------------

All simplified classnames below are located in the namespace
:php:`\TYPO3\CMS\Backend\Security\SudoMode\Access`).
The low-level request orchestration happens in the middleware
:php:`\TYPO3\CMS\Backend\Middleware\SudoModeInterceptor`,
markup rendering and payload processing in controller
:php:`\TYPO3\CMS\Backend\Controller\Security\SudoModeController`.

#.  A backend route is processed, that requires sudo mode for route URI `/my/route`
    in :php:`\TYPO3\CMS\Backend\Http\RouteDispatcher`.
#.  Using :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessFactory`
    and :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessStorage`,
    the :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\RouteDispatcher`
    tries to find a valid and not expired
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessGrant` item
    for the specific :php:`RouteAccessSubject('/my/route')` aspect in the
    current backend user session data.
#.  In case no
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessGrant` can be
    determined, a new
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessClaim`
    is created for the specific
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\RouteAccessSubject`
    instance and temporarily persisted in the current user session data -
    the claim also contains the originally requested route as
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\ServerRequestInstruction`
    (a simplified representation of a
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\ServerRequestInterface`).
#.  Next, the user is redirected to the user interface for providing either
    their own password, or the global install tool password as alternative.
#.  Given, the password was correct, the
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessClaim`
    is "converted" to an
    :php-short:`\TYPO3\CMS\Backend\Security\SudoMode\Access\AccessGrant`,
    which is only valid for the specific subject (URI `/my/route`)
    and for a limited lifetime.
