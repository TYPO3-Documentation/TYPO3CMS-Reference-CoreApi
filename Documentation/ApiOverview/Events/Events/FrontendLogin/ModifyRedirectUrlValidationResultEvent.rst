..  include:: /Includes.rst.txt
..  index:: Events; ModifyRedirectUrlValidationResultEvent
..  _ModifyRedirectUrlValidationResultEvent:

======================================
ModifyRedirectUrlValidationResultEvent
======================================

..  versionadded:: 13.2
    With this event developers have the possibility to modify the validation
    results for the redirect URL, allowing redirects to URLs not matching the
    existing validation constraints.

The PSR-14 event
:php:`\TYPO3\CMS\FrontendLogin\Event\ModifyRedirectUrlValidationResultEvent`
provides developers with the possibility and flexibility to implement custom
validation for the redirect URL in the frontend login.

This may be useful, if TYPO3 frontend login
acts as an SSO system or if users should be redirected to an external URL after
login.

Example: Validate that the redirect after frontend login goes to a trusted domain
=================================================================================

..  literalinclude:: _ModifyRedirectUrlValidationResultEvent/_ValidateRedirectUrl.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListeners/ValidateRedirectUrl.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/ModifyRedirectUrlValidationResultEvent.rst.txt
