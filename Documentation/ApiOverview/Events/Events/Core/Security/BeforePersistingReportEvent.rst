..  include:: /Includes.rst.txt
..  index:: Events; BeforePersistingReportEvent
..  _BeforePersistingReportEvent:


===========================
BeforePersistingReportEvent
===========================

..  versionadded:: 14.2

When a :ref:`Content Security Policy <content-security-policy>`
:ref:`violation report <content-security-policy-reporting>` needs to be
persisted, the :php-short:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\BeforePersistingReportEvent`
can be used to provide an alternative report or to prevent a particular report
from being persisted at all.


Example
=======

..  literalinclude:: _BeforePersistingReportEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/ContentSecurityPolicy/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Core/Security/BeforePersistingReportEvent.rst.txt
