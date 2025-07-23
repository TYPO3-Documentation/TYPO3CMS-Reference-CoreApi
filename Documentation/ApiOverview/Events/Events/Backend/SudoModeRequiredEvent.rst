..  include:: /Includes.rst.txt
..  index:: Events; SudoModeRequiredEvent
..  _SudoModeRequiredEvent:

=====================
SudoModeRequiredEvent
=====================

..  versionadded:: 12.4.32 / 13.4.13
    This event was introduced by security advisory `TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_
    to address challenges with single sign-on (SSO) providers.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Backend\Event\SudoModeRequiredEvent` is triggered before
showing the `sudo-mode verification dialog <https://docs.typo3.org/permalink/t3coreapi:backend-user-api-sudo>`_
when managing backend user accounts.

This step-up authentication, introduced as part of the fix for
`TYPO3-CORE-SA-2025-013 <https://typo3.org/security/advisory/typo3-core-sa-2025-013>`_,
helps prevent unauthorized password changes. However,
it may pose challenges when using remote single sign-on (SSO) systems, which
typically do not support a separate step-up verification process.

This event allows developers to skip / bypass the step-up
authentication process and uses custom logic, such as identifying users
authenticated through an :abbr:`SSO (single sign-on)` system.

..  seealso::

    *   The `SudoModeVerifyEvent <https://docs.typo3.org/permalink/t3coreapi:sudomodeverifyevent>`_
        is triggered before verification of a submitted password.

..  _SudoModeRequiredEvent-example:


Example: Use an event listener to skip step-up authentication for SSO users
===========================================================================

The following example demonstrates how to use an event listener to skip step-up
authentication for `be_users` records that have an active `is_sso` flag:

..  literalinclude:: _SudoModeRequiredEvent/_Services.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

..  literalinclude:: _SudoModeRequiredEvent/_SkipSudoModeDialog.php
    :caption: EXT:my_extension/Classes/EventListener/SkipSudoModeDialog.php

See also: `StaticPasswordVerification example <https://docs.typo3.org/permalink/t3coreapi:sudomodeverifyevent-example>`_

..  _SudoModeRequiredEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/SudoModeRequiredEvent.rst.txt
