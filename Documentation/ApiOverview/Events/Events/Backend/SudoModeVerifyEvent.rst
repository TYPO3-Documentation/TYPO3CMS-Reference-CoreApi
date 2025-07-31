..  include:: /Includes.rst.txt
..  index:: Events; SudoModeVerifyEvent
..  _SudoModeVerifyEvent:

===================
SudoModeVerifyEvent
===================

..  versionadded:: 12.4.32 / 13.4.13
    This event was introduced by the fix for security advisory `TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_
    to address challenges with single sign-on (SSO) providers.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Backend\Event\SudoModeVerifyEvent` is triggered before
a password submitted in `sudo-mode verification dialog
<https://docs.typo3.org/permalink/t3coreapi:backend-user-api-sudo>`_ is verified
for backend user accounts.

This step-up authentication mechanism, introduced as part of the fix for
`TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_,
may pose challenges when using remote single sign-on
(SSO) systems because they do not support a dedicated verification step.

This event allows developers to change the verification logic of step-up
authentication, by conditionally allowing or denying verification based
on custom logic — for example, by identifying users authenticated via an
:abbr:`SSO (single sign-on)` system.

..  seealso::

    *   `SudoModeRequiredEvent <https://docs.typo3.org/permalink/t3coreapi:sudomoderequiredevent>`_
        is triggered before showing the sudo-mode verification dialog.

..  _SudoModeVerifyEvent-example:

Example: Use an event listener to modify the verification of password in sudo mode
==================================================================================

The following demonstrates using the event to statically check the password for
an expected hash.

..  warning::
    This example has been simplified for clarity. Always use secure password
    handling with salted hashing in production. **Never** hard-code a password hash as
    shown below.

..  literalinclude:: _SudoModeRequiredEvent/_Services.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

..  literalinclude:: _SudoModeVerifyEvent/_StaticPasswordVerification.php
    :caption: EXT:my_extension/Classes/EventListener/StaticPasswordVerification.php

See also: `SkipSudoModeDialog example <https://docs.typo3.org/permalink/t3coreapi:sudomoderequiredevent-example>`_.

..  _SudoModeVerifyEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/SudoModeVerifyEvent.rst.txt
