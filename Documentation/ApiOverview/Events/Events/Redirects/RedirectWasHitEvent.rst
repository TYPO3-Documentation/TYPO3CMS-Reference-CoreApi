..  include:: /Includes.rst.txt
..  index:: Events; RedirectWasHitEvent
..  _RedirectWasHitEvent:


===================
RedirectWasHitEvent
===================

..  versionadded:: 12.0

The PSR-14 event :php:`\TYPO3\CMS\Redirects\Event\RedirectWasHitEvent` is fired
in the :php:`\TYPO3\CMS\Redirects\Http\Middleware\RedirectHandler`
:ref:`middleware <request-handling>` and allows extension authors to further
process the matched redirect and to adjust the PSR-7 response.


Example: Disable the hit count increment for monitoring tools
=============================================================

TYPO3 already implements the :t3src:`redirects/Classes/EventListener/IncrementHitCount.php`
listener. It is used to increment the hit count of the matching redirect record,
if the :ref:`feature "redirects.hitCount" <typo3ConfVars_sys_features_redirects.hitCount>`
is enabled. In case you want to prevent the increment in some
cases, for example if the request was initiated by a monitoring tool, you
can either implement your own listener with the same identifier
(:yaml:`redirects-increment-hit-count`) or add your custom listener
before and dynamically set the records :php:`disable_hitcount` flag.

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _RedirectWasHitEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _RedirectWasHitEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

API
===

.. include:: /CodeSnippets/Events/Redirects/RedirectWasHitEvent.rst.txt
