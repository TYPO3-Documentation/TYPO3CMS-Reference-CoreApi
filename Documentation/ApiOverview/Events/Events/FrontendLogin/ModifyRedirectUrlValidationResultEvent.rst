..  include:: /Includes.rst.txt
..  index:: Events; ModifyRedirectUrlValidationResultEvent
..  _ModifyRedirectUrlValidationResultEvent:

======================================
ModifyRedirectUrlValidationResultEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\FrontendLogin\Event\ModifyRedirectUrlValidationResultEvent`
provides developers with the possibility and flexibility to implement custom
validation for the redirect URL in the frontend login.

With this event developers have the possibility to modify the validation
results for the redirect URL, allowing redirects to URLs not matching the
existing validation constraints.

This may be useful, if TYPO3 frontend login
acts as an :abbr:`SSO (Single-Sign On)` system, or if users should be redirected to an external URL after
login.

Example: Validate that the redirect after frontend login goes to a trusted domain
=================================================================================

..  literalinclude:: _ModifyRedirectUrlValidationResultEvent/_ValidateRedirectUrl.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListeners/ValidateRedirectUrl.php

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/ModifyRedirectUrlValidationResultEvent.rst.txt
