..  include:: /Includes.rst.txt
..  index:: Events; RedirectIntegrityCheckEvent
..  _RedirectIntegrityCheckEvent:

==============================================================
RedirectIntegrityCheckEvent
==============================================================

..  versionadded:: 14.2

The PSR-14 event
:php:`\TYPO3\CMS\Redirects\Event\RedirectIntegrityCheckEvent`
is dispatched for each redirect record during integrity checks, allowing
extensions to validate redirect targets (such as t3://record links) and flag broken or
invalid redirects. It is dispatched in
:php:`\TYPO3\CMS\Redirects\Service\IntegrityService->checkRedirectTargetIntegrity()`
for each redirect record.

Additionally, the following class constants allow the
shared reuse of conflict statuses that extensions developers can set in custom
event listeners: :php:`\TYPO3\CMS\Redirects\Utility\RedirectConflict::INVALID_TARGET`,
:php:`\TYPO3\CMS\Redirects\Utility\RedirectConflict::NO_CONFLICT`,


Extensions can now validate redirects during an integrity check by listening
to this event. Broken or invalid redirects are reported as well as
self-reference conflicts in the :bash:`redirects:checkintegrity` command
output.

Example
=======

An event listener that validates ``t3://record`` targets:

..  literalinclude:: _RedirectIntegrityCheckEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

API
===

.. include:: /CodeSnippets/Events/Redirects/RedirectIntegrityCheckEvent.rst.txt
