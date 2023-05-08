..  include:: /Includes.rst.txt
..  index:: Events; BrokenLinkAnalysisEvent
..  _BrokenLinkAnalysisEvent:

=======================
BrokenLinkAnalysisEvent
=======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Html\Event\BrokenLinkAnalysisEvent`
can be used to get information about broken links set in the
:ref:`rich text editor (RTE) <rte>`.

The procedure for marking the broken links in the RTE is as follow:

#.  The RTE content is fetched from the database. Before it is displayed in
    the edit form, RTE transformations are performed.
#.  The transformation function parses the text and detects links.
#.  For each link, a new PSR-14 event is dispatched.
#.  If a listener is attached, it may set the link as broken and will set
    the link as "checked".
#.  If a link is detected as broken, RTE will mark it as broken.

This functionality is implemented in the system extension
:doc:`linkvalidator <ext_linkvalidator:Index>`. Other extensions can use the
event to override the default behaviour.

API
===

..  include:: /CodeSnippets/Events/Core/BrokenLinkAnalysisEvent.rst.txt
