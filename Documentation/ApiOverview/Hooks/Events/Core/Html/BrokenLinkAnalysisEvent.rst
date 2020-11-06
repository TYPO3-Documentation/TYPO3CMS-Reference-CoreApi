.. include:: /Includes.rst.txt


.. _BrokenLinkAnalysisEvent:


=======================
BrokenLinkAnalysisEvent
=======================

A PSR-14-based event :php:`TYPO3\CMS\Core\Html\Event\BrokenLinkAnalysisEvent`
can be used to get information about broken links set in the rich text editor (RTE).

The procedure for marking the broken links in the RTE is as follow:

#. RTE content is fetched from the database. Before it is displayed in
   the edit form, RTE transformations are performed.
#. The transformation function parses the text and detects links.
#. For each link, a new PSR-14 event is dispatched.
#. If a listener is attached, it may set the link as broken and will set
   the link as "checked".
#. If a link is detected as broken, RTE will mark it as broken.

This functionality is implemented in the system extension "linkvalidator".
Other extensions can use the event to override the default behaviour.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

isPropagationStopped()
   :sep:`|` :aspect:`ReturnType:` bool
   :sep:`|`

   This is a stoppable event. If the link was checked by any responsible listener,
   other listeners are not called anymore. (see `markAsCheckedLink` below).

getLinkType()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getLinkData()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

markAsCheckedLink()
   :sep:`|` :aspect:`ReturnType:` void

   Mark a link as checked - other listeners will not be called afterwards, so only
   call this method, if your listener was capable of checking this type of link.

markAsBrokenLink(string $reason = '')
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

isBrokenLink()
   :sep:`|` :aspect:`ReturnType:` bool
   :sep:`|`

   |nbsp|

getReason()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

