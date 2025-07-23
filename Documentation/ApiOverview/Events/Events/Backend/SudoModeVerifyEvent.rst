..  include:: /Includes.rst.txt
..  index:: Events; SudoModeVerifyEvent
..  _SudoModeVerifyEvent:

===================
SudoModeVerifyEvent
===================

..  versionadded:: 12.4.32 / 13.4.13
    The fix for the security advisory `TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_
    introduced this event to address challenges with single sign-on (SSO) providers.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Backend\Event\SudoModeVerifyEvent` is triggered before
verifying the submitted password from the `sudo-mode verification dialog
<https://docs.typo3.org/permalink/t3coreapi:backend-user-api-sudo>`_ when
attempting to manipulate backend user accounts.

This step-up authentication mechanism, introduced as part of the fix for
`TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_,
may pose challenges when using remote single sign-on
(SSO) systems, which typically do not support a dedicated verification step.

This event allows developers to adjust the verification logic of step-up
authentication, such as conditionally allowing or denying verification based
on custom logic—for example, identifying users authenticated via an
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
    This example is simplified for clarity. In production, always use secure
    password handling with salted hashing. **Never** hard-code a password hash as
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
