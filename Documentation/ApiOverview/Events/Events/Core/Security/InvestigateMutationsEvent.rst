..  include:: /Includes.rst.txt
..  index:: Events; InvestigateMutationsEvent
..  _InvestigateMutationsEvent:


=========================
InvestigateMutationsEvent
=========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\InvestigateMutationsEvent`
will be dispatched when the
:ref:`Content Security Policy backend module <content-security-policy-reporting>`
searches for potential resolutions to a specific CSP violation report. This way,
third-party integrations that rely on external resources (for example, maps,
file storage, content processing/translation, ...) can provide the necessary
mutations.


Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt


API
===

..  include:: /CodeSnippets/Events/Core/Security/InvestigateMutationsEvent.rst.txt
