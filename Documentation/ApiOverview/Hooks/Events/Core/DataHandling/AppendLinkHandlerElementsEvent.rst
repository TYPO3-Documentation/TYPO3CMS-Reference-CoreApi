.. include:: /Includes.rst.txt
.. index:: Events; AppendLinkHandlerElementsEvent
.. _AppendLinkHandlerElementsEvent:

==============================
AppendLinkHandlerElementsEvent
==============================

Event fired so listeners can intercept add elements when checking
links within the SoftRef parser.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getLinkParts()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

getContent()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getElements()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

getIdx()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

getTokenId()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

setLinkParts(array $linkParts)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

setContent(string $content)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

setElements(array $elements)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

addElements(array $elements)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Appends elements (with `array_replace_recursive`) -
   existing elements with the same key will be overwritten.
   Sets `isResolved` to true (see below).

isResolved()
   :sep:`|` :aspect:`ReturnType:` bool
   :sep:`|`

   |nbsp|

