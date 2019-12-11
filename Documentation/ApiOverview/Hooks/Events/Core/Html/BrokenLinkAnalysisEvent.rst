.. include:: ../../../../../Includes.txt


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


 - :Method:
         isPropagationStopped()
   :Description:
         This is a stoppable event. If the link was checked by any responsible listener,
         other listeners are not called anymore. (see `markAsCheckedLink` below).
   :ReturnType:
         bool


 - :Method:
         getLinkType()
   :Description:
         Return the current link type (see constants in `LinkService`, for example: "page" or "file").
   :ReturnType:
         string


 - :Method:
         getLinkData()
   :Description:
         Return the current link data.
   :ReturnType:
         array


 - :Method:
         markAsCheckedLink()
   :Description:
         Mark a link as checked - other listeners will not be called afterwards, so only 
         call this method, if your listener was capable of checking this type of link.
   :ReturnType:
         void


 - :Method:
         markAsBrokenLink(string $reason = '')
   :Description:
         Mark a link as broken. Optionally add a reason.
   :ReturnType:
         void


 - :Method:
         isBrokenLink()
   :Description:
         Check if the link is marked as broken.
   :ReturnType:
         bool


 - :Method:
         getReason()
   :Description:
         Get reason for marking the link as broken.
   :ReturnType:
         string

