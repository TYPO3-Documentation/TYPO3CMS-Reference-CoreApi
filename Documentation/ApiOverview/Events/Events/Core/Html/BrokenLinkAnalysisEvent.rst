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

Example
=======

An event listener class is constructed which will take a RTE input *TYPO3* and internally
store it in the database as *[tag:typo3]*. This could allow a content element data processor
in the frontend to handle this part of the content with for example internal glossary operations.

The workflow would be:

*   Editor enters "TYPO3" in the RTE instance.
*   When saving, this gets stored as "[tag:typo3]".
*   When the editor sees the RTE instance again, "[tag:typo3]" gets replaced to "TYPO3" again.
*   So: The editor will always only see "TYPO3" and not know how it is internally handled.
*   The frontend output receives "[tag:typo3]" and could do its own content element magic,
    other services accessing the database could also use the parseable representation.

The corresponding event listener class:

..  include:: _TransformTextEvents/_TransformListener.php

API
===

..  include:: /CodeSnippets/Events/Core/BrokenLinkAnalysisEvent.rst.txt
