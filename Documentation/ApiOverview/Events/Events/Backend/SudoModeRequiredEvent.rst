..  include:: /Includes.rst.txt
..  index:: Events; SudoModeRequiredEvent
..  _SudoModeRequiredEvent:

=====================
SudoModeRequiredEvent
=====================

..  versionadded:: 12.4.32 / 13.4.13
    The fix for the security advisory `TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_
    introduced this event to address challenges with single sign-on (SSO) providers.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Backend\Event\SudoModeRequiredEvent` is triggered before
showing the `sudo-mode verification dialog <https://docs.typo3.org/permalink/t3coreapi:backend-user-api-sudo>`_
when attempting to manipulate backend user accounts.

This step-up authentication, introduced as part of the fix for
`TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_,
helps prevent unauthorized password changes. However,
it may pose challenges when using remote single sign-on (SSO) systems, which
typically do not support a separate step-up verification process.

This event allows developers to bypass or adjust the step-up
authentication process based on custom logic, such as identifying users
authenticated through an :abbr:`SSO (single sign-on)` system.

..  seealso::

    *   `SudoModeVerifyEvent <https://docs.typo3.org/permalink/t3coreapi:sudomodeverifyevent>`_
         triggered before actually verifying the submitted password.

..  _SudoModeRequiredEvent-example:


Example: Use an event listener to skip the step-up authentication for SSO users
===============================================================================

The following example demonstrates how to use an event listener to skip the step-up
authentication for `be_users` records with an active `is_sso` flag:

..  literalinclude:: _SudoModeRequiredEvent/_Services.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

..  literalinclude:: _SudoModeRequiredEvent/_SkipSudoModeDialog.php
    :caption: EXT:my_extension/Classes/EventListener/SkipSudoModeDialog.php

See also: `StaticPasswordVerification example <https://docs.typo3.org/permalink/t3coreapi:sudomodeverifyevent-example>`_

..  _SudoModeRequiredEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/SudoModeVerifyEvent.rst.txt
